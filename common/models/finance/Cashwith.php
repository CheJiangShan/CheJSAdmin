<?php
/*用户提现列表*/
namespace common\models\finance;

use common\models\member\Member;
use Yii;
use common\helpers\TreeHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property int $id
 * @property int $user_id 申请者ID
 * @property int $admin_id 后台操作者ID
 * @property string $bankcard 银行卡号
 * @property string $bankname 卡号归属地
 * @property string $accountname 持卡者名称
 * @property string $phoneno 持卡者手机号
 * @property string $idcard 持卡者身份证
 * @property string $reason 转账失败原因
 * @property int $amount 提现金额
 * @property int $status 状态[1:发起提现;2:提现成功;3转账失败]
 * @property string $created_at 添加时间
 * @property string $updated_at 修改时间
 */
class Cashwith extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cashwith}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'admin_id', 'bankcard','bankname','accountname','phoneno','idcard','amount'], 'required'],
            [[ 'user_id', 'admin_id', 'bankcard','phoneno','idcard'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '申请者',
            'admin_id' => '操作者',
            'bankcard' => '银行卡号',
            'bankname' => '卡号归属地',
            'accountname' => '持卡者名称',
            'phoneno' => '手机号',
            'idcard' => '身份证',
            'amount' => '提现金额',
            'status' => '状态',
            'reason' => '转账失败原因',
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
            'backendCreate' => ['user_id', 'bankcard'],
            'default' => array_keys($this->attributeLabels()),
        ];
    }


    /**
     * 关联上报者用户
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::class, ['id' => 'user_id']);
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}
