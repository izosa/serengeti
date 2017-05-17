<?
namespace izosa\serengeti\widgets\facebook;

use Yii;
use yii\base\Widget;

/**
 * Facebook like buton
 */
class Like extends Widget
{
    
    const COLOR_LIGHT = 'light';
    const COLOR_DARK = 'dark';
    
    const ACTION_LIKE  = 'like';
    const ACTION_RECOMMEND  = 'recommend';
    
    const LAYOUT_STANDART = 'standard';
    const LAYOUT_BUTTON = 'button';
    const LAYOUT_BUTTON_COUNT = 'button_count';
    const LAYOUT_BOX_COUNT = 'box_count';

    
    /**
     * The verb to display on the button. Can be either "like" or "recommend".
     * @var string
     */
    public $action = self::ACTION_LIKE;
    
    /**
     * The color scheme used by the plugin. Can be "light" or "dark".
     * @var string
     */
    public $colorscheme = self::COLOR_LIGHT;
    
    /**
     * The absolute URL of the page that will be liked.
     * @var string
     */
    public $href;

    /**
     * If your web site or online service, or a portion of your service, 
     * is directed to children under 13 you must enable this
     * @var boolean
     */
    public $kid_directed_site = false;
    
    /**
     * Selects one of the different layouts that are available for the plugin. 
     * Can be one of "standard", "button_count", "button" or "box_count". 
     * See the FAQ for more details.
     * @url https://developers.facebook.com/docs/plugins/like-button#faqlayout
     * @var string
     */
    public $layout = self::LAYOUT_STANDART;

    /**
     * A label for tracking referrals which must be less than 50 characters 
     * and can contain alphanumeric characters and some punctuation 
     * (currently +/=-.:_). See the FAQ for more details.
     * @url https://developers.facebook.com/docs/plugins/like-button#faqref
     * @var string
     */
    public $ref = '';
    
    /**
     * Specifies whether to include a share button beside the Like button. 
     * This only works with the XFBML version.
     * @var boolean
     */
    public $share = false;

    /**
     * Specifies whether to display profile photos below the button 
     * (standard layout only). You must not enable this on child-directed sites.
     * @url https://developers.facebook.com/docs/plugins/restrictions
     * @var boolean 
     */
    public $show_faces = false;

    /**
     * The width of the plugin (standard layout only), which is subject to 
     * the minimum and default width. Please see the FAQ below for more details.
     * @url https://developers.facebook.com/docs/plugins/like-button#faqlayout 
     * @var string 
     */
    public $width = 550;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 

        echo    '<div class="fb-like" '
                . 'data-action="'.$this->action.'" '
                . 'data-colorscheme="'.$this->colorscheme.'" '
                . 'data-href="'.$this->href.'" '
                . 'data-kid_directed_site="'.var_export($this->kid_directed_site, true).'" '
                . 'data-layout="'.$this->layout.'" '
                . 'data-ref="'.$this->ref.'" '
                . 'data-share="'.var_export($this->share, true).'" '
                . 'data-show-faces="'.var_export($this->show_faces, true).'" '
                . 'data-width="'.$this->width.'"></div>';
    }
}
