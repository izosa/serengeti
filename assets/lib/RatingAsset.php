<?

namespace izosa\serengeti\assets\lib;

use izosa\serengeti\assets\AssetBundle;


/**
 * Rating asset
 * @author Hristo Hristov <izosa@msn.com>
 * @version 2.0
 */
class RatingAsset extends AssetBundle
{
    public $sourcePath = '@common/resources/';

    public $js = [
        'js/lib/rating.js',
    ];
}