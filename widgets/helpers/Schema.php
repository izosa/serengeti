<?
namespace izosa\serengeti\widgets\helpers;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Widget Schema.org
 */
class Schema extends Widget
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 
    }
    
    public static function addTag($name, $value)
    {
        if(!empty($name) && !empty($value))
        {
            return '<meta itemprop="'.$name.'" content="'.$value.'">';
        }
    }
    
    public static function logo()
    {
        echo 
        '<h1 itemscope="" class="col-md-3" itemtype="http://schema.org/Brand">'
        .Html::a(
                Html::img(
                        Url::to('images/logo.svg', true),
                        [
                            'class' => 'img-responsive', 
                            'rel' => 'home', 
                            'alt' => Yii::$app->params['site']['name'].' logo', 
                            'title' => Yii::$app->params['site']['name'].' logo',
                            'itemprop'=>'logo',
                        ]
                )
                
                .self::addTag('name', Yii::$app->params['site']['name'])
                .self::addTag('url', Yii::$app->request->getHostInfo())
                .self::addTag('description', Yii::$app->params['site']['description'])
                
                , Url::to('/', true)
        )
        .'</h1>';
    }
        
    public static function breadcrumbs()
    {
        $output =  '<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb desktop-inline">';
        foreach (Yii::$app->view->params['breadcrumbs'] as $key => $value)
        {
           $output.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'
                   . '  <a itemprop="item" href="'.$value['url'].'">
                        <span itemprop="name">'.$value['label'].'</span></a>
                        <meta itemprop="position" content="'.($key+1).'" />
                      </li>';
        }
        $output.= '</ol>';
        echo $output;
    }
}
