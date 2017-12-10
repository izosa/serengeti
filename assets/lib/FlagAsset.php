<?

namespace common\assets\lib;

use yii\web\AssetBundle;

/**
 * Map asset
 * @author Hristo Hristov <izosa@msn.com>
 * @since 2.0
 */
class FlagAsset extends AssetBundle
{
    public $sourcePath = '@npm/flag-icon-css';
    public $css = [
        'css/flag-icon.min.css',
    ];
    public $publishOptions = [
        'only' => [
            'flags/',
            'css/',
        ]
    ];
}