<?php 
$postID = get_queried_object_id();
 echo '<div class="shortlink"> <input type="hidden" value="'. site_url() .'?p=' . $postID . '" id="short_url" maxlength="30" size="30" ><button class="copy-short-link" data-clipboard-target="#short_url">
Copy Permanent URL</button></div>' ;
?>
