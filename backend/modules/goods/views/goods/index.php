<?php

use yii\grid\GridView;
use common\helpers\Html;
use common\enums\StatusEnum;

$this->title = '商品信息';
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
                        'goods_num',
                        'goods_name',
                        'goods_price',
                        [
                            'attribute' => 'goods_menu_id',
                            'value' => function ($model) {
                                return \common\models\goods\GoodsMenu::find()->where(['id'=>$model->goods_menu_id])->select('title')->one()['title'];
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'goods_menu_id', $menuDropDownList, [
                                    'class' => 'form-control'
                                ]
                            )
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                    if ($model->status == 1){
                                        return '上架';
                                    }else{
                                        return '下架';
                                    }
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status', StatusEnum::$listExplain, [
                                    'class' => 'form-control'
                                ]
                            )
                        ],
                        [
                            'attribute' => 'pay_type',
                            'value' => function ($model) {
                                if ($model->pay_type == 1){
                                    return '线上支付';
                                }else{
                                    return '线下支付';
                                }
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'pay_type', StatusEnum::$payExplain, [
                                    'class' => 'form-control'
                                ]
                            )
                        ],
                        'sort',
                        'goods_stock',
                        'count_stock',
                        'storm_stock',
                        'supplier',
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