<?
namespace izosa\serengeti\widgets\elements;

use izosa\serengeti\widgets\helpers\DebugAsset;

/**
 * Rating asset
 * @author Hristo Hristov <izosa@msn.com>
 */
class SliderAsset extends DebugAsset
{
    public $js = [
        'js/owl.carousel.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->setSourcePath(__DIR__);
        parent::init();
    }
}