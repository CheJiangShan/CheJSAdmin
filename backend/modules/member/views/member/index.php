<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\helpers\ImageHelper;

$this->title = '会员信息';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
                <div class="box-tools">
                    <?= Html::create(['ajax-edit'], '创建', [
                        'data-toggle' => 'modal',
                        'data-target' => '#ajaxModal',
                    ]) ?>
                </div>
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
                            'headerOptions' => ['class' => 'col-md-1'],
                        ],
                        [
                            'attribute' => 'head_portrait',
                            'value' => function ($model) {
                                return Html::img(ImageHelper::defaultHeaderPortrait(Html::encode($model->head_portrait)),
                                    [
                                        'class' => 'img-circle rf-img-md img-bordered-sm',
                                    ]);
                            },
                            'filter' => false,
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'username',
                            'filter' => false, //不显示搜索框
                        ],
                        'realname',
                        'mobile',
//                        [
//                            'attribute' => 'type',
//                            'label' => '身份类别',
//                            'value' => function($model) {
//                                return $model->type == 1 ? "会员" : "关闭";
//                            },
//                        ],
                        [
                            'label' => '账户金额',
                            'contentOptions' => [
                                'width'=>'150'
                            ],
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return "余额：" . $model->user_money ;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'label' => '最后登陆',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return "注册时间：" . Yii::$app->formatter->asDatetime($model->created_at);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{ajax-edit} {viewup}  {edit} {status} {destroy}',
                            'buttons' => [
                                'ajax-edit' => function ($url, $model, $key) {
                                    return Html::linkButton(['ajax-edit', 'id' => $model->id], '账号密码', [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModal',
                                    ]);
                                },

                                'viewup' => function ($url, $model, $key) {
                                    return Html::linkButton(['viewup', 'id' => $model->id],'提现记录');
                                },
                                /*收货地址*/
////                                'address' => function ($url, $model, $key) {
////                                    return Html::linkButton(['address/index', 'member_id' => $model->id], '收货地址');
////                                },
//                            /*充值*/
////                                'recharge' => function ($url, $model, $key) {
////                                    return Html::linkButton(['recharge', 'id' => $model->id], '充值', [
////                                        'data-toggle' => 'modal',
////                                        'data-target' => '#ajaxModal',
////                                    ]);
////                                },
                                'edit' => function ($url, $model, $key) {
                                    return Html::edit(['edit', 'id' => $model->id]);
                                },
                                'status' => function ($url, $model, $key) {
                                    return Html::status($model->status);
                                },
                                'destroy' => function ($url, $model, $key) {
                                    return Html::delete(['destroy', 'id' => $model->id]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>