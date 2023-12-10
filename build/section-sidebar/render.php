<?php 
function list_section_pages() {

global $post;
$parent = get_the_title( $post->post_parent );
$linkToParent = get_permalink($post->post_parent);

if ( $post->post_parent )
$childpages = wp_list_pages( 'sort_column=menu_order&depth=1&title_li=&child_of=' . $post->post_parent . '&echo=0' );
else
$childpages = wp_list_pages( 'sort_column=menu_order&depth=1&title_li=&child_of=' . $post->ID . '&echo=0' );

if ( $childpages ) {

$string = '' . $childpages . ''; 
// echo '<span>< Back to <a href=" ' . $linkToParent . '"> ' . $parent . '</a><//h2>';
// echo '<h2>In this Section</h2>';
}

echo $string;
}
?>

<ul <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo list_section_pages(); ?>
</ul>
