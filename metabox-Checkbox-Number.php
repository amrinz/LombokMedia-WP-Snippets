class Locations_Metabox {

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
			'locations-metabox',
			__( 'Locations', 'martinhal2' ),
			array( $this, 'render_locations_metabox' ),
			'm2_accomodation',
			'normal',
			'default'
		);

	}

	public function render_locations_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'locations_nonce_action', 'locations_nonce' );

		// Retrieve an existing value from the database.
		$locations_tag_term = get_post_meta( $post->ID, 'locations_tag_term', true );
		$locations_distance = get_post_meta( $post->ID, 'locations_distance', true );

		// Set default values.
		if( empty( $locations_tag_term ) ) $locations_tag_term = array();
		if( empty( $locations_distance ) ) $locations_distance = '5';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="locations_tag_term" class="locations_tag_term_label">' . __( 'tag_term_name', 'martinhal2' ) . '</label></th>';
		echo '		<td>';
		echo '			<label><input type="checkbox" name="locations_tag_term[]" class="locations_tag_term_field" value="' . esc_attr( '' ) . '" ' . ( in_array( '', $locations_tag_term )? 'checked="checked"' : '' ) . '> ' . __( '', 'martinhal2' ) . '</label><br>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="locations_distance" class="locations_distance_label">' . __( 'Distance (min)', 'martinhal2' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="number" id="locations_distance" name="locations_distance" class="locations_distance_field" placeholder="' . esc_attr__( '5', 'martinhal2' ) . '" value="' . esc_attr( $locations_distance ) . '">';
		echo '			<p class="description">' . __( 'time it takes to walk', 'martinhal2' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['locations_nonce'] ) ? $_POST['locations_nonce'] : '';
		$nonce_action = 'locations_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Sanitize user input.
		$locations_new_tag_term = isset( $_POST[ 'locations_tag_term' ] ) ? array_intersect( (array) $_POST[ 'locations_tag_term' ], array( '' ) )  : array();
		$locations_new_distance = isset( $_POST[ 'locations_distance' ] ) ? floatval( $_POST[ 'locations_distance' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'locations_tag_term', $locations_new_tag_term );
		update_post_meta( $post_id, 'locations_distance', $locations_new_distance );

	}

}

new Locations_Metabox;