<?
namespace izosa\serengeti\widgets\facebook;

use Yii;
use yii\base\Widget;


/**
 * Facebook pop up display
 */
class PopUp extends Widget
{
    const COLOR_LIGHT = 'light';
    const COLOR_DARK = 'dark';

    /**
     * Pop-up title
     * @var string
     */
    public $title = 'Follow us on Facebook!';

    /**
     * The absolute URL of the Facebook Page that will be liked.
     * This is a required setting.
     * @var string
     */
    public $page;

    /**
     * The color scheme used by the plugin. Can be "light" or "dark".
     * @var string
     */
    public $colorscheme = self::COLOR_LIGHT;

    /**
     * For "place" Pages (Pages that have a physical location
     * that can be used with check-ins), this specifies whether
     * the stream contains posts by the Page or just check-ins from friends.
     * @var boolean
     */
    public $force_wall = false;

    /**
     * Specifies whether to display the Facebook header at the top of the plugin.
     * @var boolean
     */
    public $header = false;

    /**
     * The height of the plugin in pixels.
     * The default height varies based on number of faces to display,
     * and whether the stream is displayed. With stream set to true and
     * 10 photos displayed (via show_faces) the default height is 556px.
     * With stream and show_faces both false, the default height is 63px.
     * The stream is always 300px so if you have it enabled, you need to make
     * sure there is enough height for any other elements, e.g. footer, header
     * @var integer
     */
    public $height = 340;

    /**
     * Specifies whether or not to show a border around the plugin.
     * @var boolean
     */
    public $show_border = false;

    /**
     * Specifies whether to display profile photos of people who like the page.
     * @var boolean
     */
    public $show_faces = true;

    /**
     * Specifies whether to display a stream of the latest posts by the Page.
     * @var boolean
     */
    public $stream = false;

    /**
     * The width of the plugin in pixels. Minimum is 292.
     * @var integer
     */
    public $width = 600;

    /**
     * Pop-up code
     * @var string
     */
    public $content;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(!isset($_COOKIE['facebookPopUp']))
        {

            if(empty($this->page))
            {
                $this->page = Yii::$app->params['service']['facebook']['url'];
            }

            $this->content = '<div class="fb-like-box" '
                    . 'data-href="'.$this->page.'" '
                    . 'data-width="'.$this->width.'" '
                    . 'data-height="'.$this->height.'" '
                    . 'data-colorscheme="'.$this->colorscheme.'" '
                    . 'data-show-faces="'.var_export($this->show_faces, true).'" '
                    . 'data-header="'.var_export($this->header, true).'" '
                    . 'data-stream="'.var_export($this->stream, true).'" '
                    . 'data-force-wall="'.var_export($this->force_wall, true).'" '
                    . 'data-show-border="'.var_export($this->show_border, true).'"></div>';

            echo $this->render('@widgets/facebook/popup', ['object' => $this]);
        }
    }
}
