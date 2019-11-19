<?php
namespace common\models\storm;

use common\models\base\BaseModel;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%storm}}".
 */
class Storm extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%storm}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['storm_name', 'province_id','city_id','area_id','address'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'storm_num' => '门店编号',
            'storm_name' => '门店名称',
            'province_id' => '省',
            'city_id' => '市',
            'area_id' => '市',
            'address' => '地址详情',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',

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
            'backendCreate' => ['storm_name', 'province_id','city_id','area_id','address','storm_num'],
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
            $counts = $this::find()->count()+1;
            $this->last_ip = Yii::$app->request->getUserIP();
            $this->storm_num = '10000'.$counts;
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}
