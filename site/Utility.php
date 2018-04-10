<?
namespace izosa\serengeti\site;

use Yii;
use yii\base\InvalidArgumentException;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class Utility{

    public static $latin = [ "a", "b", "v", "g", "d", "e", "j", "z", "i", "i", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h", "tz", "ch", "sh", "sht", "y", "x", "iu", "ia", "A", "B", "V", "G", "D", "E", "J", "Z", "I", "I", "K", "L", "M", "N", "O", "P", "R", "S", "T", "U", "F", "H", "TZ", "CH", "SH", "SHT", "Y", "IU", "IA"];
    public static $cyrillic = [ "а", "б", "в", "г", "д", "е", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ь", "ю", "я", "А", "Б", "В", "Г", "Д", "Е", "Ж", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ю", "Я",];

    public static function parceNumbers($value)
    {
        return preg_replace( '/[^0-9]/', '', $value );
    }

    public static function textShoter($content, $max_length = 150)
    {
        $end_substitute = null;
        $html_linebreaks = false;

        if($html_linebreaks) $content = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $content);
        $content = strip_tags($content); //gets rid of the HTML

        if(empty($content) || mb_strlen($content) <= $max_length) {
            if($html_linebreaks) $content = nl2br($content);
            return $content;
        }

        if($end_substitute) $max_length -= mb_strlen($end_substitute, 'UTF-8');

        $stack_count = 0;
        while($max_length > 0){
            $char = mb_substr($content, --$max_length, 1, 'UTF-8');
            if(preg_match('#[^\p{L}\p{N}]#iu', $char)) $stack_count++; //only alnum characters
            elseif($stack_count > 0) {
                $max_length++;
                break;
            }
        }
        $content = mb_substr($content, 0, $max_length, 'UTF-8').$end_substitute;
        if($html_linebreaks) $content = nl2br($content);

        return $content. '...';
    }

    /**
     * Return list with uploaded images
     * @return array
     */
    public static function getUploadedImage($errorReport = false)
    {
        $files = [];



        // get FILE parameters
        if (count($_FILES) > 0) {
            foreach (array_keys($_FILES) as $variableName) {
                if (is_array($_FILES[$variableName]['name'])) {
                    foreach($_FILES[$variableName]['name'] as $key => $value){
                        if($_FILES[$variableName]['error'][$key] == 0 || $errorReport){
                            $files[$variableName][$key]['name'] = $_FILES[$variableName]['name'][$key];
                            $files[$variableName][$key]['type'] = $_FILES[$variableName]['type'][$key];
                            $files[$variableName][$key]['tmp_name'] = $_FILES[$variableName]['tmp_name'][$key];
                            $files[$variableName][$key]['error'] = $_FILES[$variableName]['error'][$key];
                            $files[$variableName][$key]['size'] = $_FILES[$variableName]['size'][$key];
                        }
                    }
                } else {
                    $files[$variableName]['name'] = $_FILES[$variableName]['name'];
                    $files[$variableName]['tmp_name'] = $_FILES[$variableName]['tmp_name'];
                    $files[$variableName]['error'] = $_FILES[$variableName]['error'];
                    $files[$variableName]['size'] = $_FILES[$variableName]['size'];
                }
            }
        }
        return $files;
    }


    /**
     * Show a status bar in the console
     * @param     $done
     * @param     $total
     * @param int $size
     */
    public static function progressbar($done, $total, $size=50) {

        // ╢ █ ░ ╟

        static $start_time;

        // if we go over our bound, just ignore it
        if($done > $total) return;

        if(empty($start_time)) $start_time=time();
        $now = time();

        $perc=(double)($done/$total);

        $bar=floor($perc*$size);
        $status_bar="\r╢";
        $status_bar.=str_repeat("█", $bar);
        if($bar<$size){
            $status_bar.="█";
            $status_bar.=str_repeat("░", $size-$bar);
        } else {
            $status_bar.="█";
        }

        $disp=number_format($perc*100, 0);

        $status_bar.="╟ $disp%  $done/$total";

        $rate = ($now-$start_time)/$done;
        $left = $total - $done;
        $eta = round($rate * $left, 2);

        $elapsed = $now - $start_time;

        $status_bar.= " remaining: ".gmdate("i:s", intval($eta)) ." min.  elapsed: ".gmdate("i:s", intval($elapsed))." min.";

        echo "$status_bar  ";

        flush();

        // when done, send a newline
        if($done == $total) {
            echo "\n";
        }

    }


    /**
     * Check is valid date
     * @param $date
     * @param string $format
     * @return bool
     */
    public static function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    /**
     * Handle url normalisation
     * @param $url
     * @param bool $caseSensitive
     * @return mixed|string
     */
    public static function url($url, $caseSensitive = false){
        $url = str_replace([" " , "/" ,"|","="], ["-"],self::cyrToLat(trim($url)));
        !$caseSensitive ? $url = strtolower($url) : '';
        return $url;
    }

    /**
     * Convert latin to cyrillic symbols
     * @param $text
     * @return string
     */
    public static function latToCyr($text){
        return str_replace(self::$latin, self::$cyrillic,$text);
    }
    /**
     * Convert latin to cyrillic symbols
     * @param $text
     * @return string
     */
    public static function cyrToLat($text){
        return str_replace(self::$cyrillic, self::$latin,$text);
    }


    public static function createURL($url, $params = [], $absolute = true)
    {

        if(!empty($params))
        {
            $queue = '?';
            foreach($params as $key => $value)
            {
                if(is_int($key))
                {
                    $queue.= $value;
                }
                else
                {
                    $queue.=$key.'='.$value;
                }
                $queue.= '&';
            }

            $queue = substr($queue, 0 , -1);
        }
        else
        {
            $queue = '';
        }

        return Url::to($url, $absolute).$queue;
    }

    /**
     * Handle tag values
     * @param $tags
     * @param bool $convert
     * @param string $separator
     * @return array|string
     */
    public static function tags($tags, $convert = false,  $separator = ','){
        if(!empty($tags)){
            if(is_string($tags)){
                $tags = array_filter(explode($separator, trim($tags)));
                if(!$convert){
                    $tags = implode($separator, $tags);
                }
            } else if(is_array($tags)){
                $tags = array_filter($tags);
                if($convert){
                    $tags = implode($separator, $tags);
                }
            }
        }

        return $tags;
    }

    /**
     * Return Class short name
     * @param $model
     * @return string
     */
    public static function shortClassName($model, $lowercase = true){

        if(is_object($model)){
            $name =  (new \ReflectionClass($model))->getShortName();
        } else if(is_string($model)){
            $name = basename(str_replace('\\','/',$model));
        } else{
            throw new InvalidArgumentException();
        }

        return $lowercase ? strtolower($name) : $name;
    }

}