<?
namespace izosa\serengeti\widgets\helpers;

use Yii;
use yii\helpers\Json;
use yii\base\Widget;

/**
 * Widget Loader
 */
class Loader extends Widget
{
    public static $this;
    public $widgets = [];
    public $config = [];
    public static $added = [];
    public static $remouved = [];
    
    public function init()
    {
        parent::init();    
        $this->config();
        $final = [];
        $this->widgets = array_merge($this->widgets,Yii::$app->params['widgets']);
        $this->widgets = array_merge($this->widgets,self::$added); 

        foreach($this->widgets as $title => $options)
        {
            if(!in_array($title, self::$remouved))
            {
                $final[$title] = $options;
            }
        }
        
        Yii::$app->view->registerJs(
                'var options = { config: '.Json::encode($this->config).' , widgets: '.Json::encode($final).'}',
                yii\web\View::POS_HEAD
        );
    }
    
    private function config()
    {
        self::$this = $this;
        $this->config['language'] = Yii::$app->language.'_'.  strtoupper(Yii::$app->language);
    }

    public static function addWidget($title, $options = ['status' => true])
    {
        self::$added[$title] = $options;
    }
    
    public static function remouveWidget($title)
    {
        self::$remouved[$title] = $title;
    }
}


/**
 * Enable JS widget code
 * \frontend\widgets\Loader::addWidget('widgetTitle', ['status'=>true, 'id' => 123]);
 * 
 * Disable JS widget code execution
 * \frontend\widgets\Loader::remouveWidget('widgetTitle');
 * 
 * JavaScript variable 
 * options
 * 
 */
