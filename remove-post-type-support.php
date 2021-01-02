<?php
/* This will remove the content editor box from the custom post type called "the_post_type" 

<?php remove_post_type_support( $post_type, $supports ) ?>

$support
--------
'title'
'editor' (content)
'author'
'thumbnail' (featured image) (current theme must also support Post Thumbnails)
'excerpt'
'trackbacks'
'custom-fields'
'comments' (also will see comment count balloon on edit screen)
'revisions' (will store revisions)
'page-attributes' (template and menu order) (hierarchical must be true)
'post-formats' 

*/

add_action( 'init', function() {
    remove_post_type_support( 'the_post_type', 'editor' );
}, 99);

