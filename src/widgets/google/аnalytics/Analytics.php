<?
namespace izosa\serengeti\widgets\google\analytics;

use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: izosa
 * Date: 15.05.17
 * Time: 10:22
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