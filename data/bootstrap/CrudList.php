<?

namespace izosa\serengeti\data\bootstrap;

use izosa\serengeti\data\CrudItem;
use izosa\serengeti\site\Utility;
use Yii;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * CrudList implement bootstrap design
 * @package izosa\serengeti\data\bootstrap
 * @version 1.0
 * @author Hristo Hristov <izosa@msn.com>
 */
class CrudList extends GridView
{

    public $option_layout = '';

    public $bordered = true;
    public $condensed = true;
    public $hover = true;
    public $responsive = true;
    public $export = false;
    public $filterPosition = self::FILTER_POS_HEADER;
    public $resizableColumns = false;


    public $exportConfig;

    public $filterDisplay = true;
    public $toolbarDisplay = true;
    public $createDisplay = true;

    public $toolbar = false;
    public $toolbarCreate = true;
    public $toolbarResetFilter = true;

    public $panel = [
        'heading'=> '',
        'type'=> self::TYPE_DEFAULT,
        'before'=> '',
        'after'=> false,
        'footer'=> ''
    ];

    public $pjax = true;
    public $pjaxSettings = [
        'neverTimeout'=>true,
        'beforeGrid'=>'',
        'afterGrid'=>'',
        'loadingCssClass' => false,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        //options
        $this->options['class'] = 'crudList';
        $this->id = $this->options['class'].'-'.$this->filterModel->modelType;

        // panel
        if(!is_bool($this->panel) || $this->panel != false) { // status

            // FilterModel Title [Card][Title]
            $this->panelHeadingTemplate = Icon::show($this->filterModel::$icon).Yii::t('model/'.(empty($this->filterModel::$modelPrefix) ? '' : $this->filterModel::$modelPrefix.'/').$this->filterModel->modelType, 'model.title', ['n' => 2]).'{summary}';

            // panel default
            $this->panel = ArrayHelper::merge([
                'type' => self::TYPE_DEFAULT,
            ], $this->panel);

            // panel container class (table) [Card][Body]
            $this->containerOptions['class'] = 'card-body'.(isset($this->containerOptions['class']) ? ' '.$this->containerOptions['class'] : '');


            // Toolbar (panel before)
            $this->panelBeforeTemplate = '{before}';

            // Toolbar Create Button
            if ($this->toolbarCreate) {
                $this->panel['before'].= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app/crud', 'create'), ['create'], [
                    'class' => 'btn btn-success pull-left',
                ]);
            }

            // Toolbar Filter Clear Button
            if ($this->toolbarResetFilter) {
                $this->panel['before'].= Html::a('<i class="fa fa-close"></i> ' . Yii::t('app/crud', 'filter.clear'), ['index'], [
                    'class' => 'btn btn-danger pull-right',
                    'title' => Yii::t('app/crud', 'filter.clear')
                ]);
            }
        }

        // pager
        $this->pager = [
            'maxButtonCount' => 5,
            'prevPageLabel' => Icon::show('chevron-left'),
            'nextPageLabel' => Icon::show('chevron-right'),
            'options' => ['class' => 'pagination justify-content-center m-0']
        ];

        // filter display
        if(!$this->filterDisplay){
            $this->filterModel = null;
        } else {
            $this->filterModel->setScenario(CrudItem::SCENARIO_SEARCH);
        }

        // dataProvider
        if(is_null($this->dataProvider)){
            $this->dataProvider = $this->filterModel->getDataProvider();
        }



        parent::init();
    }

    static function delete($item, $options = []){

        Modal::begin([
            'id' => $item->modelName.'delete'.$item->id,
            'title' => Yii::t('app/crud','confirmation'),
            'toggleButton' => ArrayHelper::merge(['tag' => 'span', 'label' => Icon::show('trash text-info'), 'type' => false],$options),
            'footer' =>
                Html::button(Icon::show('close').' '.Yii::t('app/crud','form.cancel'), ['class' => 'btn btn-warning', 'type' => 'button', 'data' => ['dismiss' => 'modal']]).
                Html::a(Icon::show('trash-o').' '.Yii::t('app/crud','form.delete'), $item->getURLDashboard($item::ACTION_DELETE), ['class' => 'btn btn-danger']),
        ]);

        echo Yii::t('app/crud','question.delete.item',['item' => mb_strtolower(Yii::t('model/'.(empty($item::$modelPrefix) ? '' : $item::$modelPrefix.'/').$item->modelType,'model.title',['n' => 100]))]);

        Modal::end();
    }


    static function status($item, $options = []){
        return Html::a(Icon::show('circle',['class'=>'text-'.($item->status > 0 ? 'success' : 'danger')]),$item->getURLDashboard($item::ACTION_STATUS),$options);
    }

    static function move($item, $all,  $options = [],$iconUp = 'up', $iconDown =  'down'){
        $optionsUp = $optionsDown = $options;
        $optionsDown['class'].= ($item->order == 1) ? ' disabled' : '';
        $optionsUp['class'].= ($item->order ==$all) ? ' disabled' : '';

        return
            self::move_item($item, $iconUp, $item::ACTION_MOVE_DOWN,$optionsDown).
            self::move_item($item, $iconDown, $item::ACTION_MOVE_UP,$optionsUp);
    }

    static function move_item($item, $icon, $action, $options = []){
        return Html::a(Icon::show('arrow-'.$icon,['title' =>  Yii::t('model', 'move.'.$action)]),$item->getURLDashboard($action),$options);
    }



}