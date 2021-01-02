// Rename Default Posts Type Menu
function lmd_change_menu_posts_label() {
	global $menu, $submenu;

	$menu[5][0] = 'Packages';
	$submenu['edit.php'][5][0] = 'Packages';
	$submenu['post-new.php'][10][0] = 'New Packages';
	$submenu['edit-tags.php?taxonomy=category'][15][0] = 'Categories';
	//$submenu['edit-tags.php?taxonomy=post_tag'][20][0] = 'Tags';
}
add_action( 'admin_menu', 'lmd_change_menu_posts_label');

// Remove Post Tags
function lmd_unregister_post_tags() {
	register_taxonomy('post_tag', array());
}
add_action('init', 'lmd_unregister_post_tags');

// Rename Post Type Labels
function lmd_change_object_posts_label() {
	global $wp_post_types;

	$labels = &$wp_post_types['post'] -> labels;
	$labels -> name = 'Packages';
	$labels -> singular_name = 'Package';
	$labels -> add_new = 'New Package';
	$labels -> add_new_item = 'New Package';
	$labels -> edit_item = 'Edit Package';
	$labels -> new_item = 'New Package';
	$labels -> view_item = 'View Package';
	$labels -> search_items = 'Search Packages';
	$labels -> not_found = 'No package found';
	$labels -> not_found_in_trash = 'No packages found in trash';
}
add_action('init', 'lmd_change_object_posts_label');

// Remove Post Type Support
function lmd_remove_post_supports() {
	remove_post_type_support('post', 'post_tag');
}
add_action('init', 'lmd_remove_post_supports');