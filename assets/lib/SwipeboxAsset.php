<?

namespace izosa\serengeti\assets\lib;

use izosa\serengeti\assets\AssetBundle;


/**
 * Swipebox asset
 * @author Hristo Hristov <izosa@msn.com>
 * @since 2.0
 */
class SwipeboxAsset extends AssetBundle
{
    public $sourcePath = '@npm/swipebox/src';

    public $js = [
        'js/jquery.swipebox.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'js/jquery.swipebox.min.js',
        ],
    ];
}