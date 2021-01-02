function showHotelRating() {
	$stars = get_post_meta( get_the_ID(), 'lmd_hotelRating', true );
	
	if ($stars == 1) {
		return '<i class="fa fa-star"></i>';
	} elseif ($stars == 2) {
		return '<i class="fa fa-star"></i><i class="fa fa-star"></i>';
	} elseif ($stars == 3) {
		return '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
	} elseif ($stars == 4) {
		return '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
	} elseif ($stars == 5) {
		return '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
	} else {
		return '';
	}
}

function is_post_type($type) {
	global $wp_query;
	if($type == get_post_type($wp_query->post->ID)) return true;
	return false;
}


//cf7 custom field
add_action( 'wpcf7_init', 'custom_add_form_tag_clock' );
 
function custom_add_form_tag_clock() {
    wpcf7_add_form_tag( 'tipekamar', 'custom_clock_form_tag_handler' ); // "clock" is the type of the form-tag
}
 
function custom_clock_form_tag_handler( $tag ) {
    $rT = get_post_meta( get_the_ID(), 'lmd_roomType1', true ); if(! empty($rT)) { $rT1 = '<option value="'.$rT.'">'.$rT.'</option>'; }
	$rT = get_post_meta( get_the_ID(), 'lmd_roomType2', true ); if(! empty($rT)) { $rT2 = '<option value="'.$rT.'">'.$rT.'</option>'; }
	$rT = get_post_meta( get_the_ID(), 'lmd_roomType3', true ); if(! empty($rT)) { $rT3 = '<option value="'.$rT.'">'.$rT.'</option>'; }
	$rT = get_post_meta( get_the_ID(), 'lmd_roomType4', true ); if(! empty($rT)) { $rT4 = '<option value="'.$rT.'">'.$rT.'</option>'; }
	$rT = get_post_meta( get_the_ID(), 'lmd_roomType5', true ); if(! empty($rT)) { $rT5 = '<option value="'.$rT.'">'.$rT.'</option>'; }
	$rT = get_post_meta( get_the_ID(), 'lmd_roomType6', true ); if(! empty($rT)) { $rT6 = '<option value="'.$rT.'">'.$rT.'</option>'; }

	return '<select name="tipekamar" class="wpcf7-form-control wpcf7-select form-control">'.$rT1.$rT2.$rT3.$rT4.$rT5.$rT6.'</select>';
}


// Random Posts from Category
function randomCategoryPosts() { 
	$category = get_the_category(); 
	$parent = get_category($category[0]->category_parent);
	$randcat = $parent->slug;

	$currentID = get_the_ID();

	query_posts(array(
		'orderby' => 'rand', 
		'category_name' => $randcat, 
		'posts_per_page' => 4,
		'post__not_in' => array($currentID)
		)); 
	
	if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div class="col-md-3 portfolio-item randCatPost padding-right-zero mr-btn-15" id="post-<?php the_ID(); ?>">
				
				<figure><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				  
				  <?php if ( has_post_thumbnail() ) { the_post_thumbnail('post-thumb', array('class' => 'img-responsive') ); } else { echo '<img width="750" height="500" src="' .get_template_directory_uri(). '/img/no-thumbnail.jpg" alt="' .get_the_title(). 'thumbnail" class="img-responsive" />'; } ?>

				  <figcaption>
					<h3 class="h4"><?php the_title(); ?></h3>					
					<p><span class="black"><?php echo showHotelRating(); ?></p>
				  </figcaption>
				</a></figure>
				
			</div>
	
	<?php endwhile; endif; wp_reset_query(); 
}


function change_post_admin_bar_label() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#wp-admin-bar-new-post > a').text('Hotel');
        });
    </script>
    <?php
}
add_action( 'wp_after_admin_bar_render', 'change_post_admin_bar_label' );


function wpse_custom_menu_order( $menu_ord ) {
    if ( !$menu_ord ) return true;

    return array(
        'index.php', // Dashboard
        'separator1', // First separator
        'edit.php?post_type=page', // Pages
		'edit.php', // Posts
		'edit.php?post_type=news', // Pages
    );
}
add_filter( 'custom_menu_order', 'wpse_custom_menu_order', 10, 1 );
add_filter( 'menu_order', 'wpse_custom_menu_order', 10, 1 );