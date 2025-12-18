<?php

namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;
use common\models\Company;
use yii\helpers\Console;

class CrawlController extends Controller
{
    public $startPage = 1;
    public $endPage = 1582403;
    public $recordsPerPage = 50; // Tăng lên để nhanh hơn (test thấy 50-100 OK)
    public $delay = 1; // giây delay giữa các request

    public function options($actionID)
    {
        return ['startPage', 'endPage', 'recordsPerPage', 'delay'];
    }

    public function actionIndex()
    {
        $this->stdout("Bắt đầu crawl dữ liệu doanh nghiệp từ thongtindoanhnghiep.co\n", Console::FG_YELLOW);
        $this->stdout("Từ trang {$this->startPage} đến trang {$this->endPage}\n", Console::FG_GREEN);
        $this->stdout("Records/trang: {$this->recordsPerPage} | Delay: {$this->delay}s\n\n", Console::FG_GREEN);

        $baseUrl = 'https://thongtindoanhnghiep.co/api/company';

        for ($page = $this->startPage; $page <= $this->endPage; $page++) {
            $url = "{$baseUrl}?p={$page}&r={$this->recordsPerPage}";

            $this->stdout("Đang crawl trang $page / {$this->endPage} ... ", Console::FG_CYAN);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (HISepCrawler/1.0; Yii2)',
                'Accept: application/json'
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || empty($response)) {
                $this->stdout("Lỗi HTTP $httpCode hoặc empty response\n", Console::FG_RED);
                sleep($this->delay);
                continue;
            }

            $data = json_decode($response, true);

            if (!isset($data['LtsItems']) || empty($data['LtsItems'])) {
                $this->stdout("Không có data trang $page\n", Console::FG_YELLOW);
                sleep($this->delay);
                continue;
            }

            $inserted = 0;
            foreach ($data['LtsItems'] as $item) {
                $company = Company::findOne(['tax_code' => $item['MaSoThue']]);
                if (!$company) {
                    $company = new Company();
                }

                $company->tax_code = $item['MaSoThue'] ?? null;
                $company->company_name = $item['Title'] ?? null;
                $company->company_name_en = $item['TitleEn'] ?? null;
                $company->address = $item['DiaChiCongTy'] ?? null;
                $company->legal_representative = $item['ChuSoHuu'] ?? null;
                $company->established_date = $item['NgayCap'] ? date('Y-m-d', strtotime($item['NgayCap'])) : null;
                $company->industry = $item['NganhNgheTitle'] ?? null;
                $company->province = $item['TinhThanhTitle'] ?? null;
                $company->district = $item['QuanHuyenTitle'] ?? null;
                $company->ward = $item['PhuongXaTitle'] ?? null;
                $company->is_active = $item['IsDelete'] ? 0 : 1;

                if ($company->save()) {
                    $inserted++;
                } else {
                    $this->stdout("Lỗi lưu MST {$item['MaSoThue']}: " . json_encode($company->errors) . "\n", Console::FG_RED);
                }
            }

            $this->stdout("Đã lưu $inserted records\n", Console::FG_GREEN);
            sleep($this->delay); // Delay tránh bị block
        }

        $this->stdout("Crawl hoàn tất!\n", Console::FG_YELLOW);
        return ExitCode::OK;
    }
}