<?

namespace izosa\serengeti\widgets\elements;

use function var_dump;
use Yii;
use izosa\serengeti\widgets\helpers\Loader;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;

/**
 * Slider extension
 * @version 2.2.1
 * @link https://owlcarousel2.github.io/OwlCarousel2/docs/started-welcome.html documentation
 */
class Slider extends Widget
{
    // https://owlcarousel2.github.io/OwlCarousel2/docs/api-options.html
    public $items = 3;
    public $margin = 0;
    public $loop = false;
    public $center = false;
    public $mouseDrag = true;
    public $touchDrag = true;
    public $pullDrag = true;
    public $freeDrag = false;
    public $stagePadding = 0;
    public $merge = false;
    public $mergeFit = true;
    public $autoWidth = false;
    public $startPosition = 0;
    public $URLhashListener = false;
    public $nav = false;
    public $navRewind = true;
    public $navText = '[&#x27;next&#x27;,&#x27;prev&#x27;]';
    public $navElement = 'div';
    public $slideBy = 1;
    public $dots = true;
    public $dotsEach = false;
    public $dotData = false;
    public $lazyLoad = false;
    public $lazyContent = false;
    public $autoplay = false;
    public $autoplayTimeout = 5000;
    public $autoplayHoverPause = false;
    public $smartSpeed = 250;
    public $fluidSpeed = false;
    public $autoplaySpeed = false;
    public $navSpeed = false;
    public $dotsSpeed = false;
    public $dragEndSpeed = false;
    public $callbacks = true;
    public $responsive = true; // Default: empty object
    public $responsiveRefreshRate = 200;
    public $responsiveBaseElement = 'window';
    public $video = false;
    public $videoHeight = false;
    public $videoWidth = false;
    public $animateOut = false;
    public $animateIn = false;
    public $fallbackEasing = 'swing';
    public $info = false;
    public $nestedItemSelector = false;
    public $itemElement = 'div';
    public $navContainer = false;
    public $dotsContainer = false;

    // https://owlcarousel2.github.io/OwlCarousel2/docs/api-classes.html
    public $refreshClass = 'owl-refresh';
    public $loadingClass = 'owl-loading';
    public $loadedClass = 'owl-loaded';
    public $rtlClass = 'owl-rtl';
    public $dragClass = 'owl-drag';
    public $grabClass = 'owl-grab';
    public $stageClass = 'owl-stage';
    public $stageOuterClass = 'owl-stage-outer';
    public $navContainerClass = 'owl-nav';
    public $navClass = ['&#x27;owl-prev&#x27;','&#x27;owl-next&#x27;'];
    public $controlsClass = 'owl-controls';
    public $dotClass = 'owl-dot';
    public $dotsClass = 'owl-dots';
    public $autoHeightClass = 'owl-height';
    public $responsiveClass = false; //

    public static $cache = [];
    public $target = 'slider';
    public $config;
    public $view = null;
    public static $loaderJS = [];



    public function init()
    {
        if(self::hasItems())
        {
            SliderAsset::register(Yii::$app->view);

            // load js module
            $this->loader();

            // select view
            $view = is_null($this->view) ? 'slider' :  '@view/'.$this->view;

            // render
            $output = Html::beginTag('div', ['class' => 'owl-carousel', 'id' => $this->target]);

            foreach(self::$cache as $item)
            {
                $output.= $this->render($view, ['item' => $item]);
            }

            echo  $output.Html::endTag('div');
        }

        $this->reset();
    }

    /**
     * Add Slider Item
     * @param $image image url
     * @param $alt
     * @param $url
     */
    public static function add($image, $alt = '', $url = '')
    {
        self::$cache[] = [
            'image' => $image,
            'url' => $url,
            'alt' => $alt,
        ];
    }

    /**
     *
     * @param $item
     */
    public static function addItem($item)
    {
        self::$cache[] = $item;
    }

    public static function addAll($items)
    {
        self::$cache = $items;
    }

    public static function hasItems()
    {
        return count(self::$cache) > 0 ? true : false;
    }

    private function loader()
    {
        self::$loaderJS['#'.$this->target] = $this->config;
        Loader::addWidget('slider',  self::$loaderJS);
    }

    private function reset()
    {
        self::$cache  = [];
        $this->target = '';
        $this->config = '';
    }
}
