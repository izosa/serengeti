<?

namespace izosa\serengeti\widgets\elements;

use Yii;
use yii\base\Widget;

class Notification extends Widget{
    
    const TYPE_ERROR = 'danger';
    const TYPE_WARNING = 'warning';
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    
    public static $now_notifications = [];
    public static $next_notifications = [];
    
    /**
     * @inheritdoc
     */
    public function init() 
    {
        if(Yii::$app->session->hasFlash('notifications'))
        {
            foreach(Yii::$app->session->getFlash('notifications') as $notification)
            {
                echo $this->display($notification);
            }
        }
       
        if(!empty(self::$now_notifications))
        {
            foreach(self::$now_notifications as $notification)
            {
                echo $this->display($notification);
            }
        }
        
        if(!empty(self::$next_notifications))
        {
            Yii::$app->session->setFlash('notifications',self::$next_notifications);
        }
    }
   
    /**
     * Add notification
     * @param string $content
     * @param string $type
     */
    public static function show($content,$type = self::TYPE_INFO)
    {
        self::$now_notifications[] = [
            'content' => $content,
            'type' => $type,
        ];
    }
    
    /**
     * Add notification
     * @param string $content
     * @param string $type
     */
    public static function add($content,$type = self::TYPE_INFO)
    {
        self::$next_notifications[] = [
            'content' => $content,
            'type' => $type,
        ];
    }
    
    /**
     * Display single notification
     * @param type $notification
     */
    private function display($notification)
    {
        echo $this->render('notification',[
            'type' => $notification['type'],
            'content' => $notification['content']
        ]);
    }
    
}