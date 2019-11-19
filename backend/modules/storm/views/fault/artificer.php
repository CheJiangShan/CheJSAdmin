<?php

use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\models\member\Member;
use common\helpers\ArrayHelper;

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'class' => 'form-horizontal',
    'validationUrl' => Url::to(['artificer', 'id' => $model['id']]),
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ]
]);
?>

<div class="modal-content" style="width: 642px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">设置班组</h4>
    </div>
    <div class="modal-body">
        <?= $form->field($model, 'artificer_id')->dropDownList($artificer)?>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
        <button class="btn btn-primary" type="submit">保存</button>
    </div>
</div>
<?php ActiveForm::end(); ?>
