<?
namespace izosa\serengeti\data\bootstrap;

use izosa\serengeti\data\CrudItem;
use Yii;
use kartik\icons\Icon;
use \kartik\helpers\Html;
use \kartik\form\ActiveForm;
use letyii\tinymce\Tinymce;
use yii\widgets\Pjax;

/**
 * CrudView implement bootstrap design
 * @package izosa\serengeti\data\bootstrap
 * @version 1.0
 * @author Hristo Hristov <izosa@msn.com>
 *
 * @property $item CrudItem
 */
class CrudView extends CrudForm {

    public $item = null;
    public $title = '';
    private $item_prefix = '';

    public $panels = [];
    public $panels_selected = 'item';
    public $panels_prefix = 'crudViewPanel_';

    public function init()
    {
        parent::init();

        $this->item_prefix = empty($this->item::$modelPrefix) ? '' : $this->item::$modelPrefix . '/';

        $this->title = Yii::t('app/crud', ($this->item->isNewRecord ? 'create' : 'update')).' '.Yii::t('model/'.$this->item_prefix.$this->item->modelType, 'model.title', ['n' => 1]);

        if(!empty($this->panels)) {
            $this->panels_selected = Yii::$app->request->get('panel', $this->panels[0]);
            $this->panels_selected = (!in_array($this->panels_selected, $this->panels)) ? $this->panel[0] : $this->panels_selected;
            $this->panels_selected = $this->item->hasErrors('gallery') ? 'gallery' : $this->panels_selected;
        }
    }

    public function run()
    {

        /* Header */
        echo Html::beginTag('div',['class' => 'card-header']);
            echo Html::tag('div', Icon::show($this->item::$icon).' &nbsp; &nbsp;'.$this->title);
        echo Html::endTag('div');

        /* Body */
        echo Html::beginTag('div',['class' => 'card-body']);

            if(!empty($this->panels)) {

                /* TabPanel */
                echo Html::beginTag('div',['role' => 'tabpanel']);

                    /* TabPanel Nav */
                    echo Html::beginTag('ul', ['class' => 'nav nav-tabs', 'role' => 'tablist']);

                    foreach ($this->panels as $panel) {

                        echo Html::tag('li', Html::a(Yii::t('model' . ($panel == 'item' ? '/' . $this->item_prefix .$this->item->modelType : ''), ($panel == 'item' ? '/' . $this->item->modelType : '') ? 'model.title' : 'tab.' . $panel, ['n' => 1]), '#' . $this->panels_prefix.$panel, [
                            'class' => 'nav-link' . (($panel == $this->panels_selected) ? ' active' : ''),
                            'data-toggle' => 'tab',
                        ]), ['class' => 'nav-item']);
                    }

                    echo Html::endTag('ul');

                    /* TabPanel Body */
                    echo Html::beginTag('div', ['class' => 'tab-content']);

                    /* Panel Item */
                    foreach ($this->panels as $panel) {
                        echo Html::beginTag('div', ['id' => $this->panels_prefix.$panel, 'role' => 'tabpanel', 'class' => 'tab-pane ' . (($this->panels_selected == $panel) ? 'active' : '')]);
                        /* Panel content */
                        echo $this->render('/'.$this->item_prefix.$this->item->modelType.'/form_' . $panel, ['form' => $this, 'item' => $this->item]);
                        echo Html::endTag('div');
                    }

                    echo Html::endTag('div');


                echo Html::endTag('div');
            } else {
                echo $this->render('/'.$this->item_prefix.$this->item->modelType.'/form_item', ['form' => $this, 'item' => $this->item]);
            }


        echo Html::endTag('div');

        /* Footer */
        echo Html::beginTag('div',['class' => 'card-footer text-right']);
            /* Controls */
            echo $this->buttonSave();
            echo $this->buttonPreview();
            echo $this->buttonCancel();
        echo Html::endTag('div');

        $this->options['class'].=' card';

        echo parent::run();
    }

    public function itemField($attribute, $options = []){
        return $this->field($this->item,$attribute,$options);
    }

}
