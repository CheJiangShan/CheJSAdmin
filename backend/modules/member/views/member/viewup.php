<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\helpers\ImageHelper;

$this->title = '用户提现记录';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //重新定义分页样式
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'visible' => false, // 不显示#
                        ],
                        [
                            'attribute' => 'id',
                            'contentOptions' => ['width'=>'100'],
                        ],
                        [
                            'attribute' => 'accountname',
                            'contentOptions' => ['width'=>'100'],
                        ],
                        [
                            'attribute' => 'phoneno',
                            'contentOptions' => ['width'=>'140'],
                        ],
                        [
                            'attribute' => 'bankname',
                            'contentOptions' => ['width'=>'140'],
                        ],
                        [
                            'attribute' => 'bankcard',
                            'contentOptions' => ['width'=>'180'],
                        ],
                        [
                            'attribute' => 'amount',
                            'contentOptions' => ['width'=>'100'],
                        ],
                        [
                            'label' => '申请时间',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->created_at) ;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => '转账时间',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->updated_at) ;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => '提现状态',
                            'value' => function ($model) {
                                if ($model->status == 1){
                                    $a = '发起提现';
                                }elseif ($model->status == 2){
                                    $a = '提现成功';
                                }else{
                                    $a  = "提现失败";
                                }
                                return $a;
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status', [''=>'全部',1=>'发起提现',2=>'提现成功',3=>'提现失败'], [
                                    'class' => 'form-control'
                                ]
                            )
                        ],
                        [
                            'label' => '失败原因',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return $model->reason ?$model->reason : '/';
                            },
                            'format' => 'raw',
                        ],

                    ],
                ]); ?>
            </div>
        </div>
    </div>