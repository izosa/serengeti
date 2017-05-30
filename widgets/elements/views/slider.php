<?use yii\helpers\Html;?>
<div class="owl-carousel" id="'.$this->target.'">
    <?
    foreach(self::$items as $item)
    {
        echo Html::tag('div',
            Html::a(
                Html::img(
                    Url::to($item['image_path'], true),
                    ['alt' => $item['alt'],
                     'title' => $item['alt']]
                ),
                Url::to($item['url'], true)
            )
        );
    }
    ?>
</div>