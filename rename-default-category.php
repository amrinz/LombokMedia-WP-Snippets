Re-label the default category

Note: to apply these changes to the tag taxonomy, change:
$labels = &$wp_taxonomies['category']->labels;
to…
$labels = &$wp_taxonomies['post_tag']->labels;
-------------------------------

// Change the admin menu
function revcon_change_cat_label() {
    global $submenu;
    $submenu['edit.php'][15][0] = 'Authors'; // Rename categories to Authors
}
add_action( 'admin_menu', 'revcon_change_cat_label' );


// Re-label the default category
function revcon_change_cat_object() {
    global $wp_taxonomies;
    $labels = &$wp_taxonomies['category']->labels;
    $labels->name = 'Author';
    $labels->singular_name = 'Author';
    $labels->add_new = 'Add Author';
    $labels->add_new_item = 'Add Author';
    $labels->edit_item = 'Edit Author';
    $labels->new_item = 'Author';
    $labels->view_item = 'View Author';
    $labels->search_items = 'Search Authors';
    $labels->not_found = 'No Authors found';
    $labels->not_found_in_trash = 'No Authors found in Trash';
    $labels->all_items = 'All Authors';
    $labels->menu_name = 'Author';
    $labels->name_admin_bar = 'Author';
}
add_action( 'init', 'revcon_change_cat_object' );