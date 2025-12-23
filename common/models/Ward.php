<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Ward
 * @package app\models
 *
 * @property int $id
 * @property int $api_id
 * @property int $province_id
 * @property int $district_id
 * @property string $solr_id
 * @property string $title
 * @property int $type
 * @property int $stt
 * @property string $province_title
 * @property string $province_solr_id
 * @property string $district_title
 * @property string $district_solr_id
 * @property string $created_at
 * @property string $updated_at
 */
class Ward extends ActiveRecord
{
    public static function tableName()
    {
        return 'wards';
    }

    public function rules()
    {
        return [
            [['api_id', 'province_id', 'district_id', 'solr_id', 'title', 'province_title', 'province_solr_id', 'district_title', 'district_solr_id'], 'required'],
            [['api_id', 'province_id', 'district_id', 'type', 'stt'], 'integer'],
            [['solr_id'], 'string', 'max' => 200],
            [['title', 'province_title', 'district_title'], 'string', 'max' => 100],
            [['province_solr_id'], 'string', 'max' => 50],
            [['district_solr_id'], 'string', 'max' => 100],
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
            'district_id' => 'Quận/Huyện ID',
            'solr_id' => 'Solr ID',
            'title' => 'Tên Phường/Xã',
            'type' => 'Type',
            'stt' => 'Số Thứ Tự',
            'province_title' => 'Tên Tỉnh/Thành',
            'province_solr_id' => 'Solr ID Tỉnh',
            'district_title' => 'Tên Quận/Huyện',
            'district_solr_id' => 'Solr ID Quận/Huyện',
            'created_at' => 'Ngày Tạo',
            'updated_at' => 'Ngày Cập Nhật',
        ];
    }

    /**
     * Quan hệ: Phường/Xã thuộc về một Quận/Huyện
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::class, ['api_id' => 'district_id']);
    }

    /**
     * Quan hệ: Phường/Xã thuộc về một Tỉnh/Thành phố
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::class, ['api_id' => 'province_id']);
    }

    /**
     * Lấy địa chỉ đầy đủ: Phường/Xã, Quận/Huyện, Tỉnh/Thành
     * @return string
     */
    public function getFullAddress()
    {
        return $this->title . ', ' . $this->district_title . ', ' . $this->province_title;
    }
}