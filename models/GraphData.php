<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "graph_datas".
 *
 * @property int $id
 * @property int $time
 * @property int $amount
 */
class GraphData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'graph_datas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time', 'amount'], 'required'],
            [['time'], 'date', 'format' => 'php:Y-m-d'],
            [['amount'], 'double'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'amount' => 'Amount',
        ];
    }
}
