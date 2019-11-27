<?php

use yii\grid\GridView;
use common\helpers\Html;

$this->title = '用户提现列表';
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
                        'bankcard',
                        [
                            'attribute' => 'user_id',
                            'label' => '提现用户',
                            'contentOptions' => [
                                'width'=>'180'
                            ],
                            'filter' => Html::activeTextInput($searchModel, 'member_username', [
                                    'class' => 'form-control',
                                ]
                            ),
                            'value' => function ($model) {
                                return '提现人：'.$model->member->username.'<br/>'.'手机号：'.$model->member->mobile ;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'amount',
                            'contentOptions' => ['width'=>'100'],
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

                        [
                            'label' => '添加时间',
                            'filter' => false, //不显示搜索框
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDatetime($model->created_at) ;
                            },
                            'format' => 'raw',
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{RFSuccess} {ajax-edit} {destroy}',
                            'buttons' => [
                                'RFSuccess' => function ($url, $model, $key) {
                                    if ($model->status != 3 && $model->status != 2) {
                                        return Html::linkButton(['cash-with', 'id' => $model->id], '提现成功',[
                                            'class' => 'btn btn-primary btn-sm',
                                            'onclick' => "rfTwiceAffirm(this,'确定转账成功');return false;"
                                        ]);
                                    }
                                },
                                'ajax-edit' => function ($url, $model, $key) {
                                      if ($model->status != 3 && $model->status != 2) {
                                          return Html::linkButton(['ajax-edit', 'id' => $model->id], '提现失败', [
                                              'data-toggle' => 'modal',
                                              'data-target' => '#ajaxModal',
                                          ]);
                                      }

                                },
                                'destroy' => function ($url, $model, $key) {
                                    return Html::delete(['destroy','id'=>$model->id],'删除');
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>