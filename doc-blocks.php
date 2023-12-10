<?php
/**
 * Plugin Name:       Doc Blocks
 * Description:       A set of blocks and templates for enhancing page in the block themes
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0

 * Author:            Tim Lindgren
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       doc-blocks
 *
 * @package           docblocks
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function docblocks_block_init() {
	register_block_type( __DIR__ . '/build/section-sidebar' );
    register_block_type( __DIR__ . '/build/section-children' );
    register_block_type( __DIR__ . '/build/next-previous' );
    register_block_type( __DIR__ . '/build/permanent-url' );
    register_block_type( __DIR__ . '/build/toc');
}
add_action( 'init', 'docblocks_block_init' );


// Enqueue Scripts and Styles
function add_theme_scripts() {
	
	wp_enqueue_style( 'tocbot', get_template_directory_uri() . '/vendor/toc/toc.css', array(), '1.1', 'all');
	wp_enqueue_script('tocbot', get_stylesheet_directory_uri().'/vendor/toc/tocbot.min.js', 
    array(), false, true);
	wp_enqueue_script('tocbot-init', get_stylesheet_directory_uri().'/vendor/toc/tocbot-init.js', 
    array(), false, true);
	
	wp_enqueue_style( 'clipboard', get_template_directory_uri() . '/vendor/clipboard/clipboard.css', array(), '1.1', 'all');
	wp_enqueue_script('clipboard', get_stylesheet_directory_uri().'/vendor/clipboard/clipboard.min.js', 
    array(), false, true);
	wp_enqueue_script('clipboard-init', get_stylesheet_directory_uri().'/vendor/clipboard/clipboard-init.js', 
    array(), false, true);

  }
  add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// Register Block Patterns

function doc_blocks_register_block_pattern_category() {
    if ( class_exists( 'WP_Block_Pattern_Categories_Registry' ) ) {
        WP_Block_Pattern_Categories_Registry::get_instance()->register( 'doc-blocks', array( 'label' => __( 'Doc Blocks', 'text-domain' ) ) );
    }
}

add_action( 'init', 'doc_blocks_register_block_pattern_category' );

function doc_blocks_register_block_patterns() {
    $pattern_directory = plugin_dir_path( __FILE__ ) . 'patterns/';

    // Register Child Page Pattern
    ob_start();
    include( $pattern_directory . 'child-page.php' );
    $child_page_content = ob_get_clean();

    register_block_pattern(
        'doc-blocks/child-page',
        array(
            'title'         => __( 'Child Page', 'text-domain' ),
            'description'   => _x( 'A custom block pattern for a child page layout.', 'Block pattern description', 'text-domain' ),
            'content'       => $child_page_content,
            'categories'    => array( 'doc-blocks' ),
        )
    );

    // Register Parent Page Pattern
    ob_start();
    include( $pattern_directory . 'parent-page.php' );
    $parent_page_content = ob_get_clean();

    register_block_pattern(
        'doc-blocks/parent-page',
        array(
            'title'         => __( 'Parent Page', 'text-domain' ),
            'description'   => _x( 'A custom block pattern for a parent page layout.', 'Block pattern description', 'text-domain' ),
            'content'       => $parent_page_content,
            'categories'    => array( 'doc-blocks' ),
        )
    );
}

add_action( 'init', 'doc_blocks_register_block_patterns' );



/**
 * Register block styles.
 */
function doc_blocks_register_block_styles() {

	$block_styles = array(
		'core/image'            => array(
			'plain' => __( 'Plain', 'cdilblocks' ),
		),
		'core/group'            => array(
			'shadow' => __( 'Shadow', 'cdilblocks' ),
			'shadow-lg' => __( 'Shadow-Large', 'cdilblocks' ),
			'intro-box' => __( 'Introduction Box', 'cdilblocks' ),
			'highlight-box' => __( 'Highlight Box', 'cdilblocks' ),
			'callout-info' => __( 'Info', 'cdilblocks' ),
			'callout-success' => __( 'Success', 'cdilblocks' ),
			'callout-warning' => __( 'Warning', 'cdilblocks' ),
			'callout-danger' => __( 'Danger', 'cdilblocks' ),
		),

		'core/embed'            => array(
			'plain' => __( 'Plain', 'cdilblocks' ),
		),
		'core/paragraph'            => array(
			'intro-box' => __( 'Introduction Box', 'cdilblocks' ),
			'highlight-box' => __( 'Highlight Box', 'cdilblocks' ),
			'callout-info' => __( 'Info', 'cdilblocks' ),
			'callout-success' => __( 'Success', 'cdilblocks' ),
			'callout-warning' => __( 'Warning', 'cdilblocks' ),
			'callout-danger' => __( 'Danger', 'cdilblocks' ),
		),
	);

	foreach ( $block_styles as $block => $styles ) {
		foreach ( $styles as $style_name => $style_label ) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action( 'init', 'doc_blocks_register_block_styles' );


// Add Exerpts on Pages
add_post_type_support( 'page', 'excerpt' );


// Plugn Update Checker
// https://github.com/YahnisElsts/plugin-update-checker/
require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/tlindgren/docblocks/',
	__FILE__,
	'doc-blocks'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');
