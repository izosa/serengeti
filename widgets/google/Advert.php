<?
namespace izosa\serengeti\widgets\google;

use Yii;
use yii\base\Widget;

/**
 * Advert extension
 */
class Advert extends Widget
{

    public $type;
    public $position;
    public $debug;

    
    public function init() 
    {
        echo Yii::$app->params['adverts'][$this->type][YII_ADVERT ? $this->debug : $this->position];
    }

    public static function match($position, $debug = 'debug'){
        echo self::widget([
            'type' => 'match',
            'position' => $position,
            'debug' => $debug,
        ]);
    }

    public static function center($position, $debug = 'debug'){
        echo self::widget([
            'type' => 'center',
            'position' => $position,
            'debug' => $debug,
        ]);
    }

    public static function left($position, $debug = 'debug'){
        echo self::widget([
            'type' => 'left',
            'position' => $position,
            'debug' => $debug,
        ]);
    }

    public static function right($position, $debug = 'debug'){
        echo self::widget([
            'type' => 'right',
            'position' => $position,
            'debug' => $debug,
        ]);
    }

}
