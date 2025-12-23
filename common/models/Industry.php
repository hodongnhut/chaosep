<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Industry
 * @package app\models
 *
 * @property int $id
 * @property int $api_id
 * @property string $solr_id
 * @property string $title
 * @property string $title_ascii
 * @property int $type
 * @property string $lv1
 * @property string $lv2
 * @property string $lv3
 * @property string $lv4
 * @property string $lv5
 * @property int $total_doanh_nghiep
 * @property string $created_at
 * @property string $updated_at
 */
class Industry extends ActiveRecord
{
    public static function tableName()
    {
        return 'industries';
    }

    public function rules()
    {
        return [
            [['api_id', 'solr_id', 'title', 'lv1'], 'required'],
            [['api_id', 'type', 'total_doanh_nghiep'], 'integer'],
            [['title', 'title_ascii'], 'string', 'max' => 255],
            [['solr_id'], 'string', 'max' => 200],
            [['lv1', 'lv2', 'lv3', 'lv4'], 'string', 'max' => 10],
            [['lv5'], 'string', 'max' => 20],
            [['created_at', 'updated_at'], 'safe'],
            [['api_id', 'solr_id'], 'unique'],
            [['title_ascii'], 'default', 'value' => null],
            [['lv2', 'lv3', 'lv4', 'lv5'], 'default', 'value' => ''],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'api_id' => 'API ID',
            'solr_id' => 'Solr ID',
            'title' => 'Tên Ngành Nghề',
            'title_ascii' => 'Tên Không Dấu',
            'type' => 'Type',
            'lv1' => 'Mã Cấp 1',
            'lv2' => 'Mã Cấp 2',
            'lv3' => 'Mã Cấp 3',
            'lv4' => 'Mã Cấp 4',
            'lv5' => 'Mã Cấp 5',
            'total_doanh_nghiep' => 'Tổng Doanh Nghiệp',
            'created_at' => 'Ngày Tạo',
            'updated_at' => 'Ngày Cập Nhật',
        ];
    }

    /**
     * Lấy tên cấp ngành đầy đủ (ví dụ: A - NÔNG NGHIỆP, LÂM NGHIỆP VÀ THUỶ SẢN)
     * @return string
     */
    public function getFullCodeTitle()
    {
        $code = trim(implode(' ', [$this->lv1, $this->lv2, $this->lv3, $this->lv4, $this->lv5]));
        return $code . ' - ' . $this->title;
    }

    /**
     * Lấy top ngành nhiều doanh nghiệp nhất
     * @param int $limit
     * @return array
     */
    public static function getTopIndustries($limit = 10)
    {
        return self::find()
            ->orderBy(['total_doanh_nghiep' => SORT_DESC])
            ->limit($limit)
            ->all();
    }
}