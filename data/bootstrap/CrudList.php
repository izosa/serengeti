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

    public $bordered = true;
    public $condensed = true;
    public $hover = true;
    public $responsive = true;
    public $export = false;
    public $summary = true;
    public $filterPosition = CrudList::FILTER_POS_HEADER;

    public $filterDisplay = true;
    public $toolbarDisplay = true;
    public $createDisplay = true;

    public $create = true;
    public $resetFilter = true;

    public $pjax = true;
    public $pjaxSettings = [
        'neverTimeout'=>true,
        'beforeGrid'=>'',
        'afterGrid'=>'',
        'loadingCssClass' => false,
    ];

    public $panel_up_left = '';
    public $panel_up_right = '';

    //public $layout ='{items}<div class="text-center">{pager}{summary}</div>';


    /**
     * @inheritdoc
     */
    public function init()
    {

        //options
//        $this->option_id = empty($this->id) ? false : $this->id;
//        $this->panel_class = empty($this->option_class) ? 'crudList crudList'.Utility::shortClassName($this->filterModel) : $this->option_class;


        // toolbar
        if($this->toolbarDisplay){

            $this->toolbar = [];

            // create
            if($this->createDisplay){
                $this->toolbar[] = Html::a('<i class="fa fa-plus"></i> '.Yii::t('app/crud', 'create'), ['create'], [
                    'class' => 'btn btn-success',
                ]);
            }

            // filter clear
            if($this->filterDisplay){
                $this->toolbar[] = Html::a('<i class="fa fa-close"></i> '.Yii::t('app/crud', 'filter.clear'), ['index'], [
                    'class' => 'btn btn-danger pull-right',
                    'title' => 'Reset Grid'
                ]);
            }

            // items
            if($this->toolbarDisplay && !empty($this->toolbarItems)){
                foreach ($this->toolbarItems as $item){
                    $this->toolbar[] = $item;
                }
            }

            $this->toolbar[] = '{summary}';
        }

        //template
        $this->panelTemplate = '<div class="{prefix}{type} '.(empty($this->option_class) ? ' crudList crudList'.Utility::shortClassName($this->filterModel,false) : $this->option_class).'">';
        $this->panelTemplate.= $this->toolbarDisplay ? Html::tag('div', '{toolbar}',['class' => 'toolbar']) : '';
        $this->panelTemplate.='{items}{panelFooter}</div>';

        //panels
//
//        $this->panelFooterTemplate =

        $this->panel = ArrayHelper::merge( [
//            'type'=>CrudList::TYPE_DEFAULT,
//            'heading'=>false,
//            'footer'=>false,

            'footerOptions' => ['class' => 'panel-footer text-center'],
        ],$this->panel);

//        $this->panel = false;


        // pager
        $this->pager = [
            'maxButtonCount' => 5,
            'prevPageLabel' => Icon::show('chevron-left'),
            'nextPageLabel' => Icon::show('chevron-right'),
        ];

        // dataProvider
        if(is_null($this->dataProvider)){
            $this->dataProvider = $this->filterModel->dataProvider;
        }


        // filter display
        if(!$this->filterDisplay){
            $this->filterModel = null;
        }



        parent::init();
    }

}