<?

namespace common\assets\lib;

use yii\web\AssetBundle;

/**
 * Mobile Detect asset
 * @author Hristo Hristov <izosa@msn.com>
 * @since 1.0
 */
class MobileDetectAsset extends AssetBundle
{
    public $sourcePath = '@npm/mobile-detect';

    public $js = [
        'mobile-detect.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'mobile-detect.min.js',
        ],
    ];
}