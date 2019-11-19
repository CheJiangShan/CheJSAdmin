<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;

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

    <div class="modal-content" style="width: 663px">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">门店信息</h4>
        </div>
        <div class="modal-body">
            <?= $form->field($model, 'storm_name')->textInput([
                'readonly' => !empty($model->storm_name)
            ])->hint('创建后不可修改') ?>
            <?= \backend\widgets\provinces\Provinces::widget([
                'form' => $form,
                'model' => $model,
                'provincesName' => 'province_id',// 省字段名
                'cityName' => 'city_id',// 市字段名
                'areaName' => 'area_id',// 区字段名
//                 'template' => 'short' //合并为一行显示
            ]); ?>
            <?= $form->field($model, 'address')->textInput() ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </div>

<?php ActiveForm::end(); ?>