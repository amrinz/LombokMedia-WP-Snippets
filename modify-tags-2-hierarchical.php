<?php
// Modify Post Tags
function wd_hierarchical_tags_register() {

  // Maintain the built-in rewrite functionality of WordPress tags

  global $wp_rewrite;

  $rewrite =  array(
    'hierarchical'              => false, // Maintains tag permalink structure
    'slug'                      => get_option('tag_base') ? get_option('tag_base') : 'tag',
    'with_front'                => ! get_option('tag_base') || $wp_rewrite->using_index_permalinks(),
    'ep_mask'                   => EP_TAGS,
  );

  // Redefine tag labels (or leave them the same)

  $labels = array(
    'name'                       => _x( 'Lokasis', 'Taxonomy General Name', 'lombokmedia' ),
    'singular_name'              => _x( 'Lokasi', 'Taxonomy Singular Name', 'lombokmedia' ),
    'menu_name'                  => __( 'Lokasis', 'lombokmedia' ),
    'all_items'                  => __( 'All Lokasis', 'lombokmedia' ),
    'parent_item'                => __( 'Parent Lokasi', 'lombokmedia' ),
    'parent_item_colon'          => __( 'Parent Lokasi:', 'lombokmedia' ),
    'new_item_name'              => __( 'New Lokasi Name', 'lombokmedia' ),
    'add_new_item'               => __( 'Add New Lokasi', 'lombokmedia' ),
    'edit_item'                  => __( 'Edit Lokasi', 'lombokmedia' ),
    'update_item'                => __( 'Update Lokasi', 'lombokmedia' ),
    'view_item'                  => __( 'View Lokasi', 'lombokmedia' ),
    'separate_items_with_commas' => __( 'Separate items with commas', 'lombokmedia' ),
    'add_or_remove_items'        => __( 'Add or remove tags', 'lombokmedia' ),
    'choose_from_most_used'      => __( 'Choose from the most used', 'lombokmedia' ),
    'popular_items'              => __( 'Popular Lokasis', 'lombokmedia' ),
    'search_items'               => __( 'Search Lokasis', 'lombokmedia' ),
    'not_found'                  => __( 'Not Found', 'lombokmedia' ),
  );

  // Override structure of built-in WordPress tags

  register_taxonomy( 'post_tag', 'post', array(
    'hierarchical'              => true, // Was false, now set to true
    'query_var'                 => 'tag',
    'labels'                    => $labels,
    'rewrite'                   => $rewrite,
    'public'                    => true,
    'show_ui'                   => true,
    'show_admin_column'         => true,
    '_builtin'                  => true,
  ) );

}
add_action('init', 'wd_hierarchical_tags_register');

// Move all "advanced" metaboxes above the default editor
add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});