<?php

use yii\grid\GridView;
use common\helpers\Html;

$this->title = '外拓人员';
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
                            'attribute' => 'storm_id',
                            'label' => '所属门店(按数字搜索)',
                            'value' => function($model) {
                                return $model->storm_id .'：'.\common\models\storm\Storm::find()->where(['id'=>$model->storm_id])->one()['storm_name'] ;
                            },
                        ],
                        'realname',
                        'mobile',

                        [
                            'attribute' => 'identity',
                            'value' => function ($model, $key, $index, $column) {
                                return Yii::$app->params['identity'][$model->identity];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'identity', Yii::$app->params['identity'], [
                                    'class' => 'form-control'
                                ]
                            )
                        ],

                        [
                            'label' => '添加时间',
                            'filter' => true, //不显示搜索框
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->created_at) ;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{ajax-edit} {status} {destroy}',
                            'buttons' => [
                                'ajax-edit' => function ($url, $model, $key) {
                                    return Html::linkButton(['ajax-edit', 'id' => $model->id], '修改信息', [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModal',
                                    ]);
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