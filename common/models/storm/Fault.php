<?php
namespace common\models\storm;

use common\models\base\BaseModel;
use common\models\member\Member;
use OSS\OssClient;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%storm}}".
 */
class Fault extends BaseModel
{
    public  $a; // 对于参数
    public  $b; // 对于参数
    public  $c; // 对于参数
    public  $d; // 对于参数
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return '{{%order_report}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_num', 'user_id','exten_id','pid','artificer_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_num' => '事故订单编号',
            'user_id' => '上报者名称',
            'exten_id' => '外拓人员',
            'artificer_id' => '班组人员',
            'order_status' => '订单状态',
            'pay_status' => '支付状态',
            'status' => '状态',
            'pid' => '父级',
            'createtime' => '创建时间',


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
            'backendCreate' => ['order_num', 'user_id','exten_id' ,'artificer_id','order_status','pay_status'],
            'ArtificerCreate' => ['artificer_id'],
            'default' => array_keys($this->attributeLabels()),
        ];
    }


    /**
     * 关联上报者用户
     * @return \yii\db\ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasOne(Member::class, ['id' => 'user_id']);
    }

    /**
     * 关联事故信息
     * @return \yii\db\ActiveQuery
     */
    public function getReport()
    {
        return $this->hasOne(Report::class, ['order_id' => 'id']);
    }

    /**
     * 关联事故信息
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExternal()
    {
        return $this->hasOne(External::class, ['id' => 'exten_id']);
    }


    /**
     * 关联事故信息
     * @return \yii\db\ActiveQuery
     */
    public function getArtificer()
    {
        return $this->hasOne(Artificer::class, ['id' => 'artificer_id']);
    }

    /*添加事故子订单*/
    public function SaveAdd(){
      if (Yii::$app->request->isPost) {
        $id = Yii::$app->request->get('id');
        $post_data = Yii::$app->request->post('Fault');
        $transaction = Yii::$app->db->beginTransaction();
        try {
          /*订单*/
          $order_res = Fault::find()->where(['id' => $id])->asArray()->one();
          $counts =  Fault::find()->where(['pid'=>$id])->count() + 1;
          $order_re = [
            'order_num' => $order_res['order_num'] . '-' . $counts,
            'user_id' => $order_res['user_id'],
            'exten_id' => $order_res['exten_id'],
            'status' => $order_res['status'],
            'order_status' => $order_res['order_status'],
            'pay_status' => $order_res['pay_status'],
            'createtime' => time(),
            'pid' => $order_res['id'],
          ];
          $f = new Fault();
          $f->setAttributes($order_re);
          $f->save();
            /*事故信息*/
            if ($f->attributes['id']) {
                $report_a = Report::find()->where(['order_id' => $id])->asArray()->one();
                $report = [
                    'order_id' => $f->attributes['id'],
                    'address' => $report_a['address'],
                    'ins_type' => $report_a['ins_type'],
                    'ins_car_name' => $post_data['b'],
                    'ins_name' => $post_data['a'],
                    'ins_plate' => $post_data['c'],
                    'ins_tel' => $post_data['d'],
                    'status' => $report_a['status'],
                ];
                $r = new Report();
                $r->setAttributes($report);
                $bool = $r->save();
                if ($bool) {
                    $transaction->commit();
                    return ['code' => 3];
                } else {
                    $transaction->rollBack();
                    return ['code' => -2];
                }
            }
        }catch (\Exception $e){
          $transaction->rollBack();
          return ['code'=>-1,'msg'=>$e->getMessage()];
        }
      }

    }




    /* 访问图片  */
    public function OssVisit($ImgUrl){
        $accessKeyId = 'LTAI4FmRWhTuiATBNsnWFjAW';
        $accessKeySecret = 'XHs01bAhRhOZF6yoYpDcYplAIlmr3n';
// Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = "http://oss-cn-beijing.aliyuncs.com";
// 存储空间名称
        $bucket= "chejiangshan";
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
// 生成一个带签名的URL，有效期是3600秒，可以直接使用浏览器访问。
        $timeout = 3600;
        try {
            $options = array(
                OssClient::OSS_PROCESS => "image/resize,m_lfit,h_100,w_100");
            $signedUrl = $ossClient->signUrl($bucket, "Accident/" . $ImgUrl, $timeout, "GET", $options);
            return $signedUrl;
        }catch (\Exception $e){
            return false;
        }
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
