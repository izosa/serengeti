<?
namespace izosa\serengeti\widgets\helpers;

use Yii;
use yii\helpers\Url;
use yii\base\Widget;

/**
 * SEO
 */
class SEO extends Widget
{
    public static $meta = [];
    public static $link = [];
    public static $json = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public static function addTag($name, $value)
    {
        if(!empty($name) && !empty($value) && !isset(self::$meta[$name]))
        {
            Yii::$app->view->registerMetaTag([
                'name'  => $name,
                'content' => $value
            ]);

            self::$meta[$name] = true;
        }
    }

    public static function addLink($rel, $href)
    {
        if(!empty($rel) && !empty($href) && !isset(self::$link[$rel]))
        {
            Yii::$app->view->registerLinkTag([
                'rel'  => $rel,
                'href' => $href
            ]);

            self::$link[$rel] = true;
        }
    }

    public static function addDescription($content)
    {
        self::addTag('description', $content);
    }

    public static function addAuthor($author)
    {
        self::addLink('author', $author);
    }

    public static function addCanonical()
    {

        self::addLink('canonical', Yii::$app->request->hostInfo.(!empty(Yii::$app->request->pathInfo) ? '/'.Yii::$app->request->pathInfo : ''));
    }

    public static function addIndexNoFollow()
    {
        self::addTag('robots', 'index,nofollow');
    }

    public static function addNoIndexNoFollow()
    {
        self::addTag('robots', 'noindex,nofollow');
    }

    public static function addNoIndexFollow()
    {
        self::addTag('robots', 'noindex,follow');
    }

    public static function addBreadcrumb($label = '',$url = '')
    {
        if(!empty($label))
        {
            if(empty($url))
            {
                $url = Yii::$app->request->getAbsoluteUrl();
            }
            Yii::$app->view->params['breadcrumbs'][] = ['label' => $label, 'url' => Url::to($url, true)];
        }
    }

    public static function breadcrumbs()
    {
        if(!empty(Yii::$app->view->params['breadcrumbs'])){
            $output =  '<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb desktop-inline">';
            foreach (Yii::$app->view->params['breadcrumbs'] as $key => $value)
            {
                $output.= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'
                    . '  <a itemprop="item" href="'.$value['url'].'">
                            <span itemprop="name">'.$value['label'].'</span></a>
                            <meta itemprop="position" content="'.($key+1).'" />
                          </li>';
            }
            $output.= '</ol>';
            echo $output;
        }
    }

    public static function title($title)
    {
        Yii::$app->view->title = $title.' | '.Yii::$app->params['site']['name'];
    }

    public static function JsonLd()
    {
        self::JsonLogo();
        echo '<script type="application/ld+json">'.self::$json.'</script>';
    }

    public static function JsonLogo()
    {
        self::$json.= '
                {
                  "@context": "http://schema.org",
                  "@type": "Organization",
                  "name" : "'.Yii::$app->params['site']['name'].'",
                  "url": "'.Url::to('/',true).'",
                  "logo": "'.Url::to('/images/logo.svg',true).'",
                  "sameAs" : [
                    "https://www.facebook.com/'.Yii::$app->params['site']['name'].'",
                    "https://www.twitter.com/'.Yii::$app->params['site']['name'].'",
                    "https://plus.google.com/+'.Yii::$app->params['site']['name'].'"
                   ]
                }
                ';
    }
}