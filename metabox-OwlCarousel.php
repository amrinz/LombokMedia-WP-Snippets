<?php
class Owl_Carousel_2_Meta {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'add_metabox' )         );
		add_action( 'save_post',             array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		add_meta_box(
			'Carousel_Data',
			__( 'Carousel Data', 'owl-carousel-2' ),
			array( $this, 'render_carousel_data' ),
			'owl-carousel',
			'normal',
			'default'
		);

	}

	public function render_carousel_data( $post ) {

		// Retrieve an existing value from the database.
		$dd_owl_duration = get_post_meta( $post->ID, 'dd_owl_duration', true );
		$dd_owl_transition = get_post_meta( $post->ID, 'dd_owl_transition', true );
		$dd_owl_stop = get_post_meta( $post->ID, 'dd_owl_stop', true );
		$dd_owl_orderby = get_post_meta( $post->ID, 'dd_owl_orderby', true );
		$dd_owl_navs = get_post_meta( $post->ID, 'dd_owl_navs', true );
		$dd_owl_dots = get_post_meta( $post->ID, 'dd_owl_dots', true );
		$dd_owl_image_options = get_post_meta( $post->ID, 'dd_owl_image_options', true );

		// Set default values.
		if( empty( $dd_owl_duration ) ) $dd_owl_duration = '2000';
		if( empty( $dd_owl_transition ) ) $dd_owl_transition = '400';
		if( empty( $dd_owl_stop ) ) $dd_owl_stop = 'false';
		if( empty( $dd_owl_orderby ) ) $dd_owl_orderby = '';
		if( empty( $dd_owl_navs ) ) $dd_owl_navs = 'true';
		if( empty( $dd_owl_dots ) ) $dd_owl_dots = 'true';
		if( empty( $dd_owl_image_options ) ) $dd_owl_image_options = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_duration" class="dd_owl_duration_label">' . __( 'Slide Duration', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="dd_owl_duration" name="dd_owl_duration" class="dd_owl_duration_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_duration ) . '">';
		echo '			<p class="description">' . __( 'Duration in ms.', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_transition" class="dd_owl_transition_label">' . __( 'Slide Transition', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="dd_owl_transition" name="dd_owl_transition" class="dd_owl_transition_field" placeholder="' . esc_attr__( '', 'owl-carousel-2' ) . '" value="' . esc_attr( $dd_owl_transition ) . '">';
		echo '			<p class="description">' . __( 'Transition Time in ms', 'owl-carousel-2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_stop" class="dd_owl_stop_label">' . __( 'Stop on Hover', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_stop" name="dd_owl_stop" class="dd_owl_stop_field" value="checked" ' . checked( $dd_owl_stop, 'checked', false ) . '> ' . __( '', 'owl-carousel-2' ) . '</label>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_orderby" class="dd_owl_orderby_label">' . __( 'Order Output', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<select id="dd_owl_orderby" name="dd_owl_orderby" class="dd_owl_orderby_field">';
		echo '			<option value="dd_owl_asc" ' . selected( $dd_owl_orderby, 'dd_owl_asc', false ) . '> ' . __( ' Date Ascending', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="dd_owl_desc" ' . selected( $dd_owl_orderby, 'dd_owl_desc', false ) . '> ' . __( 'Date Descending', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="dd_owl_rand" ' . selected( $dd_owl_orderby, 'dd_owl_rand', false ) . '> ' . __( 'Date Random', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="dd_owl_title" ' . selected( $dd_owl_orderby, 'dd_owl_title', false ) . '> ' . __( 'Title', 'owl-carousel-2' ) . '</option>';
		echo '			<option value="dd_owl_menu" ' . selected( $dd_owl_orderby, 'dd_owl_menu', false ) . '> ' . __( 'Menu Order', 'owl-carousel-2' ) . '</option>';
		echo '			</select>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_navs" class="dd_owl_navs_label">' . __( 'Show Nav Arrows', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_navs" name="dd_owl_navs" class="dd_owl_navs_field" value="checked" ' . checked( $dd_owl_navs, 'checked', false ) . '> ' . __( '', 'owl-carousel-2' ) . '</label>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_dots" class="dd_owl_dots_label">' . __( 'Show Dots', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" id="dd_owl_dots" name="dd_owl_dots" class="dd_owl_dots_field" value="checked" ' . checked( $dd_owl_dots, 'checked', false ) . '> ' . __( '', 'owl-carousel-2' ) . '</label>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="dd_owl_image_options" class="dd_owl_image_options_label">' . __( 'Image Display Options', 'owl-carousel-2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="radio" name="dd_owl_image_options" class="dd_owl_image_options_field" value="dd_owl_null" ' . checked( $dd_owl_image_options, 'dd_owl_null', false ) . '> ' . __( 'None', 'owl-carousel-2' ) . '</label><br>';
		echo '			<label><input type="radio" name="dd_owl_image_options" class="dd_owl_image_options_field" value="dd_owl_lightbox" ' . checked( $dd_owl_image_options, 'dd_owl_lightbox', false ) . '> ' . __( 'Lightbox', 'owl-carousel-2' ) . '</label><br>';
		echo '			<label><input type="radio" name="dd_owl_image_options" class="dd_owl_image_options_field" value="dd_owl_link" ' . checked( $dd_owl_image_options, 'dd_owl_link', false ) . '> ' . __( 'Link to Post', 'owl-carousel-2' ) . '</label><br>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Sanitize user input.
		$dd_owl_new_duration = isset( $_POST[ 'dd_owl_duration' ] ) ? floatval( $_POST[ 'dd_owl_duration' ] ) : '';
		$dd_owl_new_transition = isset( $_POST[ 'dd_owl_transition' ] ) ? floatval( $_POST[ 'dd_owl_transition' ] ) : '';
		$dd_owl_new_stop = isset( $_POST[ 'dd_owl_stop' ] ) ? 'checked'  : '';
		$dd_owl_new_orderby = isset( $_POST[ 'dd_owl_orderby' ] ) ? $_POST[ 'dd_owl_orderby' ] : '';
		$dd_owl_new_navs = isset( $_POST[ 'dd_owl_navs' ] ) ? 'checked'  : '';
		$dd_owl_new_dots = isset( $_POST[ 'dd_owl_dots' ] ) ? 'checked'  : '';
		$dd_owl_new_image_options = isset( $_POST[ 'dd_owl_image_options' ] ) ? $_POST[ 'dd_owl_image_options' ] : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'dd_owl_duration', $dd_owl_new_duration );
		update_post_meta( $post_id, 'dd_owl_transition', $dd_owl_new_transition );
		update_post_meta( $post_id, 'dd_owl_stop', $dd_owl_new_stop );
		update_post_meta( $post_id, 'dd_owl_orderby', $dd_owl_new_orderby );
		update_post_meta( $post_id, 'dd_owl_navs', $dd_owl_new_navs );
		update_post_meta( $post_id, 'dd_owl_dots', $dd_owl_new_dots );
		update_post_meta( $post_id, 'dd_owl_image_options', $dd_owl_new_image_options );

	}

}

new Owl_Carousel_2_Meta;