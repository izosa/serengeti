<?

namespace izosa\serengeti;

use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: izosa
 * Date: 16.05.17
 * Time: 15:40
 */
class Test extends Widget
{
    public $id;

    public function init()
    {
        echo 'WORKS';
    }
}