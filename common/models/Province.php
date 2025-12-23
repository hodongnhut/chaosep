<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Province
 * @package app\models
 *
 * @property int $id
 * @property int $api_id
 * @property string $solr_id
 * @property string $title
 * @property int $type
 * @property int $total_doanh_nghiep
 * @property int $stt
 * @property string $created_at
 * @property string $updated_at
 */
class Province extends ActiveRecord
{
    public static function tableName()
    {
        return 'provinces';
    }

    public function rules()
    {
        return [
            [['api_id', 'solr_id', 'title'], 'required'],
            [['api_id', 'type', 'total_doanh_nghiep', 'stt'], 'integer'],
            [['solr_id'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 100],
            [['created_at', 'updated_at'], 'safe'],
            [['api_id', 'solr_id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'api_id' => 'API ID',
            'solr_id' => 'Solr ID',
            'title' => 'Tên Tỉnh/Thành',
            'type' => 'Type',
            'total_doanh_nghiep' => 'Tổng Doanh Nghiệp',
            'stt' => 'Số Thứ Tự',
            'created_at' => 'Ngày Tạo',
            'updated_at' => 'Ngày Cập Nhật',
        ];
    }

    /**
     * Quan hệ: Một tỉnh có nhiều quận/huyện
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::class, ['province_id' => 'api_id']);
    }
}