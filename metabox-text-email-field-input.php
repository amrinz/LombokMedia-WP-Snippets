<?php
class Team_Meta_Box {

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
			'team_meta',
			__( 'Team Member Data', 'dd_theme' ),
			array( $this, 'render_metabox' ),
			'slideshows',
			'normal',
			'default'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'team_nonce_action', 'team_nonce' );

		// Retrieve an existing value from the database.
		$team_position = get_post_meta( $post->ID, 'team_position', true );
		$team_email = get_post_meta( $post->ID, 'team_email', true );
		$team_info = get_post_meta( $post->ID, 'team_info', true );
		$team_phone = get_post_meta( $post->ID, 'team_phone', true );

		// Set default values.
		if( empty( $team_position ) ) $team_position = '';
		if( empty( $team_email ) ) $team_email = '';
		if( empty( $team_info ) ) $team_info = '';
		if( empty( $team_phone ) ) $team_phone = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="team_position" class="team_position_label">' . __( 'Position', 'dd_theme' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="team_position" name="team_position" class="team_position_field" placeholder="' . esc_attr__( 'Enter Position', 'dd_theme' ) . '" value="' . esc_attr( $team_position ) . '">';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="team_email" class="team_email_label">' . __( 'E-Mail Address', 'dd_theme' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="email" id="team_email" name="team_email" class="team_email_field" placeholder="' . esc_attr__( 'E-Mail', 'dd_theme' ) . '" value="' . esc_attr( $team_email ) . '">';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="team_info" class="team_info_label">' . __( 'Extra Info', 'dd_theme' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="team_info" name="team_info" class="team_info_field" placeholder="' . esc_attr__( '', 'dd_theme' ) . '" value="' . esc_attr( $team_info ) . '">';
		echo '			<p class="description">' . __( 'Enter anything else you want to appear', 'dd_theme' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="team_phone" class="team_phone_label">' . __( 'Phone Number', 'dd_theme' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="team_phone" name="team_phone" class="team_phone_field" placeholder="' . esc_attr__( '', 'dd_theme' ) . '" value="' . esc_attr( $team_phone ) . '">';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['team_nonce'] ) ? $_POST['team_nonce'] : '';
		$nonce_action = 'team_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Sanitize user input.
		$team_new_position = isset( $_POST[ 'team_position' ] ) ? sanitize_text_field( $_POST[ 'team_position' ] ) : '';
		$team_new_email = isset( $_POST[ 'team_email' ] ) ? sanitize_email( $_POST[ 'team_email' ] ) : '';
		$team_new_info = isset( $_POST[ 'team_info' ] ) ? sanitize_text_field( $_POST[ 'team_info' ] ) : '';
		$team_new_phone = isset( $_POST[ 'team_phone' ] ) ? sanitize_text_field( $_POST[ 'team_phone' ] ) : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'team_position', $team_new_position );
		update_post_meta( $post_id, 'team_email', $team_new_email );
		update_post_meta( $post_id, 'team_info', $team_new_info );
		update_post_meta( $post_id, 'team_phone', $team_new_phone );

	}

}

new Team_Meta_Box;