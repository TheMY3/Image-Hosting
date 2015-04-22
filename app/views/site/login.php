<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
?>
<div class="modal-dialog">
    <div class="modal-content">
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-xs-9\">{input}{error}</div>",
                'labelOptions' => ['class' => 'col-xs-3 control-label'],
            ],
        ]);
        ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="modal-body">
            <?= $form->field($model, 'username') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="modal-text-divider">
                или:
            </div>
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                'popupMode' => false,
            ]) ?>
        </div>
        <div class="modal-footer">
            <div class="form-group">
                <div class="col-xs-4">
                    <?= Html::a('Create new account', ['registration'], ['class' => 'pull-left modalWindow btn btn-primary']);?>
                </div>
                <div class="col-xs-8">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$js = <<<JS
jQuery('#login-form').on('beforeSubmit', function(){
    var form = jQuery(this);
    jQuery.post(
        form.attr("action"),
        form.serialize()
    )
    .done(function(result) {
        form.parent().replaceWith(result);
    })
    .fail(function() {
        console.log("server error");
    });
    return false;
})
JS;
$this->registerJs($js);