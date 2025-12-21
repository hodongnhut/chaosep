<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\Company;

class EnrichCompanyCommand extends Controller
{
    public $batchSize = 100;

    public function options($actionID)
    {
        return ['batchSize'];
    }

    public function actionIndex()
    {
        $this->stdout("Bắt đầu enrich data công ty từ API thongtindoanhnghiep.co (dùng pure CURL)\n", Console::FG_YELLOW);

        $maxId = Company::find()->max('id');
        $processed = 0;
        $success = 0;
        $failed = 0;

        for ($id = 1; $id <= $maxId; $id += $this->batchSize) {
            $companies = Company::find()
                ->where(['>=', 'id', $id])
                ->andWhere(['<', 'id', $id + $this->batchSize])
                // ->andWhere(['exists_in_gdt' => 0]) // Bỏ comment nếu chỉ muốn enrich những chưa có data
                ->orderBy('id')
                ->all();

            if (empty($companies)) {
                continue;
            }

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
                } elseif ($data && isset($data['MaSoThue'])) {
                    $this->updateCompanyFromApi($company, $data);
                    $company->exists_in_gdt = 1;
                    $company->is_active = $data['IsDelete'] ? 0 : 1;

                    if ($company->save(false)) {
                        $success++;
                        $this->stdout("SUCCESS [ID {$company->id}] {$taxCode} - {$data['Title']}\n", Console::FG_GREEN);
                    } else {
                        $failed++;
                        $this->stdout("SAVE FAILED [ID {$company->id}] {$taxCode}\n", Console::FG_RED);
                    }
                } else {
                    $failed++;
                    $this->stdout("NO DATA [ID {$company->id}] {$taxCode}\n", Console::FG_YELLOW);
                }

                // Rate limit nhẹ để tránh bị block
                usleep(rand(1000000, 2000000)); // 1-2 giây
                $processed++;
            }

            // Reset DB connection nếu chạy lâu
            Yii::$app->db->close();
            Yii::$app->db->open();
        }

        $this->stdout("Hoàn thành! Processed: $processed | Success: $success | Failed: $failed\n", Console::FG_PURPLE);
    }

    /**
     * Call API bằng pure CURL
     */
    private function curlGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bỏ verify SSL nếu cần (thường API public ổn)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Yii2 Cron Enrich Company');

        $response = curl_exec($ch);

        if (curl_error($ch)) {
            // curl error
            curl_close($ch);
            return false;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return false;
        }

        $data = json_decode($response, true);

        return is_array($data) ? $data : false;
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