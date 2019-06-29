<?
namespace izosa\serengeti\data\bootstrap;

use izosa\serengeti\data\CrudItem;
use izosa\serengeti\widgets\google\Youtube;
use izosa\serengeti\widgets\helpers\Loader;
use Yii;
use kartik\icons\Icon;
use \kartik\helpers\Html;
use \kartik\form\ActiveForm;
use letyii\tinymce\Tinymce;
use yii\helpers\ArrayHelper;

/**
 * CrudForm implement bootstrap design
 * @package izosa\serengeti\data\bootstrap
 * @version 1.0
 * @author Hristo Hristov <izosa@msn.com>
 *
 * @property CrudItem $item
 */
class CrudForm extends ActiveForm{

    public $item  = null;
    public $type = self::TYPE_HORIZONTAL;

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
    ];



    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        // [Form][ID]
        if(!is_null($this->item) && !$this->item->isNewRecord){
            $this->options['id'] = $this->options['class'].'-'.CrudItem::shortClassName($this->item).'-'.$this->item->id;

        }

        parent::init();
    }

    // <editor-fold defaultstate="collapsed" desc="Fields">

    /**
     * Item active field
     * @param $attribute
     * @param array $options
     * @return \kartik\form\ActiveField | string
     */
    public function itemField($attribute, $options = []){
        return $this->field($this->item,$attribute,$options);
    }


    /**
     * Item active field
     * @param $attribute
     * @param array $options
     * @return \kartik\form\ActiveField | string
     */
    public function itemHiddenField($attribute, $options = []){
        return Html::activeHiddenInput($this->item,$attribute,$options);
    }

    /**
     * Checkbox field
     * @param $attribute
     * @param array $options
     * @return \kartik\form\ActiveField | string
     */
    public function checkbox($attribute, $options = [])
    {
        return $this->field($this->item, $attribute,[
            'horizontalCheckboxTemplate' => "<div class=\"col-xs-offset-2 col-sm-10\">\n<div class=\"checkbox checkbox-success\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n</div>\n{hint}",
        ])->checkbox($options,true);

    }

    /**
     * Number field
     * @param $attribute
     * @param array $options
     * @return \kartik\form\ActiveField
     */

    /**
     * Number field
     * @param $attibute
     * @param int $step
     * @param int $min
     * @param int $max
     * @return \kartik\form\ActiveField | string
     */
    public function number($attibute, $step = 1, $min = 0 , $max = 99999999999, $options= [], $inputOptions = []){
        $inputOptions = ArrayHelper::merge([
            'type' => 'number',
            'min' => $min,
            'max' => $max,
            'step' => $step,
        ],$inputOptions);
        return $this->itemField($attibute,$options)->textInput($inputOptions);
    }

    //----------------

    /**
     * Title field
     * @param string $attribute
     * @return \kartik\form\ActiveField | string
     */
    public function title($attribute = 'title'){
        return $this->itemField($attribute);
    }

    /**
     * Status field
     * @param string $attribute
     * @return \kartik\form\ActiveField | string
     */
    public function status($attribute = 'status'){
        return $this->itemField($attribute)->dropDownList($this->item->listStatus());
    }

    /**
     * Slug field
     * @param string $attribute
     * @param string $title_attribute
     * @return \kartik\form\ActiveField | string
     */
    public function slug($attribute = 'slug', $title_attribute = 'title'){
        Loader::addWidget('pageSlug', [
            'model' =>  $this->item->modelType,
            'slug_attribute' =>  $attribute,
            'title_attribute' =>  $title_attribute,
        ]);

        return $this->itemField($attribute);
    }

    /**
     * Content field | TinyMCE field
     * @param $this->model
     * @param $attribute
     * @param array $options
     * @return $this
     * @return \kartik\form\ActiveField | string
     */
    public function content($attribute = 'content')
    {
        $class = basename(Yii::$app->getBasePath()).'\assets\AppAsset';
        $class::register(Yii::$app->view);

        return $this->itemField($attribute, ['horizontalCssClasses' => ['wrapper' => 'col-sm-10']])->widget(Tinymce::className(), [
            'options' => [
                'id' => 'content-'.$attribute,
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

    /**
     * Note field | TinyMCE field
     * @param $this->model
     * @param $attribute
     * @param array $options
     * @return \kartik\form\ActiveField | string
     */
    public function note($attribute = 'note')
    {
        return $this->content($attribute);
    }

    /**
     * Cover field
     * @param $attribute
     * @param array $options
     * @return \kartik\form\ActiveField | string
     */
    public function cover($attribute){
        $preview = '';

        if(!empty($this->item->{$attribute})){
            $preview = Html::a(
                Html::img($this->item->{$attribute},['class' => 'img-thumbnail']),
                $this->item->{$attribute},['class' => 'd-block swipebox col-sm-5 offset-sm-2 pt-3 pb-3']
            );
        }

        $button = Icon::show('upload').Yii::t('model/picture', 'upload.picture');

        return $preview. $this->itemField($attribute,[
            'template' => '{label} {beginWrapper} '.$button.' {input} {hint} {error} {endWrapper}',
                'horizontalCssClasses' => [
                    'wrapper' => ' btn btn-block btn-primary col-sm-2 ml-3 mr-3',
                ],
            ])->fileInput(['class' => 'input-file']);
    }

    /**
     * Video field
     * @param $attribute
     * @param array $options
     * @return \kartik\form\ActiveField | string
     */
    public function video($attribute = 'video'){

        $preview = '';

        if(!empty($this->item->{$attribute})){
            $preview = Html::tag('div',Youtube::widget(['youtubeid' => $this->item->{$attribute}]),['class' => 'col-sm-5 offset-sm-2 pt-3 pb-3']);
            $this->item->{$attribute} = Youtube::getUrlFromId($this->item->{$attribute});
        }

        return $preview. $this->itemField($attribute)->textInput(['placeholder' => Yii::t('app/crud','placeholder.video')]);
    }

    /**
     * Tags field
     * @param string $attribute
     * @return \kartik\form\ActiveField | string
     */
    public function tags($attribute = 'tags'){
        return $this->itemField($attribute)->textInput(['placeholder' => Yii::t('app/crud','placeholder.tags')]);
    }

    /**
     * Description field
     * @param string $attribute
     * @return \kartik\form\ActiveField | string
     */
    public function description($attribute = 'description'){
        return $this->itemField($attribute)->textInput(['placeholder' => Yii::t('app/crud','placeholder.description')]);
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Buttons">

    /**
     * Save button
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function buttonSave()
    {
        return Html::submitButton(Icon::show($this->item->isNewRecord ? 'file' : 'floppy-o').' '.Yii::t('app/crud',$this->item->isNewRecord ? 'form.create' : 'form.save') , ['class' => 'btn btn-'.($this->item->isNewRecord ? 'success' : 'primary')]);
    }

    /**
     * Cancel Button
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function buttonCancel()
    {
        return Html::a(Icon::show('remove').' '.Yii::t('app/crud','form.cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-warning']);
    }

    /**
     * Review button
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function buttonPreview()
    {
        return $this->item->isNewRecord ? '' : Html::a(Icon::show('eye').' '.Yii::t('app/crud','form.preview'), str_replace('admin.','www.',$this->item->url), ['class' => 'btn btn-dark', 'target' => '_blank']);
    }

    // </editor-fold>

}
