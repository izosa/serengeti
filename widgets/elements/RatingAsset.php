<?

namespace izosa\serengeti\widgets\elements;

use izosa\serengeti\widgets\helpers\DebugAsset;

/**
 * Rating asset
 * @author Hristo Hristov <izosa@msn.com>
 */
class RatingAsset extends DebugAsset
{
    public $js = [
        'js/rating.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}