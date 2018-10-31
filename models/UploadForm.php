<?php

namespace app\models;

use DateTime;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'html'],
        ];
    }

    /**
     * @return bool
     */
    public function saveData()
    {
        $fileName = uniqid($this->file->baseName) . '.' . $this->file->extension;
        if ($this->file->saveAs(Yii::getAlias('@app') . '/uploads/' . $fileName)) {
            if ($this->processFileContent(Yii::getAlias('@app') . '/uploads/' . $fileName)) {
                unlink(Yii::getAlias('@app') . '/uploads/' . $fileName);

                return true;
            }
        }

        return false;
    }

    /**
     * Process upload file
     *
     * @var string $fileName
     * @return bool
     */
    public function processFileContent($fileName = '')
    {
        if ($fileName) {
            $content = file_get_contents($fileName);
            $regex = '/<tr.*?align=right>.*?<td class=msdate nowrap>(?<time>[\d\.\:\s]+)<\/td><td>(?<type>.*?)<\/td>.*?<td class=mspt>(?<amount>[\d\-\.\s]*?)<\/td><\/tr>/isu';
            preg_match_all($regex, $content, $out);
            $amount = 0;
            $oldAmount = 0;
            $oldTime = null;
            foreach ($out['type'] as $key => $type) {
                $time = DateTime::createFromFormat($this->checkFormat($out['time'][$key]), $out['time'][$key])->setTime(0, 0, 0);;
                if (!$oldTime) {
                    $oldTime = $time;
                    $oldAmount = $amount;
                }
                if ($amount) {
                    $oldAmount = $amount;
                }
                if ($type == 'sell') {
                    $amount -= preg_replace('/\s+/isu', '', $out['amount'][$key]);
                } else {
                    $amount += preg_replace('/\s+/isu', '', $out['amount'][$key]);
                }
                if ((date_diff($oldTime, $time)->format('%a') > 1)) {
                    $this->fillEmptyTime($oldTime, $time, $oldAmount);
                    $oldTime = $time;
                }
                $this->setGraphData($time->format('Y-m-d'), $amount);
            }

            return true;
        }

        return false;
    }

    private function checkFormat($time)
    {
        if (preg_match('/^\d+\.\d+\.\d+\s\d+\:\d+$/isu', $time)) {
            return 'Y.m.d H:i';
        } else {
            return 'Y.m.d H:i:s';
        }
    }

    /**
     * Load graph data
     *
     * @var DateTime $time
     * @var int $amount
     * @return bool
     */
    public function setGraphData($time, $amount)
    {
        $graphData = GraphData::findOne(['time' => $time]);
        if (!$graphData) {
            $graphData = new GraphData([
                'time' => $time,
                'amount' => $amount
            ]);
        } else {
            $graphData->amount = $amount;
        }
        $graphData->save();

        return true;
    }

    /**
     * Fill empty graph time
     *
     * @var DateTime $start
     * @var DateTime $end
     * @var int $amount
     */
    public function fillEmptyTime($start, $end, $amount)
    {
        for ($t = $start; $t <= $end; $t->modify('+1 day')) {
            $this->setGraphData($t->format('Y-m-d'), $amount);
        }
    }
}
