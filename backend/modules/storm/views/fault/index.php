<?php

use yii\grid\GridView;
use common\helpers\Html;

$this->title = '事故订单管理';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
<!--                <div class="box-tools">-->
<!--                    --><?//= Html::create(['ajax-edit'], '创建', [
//                        'data-toggle' => 'modal',
//                        'data-target' => '#ajaxModal',
//                    ]) ?>
<!--                </div>-->
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
//                        [
//                            'attribute' => 'id',
//                            'headerOptions' => ['class' => 'col-md-1'],
//                        ],
                        [
                            'label' => '上报客户',
                            'contentOptions' => [
                                'width'=>'150'
                            ],
//                            'headerOptions' => ['class' => 'col-md-2'],
                            'filter' => Html::activeTextInput($searchModel, 'members_username', [
                                    'class' => 'form-control',
                                ]
                            ),
                            'value' => function ($model) {
                                return  "名称：" . $model->members->username . '<br>' .
                                    "手机：" . $model->members->mobile . '<br>';
                            },
                            'format' => 'raw',
                        ],
                        'order_num',
                        [
                            'attribute' => 'order_status',
                            'value' => function($model) {
                                return Yii::$app->params['OrderStatus'][$model->order_status];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'order_status', Yii::$app->params['OrderStatus'], [
                                    'class' => 'form-control'
                                ]
                            )
                        ],
                        [
                            'label' => '事故地点',
                            'contentOptions' => [
                                'width'=>'160'
                            ],
                            'value' => function($model) {
                                return $model->report->address;
                            },
                        ],
                        [
                            'label'=> '事故类型',
                            'filter' => Html::activeTextInput($searchModel, 'report_ins_type', [
                                    'class' => 'form-control',
                                    'placeholder' =>'标号搜索'
                                ]
                            ),
                            'value' => function($model) {
                                return $model->report->ins_type == 1 ? '1->轻微擦碰' : $model->report->ins_type == 2 ? '2->严重损伤' :'3->无法行驶';
                            },
                        ],
                        [
                            'label' => '车主名称',
                            'value' => function($model) {
                                return $model->report->ins_name ? $model->report->ins_name :'/';
                            },
                        ],
                        [
                            'label' => '事故车型',
                            'contentOptions' => [
                                'width'=>'160'
                            ],
                            'value' => function($model) {
                                return $model->report->ins_car_name ? $model->report->ins_car_name :'/';
                            },
                        ],
                        [
                            'label' => '事故车牌照',
                            'contentOptions' => [
                                'width'=>'140'
                            ],
                            'filter' => Html::activeTextInput($searchModel, 'report_ins_plate', [
                                    'class' => 'form-control',
                                    'placeholder' =>'牌照搜索'
                                ]
                            ),
                            'value' => function($model) {
                                return $model->report->ins_plate ? $model->report->ins_plate :'/';
                            },
                        ],
                        [
                            'label' => '车主电话',
                            'value' => function($model) {
                                return $model->report->ins_tel ? $model->report->ins_tel :'/';
                            },
                        ],
                      [
                        'label' => '外拓人员',
                          'contentOptions' => [
                              'width'=>'150'
                          ],
//                        'headerOptions' => ['class' => 'col-md-1'],
                        'filter' => Html::activeTextInput($searchModel, 'external_realname', [
                            'class' => 'form-control',
                            'placeholder' => '外拓人员'
                          ]
                        ),
                        'value' => function ($model) {
                            if ($model->external->realname || $model->external->mobile) {
                                return "名称：" . $model->external->realname . '<br>' .
                                    "手机：" . $model->external->mobile . '<br>';
                            }else{
                                return '未分配';
                            }
                        },
                        'format' => 'raw',
                      ],

                        [
                            'label' => '添加时间',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->createtime) ;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{ajax-edit} {SeeInfo} {destroy}',
                            'buttons' => [
                                'ajax-edit' => function ($url, $model, $key) {
                                     if (!$model->pid) {
                                       return Html::linkButton(['ajax-edit', 'id' => $model->id], '新增事故订单', [
                                         'data-toggle' => 'modal',
                                         'data-target' => '#ajaxModal',
                                       ]);
                                     }
                                },
                                'SeeInfo' => function ($url, $model, $key) {
                                        return Html::linkButton(['see-info', 'id' => $model->id], '事故详情');
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