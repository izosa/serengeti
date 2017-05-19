<?
namespace izosa\serengeti\widgets\helpers;

use yii\web\AssetBundle;

/**
 * Debug asset - prepare assets for debug
 * @author Hristo Hristov <izosa@msn.com>
 * @since 2.0
 */
class DebugAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets'.(YII_DEBUG ? '/dev' : '');
        parent::init();
    }


}