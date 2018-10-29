<?php

use dosamigos\datepicker\DatePicker;
use miloschuman\highcharts\Highcharts;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin() ?>

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
