<?php
class Offer_Meta_Box {

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
			'offer_choose_user_metabox',
			__( 'Choose Client', 'wp-business' ),
			array( $this, 'render_metabox' ),
			'slideshows', //post-Type
			'normal', //side
			'high'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'offer_metabox_nonce_action', 'offer_metabox_nonce' );

		// Retrieve an existing value from the database.
		$offer_metabox_choose_client = get_post_meta( $post->ID, 'offer_metabox_choose_client', true );

		// Set default values.
		if( empty( $offer_metabox_choose_client ) ) $offer_metabox_choose_client = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="offer_metabox_choose_client" class="offer_metabox_choose_client_label">' . __( 'Choose Client', 'wp-business' ) . '</label></th>';
		echo '		<td>';
		wp_dropdown_users( array( 'id' => 'offer_metabox_choose_client', 'name' => 'offer_metabox_choose_client', 'class' => 'offer_metabox_choose_client_field', 'selected' => $offer_metabox_choose_client ) );
		echo '			<p class="description">' . __( 'Choose your client', 'wp-business' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['offer_metabox_nonce'] ) ? $_POST['offer_metabox_nonce'] : '';
		$nonce_action = 'offer_metabox_nonce_action';

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
		$offer_metabox_new_choose_client = isset( $_POST[ 'offer_metabox_choose_client' ] ) ? sanitize_text_field( $_POST[ 'offer_metabox_choose_client' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'offer_metabox_choose_client', $offer_metabox_new_choose_client );

	}

}

new Offer_Meta_Box;