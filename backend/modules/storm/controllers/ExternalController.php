<?php

namespace backend\modules\storm\controllers;

use common\helpers\ArrayHelper;
use common\models\storm\Storm;
use Yii;
use common\models\base\SearchModel;
use common\components\Curd;
use common\models\storm\External;
use common\enums\StatusEnum;
use backend\controllers\BaseController;

/**
 * 外拓人员
 *
 * Class MemberController
 * @package backend\modules\member\controllers
 * @author cuicui
 */
class ExternalController extends BaseController
{
    use Curd;

    /**
     * @var \yii\db\ActiveRecord
     */
    public $modelClass = External::class;

    /**
     * 首页
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex()
    {
        $searchModel = new SearchModel([
            'model' => $this->modelClass,
            'scenario' => 'default',
            'partialMatchAttributes' => ['realname'], // 模糊查询
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => $this->pageSize
        ]);

        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);
        if (Yii::$app->user->getId() == Yii::$app->params['adminAccount']) {
            $dataProvider->query
                ->andWhere(['>=', 'status', StatusEnum::DISABLED]);
        }else{
            $dataProvider->query
                ->andFilterWhere(['storm_id' => $this->getStormId()])
                ->andWhere(['>=', 'status', StatusEnum::DISABLED]);
        }
        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * 编辑/创建
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAjaxEdit()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findAllModel($id);
        $model->scenario = 'backendCreate';
        $modelInfo = clone $model;

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
            return $model->save()
                ? $this->redirect(['index'])
                : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }

        if (Yii::$app->user->getId() == Yii::$app->params['adminAccount']) {
            $storm_all_a = Storm::find()->where(['>=', 'status', StatusEnum::DISABLED])->asArray()->select('id,storm_name')->all();
        }else{
            $storm_all_a = Storm::find()->where(['>=', 'status', StatusEnum::DISABLED])->andWhere(['storm_id'=> $this->getStormId()])->asArray()->select('id,storm_name')->all();
        }
        $storm_all = ArrayHelper::map($storm_all_a,'id','storm_name');
        return $this->renderAjax($this->action->id, [
            'model' => $model,
            'stormAll' => $storm_all,
        ]);
    }



}