<?
namespace izosa\serengeti\widgets\elements;

use yii\base\Widget;

/**
 * Back to top button
 */
class BackToTop extends Widget
{
    public $tooltip = 'Back to Top';

    public function init()
    {
        parent::init();       

        $this->render('backToTop',['tooltip' => $this->tooltip]);
    }
}
