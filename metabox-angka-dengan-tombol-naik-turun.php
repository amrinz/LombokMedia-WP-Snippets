<?php
class Custom_Meta_Box {

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
			'beds-metabox',
			__( 'Beds', 'martinhal2' ),
			array( $this, 'render_beds_metabox' ),
			'slideshows',
			'normal',
			'default'
		);

	}

	public function render_beds_metabox( $post ) {

		// Retrieve an existing value from the database.
		$beds_adult_beds = get_post_meta( $post->ID, 'beds_adult-beds', true );
		$beds_children_beds = get_post_meta( $post->ID, 'beds_children-beds', true );

		// Set default values.
		if( empty( $beds_adult_beds ) ) $beds_adult_beds = '';
		if( empty( $beds_children_beds ) ) $beds_children_beds = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="beds_adult-beds" class="beds_adult-beds_label">' . __( 'Number of adult beds', 'martinhal2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="beds_adult_beds" name="beds_adult-beds" class="beds_adult_beds_field" placeholder="' . esc_attr__( '', 'martinhal2' ) . '" value="' . esc_attr( $beds_adult_beds ) . '">';
		echo '			<p class="description">' . __( 'how many sleeping places for adutls', 'martinhal2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="beds_children-beds" class="beds_children-beds_label">' . __( 'Number of children beds', 'martinhal2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="beds_children_beds" name="beds_children-beds" class="beds_children_beds_field" placeholder="' . esc_attr__( '', 'martinhal2' ) . '" value="' . esc_attr( $beds_children_beds ) . '">';
		echo '			<p class="description">' . __( 'number of children beds', 'martinhal2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Sanitize user input.
		$beds_new_adult_beds = isset( $_POST[ 'beds_adult-beds' ] ) ? floatval( $_POST[ 'beds_adult-beds' ] ) : '';
		$beds_new_children_beds = isset( $_POST[ 'beds_children-beds' ] ) ? floatval( $_POST[ 'beds_children-beds' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'beds_adult-beds', $beds_new_adult_beds );
		update_post_meta( $post_id, 'beds_children-beds', $beds_new_children_beds );

	}

}

new Custom_Meta_Box;