<?
namespace izosa\serengeti\widgets\facebook;

use Yii;
use yii\base\Widget;

/**
 * Facebook pop up display
 */
class Comment extends Widget
{
    const COLOR_LIGHT = 'light';
    const COLOR_DARK = 'dark';
    
    const ORDER_SOCIAL  = 'social';
    const ORDER_TIME  = 'time';
    const ORDER_REVERCE_TIME  = 'reverse_time';

    /**
     * The color scheme used by the plugin. Can be "light" or "dark".
     * @var string
     */
    public $colorscheme = 'light';
    
    /**
     * The absolute URL that comments posted in the plugin will be permanently 
     * associated with. Stories on Facebook about comments posted in the plugin 
     * will link to this URL.
     * @var string
     */
    public $href;

    /**
     * A boolean value that specifies whether to show the mobile-optimized 
     * version or not.
     * @var boolean
     */
    public $mobile = true;
    
    /**
     * The number of comments to show by default. The minimum value is 1.
     * @var integer
     */
    public $num_posts = 10;

    /**
     * The order to use when displaying comments. Can be "social", 
     * "reverse_time", or "time". The different order types are explained 
     * in the FAQ
     * @url https://developers.facebook.com/docs/plugins/comments#faqorder
     * @var integer
     */
    public $order_by = self::ORDER_SOCIAL;

    /**
     * The width of the plugin. Either a pixel value or the literal 100% for 
     * fluid width. The mobile version of the Comments plugin ignores the 
     * width parameter, and instead has a fluid width of 100%.
     * @var integer 
     */
    public $width = 550;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 
        
        echo    '<div class="fb-comments" '
                . 'data-colorscheme="'.$this->colorscheme.'" '
                . 'data-href="'.$this->href.'" '
                . 'data-numposts="'.$this->num_posts.'" '
                . 'data-order-by="'.$this->order_by.'" '
                . 'data-mobile="'.var_export($this->mobile, true).'" '
                . 'data-width="'.$this->width.'"></div>';
    }
}
