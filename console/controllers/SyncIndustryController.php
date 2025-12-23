<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\Industry;
use yii\db\Expression;

class SyncIndustryController extends Controller
{
    public function actionIndex()
    {
        $this->stdout("Bắt đầu sync Ngành nghề kinh doanh từ thongtindoanhnghiep.co...\n", Console::FG_YELLOW);

        $url = 'https://thongtindoanhnghiep.co/api/industry';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Tăng timeout vì danh sách ngành khá dài
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || empty($response)) {
            $this->stdout("Lỗi kết nối API (HTTP $httpCode)\n", Console::FG_RED);
            return Controller::EXIT_CODE_ERROR;
        }

        $data = json_decode($response, true);
        if (!is_array($data)) {
            $this->stdout("Dữ liệu API không đúng định dạng (không phải array)\n", Console::FG_RED);
            return Controller::EXIT_CODE_ERROR;
        }

        $total = count($data);
        $inserted = 0;
        $updated = 0;

        foreach ($data as $item) {
            $industry = Industry::findOne(['api_id' => $item['ID']]);

            if (!$industry) {
                $industry = new Industry();
                $industry->api_id = $item['ID'];
                $inserted++;
            } else {
                $updated++;
            }

            $industry->solr_id = $item['SolrID'];
            $industry->title = $item['Title'];
            $industry->title_ascii = $item['TitleAscii'] ?? null;
            $industry->type = $item['Type'] ?? 4;
            $industry->lv1 = $item['Lv1'] ?? '';
            $industry->lv2 = $item['Lv2'] ?? '';
            $industry->lv3 = $item['Lv3'] ?? '';
            $industry->lv4 = $item['Lv4'] ?? '';
            $industry->lv5 = $item['Lv5'] ?? '';
            $industry->total_doanh_nghiep = $item['TotalDoanhNghiep'] ?? 0;
            $industry->updated_at = new Expression('NOW()');

            if (!$industry->save()) {
                $this->stdout("Lỗi lưu ngành: " . $item['Title'] . " - " . json_encode($industry->errors) . "\n", Console::FG_RED);
            }
        }

        $this->stdout("Sync Ngành nghề hoàn thành! Tổng: $total | Thêm mới: $inserted | Cập nhật: $updated\n", Console::FG_GREEN);
        return Controller::EXIT_CODE_NORMAL;
    }
}