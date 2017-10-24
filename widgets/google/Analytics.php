<?
namespace izosa\serengeti\widgets\google;

use Yii;
use yii\base\Widget;

/**
 * Google Analytics Widget
 * @version 2.0
 */
class Analytics extends Widget
{
    /**
     * @var string Analytics ID
     */
    public $id;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if(!YII_DEBUG && empty($this->id))
        {
            $this->id = Yii::$app->params['service']['google']['analytics'];
        }
    }

    /**
     * @inheritdoc
     */
    public function run(){
         if(!YII_DEBUG && !empty($this->id)){
            return $this->render('analytics',['id' => $this->id]);
        }
    }
}