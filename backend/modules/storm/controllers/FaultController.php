<?php

namespace backend\modules\storm\controllers;

use common\helpers\ArrayHelper;
use common\models\storm\Fault;
use common\models\storm\Artificer;
use Yii;
use common\models\base\SearchModel;
use common\components\Curd;
use common\enums\StatusEnum;
use backend\controllers\BaseController;
/**
 * 事故订单管理
 *
 * Class MemberController
 * @package backend\modules\member\controllers
 * @author cuicui
 */
class FaultController extends BaseController
{
    use Curd;

    /**
     * @var \yii\db\ActiveRecord
     */
    public $modelClass = Fault::class;

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
            'relations' => ['report' => ['ins_type','ins_plate'],'members'=>['username'],'external'=>['realname']], // 关联表（可以是Model里面的关联）
            'partialMatchAttributes' => ['order_num','report_ins_type','report_ins_plate','members_username','external_realname'], // 模糊查询
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => $this->pageSize
        ]);

        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);
        if (Yii::$app->user->getId() == Yii::$app->params['adminAccount']) {
            $dataProvider->query
                ->andWhere(['>=', $this->modelClass::tableName().'.status', StatusEnum::DISABLED]);
        }else{
            $dataProvider->query
                ->andFilterWhere(['id' => $this->getStormId()])
                ->andWhere(['>=', 'status', StatusEnum::DISABLED])->with('members');
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
//        $this->activeFormValidate($model);
        if (Yii::$app->request->isPost) {
                  $f = new Fault();
            return $f->SaveAdd()
                ? $this->redirect(['index'])
                : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }
        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }


    /**
     * 查看事故详情
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSeeInfo(){
        $id = Yii::$app->request->get('id');
        $model = $this->modelClass::find()->where(['id'=>$id])->with('external')->with('members')->with('report')->with('artificer')->one();
        $model_P = $this->modelClass::find()->where(['pid'=>$id])->with('report')->all();
//        var_dump($model);
        return $this->render($this->action->id, [
            "model" => $model,
            "model_P" => $model_P,
        ]);
    }

    /**
     * 查看事故详情
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\base\ExitException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionArtificer(){

        $id = Yii::$app->request->get('id');
        $model = $this->findAllModel($id);
        $model->scenario = 'ArtificerCreate';
        $modelInfo = clone $model;

        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load(Yii::$app->request->post())) {
//            var_dump(Yii::$app->request->post());die();
            return $model->save()
                ? $this->redirect(['see-info','id'=>$id])
                : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }
        return $this->renderAjax($this->action->id, [
            'model' => $model,
            "artificer" =>   $storm_all = ArrayHelper::map(Artificer::find()->select('id,realname')->asArray()->all(),'id','realname'),
        ]);

    }
}