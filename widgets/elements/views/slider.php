<?
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?=Html::tag('div',
    Html::a(
        Html::img(
            Url::to($item['image'], true),
            ['alt' => $item['alt'],
                'title' => $item['alt']]
        ),
        Url::to($item['url'], true)
    )
);
?>