<?php
/**
 * Created by PhpStorm.
 * User: izosa
 * Date: 17.10.2017 г.
 * Time: 10:40
 */

namespace izosa\serengeti\data\bootstrap;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use izosa\serengeti\widgets\helpers\SEO;

/**
 * DisplayList implement bootstrap design
 * @package izosa\serengeti\data\bootstrap
 * @version 0.1
 * @author Hristo Hristov <izosa@msn.com>
 */
class DisplayList extends \yii\widgets\ListView
{
    public $layout ='<ul>{items}</ul><nav>{pager}</nav>{summary}';
    public $options = [
        'class' => 'displayList',
        'id' => false,
    ];

    public $filterModel;
    private $pagination;

    public $itemView = 'list_item';
    public $itemTag = 'li';
    public $emptyText = '';
    public $pager = [
        'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
        'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
//        'firstPageLabel' => '<i class="fa fa-angle-left"></i><i class="fa fa-angle-left"></i>',
//        'lastPageLabel'  => '<i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i>',
//        'maxButtonCount' => 7,
//        'options' => ['class' => 'pager'],
//        'pageCssClass' => 'desktop',
        'registerLinkTags' => true,
        'hideOnSinglePage' => true,
        'maxButtonCount' => 9,
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        if (is_null($this->filterModel)) {
            throw new InvalidConfigException('The "filterModel" property must be set.');
        }

        // dataProvider
        $this->dataProvider = $this->filterModel->dataProvider;

        // Model Name
        $modelName = (new \ReflectionClass($this->filterModel))->getShortName();

        // listView class
        $this->options['class'].= (empty($this->options['class']) ? '' : ' ').'displayList_'.$modelName;

        // listItem class
        if(empty($this->itemOptions)){
            $this->itemOptions = ['class'=> (empty($this->itemOptions['class']) ? '' : ' ').'displayListItem_'.$modelName];
        } else {
            $this->itemOptions['class'].= (empty($this->itemOptions['class']) ? '' : ' ').'displayListItem_'.$modelName;
        }

        parent::init();

//        $this->dataProvider->prepare();

        // SEO
        if($this->dataProvider->count > 0 && $this->dataProvider->getPagination()->page == 0){
            SEO::addCanonical();
        } else {
            SEO::addNoIndexFollow();
        }
    }



    /**
     * Renders a single data model.
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key value associated with the data model
     * @param integer $index the zero-based index of the data model in the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderItem($model, $key, $index)
    {
        if ($this->itemView === null) {
            $content = $key;
        } elseif (is_string($this->itemView)) {
            $content = $this->getView()->render($this->itemView, array_merge([
                'item' => $model,
                'key' => $key,
                'index' => $index,
                'widget' => $this,
            ], $this->viewParams));
        } else {
            $content = call_user_func($this->itemView, $model, $key, $index, $this);
        }
        $options = $this->itemOptions;

        $tag = ArrayHelper::remove($options, 'tag', $this->itemTag);
        return Html::tag($tag, $content, $options);
    }

}