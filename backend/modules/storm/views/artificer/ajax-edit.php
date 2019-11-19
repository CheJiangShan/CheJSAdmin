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
            <h4 class="modal-title">编辑技术信息</h4>
        </div>
<!--        --><?//= $form->field($model, 'realname')->textInput([
//            'readonly' => !empty($model->storm_name)
//        ])->hint('创建后不可修改')->label('技师名称') ?>
        <div class="modal-body">
            <?= $form->field($model, 'realname')->textInput()->label('技师名称') ?>

            <?= $form->field($model, 'mobile')->textInput() ?>

            <?= $form->field($model, 'storm_id')->dropDownList($stormAll,['prompt'=>'平台'])->label('门店') ?>
            <?= $form->field($model, 'identity')->dropDownList(Yii::$app->params['ArtificerType'])->label('技术类型')?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </div>

<?php ActiveForm::end(); ?>