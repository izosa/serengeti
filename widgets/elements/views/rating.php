<div class="widgetRating">
    <div class="pull-left"><span class="widgetRatingLabel">Rating: </span></div>
    <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <div id="widgetRatingStars">
            <? for($i = 1; $i <= $count; $i++) { ?>
            <input type="radio" class="rating" value="<?=$i?>" />
            <?}?>
        </div>
        <meta itemprop="ratingCount" content="<?=$votes?>">
        <meta itemprop="ratingValue" content="<?=$stars?>">
        <meta itemprop="worstRating" content="1">
        <meta itemprop="bestRating" content="<?=$count?>">
        <div class="pull-left" id="widgetRatingMessage"></div>
    </div>
</div>