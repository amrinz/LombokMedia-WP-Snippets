// myWidget Test  
class myWidgetTest extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = 'myWidgetTest', array( 'description' => 'View recent posts from post (default) or custom post type with thumbnail image' ) );
	}
	
	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) { 
		$title = trim(strip_tags($instance['title']));
		?>

		 <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

<?php
	}
	
/*
 * Renders the widget in the sidebar
 */
	function widget( $args, $instance ) {
	extract($args, EXTR_SKIP);

	$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

	echo $args['before_widget'];
	if (!empty($title)) echo $before_title . $title . $after_title;;
    query_posts("posts_per_page=5"); ?>

<?php if (have_posts()) : ?>
	<ul class="recentPostsType">
		<?php while (have_posts()) : the_post(); ?>
			<li>
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail', array('class' => 'img-responsive') ); } ?>
				<div class="postType-text">
					<h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
					<p class="postType-textmeta"><?php echo showHotelRating(); ?> &nbsp;&nbsp; <i class="fa fa-map-marker"></i> <?php the_category(', '); ?></p>
					<p><?php $words = get_the_excerpt(); echo lmd_limit_words($words, 15); ?></p>
				</div>
				<br class="clear" />
			</li>			
		<?php endwhile; ?>
	</ul>
	
<?php
	endif; 
	wp_reset_query();
	echo $args['after_widget'];
} };

// Initialize the widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "myWidgetTest" );' ) );