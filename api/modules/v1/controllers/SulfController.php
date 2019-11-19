<?php

namespace api\modules\v1\controllers;

use api\controllers\OnAuthController;
use common\helpers\ResultDataHelper;

/**
 * 默认控制器
 *
 * Class DefaultController
 * @package api\modules\v1\controllers
 * @property \yii\db\ActiveRecord $modelClass
 * @author jianyan74 <751393839@qq.com>
 */
class SulfController extends OnAuthController
{
  public $modelClass = '';

  /**
   * 不用进行登录验证的方法
   * 例如： ['index', 'update', 'create', 'view', 'delete']
   * 默认全部需要验证
   *
   * @var array
   */
  protected $optional = ['index','get-pass'];

  /**
   * @return string|\yii\data\ActiveDataProvider
   */
  public function actionIndex()
  {
     return 111;
  }


  public function actionGetPass()
  {
    if (\Yii::$app->request->isPost){
      try {
        $post_pass = \Yii::$app->request->post('pass');
        $md_pass['pass'] = \Yii::$app->security->generatePasswordHash($post_pass);
        $md_pass['token'] = \Yii::$app->security->generateRandomString();
        return $md_pass;
      }catch (\Exception $e){
        return $e->getMessage();
      }
    }
  }

}
