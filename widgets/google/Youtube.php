<?
namespace izosa\serengeti\widgets\google;

use Yii;
use yii\base\Widget;

/**
 * Google Youtube Widget (embed video)
 */
class Youtube extends Widget
{

    const RATIO_16x9 = '16by9';
    const RATIO_4x3 = '4by3';
    
    /**
     * Youtube video ID
     * @var string
     */
    public $youtubeid;
    
    /**
     * Sets the URL to +1. Set this attribute when you have a +1 button next 
     * to an item description for another page and want the button to +1 the 
     * referenced page and not the current page. If you set this attribute by 
     * using gapi.plusone.render, you should not escape the URL.
     * @var string
     */
    private $url;
    
    /**
     * Set responsive aspect ratio.
     * @var string
     */
    public $ratio = self::RATIO_16x9;
    
    /**
     * Display responsive video.
     * @var string
     */
    public $responsive = true;

    /**
     * Video width for non responsive
     * @var integer
     */
    public $width = 560;
    
    /**
     * Video height for non responsive
     * @var integer
     */
    public $height = 315;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 

        if(!empty($this->youtubeid))
        {            
            $this->url = self::getUrlFromId($this->youtubeid,true);

            $this->render('youtube',['video' => $this]);
        }
    }
    
    /**
     * Parce YouTube ID from URL
     * @param string $url
     * @return string
     */
    public static function getIdFromUrl($url) 
    {
        if(!empty($url))
        {
            parse_str(parse_url($url, PHP_URL_QUERY), $videoParam);
            return isset($videoParam['v']) ? $videoParam['v'] : '';
        }
        else 
        {
            return '';
        }
    }
    
    /**
     * Return YouTube URL or Embed YouTube URL from Youtube ID
     * @param string $id
     * @param boolean $embed Embed video URL flag
     * @return string
     */
    public static function getUrlFromId($id, $embed = false) 
    {
        if(!empty($id))
        {
            if($embed)
            {
                return 'https://www.youtube.com/embed/'.$id;
            }
            else
            {
                return 'https://www.youtube.com/watch?v='.$id;
            }
        }
        else
        {
            return '';
        }
    }

    /**
     * Convert Youtube link in both directions (watch,embed)
     * @param $url
     * @return mixed
     */
    public static function convertUrl($url){
        $type = strpos($url,'watch');
        $replace = $type ? 'embed/' : 'watch?v=';
        $search =  $type ? 'watch?v=' : 'embed/';
        return str_replace($search, $replace,$url);
    }
}
