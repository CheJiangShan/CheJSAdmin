<?php

namespace backend\modules\storm\controllers;

use Yii;
use common\models\base\SearchModel;
use common\components\Curd;
use common\models\storm\Storm;
use common\models\storm\Artificer;
use common\enums\StatusEnum;
use backend\controllers\BaseController;

/**
 * 门店管理
 *
 * Class MemberController
 * @package backend\modules\member\controllers
 * @author cuicui
 */
class StormController extends BaseController
{
    use Curd;

    /**
     * @var \yii\db\ActiveRecord
     */
    public $modelClass = Storm::class;

    public $AmodelClass = Artificer::class;

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
            'partialMatchAttributes' => ['storm_name','storm_num'], // 模糊查询
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
                ->andFilterWhere(['id' => $this->getStormId()])
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

        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }
}