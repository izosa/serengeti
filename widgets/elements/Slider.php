<?

namespace izosa\serengeti\widgets\elements;

use yii\base\Widget;
use izosa\serengeti\widgets\helpers\Loader;
use yii\helpers\Url;
/**
 * Slider Widget
 */
class Slider extends Widget {

    public static $items = [];
    public static $targets = [];
    public $target = 'slider';
    public $config;


    public function init() {
        
        parent::init();
        
        SliderAsset::register(\Yii::$app->view);

        self::$targets[] = '#'.$this->target;
        Loader::addWidget('slider',  [
            'targets' => self::$targets,
            'config' => $this->config
        ]);

        if(self::hasItems())
        {
            $this->render('slider', ['items' => self::items]);
        }
    }
    
    public static function add($url, $image_path,$alt) 
    {
        self::$items[] = [
            'url' => $url,
            'image_path' => $image_path,
            'alt' => $alt,
        ];
    }
    
    public static function hasItems(){
        return count(self::$items) > 0 ? true : false;
    }
}
