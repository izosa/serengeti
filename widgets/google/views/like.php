<?

Yii::$app->view->registerJsFile('https://apis.google.com/js/platform.js', ['async' => true, 'defer' => true]);

echo
    '<div class="g-plusone" '
. 'data-href="'.$this->href.'" '
. 'data-size="'.$this->size.'" '
. 'data-annotation="'.$this->annotation.'" '
. 'data-width="'.$this->width.'" '
. 'data-align="'.$this->align.'" '
. 'data-recommendations="'.var_export($this->recommendations, true).'"></div>';

