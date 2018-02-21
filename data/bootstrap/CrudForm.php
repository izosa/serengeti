<?
namespace izosa\serengeti\data\bootstrap;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use letyii\tinymce\Tinymce;
use kartik\icons\Icon;

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

        return $this->field($model, $attribute)->widget(Tinymce::className(), [
            'options' => $options,
            'configs' => [ // Read more: http://www.tinymce.com/wiki.php/Configuration
                'plugins' => 'fullscreen,image,link,preview, visualblocks,code,table,print,media,lists',
                'toolbar' => [
                    "preview fullscreen | undo redo |  alignleft aligncenter alignright alignjustify | indent outdent bullist numlist |"
                    . " styleselect | bold italic underline blockquote removeformat | link image media | code visualblocks"
                ],
                'relative_urls'=> false,
                'remove_script_host' => false,
                'document_base_url' => Yii::$app->request->hostInfo.dirname(Yii::$app->request->scriptUrl).'/',
//                'language' => substr(Yii::$app->language,0,2),
//                "language_url" => Yii::$app->assetManager->bundles['backend\assets\AppAsset']->baseUrl.'/js/lib/tinymce/langs/'.substr(Yii::$app->language,0,2).'.js',
                'external_plugins' => [
//                    "jbimages" => Yii::$app->assetManager->bundles['backend\assets\AppAsset']->baseUrl."/js/lib/tinymce/jbimages/plugin.min.js",
                ],
                'image_advtab' => true,
                'height' => '600',
                'image_class_list' => [
                    ['title' => 'Responsive', 'value' => ''],
                    ['title' => 'Fixed', 'value' => 'imageFixed'],
                    ['title' => 'Align left', 'value' => 'imageLeft'],
                    ['title' => 'Align right', 'value' => 'imageRight']
                ],
            ],
        ]);
    }


    public function checkbox($model, $attribute, $options = [])
    {
        return '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="'.Html::getInputId($model, $attribute).'">   
                '.Html::activeInput('checkbox',$model,$attribute, ['class' => 'mdl-checkbox__input' ]).'
                <span class="mdl-checkbox__label">'.$model->getAttributeLabel($attribute).'</span>
            </label>';
    }

    public function switchbox($model, $attribute, $options = [])
    {
        return '<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="'.Html::getInputId($model, $attribute).'">   
                '.Html::activeInput('checkbox',$model,$attribute, ['class' => 'mdl-switch__input' ]).'
                <span class="mdl-switch__label">'.$model->getAttributeLabel($attribute).'</span>
            </label>';
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
