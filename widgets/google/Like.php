<?
namespace izosa\serengeti\widgets\google;

use Yii;
use yii\base\Widget;

/**
 * Google+ button Widget
 */
class Like extends Widget
{

    const SIZE_SMALL = 'small';
    const SIZE_MEDIUM = 'medium';
    const SIZE_STANDART = 'standard';
    const SIZE_TAIL = 'tall';

    const ANNOTATION_NONE = 'none';
    const ANNOTATION_BUBBLE = 'bubble';
    const ANNOTATION_INLINE = 'inline';
    
    const ALIGN_LEFT = 'left';
    const ALIGN_RIGHT = 'right';
    
    const EXPAND_TO_TOP = 'top';
    const EXPAND_TO_RIGHT = 'right';
    const EXPAND_TO_BOTTOM = 'bottom';
    const EXPAND_TO_LEFT = 'left';
    
    /**
     * Sets the URL to +1. Set this attribute when you have a +1 button next 
     * to an item description for another page and want the button to +1 the 
     * referenced page and not the current page. If you set this attribute by 
     * using gapi.plusone.render, you should not escape the URL.
     * @var string
     */
    public $href;
    
    /**
     * Sets the +1 button size to render. See button sizes for more information.
     * @var string
     */
    public $size = self::SIZE_STANDART;
    

    /**
     * Sets the annotation to display next to the button.
     * 
     * none   -> Do not render additional annotations.
     * 
     * bubble -> Display the number of users who have +1'd the page in a graphic
     *           next to the button.
     * 
     * inline -> Display profile pictures of connected users who have +1'd the 
     *           page and a count of users who have +1'd the page.
     * 
     * @var string
     */
    public $annotation = self::ANNOTATION_BUBBLE;
    
    /**
     * If data-annotation is set to "inline", this parameter sets the width in 
     * pixels to use for the button and its inline annotation. If the width is 
     * omitted, a button and its inline annotation use 450px.
     * See Inline annotation widths for examples of how the annotation is 
     * displayed for various width settings.
     * @var integer
     */
    public $width;
    
    /**
     * Sets the horizontal alignment of the button assets within its frame.
     * @var string
     */
    public $align = self::ALIGN_LEFT;
    
    /**
     * Sets the +1 button size to render. See button sizes for more information.
     * @var string
     */
    public $expandTo = self::EXPAND_TO_TOP;
    /**
     * Sets the +1 button size to render. See button sizes for more information.
     * @var string
     */
    public $recommendations = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init(); 

        if(empty($this->href))
        {
            $this->href = 'https://plus.google.com/' . Yii::$app->params['serengeti']['google']['profile'];
        }

        $this->render('like',['button' => $this]);
    }
}
