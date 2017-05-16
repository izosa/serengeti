<?

if($video->responsive){
    echo '<div class="embed-responsive embed-responsive-'.$video->ratio.'">';
}
    echo '<iframe '.($video->responsive ? 'class="embed-responsive-item" ' : '').'width="'.$video->width.'" height="'.$video->height.'" src="'.$video->url.'" allowfullscreen></iframe>';

if($video->responsive){
    echo '</div>';
}