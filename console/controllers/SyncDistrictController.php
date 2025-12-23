<?php

namespace console\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\Province;
use common\models\District;
use yii\db\Expression;

class SyncDistrictController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Bắt đầu sync Quận/Huyện từ thongtindoanhnghiep.co...\n", Console::FG_YELLOW);

        // Lấy tất cả tỉnh đã có trong DB
        $provinces = Province::find()->all();

        if (empty($provinces)) {
            $this->stdout("Chưa có dữ liệu Tỉnh/Thành phố. Chạy sync-province trước nhé!\n", Console::FG_RED);
            return Controller::EXIT_CODE_ERROR;
        }

        $totalInserted = 0;
        $totalUpdated = 0;
        $totalProvinces = count($provinces);

        foreach ($provinces as $province) {
            $apiId = $province->api_id;
            $provinceTitle = $province->title;
            $provinceSolrId = $province->solr_id;

            $this->stdout("Đang sync quận/huyện cho: $provinceTitle (ID: $apiId)...\n", Console::FG_CYAN);

            $url = "https://thongtindoanhnghiep.co/api/city/{$apiId}/district";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200 || empty($response)) {
                $this->stdout("   Lỗi API tỉnh $provinceTitle (HTTP $httpCode)\n", Console::FG_RED);
                continue;
            }

            $data = json_decode($response, true);
            if (!is_array($data)) {
                $this->stdout("   Dữ liệu API không phải array cho tỉnh $provinceTitle\n", Console::FG_RED);
                continue;
            }

            $inserted = 0;
            $updated = 0;

            foreach ($data as $item) {
                $district = District::findOne(['api_id' => $item['ID']]);

                if (!$district) {
                    $district = new District();
                    $district->api_id = $item['ID'];
                    $inserted++;
                    $totalInserted++;
                } else {
                    $updated++;
                    $totalUpdated++;
                }

                $district->province_id = $item['TinhThanhID'];
                $district->solr_id = $item['SolrID'];
                $district->title = $item['Title'];
                $district->type = $item['Type'] ?? 2;
                $district->stt = $item['STT'] ?? 0;
                $district->province_title = $item['TinhThanhTitle'];
                $district->province_solr_id = $item['TinhThanhTitleAscii'];
                $district->updated_at = new Expression('NOW()');

                if (!$district->save()) {
                    $this->stdout("   Lỗi lưu quận/huyện: " . $item['Title'] . " - " . json_encode($district->errors) . "\n", Console::FG_RED);
                }
            }

            $this->stdout("   Hoàn thành tỉnh $provinceTitle: Thêm $inserted | Cập nhật $updated\n", Console::FG_GREEN);
        }

        $this->stdout("Sync Quận/Huyện toàn quốc hoàn thành! Tổng tỉnh: $totalProvinces | Thêm mới: $totalInserted | Cập nhật: $totalUpdated\n", Console::FG_GREEN);

        return Controller::EXIT_CODE_NORMAL;
    }
}