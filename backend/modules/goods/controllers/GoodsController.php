<?php
namespace backend\modules\goods\controllers;

use common\enums\StatusEnum;
use common\models\base\SearchModel;
use common\models\goods\Goods;
use Yii;
use common\components\Curd;
use backend\controllers\BaseController;

/**
 * 商品信息管理
 *
 * Class MemberController
 * @package backend\modules\goods\controllers
 * @author cuicui
 */
class  GoodsController extends BaseController{
    use Curd;
    /**
     * @var \yii\db\ActiveRecord
     */

    public $modelClass = Goods::class;

    /**
     * Lists all Tree models.
     * @return mixed
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
//        if (Yii::$app->user->getId() == Yii::$app->params['adminAccount']) {
            $dataProvider->query
                ->andWhere(['>=', 'status', StatusEnum::DISABLED]);
//        }
        return $this->render($this->action->id, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'menuDropDownList' => Yii::$app->services->sysMenu->getGoodsDropDownList(),
        ]);
    }

    /**
     * 编辑/创建
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionAjaxEdit(){
        $request = Yii::$app->request;
        $id = $request->get('id', '');
        $model = $this->findAllModel($id);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load($request->post())) {
            return $model->save()
                ? $this->redirect(['index'])
                : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }

        return $this->renderAjax('ajax-edit', [
            'model' => $model,
            'menuDropDownList' => Yii::$app->services->sysMenu->getGoodsDropDownList(),
        ]);
    }
}