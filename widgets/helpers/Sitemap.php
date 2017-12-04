<?

namespace izosa\serengeti\widgets\helpers;

use Yii;
use yii\helpers\Url;
use yii\base\Widget;
use yii\web\Response
/**
 * Sitemap creator
 *
 * @version 1.0
 * @author Hristo Hristov <izosa@msn.com>
 */
class Sitemap extends Widget{

    public static $items =[];
    public static $indexs =[];
    public $type = 'urlset';
    private $output = '';

    const TYPE_URLSET = 'urlset';
    const TYPE_SITEINDEX = 'sitemapindex';
    
    const FREQUENCY_ALWAYS = 'always';
    const FREQUENCY_HOURLY = 'hourly';
    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';
    const FREQUENCY_MONTHLY = 'monthly';
    const FREQUENCY_YEARLY = 'yearly';
    const FREQUENCY_NEVER = 'never';
    
    const PRIORITY_NORMAL  = '0.5';
    const PRIORITY_MEDIUM  = '0.8';
    const PRIORITY_HIGH    = '1';
    
    const ENGINE_GOOGLE = 'https://www.google.com/webmasters/sitemaps/ping?sitemap=';
    const ENGINE_BING = 'http://www.bing.com/webmaster/ping.aspx?siteMap=';
    const ENGINE_YANDEX = 'http://blogs.yandex.ru/pings/?status=success&url=';
            
    
    public function init() {

        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        
        $this->output.= '<?xml version="1.0" encoding="UTF-8"?><'.$this->type.' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $items = $this->type == 'urlset' ? self::$items : self::$indexs;   
            
        foreach($items as $item)
        {
            $this->output.= $this->type == 'urlset' ?  '<url>' : '<sitemap>';
            $this->output.= '<loc>'.$item['loc'].'</loc>';
            $this->output.= empty($item['lastmod'])     ? '' : '<lastmod>'.gmDate("Y-m-d\TH:i:sP",$item['lastmod']).'</lastmod>';
            
            if($this->type == 'urlset')
            {
                $this->output.= empty($item['changefreq'])  ? '' : '<changefreq>'.$item['changefreq'].'</changefreq>';
                $this->output.= empty($item['priority'])     ? '' : '<priority>'.$item['priority'].'</priority>';                
            }
            
            $this->output.= $this->type == 'urlset' ?  '</url>' : '</sitemap>';
        }
        
        $this->output.= '</'.$this->type.'>';
        
        
        echo $this->output;
    }
    
    /**
     * Add item to Sitemap
     * @param string $loc
     * @param int $lastmod
     * @param string $changefreq
     * @param string $priority
     */
    public static function addItem($loc, $lastmod = 0, $changefreq = self::FREQUENCY_MONTHLY, $priority = self::PRIORITY_NORMAL) 
    {
        self::$items[] = [
            'loc'           => $loc,   
            'lastmod'       => $lastmod,   
            'changefreq'    => $changefreq,   
            'priority'      => $priority,   
        ];
    }
    
    public static function addIndex($title,$lastmod = 0)
    {
        self::$indexs[] = [
          'loc'  => Url::to('/sitemap-'.$title.'.xml',true),
          'lastmod' => $lastmod
        ];
    }
    
    public static function pingEngine($title,$engine = self::ENGINE_GOOGLE)
    {
        $ch = curl_init($engine.Url::to($title,TRUE).'xml');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode == 200 || $httpCode == 301;
    }
    
    public static function ping($title,$engines = [self::ENGINE_GOOGLE])
    {
        foreach($engines as $engine)
        {
            if(!self::pingEngine($title, $engine))
            {
                return $engine;
            }
        }
        
        return true;
    }

}