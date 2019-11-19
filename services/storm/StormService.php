<?php
namespace services\storm;

use common\components\Service;
use common\models\sys\Manager;

/**
 * 门店
 *
 * Class MerchantService
 * @package services\merchant
 * @author jianyan74 <751393839@qq.com>
 */
class StormService extends Service
{
    /**
     * @var array
     */
    protected $info = [];

    protected $storm_id = 1;

    /**
     * @return int
     */
    public function getId()
    {
        $this->storm_id = Manager::find()->where(['id'=>\Yii::$app->user->getId()])->select('storm_id')->asArray()->one();
        return $this->storm_id;
    }

    /**
     * @param $storm_id
     */
    public function setId($storm_id)
    {
        $this->storm_id = $storm_id ? $storm_id : Manager::find()->where(['id'=>\Yii::$app->user->getId()])->select('storm_id')->one();
        $this->setInfo($storm_id);
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param $storm_id
     */
    public function setInfo($storm_id)
    {
        // TODO 查询门店是否存在

        $this->info = [];
    }
}