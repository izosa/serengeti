<?
namespace izosa\serengeti\assets;

/**
 * Debug asset - prepare asset for debug
 * @author Hristo Hristov <izosa@msn.com>
 * @version 1.1
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@assets';

//    public function init()
//    {
//        if(YII_DEBUG)
//        {
//            foreach($this->js as $position => $file)
//            {
//                if(is_bool(strpos($file,'//')))
//                {
//                    $this->js[$position] = 'dev/'.$file;
//                }
//            }
//        }
//        parent::init();
//    }
}