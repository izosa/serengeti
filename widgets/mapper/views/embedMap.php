<script type="text/javascript">
<?
    if(!empty($item->width)){ echo 'var width = \''.$item->width.'\';'; }
    if(!empty($item->height)){ echo 'var height = \''.$item->height.'\';'; }
    if(!empty($item->latitude)  || $item->latitude  == 0){ echo 'var latitude = '.$item->latitude.';'; }
    if(!empty($item->longitude) || $item->longitude == 0){ echo 'var longitude = '.$item->longitude.';'; }
    if(!empty($item->zoom)){ echo 'var zoom = '.$item->zoom.';'; }
    if(!empty($item->imo)){ echo 'var imo = '.$item->imo.';'; }
    if(!empty($item->mmsi)){ echo 'var mmsi = '.$item->mmsi.';'; }
    if(!empty($item->vessel)){ echo 'var vessel = '.$item->vessel.';'; }
    if(!empty($item->poi)){ echo 'var poi = '.$item->poi.';'; }
?>
</script>
<script type="text/javascript" src="<?=yii\helpers\Url::to('/map/embed.js',true)?>"></script>