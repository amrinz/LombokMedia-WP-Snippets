<?php
// get page template outside loop
$post_id = (isset($_GET['post'])) ? $_GET['post'] : $_POST['post_ID'];
$template = get_post_meta( $post_id, '_wp_page_template', true );

if($template == "tpl-home.php") {

	// do something only in this page template
}


// Ripped from Star Hotel Theme
/**
 * WP Edits
 * */

// Category: Count badge display
function cat_count_span($links) {
    $links = str_replace('</a> (', '<span class="badge pull-right">', $links);
    $links = str_replace(')', '</span></a> ', $links);
    return $links;
}
add_filter('wp_list_categories', 'cat_count_span');

// Archive: Count badge display
function archive_count_inline($links) {
    $links = str_replace('</a>&nbsp;(', '<span class="badge pull-right">', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}
add_filter('get_archives_link', 'archive_count_inline');

// Sidebar Display: Remove inline style tagcloud
function xf_tag_cloud($tag_string){
    return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}
add_filter('wp_generate_tag_cloud', 'xf_tag_cloud',10,3);

// Search: Change
function my_search_form($form) {
    $form = '<form role="search" method="get" class="searchform" action="' . home_url( '/' ) . '" >
                 <div>
                    <input type="text" value="' . get_search_query() . '" name="s" id="s" class="form-control" placeholder="Search..." />
                 </div>
             </form>';
    return $form;
}
add_filter( 'get_search_form', 'my_search_form' );

// Avatar: Add class
function change_avatar_css($class) {
    $class = str_replace("class='avatar", "class='img-circle", $class) ;
    return $class;
}
add_filter('get_avatar','change_avatar_css');

// Content: Password protected fields

function my_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    ' . __( "To view this protected post, enter the password below:", "starhotel" ) . '
    <label for="' . $label . '">' . __( "Password:", "starhotel" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="5" maxlength="20" class="form-control half" /><input type="submit" class="btn btn-default" name="Submit" value="' . esc_attr__( "Submit", "starhotel" ) . '" />
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'my_password_form' );


// Change Select in widget
function cat_output($class) {
    $class = str_replace('<select', '<select class="form-control"', $class);
    $class = str_replace('</select>', '</select>', $class);
    return $class;
}

add_filter('wp_dropdown_pages', 'cat_output');
add_filter('wp_dropdown_cats', 'cat_output');
add_filter('wp_dropdown_users', 'cat_output');
add_filter('wp_get_archives', 'cat_output');
add_filter('get_archives_link', 'cat_output');

/**
 * Comments
 */
class WPSE_127257_Walker_Comment extends Walker_Comment
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // do nothing.
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        // do nothing.
    }
    function end_el( &$output, $comment, $depth = 0, $args = array() ) {
        // do nothing, and no </li> will be created
    }
    protected function comment( $comment, $depth, $args ) {
        // create the comment output
        // use the code from your old callback here
    }
}
// Custom HTML comments structure
function sh_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'div';
        $add_below = 'div-comment';
    }
    ?>
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment">
    <?php endif; ?>
    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    <div class="avatar">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, 50 ); ?>
    </div>
    <div class="comment-text">
        <div class="author">
            <?php printf( __( '<div class="name">%s</div>', 'starhotel' ), get_comment_author_link() ); ?>
        </div>
        <div class="date">
            <?php
            /* translators: 1: date, 2: time */
            printf( __('%1$s at %2$s' , 'starhotel' ), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( '(Edit)' , 'starhotel'  ), '  ', '' );
            ?>
        </div>
        <div class="text">
            <?php comment_text(); ?>
        </div>
    </div>
    <?php if ( $comment->comment_approved == '0' ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' , 'starhotel'  ); ?></em>
        <br />
    <?php endif; ?>
    <?php if ( 'div' != $args['style'] ) : ?>
        </div>
    <?php endif; ?>
<?php
}

/**
 * Custom WP Widgets
 */

// Creating the widget
class sh_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'sh_widget',
            __('Starhotel Widget: Latest News', 'starhotel'),
            array( 'description' => __( 'Latest News', 'starhotel' ), )
        );
    }
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        $recentPosts = new WP_Query();
        $recentPosts->query('showposts=3');
        echo '<ul class="list-unstyled">'
        ?>
        <?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
            <li>
                <article>
                    <div class="news-thumb"> <a href="<?php esc_url(the_permalink()) ?>"><?php the_post_thumbnail( array(75, 75) ); ?></a> </div>
                    <div class="news-content clearfix">
                        <h4><a href="<?php esc_url(the_permalink())  ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                        <span><a href="<?php esc_url(the_permalink()) ?>"><?php the_date(); ?></a></span>
                    </div>
                </article>
            </li>
        <?php endwhile; ?>
        <?php echo '</ul>'?>
        <?php echo $args['after_widget'];
    }
// Widget Backend
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'starhotel' );
        }
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , 'starhotel' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <?php
    }

// Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here
// Register and load the widget
function sh_load_widget() {
    register_widget( 'sh_widget' );
}
add_action( 'widgets_init', 'sh_load_widget' );


/**
 * Title tag support
 */
add_action( 'after_setup_theme', 'theme_functions' );
function theme_functions() {

    add_theme_support( 'title-tag' );

}
add_filter( 'wp_title', 'custom_titles', 10, 2 );
function custom_titles( $title, $sep ) {
    //Check if custom titles are enabled from your option framework
    return $title;
}