<?php

namespace common\models;


use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "consultation_requests".
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string|null $company
 * @property string|null $industry
 * @property string $source
 * @property string $status
 * @property string|null $notes
 * @property string $created_at
 * @property string $updated_at
 */
class ConsultationRequest extends ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_DEMO_SCHEDULED = 'demo_scheduled';
    const STATUS_DEMO_DONE = 'demo_done';
    const STATUS_CUSTOMER = 'customer';
    const STATUS_LOST = 'lost';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consultation_requests';
    }

    /**
     * Auto timestamp created_at & updated_at
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'phone'], 'required', 'message' => '{attribute} không được để trống.'],

            [['notes'], 'string'],

            [['email'], 'email', 'message' => 'Vui lòng nhập đúng định dạng email (ví dụ: example@congty.com).'],

            [['email'], 'unique', 'message' => 'Email này đã được đăng ký trước đó. Vui lòng dùng email khác.'],

            [['phone'], 'string', 'max' => 20, 'tooLong' => 'Số điện thoại không được vượt quá 20 ký tự.'],

            [['company', 'industry', 'source'], 'string', 'max' => 255, 'tooLong' => '{attribute} không được vượt quá 255 ký tự.'],

            [['status'], 'string'],

            [['status'], 'default', 'value' => self::STATUS_NEW],

            [['status'], 'in', 'range' => [
                self::STATUS_NEW,
                self::STATUS_CONTACTED,
                self::STATUS_DEMO_SCHEDULED,
                self::STATUS_DEMO_DONE,
                self::STATUS_CUSTOMER,
                self::STATUS_LOST,
            ], 'message' => 'Trạng thái không hợp lệ.'],

            [['source'], 'default', 'value' => 'website'],

            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'phone' => 'Số điện thoại (Zalo)',
            'company' => 'Tên công ty',
            'industry' => 'Lĩnh vực',
            'source' => 'Nguồn lead',
            'status' => 'Trạng thái',
            'notes' => 'Ghi chú',
            'created_at' => 'Thời gian đăng ký',
            'updated_at' => 'Cập nhật lần cuối',
        ];
    }

    // Scope tiện dụng để query lead mới hôm nay
    public function scopeNew($query)
    {
        return $query->where(['status' => self::STATUS_NEW]);
    }

    public function scopeToday($query)
    {
        return $query->where(['>=', 'created_at', date('Y-m-d 00:00:00')]);
    }
}