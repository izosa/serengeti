<?

namespace common\assets\lib;

use yii\web\AssetBundle;

/**
 * Slider asset
 * @author Hristo Hristov <izosa@msn.com>
 * @since 2.0
 */
class SliderAsset extends AssetBundle
{
    public $sourcePath = '@npm/owl.carousel/dist';

    public $js = [
        'owl.carousel.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public $publishOptions = [
        'only' => [
            'owl.carousel.min.js',
        ],
    ];

}