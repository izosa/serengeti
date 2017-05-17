<?

namespace izosa\serengeti\widgets\yandex;
use Yii;
use frontend\widgets\SEO;
/**
 * Yandex Metrica analysis
 */
class Metrica extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 
    
        if(!YII_DEBUG)
        {
            $this->render('metrica');
        }
    }
}
