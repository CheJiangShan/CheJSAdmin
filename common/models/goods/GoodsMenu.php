<?php
namespace common\models\goods;

use Yii;
use common\helpers\TreeHelper;

/**
 * This is the model class for table "{{%goods_menu}}".
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
class GoodsMenu extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%goods_menu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'pid', ], 'required'],
            [[ 'pid', 'level', 'sort', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['tree'], 'string', 'max' => 300],
            [['level'], 'default', 'value' => 1],
            [[ 'title'], 'trim'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'pid' => '父级',
            'tree' => '树',
            'level' => '级别',
            'sort' => '排序',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'pid']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            if ($this->pid == 0) {
                $this->tree = TreeHelper::defaultTreeKey();
            } else {
                $parent = $this->parent;
//                $this->cate_id = $parent->cate_id;
                $this->level = $parent->level + 1;
                $this->tree = $parent->tree . TreeHelper::prefixTreeKey($parent->id);
            }
        } else {
            // 修改父类
            if ($this->oldAttributes['pid'] != $this->pid) {
                $parent = $this->parent;
//                $this->cate_id = $parent->cate_id;
                $level = $parent->level + 1;
                $tree = $parent->tree . TreeHelper::prefixTreeKey($parent->id);
                // 查找所有子级
                $list = self::find()
                    ->where(['like', 'tree', $this->tree . TreeHelper::prefixTreeKey($this->id) . '%', false])
                    ->select(['id', 'level', 'tree'])
                    ->asArray()
                    ->all();

                /** @var GoodsMenu $item */
                foreach ($list as $item) {
                    $itemLevel = $item['level'] + ($level - $this->level);
                    $itemTree = str_replace($this->tree, $tree, $item['tree']);
                    self::updateAll(['level' => $itemLevel, 'tree' => $itemTree], ['id' => $item['id']]);
                }

                $this->level = $level;
                $this->tree = $tree;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        self::deleteAll(['like', 'tree', $this->tree . TreeHelper::prefixTreeKey($this->id) . '%', false]);

        return parent::beforeDelete();
    }
}
