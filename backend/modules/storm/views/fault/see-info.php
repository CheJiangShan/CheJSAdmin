<?php

use yii\grid\GridView;
use common\helpers\Html;

$this->title = '事故订单详情';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<style>
    .btn-primary{
        margin-left: 22px;
    }
</style>
<div  class="row">
        <div class="col-xs-7">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-cog"></i> 订单信息</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td width="100px">事故订单号：</td>
                            <td><?= $model->order_num; ?></td>
                        </tr>
                        <tr>
                            <td width="100px">维修总金额：</td>
                            <td>¥  3640.00</td>
                        </tr>
                        <tr>
                            <td width="100px">订单状态：</td>
                            <td><?= Yii::$app->params['OrderStatus'][$model->order_status] ; ?></td>
                        </tr>
                        <tr>
                            <td width="100px">外拓顾问：</td>
                            <td>
                                <?php
                                    if ($model->external->realname || $model->external->mobile){
                                        echo  $model->external->realname.'：'. $model->external->mobile;
                                    }else{
                                        echo  Html::create(['ajax-edit'], '选择外拓顾问', [
                                                'data-toggle' => 'modal',
                                                'data-target' => '#ajaxModal',
                                                ]);
                                    }
                                ?>
                        </tr>
                        <tr>
                            <td width="100px">服务班组：</td>
                            <td>
                                <?php
                                if ($model->artificer->realname || $model->artificer->mobile){
                                    echo  $model->artificer->realname.'：'. $model->artificer->mobile;
                                    echo  Html::create(['artificer','id'=>$model->id], '选择服务班组', [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModal',
                                    ]);
                                }else{
                                    echo  Html::create(['artificer','id'=>$model->id], '选择服务班组', [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModal',
                                    ]);
                                }
                                ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
            <div class="col-xs-5">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-code"></i> 上报客户</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <td colspan="2" width="150px">上报客户：</td>
                                <td colspan="2"><?= $model->members->username; ?></td>
                            </tr>
                            <tr>
                                <td  colspan="2" width="150px">上报客户手机号：</td>
                                <td colspan="2"><?= $model->members->mobile; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" width="150px">上报时所在地址：</td>
                                <td  colspan="2">郑州市陇海路与城东路交叉口南500米路东</td>
                            </tr>
                            <tr>
                                <td width="150px">线索奖励金：</td>
                                <td width="100px">¥ 10.00</td>
                                <td width="150px">发放时间：</td>
                                <td>2019.10.19 14:35</td>
                            </tr>
                            <tr>
                                <td width="150px">维修奖励金：</td>
                                <td  width="100px">¥ 100.00</td>
                                <td width="150px">发放时间：</td>
                                <td>2019.10.19 14:35</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-cog"></i> 事故线索详情</h3>
            </div>
            <div class="box-body table-responsive">
                <table class="table">
                    <tr>
                        <td width="150px" style="color: red">事故地址：</td>
                        <td  width="300px" style="color: red"><?= $model->report->address; ?></td>
                        <td width="150px">事故类型：</td>
                        <td  width="300px"><?= $model['report']['ins_type'] == 1 ?'轻微擦碰': $model['report']['ins_type'] == 2 ?'严重损伤' :'无法行驶' ?></td>
                        <td width="150px">事故车型：</td>
                        <td><?= $model->report->ins_car_name; ?></td>
                    </tr>
                    <tr>
                        <td width="150px">事故方手机号：</td>
                        <td><?= $model->report->ins_tel ?$model->report->ins_tel:'无填写' ; ?></td>
                        <td width="150px">事故方车牌号：</td>
                        <td><?= $model->report->ins_plate?$model->report->ins_plate:'无填写' ;  ?></td>
                        <td width="150px"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>事故照片：</td>
                        <?php $img = explode(',',$model->report->ins_img);
                            $Imgs = new \common\models\storm\Fault();
                            foreach ($img as $v){
                                echo '<td><img width="160px" height="80px" src="'.$Imgs->OssVisit($v).'" alt=""> </td>
';
                            }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php if ($model->pid == 0){ ?>
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-cog"></i> 事故维修订单</h3>
            </div>
            <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>事故维修订单号</th>
                            <th>所属门店</th>
                            <th>事故车主姓名</th>
                            <th>事故车型</th>
                            <th>事故车牌号</th>
                            <th>维修金额</th>
                            <th>出单失败原因</th>
                            <th>维修失败原因</th>
                            <th>备注</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($model_P as $v) { ?>
                                    <tr id="">
                                        <td><?= $v->order_num; ?></td>
                                        <td>/</td>
                                        <td><?= $v->report->ins_name?$v->report->ins_name:'/' ?></td>
                                        <td><?= $v->report->ins_car_name?$v->report->ins_car_name:'/' ?></td>
                                        <td><?= $v->report->ins_plate?$v->report->ins_plate:'/' ?></td>
                                        <td>10</td>
                                        <td>10</td>
                                        <td>10</td>
                                        <td>10</td>
                                    </tr>
                                <?php }?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>

    <?php } ?>

    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-cog"></i> 订单处理日志</h3>
            </div>
            <div class="box-body table-responsive">

            </div>
        </div>
    </div>

</div>
