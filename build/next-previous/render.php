<div <?php echo get_block_wrapper_attributes(); ?>>

<?php
function getPrevNext(){
  global $post;
  
	$pagelist = get_pages('sort_column=menu_order&sort_order=asc&post_status=publish,private&child_of=' . $post->post_parent . '');
	$pages = array();
	foreach ($pagelist as $page) {
	   $pages[] += $page->ID;
	}

	$current = array_search(get_the_ID(), $pages);
	$prevID = $pages[$current-1];
	$nextID = $pages[$current+1];
	
	echo '<div class="next-previous-nav">';
	
	if (!empty($prevID) & has_post_parent( get_the_ID() )) {
		echo '<div class="previous">';
		echo '<div><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet" data-rnw-int-class="nearest__265-1786__" class="arrow" style="vertical-align: middle;"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg> Previous </div>';
		echo '<a href="';
		echo get_permalink($prevID);
		echo '">';
		echo get_the_title($prevID); 
		echo'</a>';
		echo "</div>";
	}
    if ( has_post_parent( get_the_ID() ) ) : ?>
        <div class="parent"><div>Up <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet" data-rnw-int-class="nearest__265-1786__" class="arrow" style="vertical-align: middle;"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg></div>
        <a href="<?php the_permalink( get_post_parent( get_the_ID() ) ); ?>">
            <?php
            echo get_the_title( get_post_parent( get_the_ID() ) );
            ?>
        </a></div>
        <?php endif;
	if (!empty($nextID)) {
		echo '<div class="next">';
		echo'<div>Next <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" preserveAspectRatio="xMidYMid meet" data-rnw-int-class="nearest__265-1786__" class="arrow" style="vertical-align: middle;"><path d="M5 12h14M12 5l7 7-7 7"></path></svg></div>';
		echo '<a href="';
		echo get_permalink($nextID);
		echo '">';
		echo get_the_title($nextID); 
		echo'</a>';
		echo "</div>";		
	} 
}	
echo '</div>';
?>
<?php 
// $ID = get_the_ID();
//echo $ID;
//$children = get_pages( array( 'child_of' => $ID, 'post_type' => 'resource', ) );
//if (!$children) { 
  getPrevNext();
// }
wp_reset_postdata();
?>



</div>