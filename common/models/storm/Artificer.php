<?php
namespace common\models\storm;

use common\helpers\RegularHelper;
use common\models\base\BaseModel;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%artificer}}".
 */
class Artificer extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%artificer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['realname', 'mobile','storm_id','identity','logintoken'], 'required'],
            [['mobile'], 'unique'],
            ['mobile', 'match', 'pattern' => RegularHelper::mobile(),'message' => '不是一个有效的手机号码'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'realname' => '名称',
            'mobile' => '手机号',
            'storm_id' => '门店',
            'status' => '状态',
            'identity' => '技术类型',
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
            'backendCreate' => ['realname', 'mobile','identity'],
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
            $this->logintoken = Yii::$app->security->generateRandomString();
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
