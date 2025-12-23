<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class District
 * @package app\models
 *
 * @property int $id
 * @property int $api_id
 * @property int $province_id
 * @property string $solr_id
 * @property string $title
 * @property int $type
 * @property int $stt
 * @property string $province_title
 * @property string $province_solr_id
 * @property string $created_at
 * @property string $updated_at
 */
class District extends ActiveRecord
{
    public static function tableName()
    {
        return 'districts';
    }

    public function rules()
    {
        return [
            [['api_id', 'province_id', 'solr_id', 'title', 'province_title', 'province_solr_id'], 'required'],
            [['api_id', 'province_id', 'type', 'stt'], 'integer'],
            [['solr_id'], 'string', 'max' => 100],
            [['title', 'province_title'], 'string', 'max' => 100],
            [['province_solr_id'], 'string', 'max' => 50],
            [['created_at', 'updated_at'], 'safe'],
            [['api_id', 'solr_id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'api_id' => 'API ID',
            'province_id' => 'Tỉnh/Thành ID',
            'solr_id' => 'Solr ID',
            'title' => 'Tên Quận/Huyện',
            'type' => 'Type',
            'stt' => 'Số Thứ Tự',
            'province_title' => 'Tên Tỉnh/Thành',
            'province_solr_id' => 'Solr ID Tỉnh',
            'created_at' => 'Ngày Tạo',
            'updated_at' => 'Ngày Cập Nhật',
        ];
    }

    /**
     * Quan hệ ngược: Quận/huyện thuộc về một tỉnh
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::class, ['api_id' => 'province_id']);
    }
}