<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\models\member\Member;
use common\helpers\ArrayHelper;

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'class' => 'form-horizontal',
    'validationUrl' => Url::to(['ajax-edit', 'id' => $model['id']]),
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ]
]);
?>

    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">新增事故订单</h4>
        </div>
        <div class="modal-body">
            <div style="padding: 15px">
                外拓订单编号： <?= $model->order_num ?><br/>
                事故地址：<?= $model->report->address ?><br/>
                事故类型：<?= $model->report->ins_type == 1 ? '轻微擦碰' : $model->report->ins_type == 2 ? '严重损伤' :'无法行驶' ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 事故车型： <?= $model->report->ins_car_name ?>
            </div>


            <?= $form->field($model, 'a')->textInput()->label('姓名') ?>
            <?= $form->field($model, 'b')->textInput()->label('车型') ?>
            <?= $form->field($model, 'c')->textInput()->label('车牌号') ?>
            <?= $form->field($model, 'd')->textInput()->label('手机号') ?>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </div>
<?php ActiveForm::end(); ?>