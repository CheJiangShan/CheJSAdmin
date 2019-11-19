<?php
namespace backend\modules\goods\controllers;

use Yii;
use common\components\Curd;
use common\models\goods\GoodsMenu;
use backend\controllers\BaseController;
use yii\data\ActiveDataProvider;

/**
 * 服务信息管理
 *
 * Class MemberController
 * @package backend\modules\goods\controllers
 * @author cuicui
 */
class  ServiceInfoController extends BaseController{

    use Curd;
    /**
     * @var \yii\db\ActiveRecord
     */
    public $modelClass = GoodsMenu::class;

    /**
     * Lists all Tree models.
     * @return mixed
     */

    public function actionIndex()
    {
        $query = $this->modelClass::find()
            ->where(['type'=>2])
            ->orderBy('sort asc,created_at asc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 编辑/创建
     *
     * @return mixed|string|\yii\web\Response
     * @throws \yii\base\ExitException
     */
    public function actionAjaxEdit()
    {
        $request = Yii::$app->request;
        $id = $request->get('id', '');
        $model = $this->findAllModel($id);
        $model->pid = $request->get('pid', null) ?? $model->pid; // 父id
        $model->type = 2; // 类型
        // ajax 校验
        $this->activeFormValidate($model);
        if ($model->load($request->post())) {
            return $model->save()
                ? $this->redirect(['index'])
                : $this->message($this->getError($model), $this->redirect(['index']), 'error');
        }

        return $this->renderAjax('ajax-edit', [
            'model' => $model,
            'menuDropDownList' => Yii::$app->services->sysMenu->getGoodsDropDownList($id,2),
        ]);
    }
}