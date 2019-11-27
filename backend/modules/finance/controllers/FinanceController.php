<?php

namespace backend\modules\finance\controllers;

use common\models\member\Member;
use Yii;
use common\models\base\SearchModel;
use common\components\Curd;
use common\models\finance\Cashwith;
use common\enums\StatusEnum;
use backend\controllers\BaseController;

/**
 * 财务    --用户提现审核
 *
 * Class MemberController
 * @package backend\modules\member\controllers
 * @author cuicui
 */
class FinanceController extends BaseController
{
    use Curd;

    /**
     * @var \yii\db\ActiveRecord
     */
    public $modelClass = Cashwith::class;

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
            'relations' => ['member'=>['username']], // 关联表（可以是Model里面的关联）
            'partialMatchAttributes' => ['member_username'], // 模糊查询
            'defaultOrder' => [
                'id' => SORT_DESC
            ],
            'pageSize' => $this->pageSize
        ]);

        $dataProvider = $searchModel
            ->search(Yii::$app->request->queryParams);
            $dataProvider->query
                ->andWhere(['>=', $this->modelClass::tableName().'.status', StatusEnum::DISABLED])
                 ->with('member');
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
            $user_id =  $this->modelClass::find()->where(['id'=>$id])->select('user_id,amount,status')->one();
            if ($user_id['status'] == 3){
                return  $this->message('已是失败数据', $this->redirect(['index']), 'error');
            }
            $dbTrans = Yii::$app->db->beginTransaction();
            try{
                $user_money =   Member::find()->where(['id' => $user_id['user_id']])->select('user_money')->one();
                Member::updateAll(['user_money' => ($user_money['user_money']+$user_id['amount'])],['id' => $user_id['user_id']]);
                $model->status = 3;
                $model->updated_at = time();
                $model->admin_id = Yii::$app->user->getId();
                $model->reason = Yii::$app->request->post('Cashwith')['reason'];
                $dbTrans->commit();
                return $model->save()
                    ? $this->redirect(['index'])
                    : $this->message($this->getError($model), $this->redirect(['index']), 'error');
            }catch (\Exception $e){
                $dbTrans->rollback();
               return  $this->message($e->getMessage(), $this->redirect(['index']), 'error');
            }

        }

        return $this->renderAjax($this->action->id, [
            'model' => $model,
        ]);
    }

    /*用户提现转账成功呢*/
    public function actionCashWith(){
        $id = Yii::$app->request->get('id');
        $model = $this->findAllModel($id);
        // ajax 校验
        $model->status = 2;
        $model->updated_at = time();
        $model->admin_id = Yii::$app->user->getId();
        return $model->save()
            ?  $this->message("转账成功", $this->redirect(['index']))
            : $this->message($this->getError($model), $this->redirect(['index']), 'error');

    }
}