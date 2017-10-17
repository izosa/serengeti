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
                'plugins' => 'fullscreen,image,link,preview, visualblocks,code,table,print,media',
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

    public function buttonSave($model)
    {
        return Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-file"></i> Създай' : '<i class="glyphicon glyphicon-floppy-disk"></i> Запиши', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']);
    }

    public function buttonCancel($model)
    {
        return Html::a(Icon::show('remove').' Отказ', Yii::$app->request->referrer, ['class' => 'btn btn-warning']);
    }

    public function buttonPreview($model)
    {
        return $model->isNewRecord ? '' : Html::a('<i class="glyphicon glyphicon-eye-open"></i> Преглед в сайта', str_replace('/admin/','/',$model->url), ['class' => 'btn btn-review pull-right', 'target' => '_blank']);
    }


}
