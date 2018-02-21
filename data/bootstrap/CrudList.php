<?

namespace izosa\serengeti\data\bootstrap;

use izosa\serengeti\site\Utility;
use Yii;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class CrudList extends GridView
{

    public $option_id = false;
    public $option_class = '';
    public $option_layout = '';

    public $option_bordered = true;
    public $option_condensed = true;
    public $option_hover = true;
    public $option_responsive = true;
    public $option_export = false;
    public $option_summary = true;
    public $option_filterPosition = CrudList::FILTER_POS_HEADER;

    public $control_create = true;
    public $control_resetFilter = true;

    public $option_pjax = true;
    public $option_pjaxSettings = [
        'neverTimeout'=>true,
        'beforeGrid'=>'',
        'afterGrid'=>'',
        'loadingCssClass' => false,
    ];

    public $panel_up_left = '';
    public $panel_up_right = '';
    public $panel_down_left = '';
    public $panel_down_right = '';


    private $panel;

    //public $layout ='{items}<div class="text-center">{pager}{summary}</div>';


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setup_dataProvider();
        $this->setup_pager();
        $this->setup_panels();
        $this->setup_options();


        parent::init();
    }

    private function setup_pager(){
        $this->pager = [
            'maxButtonCount' => 5,
            'prevPageLabel' => Icon::show('chevron-left'),
            'nextPageLabel' => Icon::show('chevron-right'),
        ];
    }

    /**
     * Setup Visual Panels
     */
    private function setup_panels(){

        $this->panel['before'] = '';
        $this->panel['after'] = '';

        if($this->control_create){
            $this->panel['before'].= Html::a(Icon::show('plus').' '.Yii::t('app/crud', 'create'),Url::to('/'.strtolower(Utility::shortClassName($this->filterModel)).'/create',true), ['class' => 'btn btn-success']);
        }

        if($this->panel_up_left){
            $this->panel['before'].= $this->panel_up_left;
        }

        if($this->control_resetFilter){
            $this->panel['before'].= Html::a(Icon::show('times').' '.Yii::t('app/crud', 'filter.clear'), ['index'], ['class' => 'pull-right btn btn-danger', 'style' => 'margin-right:5px']);
        }

        if($this->option_summary){
            $this->panel['before'].= Html::a(Icon::show('times').' '.Yii::t('app/crud', 'clear.filters'), ['index'], ['class' => 'pull-right btn btn-danger', 'style' => 'margin-right:5px']);
        }

        if($this->panel_up_right){
            $this->panel['before'].= $this->panel_up_right;
        }

        // @todo add rows float class wrappers
        if($this->panel_down_left){
            $this->panel['after'].= $this->panel_down_left;
        }
        if($this->panel_down_right){
            $this->panel['after'].= $this->panel_down_right;
        }


        $this->panel = ArrayHelper::merge( [
            'type'=>CrudList::TYPE_DEFAULT,
            'heading'=>false,
            'footerOptions' => ['class' => 'panel-footer text-center'],
        ],$this->panel);
    }

    /**
     * Setup Data Provider
     */
    private function setup_dataProvider(){
        if(is_null($this->dataProvider)){
            $this->dataProvider = $this->filterModel->dataProvider;
        }
    }

    /**
     * Setup Options
     */
    private function setup_options(){
        $this->option_id = empty($this->option_id) ? false : $this->option->id;
        $this->option_class = empty($this->option_class) ? 'crudList crudList'.Utility::shortClassName($this->filterModel) : $this->option_class;
        $this->pjax = $this->option_pjax;
        $this->pjaxSettings = $this->option_pjaxSettings;

        $this->bordered = $this->option_bordered;
        $this->condensed = $this->option_condensed;
        $this->hover = $this->option_hover;
        $this->responsive = $this->option_responsive;
        $this->export = $this->option_export;
        $this->filterPosition = $this->option_filterPosition;
    }


}