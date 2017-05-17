<?

namespace frontend\widgets;

use yii\base\Widget;

class EmbedMap extends Widget {
    
    public $width = '100%';
    public $height = 500;
    public $latitude = 30;
    public $longitude = 0;
    public $zoom = 2;
    public $imo;
    public $mmsi;
    public $vessel;
    public $poi;
    
    public function init() {
        echo $this->render('embedMap',['item' => $this]);
    }
    
}