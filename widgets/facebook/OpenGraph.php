<?
namespace izosa\serengeti\widgets\facebook;

use Yii;
use yii\base\Widget;
use izosa\serengeti\widgets\helpers\Loader;

/**
 * OpenGraph
 */
class OpenGraph extends Widget
{
    public static $init = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 
    }
    
    public static function addTag($name, $value)
    {
        if(!empty($name) || !empty($value))
        {
            Yii::$app->view->registerMetaTag([
                'name'  => 'og:'.$name,
                'content' => $value
            ]);
            if(!self::$init)
            {
                Loader::addWidget('facebookInit', ['status' => true, 'api' => Yii::$app->params['serengeti']['facebook']['api']]);
                
                Yii::$app->view->registerMetaTag([
                    'property'  => 'fb:app_id',
                    'content' => Yii::$app->params['serengeti']['facebook']['api']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name'  => 'og:site_name',
                    'content' => Yii::$app->params['site']['name']
                ]);
                Yii::$app->view->registerMetaTag([
                    'name'  => 'og:locale',
                    'content' => Yii::$app->language
                ]);
                Yii::$app->view->registerMetaTag([
                    'name'  => 'og:url',
                    'content' => Yii::$app->request->getAbsoluteUrl()
                ]);
                self::$init = true;
            }
        }
    }
    
    public static function addArticleTag($name, $value)
    {
        if(!empty($name) || !empty($value))
        {
            Yii::$app->view->registerMetaTag([
                'name'  => 'article:'.$name,
                'content' => $value
            ]);
        }
    }
}
