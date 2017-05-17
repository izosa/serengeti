<?php

namespace frontend\widgets;

use frontend\widgets\Loader;

/**
 * Back to top button
 */
class BackToTop extends \yii\base\Widget
{
    public $tooltip = 'Back to Top';

    public function init()
    {
        parent::init();       
        
        Loader::addWidget('backToTop');

        $this->render('backToTop',['tooltip' => $this->tooltip]);

        echo '<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="'.$this->tooltip.'" data-toggle="tooltip" data-placement="left"><span class="fa fa-chevron-up"></span></a>';

    }
}
