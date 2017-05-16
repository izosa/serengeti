<?
namespace serengeti\widgets\google;

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
                $this->id = Yii::$app->params['serengeti']['google']['analytics'];
            }

            if(!empty($this->id)){
                $this->render('view/analytics',['id' => $this->id]);
            }
        }
    }
}