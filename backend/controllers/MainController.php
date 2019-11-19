<?php

namespace backend\controllers;

use common\models\storm\Report;
use common\models\storm\Storm;
use Yii;
use backend\forms\ClearCache;

/**
 * 主控制器
 *
 * Class MainController
 * @package backend\controllers
 * @author jianyan74 <751393839@qq.com>
 */
class MainController extends BaseController
{
    /**
     * 系统首页
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial($this->action->id, [
        ]);
    }

    /**
     * 子框架默认主页
     *
     * @return string
     */
    public function actionSystem()
    {
        $stormCount = Storm::find()->count();
//        $report = Report::find()->select('latitude,latitude')->all();
        $report = Yii::$app->getDb()->createCommand("SELECT latitude , longitude FROM cjs_report")->queryAll();
        $arr = [];
//        $a = [[113.694753, 34.734068], [113.666978, 34.755472], [113.690515, 34.736549], [113.663803, 34.758574]];
        foreach ($report as $v){
            $arr[] = $v;
        }
        return $this->render($this->action->id, [
            'storm' => $stormCount,
            'report' => $arr,
        ]);
    }

    /**
     * 清理缓存
     *
     * @return string
     */
    public function actionClearCache()
    {
        $model = new ClearCache();
        if ($model->load(Yii::$app->request->post())) {
            return $model->save()
                ? $this->message('清理成功', $this->refresh())
                : $this->message($this->getError($model), $this->refresh(), 'error');
        }

        return $this->render($this->action->id, [
            'model' => $model
        ]);
    }
}