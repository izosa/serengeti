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

    public $option_layout = '';

    public $bordered = true;
    public $condensed = true;
    public $hover = true;
    public $responsive = true;
    public $export = false;
    public $filterPosition = self::FILTER_POS_HEADER;
    public $resizableColumns = false;

    public $filterDisplay = true;
    public $toolbarDisplay = true;
    public $createDisplay = true;

    public $toolbar = [];
    public $toolbarCreate = true;
    public $toolbarResetFilter = true;

    public $panelTemplate = '';

    public $pjax = true;
    public $pjaxSettings = [
        'neverTimeout'=>true,
        'beforeGrid'=>'',
        'afterGrid'=>'',
        'loadingCssClass' => false,
    ];

    public $panel_up_left = '';
    public $panel_up_right = '';


    /**
     * @inheritdoc
     */
    public function init()
    {
        //options
        $this->id = 'crudList-'.Utility::shortClassName($this->filterModel);
        $this->options['class'] = 'crudList';

        // panel
        if(!is_bool($this->panel) || $this->panel != false) { // status

            // panel default
            $this->panel = ArrayHelper::merge([
                'type' => CrudList::TYPE_DEFAULT,
                'footerOptions' => ['class' => 'panel-footer text-center'],
            ], $this->panel);

            // panel default class
            $this->options['class'] .= ' ' . $this->panelPrefix . $this->panel['type'];

            // toolbar
            if (!is_bool($this->toolbar) || $this->toolbar != false){ // status
                if ($this->panel == []) { // default

                    // create
                    if ($this->toolbarCreate) {
                        $this->toolbar[] = Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app/crud', 'create'), ['create'], [
                            'class' => 'btn btn-success',
                        ]);
                    }

                    // filter clear
                    if ($this->toolbarResetFilter) {
                        $this->toolbar[] = Html::a('<i class="fa fa-close"></i> ' . Yii::t('app/crud', 'filter.clear'), ['index'], [
                            'class' => 'btn btn-danger pull-right',
                            'title' => 'Reset Grid'
                        ]);
                    }

                    $this->summaryOptions['class'] .= '  pull-right';
                    $this->toolbar[] = '{summary}<div class="clearfix"></div>';
                }
            }

            // panel templete
            if(!is_bool($this->panelTemplate) || $this->panelTemplate != false){ // status
                if(empty($this->panelTemplate)){ // default
                    $this->panelTemplate = (((!is_bool($this->toolbar) || $this->toolbar != false)) ? Html::tag('div', '{toolbar}', ['class' => 'kv-panel-before']) : '') . '{items}{panelFooter}';
                }
            }
        }

        // pager
        $this->pager = [
            'maxButtonCount' => 5,
            'prevPageLabel' => Icon::show('chevron-left'),
            'nextPageLabel' => Icon::show('chevron-right'),
        ];

        // dataProvider
        if(is_null($this->dataProvider)){
            $this->dataProvider = $this->filterModel->getDataProvider();
        }

        // filter display
        if(!$this->filterDisplay){
            $this->filterModel = null;
        }

        parent::init();
    }

}