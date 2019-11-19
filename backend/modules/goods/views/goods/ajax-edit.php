<?php
use yii\widgets\ActiveForm;
use common\helpers\Url;
use common\enums\StatusEnum;

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['ajax-edit', 'id' => $model['id']]),
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ]
]);
?>
<style>
    .modal-content{
        width: 860px;
        margin-left: -124px;
    }
</style>

    <div class="modal-header" style="width: 846px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">商品信息添加</h4>
    </div>
    <div class="modal-body">
        <?= $form->field($model, 'goods_name')->textInput() ?>
        <?= $form->field($model, 'goods_menu_id')->dropDownList($menuDropDownList) ?>
        <?= $form->field($model, 'goods_img')->widget('common\widgets\webuploader\Files', [
            'type' => 'files',
            'config' => [ // 配置同图片上传
                // 'server' => \yii\helpers\Url::to(['file/files']), // 默认files 支持videos/voices/images方法验证
                'pick' => [
                    'multiple' => false,
                ]
            ]
        ]);?>
        <?= $form->field($model, 'goods_price')->textInput() ?>
        <?= $form->field($model, 'goods_adap')->dropDownList(Yii::$app->params['GoodsAdap']) ?>
        <?= $form->field($model, 'goods_early')->textInput() ?>
        <?= $form->field($model, 'goods_stock')->textInput() ?>
        <?= $form->field($model, 'count_stock')->textInput() ?>
        <?= $form->field($model, 'storm_stock')->textInput() ?>
        <?= $form->field($model, 'status')->radioList(StatusEnum::$listExplain) ?>
        <?= $form->field($model, 'pay_type')->radioList(StatusEnum::$payExplain) ?>
        <?= $form->field($model, 'remarks')->textarea(['rowe'=>3]) ?>
        <?= $form->field($model, 'sort')->textInput() ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
        <button class="btn btn-primary" type="submit">保存</button>
    </div>
<?php ActiveForm::end(); ?>