<?php
// get page template
$post_id = (isset($_GET['post'])) ? $_GET['post'] : $_POST['post_ID'];
$template = get_post_meta( $post_id, '_wp_page_template', true );

	if($template == "tpl-home.php") {

	// remove text editor
	function remove_editor() {
	remove_post_type_support('page', 'editor');
	}
	add_action('admin_init', 'remove_editor');
	
	// start Metabox
	add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );

	// Define the metabox and field configurations.
	function cmb2_sample_metaboxes() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = 'lmd_';

		// Initiate the metabox
		$cmb = new_cmb2_box( array(
			'id'            => 'lomedia_metabox',
			'title'         => __( 'Hidden Box Area', 'cmb2' ),
			'object_types'  => array( 'page', ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
		) );

		$advanced_open = '
		<div class="divider">		
			<hr />
			<h4>Hidden Box</h4>
			<hr />
		';
		$advanced_close = '</div>';

		$cmb->add_field( array(
		'name' => esc_html__( 'Hidden Box Text', 'cmb2' ),
		'desc' => esc_html__( 'hidden box text, ex: <h3>Title</h3><p>Content</p>', 'cmb2' ),
		'id'   => $prefix . 'hbc1',
		'type' => 'textarea',
		) );

		$cmb->add_field( array(
		'name' => esc_html__( 'Hidden Box Image', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or type a URL. ex: http://example.com/image.jpg<br />Recommended size: 400 x 273 pixels', 'cmb2' ),
		'id'   => $prefix . 'hbi1',
		'type' => 'file',
		) );
		
		// URL text field
		$cmb->add_field( array(
		'name' => __( 'Image Link to URL', 'cmb2' ),
		'desc' => __( 'Your image link to, ex:http://example.com', 'cmb2' ),
		'id'   => $prefix . 'hbl1',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
		) );

		$cmb->add_field( array(
		'name' => esc_html__( 'Hidden Box Thumbnail', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or type a URL. ex: http://example.com/image.jpg<br />Recommended size: 300 x 100 pixels', 'cmb2' ),
		'id'   => $prefix . 'hbt1',
		'type' => 'file',
		) );

		$cmb->add_field( array(
		'before_row' => $advanced_open,
		'name' => esc_html__( 'Hidden Box Text', 'cmb2' ),
		'desc' => esc_html__( 'hidden box text, ex: <h3>Title</h3><p>Content</p>', 'cmb2' ),
		'id'   => $prefix . 'hbc2',
		'type' => 'textarea',
		) );

		$cmb->add_field( array(
		'name' => esc_html__( 'Hidden Box Image', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or type a URL. ex: http://example.com/image.jpg<br />Recommended size: 400 x 273 pixels', 'cmb2' ),
		'id'   => $prefix . 'hbi2',
		'type' => 'file',
		) );
		
		// URL text field
		$cmb->add_field( array(
		'name' => __( 'Image Link to URL', 'cmb2' ),
		'desc' => __( 'Your image link to, ex:http://example.com', 'cmb2' ),
		'id'   => $prefix . 'hbl2',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
		) );

		$cmb->add_field( array(
		'name' => esc_html__( 'Hidden Box Thumbnail', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or type a URL. ex: http://example.com/image.jpg<br />Recommended size: 300 x 100 pixels', 'cmb2' ),
		'id'   => $prefix . 'hbt2',
		'type' => 'file',
		'after_row' => $advanced_close,
		) );

		$cmb->add_field( array(
		'before_row' => $advanced_open,
		'name' => esc_html__( 'Hidden Box Text', 'cmb2' ),
		'desc' => esc_html__( 'hidden box text, ex: <h3>Title</h3><p>Content</p>', 'cmb2' ),
		'id'   => $prefix . 'hbc3',
		'type' => 'textarea',
		) );

		$cmb->add_field( array(
		'name' => esc_html__( 'Hidden Box Image', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or type a URL. ex: http://example.com/image.jpg<br />Recommended size: 400 x 273 pixels', 'cmb2' ),
		'id'   => $prefix . 'hbi3',
		'type' => 'file',
		) );
		
		// URL text field
		$cmb->add_field( array(
		'name' => __( 'Image Link to URL', 'cmb2' ),
		'desc' => __( 'Your image link to, ex:http://example.com', 'cmb2' ),
		'id'   => $prefix . 'hbl3',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
		) );

		$cmb->add_field( array(
		'name' => esc_html__( 'Hidden Box Thumbnail', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or type a URL. ex: http://example.com/image.jpg<br />Recommended size: 300 x 100 pixels', 'cmb2' ),
		'id'   => $prefix . 'hbt3',
		'type' => 'file',
		'after_row' => $advanced_close,
		) );

	} // EO cmb2_sample_metaboxes

} // END

// USAGE:
// $var = get_post_meta( get_the_ID(), 'lmd_hbc2', true ); if(!empty($var)) { echo $var; } else { /* do something */ }