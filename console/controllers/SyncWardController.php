<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\District;
use common\models\Ward;
use yii\db\Expression;

class SyncWardController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Bắt đầu sync Phường/Xã/Thị trấn từ thongtindoanhnghiep.co...\n", Console::FG_YELLOW);

        $districts = District::find()->all();

        if (empty($districts)) {
            $this->stdout("Chưa có dữ liệu Quận/Huyện. Hãy chạy sync-district trước!\n", Console::FG_RED);
            return Controller::EXIT_CODE_ERROR;
        }

        $totalInserted = 0;
        $totalUpdated = 0;
        $totalDistricts = count($districts);

        foreach ($districts as $district) {
            $apiId = $district->api_id;
            $districtTitle = $district->title;
            $provinceTitle = $district->province_title;

            $this->stdout("Đang sync phường/xã cho: $districtTitle, $provinceTitle (District ID: $apiId)...\n", Console::FG_CYAN);

            $url = "https://thongtindoanhnghiep.co/api/district/{$apiId}/ward";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 40);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || empty($response)) {
                $this->stdout("   Lỗi gọi API (HTTP $httpCode) cho quận/huyện $districtTitle\n", Console::FG_RED);
                continue;
            }

            $data = json_decode($response, true);

            if (!is_array($data)) {
                $this->stdout("   Dữ liệu trả về không phải mảng cho quận/huyện $districtTitle\n", Console::FG_RED);
                continue;
            }

            $inserted = 0;
            $updated = 0;

            foreach ($data as $item) {
                $ward = Ward::findOne(['api_id' => $item['ID']]);

                if (!$ward) {
                    $ward = new Ward();
                    $ward->api_id = $item['ID'];
                    $inserted++;
                    $totalInserted++;
                } else {
                    $updated++;
                    $totalUpdated++;
                }

                $ward->province_id      = $item['TinhThanhID'];
                $ward->district_id      = $item['QuanHuyenID'];
                $ward->solr_id          = $item['SolrID'];
                $ward->title            = $item['Title'];
                $ward->type             = $item['Type'] ?? 3;
                $ward->stt              = $item['STT'] ?? 0;
                $ward->province_title   = $item['TinhThanhTitle'];
                $ward->province_solr_id = $item['TinhThanhTitleAscii'];
                $ward->district_title   = $item['QuanHuyenTitle'];
                $ward->district_solr_id = $item['QuanHuyenTitleAscii'];
                $ward->updated_at       = new Expression('NOW()');

                if (!$ward->save()) {
                    $this->stdout("   Lỗi lưu phường/xã: " . $item['Title'] . " - " . json_encode($ward->errors) . "\n", Console::FG_RED);
                }
            }

            $this->stdout("   Hoàn thành $districtTitle: Thêm $inserted | Cập nhật $updated\n", Console::FG_GREEN);
        }

        $this->stdout("Sync Phường/Xã toàn quốc hoàn thành!\n", Console::FG_GREEN);
        $this->stdout("Tổng quận/huyện xử lý: $totalDistricts | Thêm mới: $totalInserted | Cập nhật: $totalUpdated\n", Console::FG_GREEN);

        return Controller::EXIT_CODE_NORMAL;
    }
}