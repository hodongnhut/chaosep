<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property int $id
 * @property string $tax_code Mã số thuế (MaSoThue)
 * @property string $company_name Tên công ty (Title)
 * @property string|null $company_name_en Tên tiếng Anh (TitleEn)
 * @property string|null $address Địa chỉ công ty (DiaChiCongTy)
 * @property string|null $tax_notification_address Địa chỉ nhận thông báo thuế (DiaChiNhanThongBaoThue)
 * @property string|null $legal_representative Chủ sở hữu / Người đại diện (ChuSoHuu)
 * @property string|null $director Giám đốc (GiamDoc)
 * @property string|null $chief_accountant Kế toán trưởng (KeToanTruong)
 * @property string|null $established_date Ngày cấp / thành lập (NgayCap)
 * @property string|null $closed_date Ngày đóng MST (NgayDongMST)
 * @property string|null $industry Ngành nghề chính (NganhNgheTitle)
 * @property string|null $province Tỉnh/Thành phố (TinhThanhTitle)
 * @property string|null $district Quận/Huyện (QuanHuyenTitle)
 * @property string|null $ward Phường/Xã (PhuongXaTitle)
 * @property int|null $is_active Tình trạng hoạt động (IsDelete = false → true)
 * @property int|null $exists_in_gdt Có tồn tại trong GDT (ExitsInGDT)
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property int|null $capital Vốn điều lệ
 * @property int|null $employee_count Tổng số lao động
 */
class Company extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name_en', 'address', 'tax_notification_address', 'legal_representative', 'director', 'chief_accountant', 'established_date', 'closed_date', 'industry', 'province', 'district', 'ward', 'phone', 'email', 'website', 'capital', 'employee_count'], 'default', 'value' => null],
            [['is_active'], 'default', 'value' => 1],
            [['exists_in_gdt'], 'default', 'value' => 0],
            [['tax_code', 'company_name'], 'required'],
            [['address', 'tax_notification_address'], 'string'],
            [['established_date', 'closed_date', 'created_at', 'updated_at'], 'safe'],
            [['is_active', 'exists_in_gdt', 'capital', 'employee_count'], 'integer'],
            [['tax_code'], 'string', 'max' => 14],
            [['company_name', 'company_name_en', 'industry', 'website'], 'string', 'max' => 255],
            [['legal_representative', 'director', 'chief_accountant', 'email'], 'string', 'max' => 150],
            [['province', 'district', 'ward'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['tax_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tax_code' => Yii::t('app', 'Mã số thuế (MaSoThue)'),
            'company_name' => Yii::t('app', 'Tên công ty (Title)'),
            'company_name_en' => Yii::t('app', 'Tên tiếng Anh (TitleEn)'),
            'address' => Yii::t('app', 'Địa chỉ công ty (DiaChiCongTy)'),
            'tax_notification_address' => Yii::t('app', 'Địa chỉ nhận thông báo thuế (DiaChiNhanThongBaoThue)'),
            'legal_representative' => Yii::t('app', 'Chủ sở hữu / Người đại diện (ChuSoHuu)'),
            'director' => Yii::t('app', 'Giám đốc (GiamDoc)'),
            'chief_accountant' => Yii::t('app', 'Kế toán trưởng (KeToanTruong)'),
            'established_date' => Yii::t('app', 'Ngày cấp / thành lập (NgayCap)'),
            'closed_date' => Yii::t('app', 'Ngày đóng MST (NgayDongMST)'),
            'industry' => Yii::t('app', 'Ngành nghề chính (NganhNgheTitle)'),
            'province' => Yii::t('app', 'Tỉnh/Thành phố (TinhThanhTitle)'),
            'district' => Yii::t('app', 'Quận/Huyện (QuanHuyenTitle)'),
            'ward' => Yii::t('app', 'Phường/Xã (PhuongXaTitle)'),
            'is_active' => Yii::t('app', 'Tình trạng hoạt động (IsDelete = false → true)'),
            'exists_in_gdt' => Yii::t('app', 'Có tồn tại trong GDT (ExitsInGDT)'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'website' => Yii::t('app', 'Website'),
            'capital' => Yii::t('app', 'Vốn điều lệ'),
            'employee_count' => Yii::t('app', 'Tổng số lao động'),
        ];
    }

}
