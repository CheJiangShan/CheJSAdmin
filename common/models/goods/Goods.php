<?php
namespace common\models\goods;

use Yii;
use common\helpers\TreeHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $pid 上级id
 * @property int $level 级别
 * @property int $sort 排序
 * @property string $params 参数
 * @property string $tree 树
 * @property int $status 状态[-1:删除;0:禁用;1启用]
 * @property string $created_at 添加时间
 * @property string $updated_at 修改时间
 */
class Goods extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goods_num', 'goods_name', 'goods_price','goods_early', 'goods_img', 'goods_menu_id', 'goods_stock', 'count_stock', 'storm_stock', 'stomr_stock'], 'required'],
            [[ 'goods_menu_id', 'goods_stock', 'count_stock', 'stomr_stock', 'storm_stock','sort','status','pay_type','goods_adap'], 'integer'],
            [['goods_name'], 'string', 'max' => 50],
            [['goods_price'], 'double'],
            [[ 'goods_name','remarks'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_num' => '商品编号',
            'goods_name' => '商品名称',
            'goods_price' => '商品价格',
            'goods_img' => '商品图片',
            'goods_early' => '商品期初库存',
            'goods_adap' => '适配车型价格',
            'goods_menu_id' => '分类名称',
            'goods_stock' => '商品库存',
            'count_stock' => '总警戒库存',
            'storm_stock' => '门店警戒库存',
            'pay_type' => '支付类型',
            'sort' => '商品权重',
            'remarks' => '备注',
            'supplier' => '供货商数量',
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
            'backendCreate' => ['goods_name', 'goods_num'],
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @return bool
     */
    /*public function beforeDelete()
    {
        self::deleteAll(['like', 'tree', $this->tree . TreeHelper::prefixTreeKey($this->id) . '%', false]);

        return parent::beforeDelete();
    }*/
}
