<?
namespace izosa\serengeti\widgets\google;

use Yii;
use yii\base\Widget;
use izosa\serengeti\widgets\helpers\Loader;
use yii\helpers\Html;

/**
 * Google Adsense Widget
 * @version 1.0
 */
class AdSense extends Widget
{

    public $type;
    public $position;
    public $debug;


    public function init()
    {

        $advert = Yii::$app->params['adverts'][$this->type][$this->position];

        if(!YII_DEBUG_ADVERT) {
            Yii::$app->view->registerJsFile(
                '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',
                ['async' => true]
            );

            Loader::addWidget('adsense');

            $options = [
                'data-ad-client' => Yii::$app->params['service']['google']['adsense'],
                'data-ad-slot' => $advert['slot'],
                'data-ad-format' => (isset($advert['format']) ? ' '.$advert['format'] : false),
                'style' => (isset($advert['style']) ? ' '.$advert['style'] : false),
                'class' => 'adsbygoogle'.(isset($advert['class']) ? ' '.$advert['class'] : ''),
            ];
        } else {
            $options = [
                'test-ad-client' => Yii::$app->params['service']['google']['adsense'],
                'test-ad-slot' => $advert['slot'],
                'test-ad-format' => (isset($advert['format']) ? ' '.$advert['format'] : false),
                'style' => (isset($advert['debug']['style']) ? ' '.$advert['debug']['style'] : false),
                'class' => 'adsbygoogleDebug'.(isset($advert['debug']['class']) ? ' '.$advert['debug']['class'] : ''),
            ];
        }

        echo Html::tag('ins','',$options);

    }

    public static function place($type, $position){
        echo self::widget([
            'type' => $type,
            'position' => $position,
        ]);
    }

    public static function match($position){
        self::place('match', $position);
    }

    public static function center($position){
        self::place('center', $position);
    }

    public static function left($position){
        self::place('left', $position);
    }

    public static function right($position){
        self::place('right', $position);
    }

}
