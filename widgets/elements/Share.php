<?

namespace izosa\serengeti\widgets\elements;

use Yii;
use yii\base\Widget;

/**
 * Share buttons
 * @version 2.0
 */
class Share extends Widget
{
    public $title;
    public $link;

	const DEFAULT_TITLE = 'Share with friends';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 
        
        if(!empty($this->title))
        {
            $this->title = self::DEFAULT_TITLE;
        }
        
        $this->link = urlencode(Yii::$app->request->absoluteURL);

        echo $this->render('share',['item' => $this]);
    }
}
