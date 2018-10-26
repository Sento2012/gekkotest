<?php

use dosamigos\datepicker\DatePicker;
use miloschuman\highcharts\Highcharts;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin() ?>

<?= /** @var app\models\GraphForm $model */
$form->field($model, 'start')->widget(DatePicker::className(), [
    'inline' => true,
    'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
    'clientOptions' => [
        'format' => 'yyyy-mm-dd'
    ]
]); ?>

<?= $form->field($model, 'end')->widget(DatePicker::className(), [
    'inline' => true,
    'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
    'clientOptions' => [
        'format' => 'yyyy-mm-dd'
    ]
]); ?>

<button>Отправить</button>

<?php ActiveForm::end() ?>

<?php /** @var app\models\GraphData $graphData */
if ($graphData) {
    echo Highcharts::widget([
        'options' => [
            'title' => ['text' => 'График баланса'],
            'xAxis' => [
                'categories' => ArrayHelper::getColumn($graphData, 'time')
            ],
            'yAxis' => [
                'title' => ['text' => 'Баланс']
            ],
            'series' => [
                ['name' => 'Дата', 'data' => ArrayHelper::getColumn($graphData, 'amount')],
            ]
        ]
    ]);
} ?>
