<?

namespace izosa\serengeti\data\bootstrap;

use Yii;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

class Crud extends GridView
{
    const SCENARIO_SEARCH = 'search';
    const SCENARIO_CRUD = 'crud';

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    public $bordered = true;
    public $condensed = true;
    public $hover = true;
    public $responsive = true;

    public $create = true;
    public $filterReset = true;

    public $pjax = true;
    public $pjaxSettings = [
        'neverTimeout'=>true,
        'beforeGrid'=>'',
        'afterGrid'=>'',
        'loadingCssClass' => false,
    ];

    //public $options = ['id' => 'list','class' => 'grid-view'];


    public $export = false;
    //public $layout ='{items}<div class="text-center">{pager}{summary}</div>';
    public $filterPosition = Crud::FILTER_POS_HEADER;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setup();

        if(is_null($this->dataProvider)){
            $this->dataProvider = $this->filterModel->dataProvider;
        }

        parent::init();
    }

    public function setup(){

        $this->pager = [
            'maxButtonCount' => 5,
            'prevPageLabel' => Icon::show('chevron-left'),
            'nextPageLabel' => Icon::show('chevron-right'),
        ];

        $this->panel['before'] = (isset($this->panel['before']) ? $this->panel['before']  : '') . ($this->create ? Html::a(Icon::show('plus').' '.Yii::t('app/crud', 'create'), Url::to('/'.strtolower(basename(str_replace('\\','/',$this->filterModel->className()))).'/create',true), ['class' => 'btn btn-success']) : '').' '.($this->filterReset ? Html::a(Icon::show('times').' '.Yii::t('app/crud', 'clear.filters'), ['index'], ['class' => 'pull-right btn btn-danger', 'style' => 'margin-right:5px']) : '').' <div class="pull-right" style="line-height:36px;color:grey;font-size:12px;margin-right:15px;">{summary}</div>';
        $this->panel['after']  = false;//(isset($this->panel['after']) ? $this->panel['after']  : '') . '';


        $this->panel = ArrayHelper::merge( [
            'type'=>Crud::TYPE_DEFAULT,
            'heading'=>false,
            'footerOptions' => ['class' => 'panel-footer text-center'],
        ],$this->panel);
    }

}