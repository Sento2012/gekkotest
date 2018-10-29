<?php

namespace app\models;

use yii\base\Model;

/**
 * GraphForm is the model behind the graph form.
 */
class GraphForm extends Model
{
    /**
     * @var GraphForm attribute
     */
    public $start;
    public $end;
    public $graphData;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['start', 'end'], 'date', 'format' => 'php:Y-m-d'],
            ['start', 'validateDates']
        ];
    }

    /**
     * Date validation
     */
    public function validateDates()
    {
        if (strtotime($this->end) <= strtotime($this->start)) {
            $this->addError('start', 'Дата начала больше даты конца или наоборот!');
            $this->addError('end', 'Дата начала больше даты конца или наоборот!');
        }
    }

    /**
     * Get graph data
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getGraphData()
    {
        $data = GraphData::find()->orderBy('time')->all();

        return $data;
    }

}
