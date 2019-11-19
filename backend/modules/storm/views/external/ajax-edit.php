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
            <h4 class="modal-title">外拓人员信息</h4>
        </div>
        <div class="modal-body">
            <?= $form->field($model, 'realname')->textInput() ?>
            <?= $form->field($model, 'mobile')->textInput() ?>
            <?= $form->field($model, 'storm_id')->dropDownList($stormAll)->label('门店') ?>
            <?= $form->field($model, 'identity')->dropDownList(Yii::$app->params['identity'])->label('身份')?>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </div>

    <script>


        $('#member-store_id').change(function () {
            var strore_id = $(this).val();
            $.post("<?= Url::to(['ajaxstr']) ?>",{strore_id:strore_id},function (msg) {
                console.log(msg);
            });
        })
    </script>
<?php ActiveForm::end(); ?>