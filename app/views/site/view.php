<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options'=>['enctype'=>'multipart/form-data'] // important
]);
echo $form->field($model, 'filename');

// display the image uploaded or show a placeholder
// you can also use this code below in your `view.php` file
$title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';
echo Html::img($model->getImageUrl(), [
    'class'=>'img-thumbnail',
    'alt'=>$title,
    'title'=>$title
]);

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
$form->field($model, 'filename');
$form->field($model, 'image')->fileInput(['id' => 'file-upload', 'accept' => 'image/*'])->label(false);
ActiveForm::end();

// render the submit button
echo Html::submitButton($model->isNewRecord ? 'Upload' : 'Update', [
        'class'=>$model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
);

// render a delete image button
if (!$model->isNewRecord) {
    echo Html::a('Delete', ['/person/delete', 'id'=>$model->id], ['class'=>'btn btn-danger']);
}

ActiveForm::end();
