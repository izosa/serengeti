<?
namespace izosa\serengeti\data\bootstrap;

use Yii;
use kartik\icons\Icon;
use \kartik\helpers\Html;
use \kartik\form\ActiveForm;
use letyii\tinymce\Tinymce;

/**
 * Form implement boostrtap design
 * @author izosa
 * @version 1.0
 */
class CrudForm extends ActiveForm{

    const SCENARIO_SEARCH = 'search';
    const SCENARIO_CRUD = 'crud';

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    public $layout = 'horizontal';

    public $options = [
        'enctype' => 'multipart/form-data',
        'class'   => 'crudForm',
    ];

    public $fieldConfig = [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}\n",
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'offset' => 'col-sm-offset-1',
            'wrapper' => 'col-sm-10',
            'error' => '',
            'hint' => '',
        ],
//
    ];

    public function content($model, $attribute, $options = [])
    {
        $class = basename(Yii::$app->getBasePath()).'\assets\AppAsset';
        $class::register(Yii::$app->view);

        return $this->field($model, $attribute, ['horizontalCssClasses' => ['wrapper' => 'col-sm-10']])->widget(Tinymce::className(), [
            'options' => [
                'id' => 'content',
                'rows' => 20,
                'required',

            ],
            'configs' => [ // Read more: http://www.tinymce.com/wiki.php/Configuration

                // global
                'width' => '750px',
                'height' => '500px',
                'max_width' => '750px',
                'plugin_preview_width' => '750px',
                'plugins' => 'lists,fullscreen,image,imagetools,link,preview, visualblocks,code,table,print,media,searchreplace,charmap,contextmenu',
                'toolbar' => [
                    "preview fullscreen | undo redo |  alignleft aligncenter alignright alignjustify | indent outdent bullist numlist |"
                    . " styleselect || bold italic underline blockquote removeformat | link  image  media  table | code visualblocks  ",
                ],

                // url
                'relative_urls' => false,
                'remove_script_host' => false,

                // todo
                'document_base_url' => Yii::$app->request->hostInfo.dirname(Yii::$app->request->scriptUrl).'/',
//                'language' => substr(Yii::$app->language,0,2),
//                "language_url" => Yii::$app->assetManager->bundles['backend\assets\AppAsset']->baseUrl.'/js/lib/tinymce/langs/'.substr(Yii::$app->language,0,2).'.js',
                'external_plugins' => [
//                    "jbimages" => Yii::$app->assetManager->bundles['backend\assets\AppAsset']->baseUrl."/js/lib/tinymce/jbimages/plugin.min.js",
                ],

                // image
                'image_advtab' => true,
                'image_class_list' => [
                    ['title' => 'Responsive', 'value' => ''],
                    ['title' => 'Fixed', 'value' => 'imageFixed'],
                    ['title' => 'Align left', 'value' => 'imageLeft'],
                    ['title' => 'Align right', 'value' => 'imageRight'],
                ],
                'image_dimensions' => true,

                // table
                "table_class_list" => [
                    ["title" => 'None', "value" => 'table table-striped'],
                    ["title" => 'Small', "value" => 'table table-striped table-condensed'],
                    ["title" => 'No Striped', "value" => 'table'],
                    ["title" => 'No Striped Small', "value" => 'table table-condensed'],
                ],
                "table_default_attributes" => [
                    'class' => 'table table-striped',
                    'border' => 0,
                    'style' => ''
                ],
                "invalid_styles" => [
                    "table" => "width height border-collapse",
                    "img" => "font-size, font-color font-style width height"
                ],
                "table_grid" => false,

                // not filter scripts
                'extended_valid_elements' => 'script[height|width|charset|defer|language|src|type]',

                // live preview styles
                'content_css' => Yii::$app->request->hostInfo . "/preview-styles.css",
                'body_class' => 'articleBody itemContent',
            ],
        ]);
    }


    public function checkbox($model, $attribute, $options = [])
    {
        return $this->field($model, $attribute,[
            'horizontalCheckboxTemplate' => "<div class=\"col-xs-offset-2 col-sm-10\">\n<div class=\"checkbox checkbox-success\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n</div>\n{hint}",
        ])->checkbox($options,true);

    }

    // buttons


    public function buttonSave($model)
    {
        return Html::submitButton(Icon::show($model->isNewRecord ? 'file' : 'floppy-o').' '.Yii::t('app/crud',$model->isNewRecord ? 'form.create' : 'form.save') , ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']);
    }

    public function buttonCancel($model)
    {
        return Html::a(Icon::show('remove').' '.Yii::t('app/crud','form.cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-warning']);
    }

    public function buttonPreview($model)
    {
        return $model->isNewRecord ? '' : Html::a(Icon::show('eye').' '.Yii::t('app/crud','form.live.preview'), str_replace('admin.','www.',$model->url), ['class' => 'btn btn-review pull-right', 'target' => '_blank']);
    }


}
