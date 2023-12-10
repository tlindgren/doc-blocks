
<?php
// Add ID to headings for TOC
// Credits https://jeroensormani.com/automatically-add-ids-to-your-headings/
	function toc_auto_id_headings( $content ) {

		$content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
			if ( ! stripos( $matches[0], 'id=' ) ) :
				$matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $matches[3] . $matches[4];
			endif;
			return $matches[0];
		}, $content );
	
		return $content;
	
	}
	add_filter( 'the_content', 'toc_auto_id_headings' );

    