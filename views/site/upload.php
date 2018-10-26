<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= /** @var app\models\UploadForm $model */
$form->field($model, 'file')->fileInput() ?>

    <button>Отправить</button>

<?php ActiveForm::end() ?>