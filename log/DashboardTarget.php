<?

namespace izosa\serengeti\log;

use Yii;
use yii\helpers\VarDumper;

class DashboardTarget extends \yii\log\DbTarget
{
    public $logTable = '{{%logger}}';

    /**
     * Stores log messages to DB.
     */
    public function export()
    {
        $message = $this->messages[0];

        list($text, $level, $category, $timestamp) = $message;
        if (!is_string($text)) {
            // exceptions may not be serializable if in the call stack somewhere is a Closure
            if ($text instanceof \Throwable || $text instanceof \Exception) {
                $text = (string)$text;
            } else {
                $text = VarDumper::export($text);
            }
        }

//        $result = $this->db->createCommand()->insert($this->logTable, [
//            'level' => $level,
//            'category' => $category,
//            'code' => $message[0]->getCode(),
//            'log_time' => $timestamp,
//            'prefix' => $this->getMessagePrefix($message),
//            'message' => $text,
//            'file_path' => $message[0]->getFile(),
//            'file_line' => $message[0]->getLine(),
//            'param_get' => serialize($_GET),
//            'param_post' => serialize($_POST),
//            'param_files' => serialize($_FILES),
//            'param_cookie' => serialize($_COOKIE),
//            'param_server' => serialize($_SERVER),
//            'user_id' => Yii::$app->user->identity->id,
//        ])->execute();


        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[code]], [[log_time]], [[prefix]], [[message]], [[file_path]] ,[[file_line]],[[param_get]],[[param_post]],[[param_files]],[[param_cookie]],[[param_server]],[[user_id]])
                VALUES (:level, :category, :code, :log_time, :prefix, :message, :file_path, :file_line, :param_get, :param_post, :param_files, :param_cookie, :param_server, :user_id)";

        $this->db->createCommand($sql)->bindValues([
            ':level' => $level,
            ':category' => $category,
            ':code' => $message[0]->getCode(),
            ':log_time' => $timestamp,
            ':prefix' => $this->getMessagePrefix($message),
            ':message' => $text,
            ':file_path' => $message[0]->getFile(),
            ':file_line' => $message[0]->getLine(),
            ':param_get' => serialize($_GET),
            ':param_post' => serialize($_POST),
            ':param_files' => serialize($_FILES),
            ':param_cookie' => serialize($_COOKIE),
            ':param_server' => serialize($_SERVER),
            ':user_id' => Yii::$app->user->identity->id,
        ])->execute();
    }


    private function comment(){
//        $_SERVER = [
//            \'USER\' => \'www-data\'
//    \'HOME\' => \'/var/www\'
//    \'SCRIPT_NAME\' => \'/admin/index.php\'
//    \'REQUEST_URI\' => \'/admin/picture/index\'
//    \'QUERY_STRING\' => \'\'
//    \'REQUEST_METHOD\' => \'GET\'
//    \'SERVER_PROTOCOL\' => \'HTTP/1.1\'
//    \'GATEWAY_INTERFACE\' => \'CGI/1.1\'
//    \'REDIRECT_URL\' => \'/admin/picture/index\'
//    \'REMOTE_PORT\' => \'56086\'
//    \'SCRIPT_FILENAME\' => \'/var/www/cruisemapper.web/www/admin/index.php\'
//    \'SERVER_ADMIN\' => \'[no address given]\'
//    \'CONTEXT_DOCUMENT_ROOT\' => \'/var/www/cruisemapper.web/www\'
//    \'CONTEXT_PREFIX\' => \'\'
//    \'REQUEST_SCHEME\' => \'http\'
//    \'DOCUMENT_ROOT\' => \'/var/www/cruisemapper.web/www\'
//    \'REMOTE_ADDR\' => \'127.0.0.1\'
//    \'SERVER_PORT\' => \'80\'
//    \'SERVER_ADDR\' => \'127.0.0.1\'
//    \'SERVER_NAME\' => \'www.cruisemapper.web\'
//    \'SERVER_SOFTWARE\' => \'Apache/2.4.18 (Ubuntu)\'
//    \'SERVER_SIGNATURE\' => \'<address>Apache/2.4.18 (Ubuntu) Server at www.cruisemapper.web Port 80</address>
//\'
//    \'PATH\' => \'/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin\'
//    \'HTTP_COOKIE\' => \'_dashboard_session=0kjeubhat5lftc8f43guuve4q3; PHPSESSID=uvec0vu3bvoqcshsp7luiftrb2; mapCenter=1604566.0977624208,2856910.369186748; mapZoom=2; _identity=bdf019a7a745e85eed357105495d2423e672da309c66307502e78afd61153c08a%3A2%3A%7Bi%3A0%3Bs%3A9%3A%22_identity%22%3Bi%3A1%3Bs%3A48%3A%22%5B%225%22%2C%22H5o4dnWpE-cDWaEd3Q0l0OcUCvdBVRb-%22%2C2592000%5D%22%3B%7D\'
//    \'HTTP_ACCEPT_LANGUAGE\' => \'en-US,en;q=0.8,bg;q=0.6\'
//    \'HTTP_ACCEPT_ENCODING\' => \'gzip, deflate, sdch\'
//    \'HTTP_REFERER\' => \'http://www.cruisemapper.web/admin/news/index\'
//    \'HTTP_ACCEPT\' => \'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\'
//    \'HTTP_USER_AGENT\' => \'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36\'
//    \'HTTP_UPGRADE_INSECURE_REQUESTS\' => \'1\'
//    \'HTTP_CACHE_CONTROL\' => \'max-age=0\'
//    \'HTTP_CONNECTION\' => \'keep-alive\'
//    \'HTTP_HOST\' => \'www.cruisemapper.web\'
//    \'proxy-nokeepalive\' => \'1\'
//    \'REDIRECT_STATUS\' => \'200\'
//    \'FCGI_ROLE\' => \'RESPONDER\'
//    \'PHP_SELF\' => \'/admin/index.php\'
//    \'REQUEST_TIME_FLOAT\' => 1490347960.4873
//    \'REQUEST_TIME\' => 1490347960
//    \'DEBUG\' => true
//]'
//        1 => 4
//        2 => 'application'
//        3 => 1490347960.4879
//    ]
//]
    }

}