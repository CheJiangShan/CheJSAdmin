<?php
namespace common\models\storm;

use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%storm}}".
 */
class Report extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%report}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ins_type', 'address','ins_car_name'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单ID',
            'address' => '事故地址',
            'ins_type' => '事故类别',
            'ins_car_name' => '事故车型',
            'ins_img' => '事故现场图片',
            'ins_tel' => '事故方电话',
            'ins_plate' => '事故方车牌',
            'createtime' => '创建时间',
            'status' => '状态',

        ];
    }

    /**
     * 场景
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'backendCreate' => ['ins_type', 'address','ins_tel','ins_plate'],
            'default' => array_keys($this->attributeLabels()),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
//            $this->last_ip = Yii::$app->request->getUserIP();
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['createtime'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}
