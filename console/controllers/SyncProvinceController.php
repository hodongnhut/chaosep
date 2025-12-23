<?php

namespace console\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\Province;
use yii\db\Expression;

class SyncProvinceController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Bắt đầu sync Tỉnh/Thành phố từ thongtindoanhnghiep.co...\n", Console::FG_YELLOW);

        $url = 'https://thongtindoanhnghiep.co/api/city';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Nếu cần bypass SSL
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || empty($response)) {
            $this->stdout("Lỗi kết nối API (HTTP $httpCode)\n", Console::FG_RED);
            return Controller::EXIT_CODE_ERROR;
        }

        $data = json_decode($response, true);
        if (!isset($data['LtsItem']) || !is_array($data['LtsItem'])) {
            $this->stdout("Dữ liệu API không đúng định dạng\n", Console::FG_RED);
            return Controller::EXIT_CODE_ERROR;
        }

        $items = $data['LtsItem'];
        $total = count($items);
        $inserted = 0;
        $updated = 0;

        foreach ($items as $item) {
            $province = Province::findOne(['api_id' => $item['ID']]);
            
            if (!$province) {
                $province = new Province();
                $province->api_id = $item['ID'];
                $inserted++;
            } else {
                $updated++;
            }

            $province->solr_id = $item['SolrID'];
            $province->title = $item['Title'];
            $province->type = $item['Type'];
            $province->stt = $item['STT'];
            $province->total_doanh_nghiep = $item['TotalDoanhNghiep'] ?? 0;
            $province->updated_at = new Expression('NOW()');

            if (!$province->save()) {
                $this->stdout("Lỗi lưu tỉnh: " . $item['Title'] . " - " . json_encode($province->errors) . "\n", Console::FG_RED);
            }
        }

        $this->stdout("Hoàn thành! Tổng: $total | Thêm mới: $inserted | Cập nhật: $updated\n", Console::FG_GREEN);
        return Controller::EXIT_CODE_NORMAL;
    }
}