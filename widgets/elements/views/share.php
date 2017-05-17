<div class="col-xs-12 shareWidget">
    <div class="title"><?=$item->title?></div>
        <ul>
            <li><a target="_blank" class="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?=$item->link?>" >Facebook</a></li>
            <li><a target="_blank" class="gplus" href="https://plus.google.com/share?url=<?=$item->link?>">Google+</a></li>
            <li><a target="_blank" class="twitter" href="https://twitter.com/intent/tweet?url=<?=$item->link?>">Twitter</a></li>
            <li><a target="_blank" class="rss" href="<?= Yii::$app->urLManager->hostInfo ?>/rss" >RSS</a></li>
        </ul>
</div>