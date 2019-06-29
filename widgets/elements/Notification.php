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

    const FLASH_KEY = 'notifications';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $output = '';

        if(Yii::$app->session->hasFlash(self::FLASH_KEY))
        {
            foreach(Yii::$app->session->getFlash(self::FLASH_KEY,[],true) as $notification)
            {
                var_dump($notification);
                $output.= $this->display($notification);
            }
        }

        if(!empty(self::$now_notifications))
        {
            foreach(self::$now_notifications as $notification)
            {
                $output.= $this->display($notification);
            }
        }

//        if(!empty(self::$next_notifications))
//        {
//            Yii::$app->session->setFlash(self::FLASH_KEY, self::$next_notifications);
//        }
//
//        var_dump(self::$now_notifications);
//        var_dump(self::$next_notifications);
//        var_dump(Yii::$app->session->getFlash(self::FLASH_KEY,[],true));
        return $output;
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
        var_dump(12123);

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
        return $this->render('notification',[
            'type' => $notification['type'],
            'content' => $notification['content']
        ]);
    }
    
}