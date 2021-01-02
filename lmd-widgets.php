<?php
/*
Plugin Name: Category Posts
Plugin URI: http://lombokmedia.web.id/plugin/category-post
Description: View posts from selected category with thumbnail images
Author: Amrin Zulkarnain
Version: 0.1
Author URI: http://amrinz.wordpress.com
*/
  
class CategoryLoop extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = 'Category Posts', array( 'description' => 'Displays posts from category with excerpt and thumbnail' ) );
	}
	
	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) { 
		$title = trim(strip_tags($instance['title']));
		$category = (int) $instance['category'];
		$num_posts = (int) $instance['num_posts'];
		$excerpt = esc_attr( $instance['excerpt'] );
		$thumbsize = (Int)$instance['thumbsize']; 
		?>

		 <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>">Category Name:</label>
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
          <?php
            $categories = get_categories('');
            foreach ($categories as $cat) {
              if ($cat->cat_ID == $instance['category']) {
                $option = '<option selected="selected" value="'.$cat->cat_ID.'">';
              } else {
                $option = '<option value="'.$cat->cat_ID.'">';
              }
              $option .= $cat->cat_name.'</option>';
              echo $option;
            }
          ?>
        </select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_posts' ); ?>">Number of Posts:</label>
			<input id="<?php echo $this->get_field_id( 'num_posts' ); ?>" name="<?php echo $this->get_field_name( 'num_posts' ); ?>" type="text" value="<?php echo $num_posts; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>">Excerpt Length (chars):</label>
			<input id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" type="text" value="<?php echo $excerpt; ?>" />
		</p>

<?php
	}
	
/*
 * Renders the widget in the sidebar
 */
	function widget( $args, $instance ) {
	extract($args, EXTR_SKIP);

	$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $category = empty($instance['category']) ? 1 : $instance['category'];
    $num_posts = empty($instance['num_posts']) ? 5 : $instance['num_posts'];
    $excerpt = empty($instance['excerpt']) ? 10 : $instance['excerpt'];

	$cat_link = get_category_link( $category );

	echo $args['before_widget'];
	if (!empty($title)) echo $before_title . $title . '<a class="pull-right" href="' . $cat_link .'" title="View more ..."><i class="icon-list"></i></a>' . $after_title;;
    query_posts("posts_per_page=$num_posts&cat=$category"); ?>

<?php if (have_posts()) : ?>
	<ul class="catloop catloop-<?php echo $category ?>">
		<?php while (have_posts()) : the_post(); ?>
			<li class="sidepost">
				<h3 class="sidepost-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>				
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail', array('class' => 'img-responsive sidepost-thumb') ); } ?>
				<div class="sidepost-text">
					<p><?php $words = get_the_excerpt(); $cut = $excerpt; echo lmd_limit_words($words,$cut); ?></p>
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
add_action( 'widgets_init', create_function( '', 'return register_widget( "CategoryLoop" );' ) );