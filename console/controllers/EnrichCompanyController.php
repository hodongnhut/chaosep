<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\Company;

class EnrichCompanyController extends Controller
{
    public $batchSize = 100;

    public function options($actionID)
    {
        return ['batchSize'];
    }

    public function actionIndex()
    {
        $this->stdout(
            "Start enrich company (batchSize={$this->batchSize})\n",
            Console::FG_YELLOW
        );

        $stateFile = Yii::getAlias('@runtime/enrich_company_last_id.txt');

        // Lấy startId
        $startId = 1;
        if (file_exists($stateFile)) {
            $startId = (int) file_get_contents($stateFile);
        }

        $maxId = Company::find()->max('id');

        if ($startId > $maxId) {
            $this->stdout("DONE – All companies enriched\n", Console::FG_GREEN);
            return;
        }

        $endId = min($startId + $this->batchSize - 1, $maxId);

        $this->stdout(
            "Processing ID {$startId} → {$endId}\n",
            Console::FG_CYAN
        );

        $companies = Company::find()
            ->where(['>=', 'id', $startId])
            ->andWhere(['<=', 'id', $endId])
            ->orderBy('id')
            ->all();

        $processed = 0;
        $success = 0;
        $failed = 0;

        foreach ($companies as $company) {
            if (empty($company->tax_code)) {
                continue;
            }

            $taxCode = trim($company->tax_code);
            $url = 'https://thongtindoanhnghiep.co/api/company/' . $taxCode;

            $data = $this->curlGet($url);

            if ($data === false) {
                $failed++;
                $this->stdout("CURL ERROR [ID {$company->id}] {$taxCode}\n", Console::FG_RED);
            } elseif (isset($data['MaSoThue'])) {
                $this->updateCompanyFromApi($company, $data);
                $company->exists_in_gdt = 1;
                $company->is_active = $data['IsDelete'] ? 0 : 1;

                if ($company->save(false)) {
                    $success++;
                    $this->stdout("SUCCESS [ID {$company->id}] {$taxCode}\n", Console::FG_GREEN);
                } else {
                    $failed++;
                    $this->stdout("SAVE FAILED [ID {$company->id}] {$taxCode}\n", Console::FG_RED);
                }
            } else {
                $failed++;
                $this->stdout("NO DATA [ID {$company->id}] {$taxCode}\n", Console::FG_YELLOW);
            }

            usleep(rand(2000000, 4000000)); // 2–4s
            $processed++;
        }

        // Lưu ID cho lần chạy tiếp theo
        file_put_contents($stateFile, $endId + 1);

        // Reset DB
        Yii::$app->db->close();
        Yii::$app->db->open();

        $this->stdout(
            "DONE batch | Processed: {$processed} | Success: {$success} | Failed: {$failed}\n",
            Console::FG_PURPLE
        );
    }


    /**
     * Call API bằng pure CURL
     */
    private function curlGet($url, $retry = 3)
    {
        for ($i = 1; $i <= $retry; $i++) {
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,

                // Fake browser
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0 Safari/537.36',

                CURLOPT_HTTPHEADER => [
                    'Accept: application/json, text/plain, */*',
                    'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                    'Connection: keep-alive',
                    'Cache-Control: no-cache',
                    'Pragma: no-cache',
                ],
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);

            curl_close($ch);


            if ($error || $httpCode !== 200 || empty($response)) {
                usleep(rand(1500000, 3000000)); // 1.5–3s
                continue;
            }

            if (stripos($response, '<html') !== false) {
                usleep(rand(2000000, 4000000));
                continue;
            }

            $data = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                return $data;
            }

            usleep(rand(1500000, 3000000));
        }

        return false;
    }


    private function updateCompanyFromApi(Company $company, array $data)
    {
        $map = [
            'Title' => 'company_name',
            'TitleEn' => 'company_name_en',
            'DiaChiCongTy' => 'address',
            'DiaChiNhanThongBaoThue' => 'tax_notification_address',
            'ChuSoHuu' => 'legal_representative',
            'GiamDoc' => 'director',
            'KeToanTruong' => 'chief_accountant',
            'NgayCap' => 'established_date',
            'NgayDongMST' => 'closed_date',
            'NganhNgheTitle' => 'industry',
            'TinhThanhTitle' => 'province',
            'QuanHuyenTitle' => 'district',
            'PhuongXaTitle' => 'ward',
            'VonDieuLe' => 'capital',
            'TongSoLaoDong' => 'employee_count',
        ];

        foreach ($map as $apiKey => $modelAttr) {
            if (isset($data[$apiKey]) && $data[$apiKey] !== null) {
                if (in_array($modelAttr, ['established_date', 'closed_date'])) {
                    $date = date('Y-m-d', strtotime($data[$apiKey]));
                    $company->$modelAttr = $date;
                } else {
                    $company->$modelAttr = trim($data[$apiKey]);
                }
            }
        }
    }
}