<?php
/* MetaBox for Custom Field to Add External Featured Image URL */
add_action('admin_menu', 'custom_fimg_hooks');
add_action('save_post', 'save_custom_fimg');

function custom_fimg_hooks() {
	add_meta_box('custom_fimg', 'External Featured Image URL', 'custom_fimg_input', 'post', 'normal', 'high');
}

function custom_fimg_input() {
	global $post;
	echo '<input type="hidden" name="custom_fimg_noncename" id="custom_fimg_noncename" value="'.wp_create_nonce('custom-fimg').'" />';
	echo '<textarea name="custom_fimg" id="custom_fimg" rows="5" cols="30" style="width:100%;">'.get_post_meta($post->ID,'_custom_fimg',true).'</textarea>';
}

function save_custom_fimg($post_id) {
	if (!wp_verify_nonce($_POST['custom_fimg_noncename'], 'custom-fimg')) return $post_id;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	$custom_fimg = $_POST['custom_fimg'];
	update_post_meta($post_id, '_custom_fimg', $custom_fimg);
}
/* END of MetaBox for Custom Field to Add External Featured Image URL */