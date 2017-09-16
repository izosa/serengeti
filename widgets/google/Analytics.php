<?
namespace izosa\serengeti\widgets\google;

use Yii;
use yii\base\Widget;

/**
 * Google Analytics Widget
 */
class Analytics extends Widget
{
    public $id;

    public function init()
    {
        if(!YII_DEBUG)
        {
            if(empty($this->id)) {
                $this->id = Yii::$app->params['service']['google']['analytics'];
            }

            if(!empty($this->id)){
                $this->render('analytics',['id' => $this->id]);
            }
        }
    }
}