class sqpp_meta_box_featured_image_control {

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
			'sqpp-mb-featured-image-control',
			__( 'Featured Image Control', 'sqppcptmeta' ),
			array( $this, 'render_metabox' ),
			array( 'post', 'page', 'idea' ),
			'side',
			'core'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'nonce_action', 'nonce' );

		// Retrieve an existing value from the database.
		$sqpp_mb_fic_select_content_use = get_post_meta( $post->ID, 'sqpp_mb_fic_select_content_use', true );
		$sqpp_mb_fic_select_bg_use = get_post_meta( $post->ID, 'sqpp_mb_fic_select_bg_use', true );

		// Set default values.
		if( empty( $sqpp_mb_fic_select_content_use ) ) $sqpp_mb_fic_select_content_use = '';
		if( empty( $sqpp_mb_fic_select_bg_use ) ) $sqpp_mb_fic_select_bg_use = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="sqpp_mb_fic_select_content_use" class="sqpp_mb_fic_select_content_use_label">' . __( 'Content + Previews Use', 'sqppcptmeta' ) . '</label></th>';
		echo '		<td>';
		echo '			<select id="sqpp_mb_fic_select_content_use" name="sqpp_mb_fic_select_content_use" class="sqpp_mb_fic_select_content_use_field">';
		echo '			<option value="1" ' . selected( $sqpp_mb_fic_select_content_use, '1', false ) . '> ' . __( 'Content + Previews', 'sqppcptmeta' ) . '</option>';
		echo '			<option value="2" ' . selected( $sqpp_mb_fic_select_content_use, '2', false ) . '> ' . __( 'Previews Only', 'sqppcptmeta' ) . '</option>';
		echo '			</select>';
		echo '			<p class="description">' . __( 'Default is: Content + Preview', 'sqppcptmeta' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="sqpp_mb_fic_select_bg_use" class="sqpp_mb_fic_select_bg_use_label">' . __( 'Header Background Use', 'sqppcptmeta' ) . '</label></th>';
		echo '		<td>';
		echo '			<select id="sqpp_mb_fic_select_bg_use" name="sqpp_mb_fic_select_bg_use" class="sqpp_mb_fic_select_bg_use_field">';
		echo '			<option value="1" ' . selected( $sqpp_mb_fic_select_bg_use, '1', false ) . '> ' . __( 'No', 'sqppcptmeta' ) . '</option>';
		echo '			<option value="2" ' . selected( $sqpp_mb_fic_select_bg_use, '2', false ) . '> ' . __( 'Yes', 'sqppcptmeta' ) . '</option>';
		echo '			</select>';
		echo '			<p class="description">' . __( 'Use the featured image as header background?', 'sqppcptmeta' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';
		$nonce_action = 'nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// Sanitize user input.
		$new_sqpp_mb_fic_select_content_use = isset( $_POST[ 'sqpp_mb_fic_select_content_use' ] ) ? $_POST[ 'sqpp_mb_fic_select_content_use' ] : '';
		$new_sqpp_mb_fic_select_bg_use = isset( $_POST[ 'sqpp_mb_fic_select_bg_use' ] ) ? $_POST[ 'sqpp_mb_fic_select_bg_use' ] : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'sqpp_mb_fic_select_content_use', $new_sqpp_mb_fic_select_content_use );
		update_post_meta( $post_id, 'sqpp_mb_fic_select_bg_use', $new_sqpp_mb_fic_select_bg_use );

	}

}

new sqpp_meta_box_featured_image_control;