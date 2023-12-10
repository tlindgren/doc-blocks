<?php


global $post;
$args = array(
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_parent'    => $post->ID,
    'order'          => 'ASC',
    'orderby'        => 'menu_order'
 ); 

$parent = new WP_Query( $args );


?>

<div <?php echo get_block_wrapper_attributes(); ?>>
<nav class="section-contents">
<ul class="parent-page">

<?php if ( $parent->have_posts() ) : ?>
    <?php while ( $parent->have_posts() ) : $parent->the_post(); 
    $children = get_pages('child_of='.$post->ID);
    $count = count($children);?>    
    <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
      <?php if( count( $children ) != 0 ): ?>
        <span class="child-count"> <?php echo $count ?></span>
       <?php endif; ?>
      <?php if ( ! has_excerpt() ) :
      echo '';  
      else: ?>
        <p class="entry-subtitle"><?php echo get_the_excerpt(); ?></p>
      <?php endif; ?></li>
    <?php endwhile; ?>

<?php endif; wp_reset_postdata(); ?>

</ul>
</nav>
</div>
<?php
// function section_children_excerpt_more( $more ) {
//     return '';
// }
// add_filter('excerpt_more', 'section_children_excerpt_more');

?>