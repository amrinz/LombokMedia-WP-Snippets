<?php
/**
 * Plugin Name: Starhotel plug-ins
 * Plugin URI: http://themeforest.net/user/Slashdown
 * Description: Important plug-in in order to make the Starhotel work
 * Version: 2.0.4
 * Author: Slashdown
 * Author URI: Author's website
 * License: GNU General Public License, version 2
 */
?>
<?php
/**
 * imagegallery
 **/
 // Custom Post Type
add_action('init', 'imagegallery', 0);
function imagegallery()
{
    $labels = array(
        'name' => _x('imagegallery', 'Post Type General Name', 'starhotel'),
        'singular_name' => _x('imagegallery', 'Post Type Singular Name', 'starhotel'),
        'menu_name' => __('Gallery', 'starhotel'),
        'parent_item_colon' => __('Parent gallery:', 'starhotel'),
        'all_items' => __('All Galleries', 'starhotel'),
        'view_item' => __('View gallery', 'starhotel'),
        'add_new_item' => __('Add New gallery', 'starhotel'),
        'add_new' => __('Add New', 'starhotel'),
        'edit_item' => __('Edit gallery', 'starhotel'),
        'update_item' => __('Update gallery', 'starhotel'),
        'search_items' => __('Search gallery', 'starhotel'),
        'not_found' => __('Not found', 'starhotel'),
        'not_found_in_trash' => __('Not found in Trash', 'starhotel'),
    );
    $args = array(
        'label' => __('Gallery', 'starhotel'),
        'description' => __('Gallery description', 'starhotel'),
        'labels' => $labels,
        'supports' => array(),
        'hierarchical' => false,
        'has_archive' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-format-gallery',
        'rewrite' => 'true',
    );
    register_post_type('imagegallery', $args);
}

//Registering meta boxes
add_filter('rwmb_meta_boxes', 'mbg_register_meta_boxes');
function mbg_register_meta_boxes($meta_boxes)
{
    $prefix = 'rmwb_';
    $meta_boxes[] = array(
        'id' => 'imagegallery',
        'title' => __('imagegallery', 'meta-box'),
        'pages' => array(
            'imagegallery'
        ),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            // Hotel Image imagegallery (WP 3.3+)
            array(
                'id' => "{$prefix}thickbox",
                'type' => 'image_advanced',
            ),
        ),
    );
    return $meta_boxes;
}

// Custom Taxonomy(apply to attachment)
add_action('init', 'sh_add_tags_taxonomy');
function sh_add_tags_taxonomy()
{
    $labels = array(
        'name' => 'imagegallery Tag',
        'singular_name' => 'imagegallery Tag',
        'search_items' => 'Search imagegallery Tags',
        'all_items' => 'All imagegallery Tags',
        'parent_item' => 'Parent Tag',
        'parent_item_colon' => 'Parent Tag:',
        'edit_item' => 'Edit Tag',
        'update_item' => 'Update Tag',
        'add_new_item' => 'Add New Tag',
        'new_item_name' => 'New Tag Name',
        'menu_name' => 'imagegallery',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'query_var' => 'true',
        'rewrite' => 'true',
        'show_admin_column' => 'true',
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
    );
    register_taxonomy('tags', 'attachment', $args);
    register_taxonomy('tags', array(
        'attachment',
        'imagegallery'
    ));
}

// Apply custom tags to attachments
add_action('init', 'sh_add_tags_to_attachments', 0);
function sh_add_tags_to_attachments()
{
    register_taxonomy_for_object_type('tags', 'attachment');
}

// Remove tags from library to overcome usability issues
add_action('admin_init', 'remove_media_categories_menu_item');
function remove_media_categories_menu_item()
{
    global $submenu;
    unset($submenu['upload.php'][17]);
}

/**
 * Rooms
 **/

// Custom Post Type: Roomtype
if (!function_exists('room')) {
    add_action('init', 'room', 0);
    function room()
    {
        $labels = array(
            'name' => _x('Rooms', 'Post Type General Name', 'starhotel'),
            'singular_name' => _x('Room', 'Post Type Singular Name', 'starhotel'),
            'menu_name' => __('Rooms', 'starhotel'),
            'parent_item_colon' => __('Parent Room:', 'starhotel'),
            'all_items' => __('All Rooms', 'starhotel'),
            'view_item' => __('View Room', 'starhotel'),
            'add_new_item' => __('Add New Room', 'starhotel'),
            'add_new' => __('New Room', 'starhotel'),
            'edit_item' => __('Edit Room', 'starhotel'),
            'update_item' => __('Update Room', 'starhotel'),
            'search_items' => __('Search rooms', 'starhotel'),
            'not_found' => __('No rooms found', 'starhotel'),
            'not_found_in_trash' => __('No rooms found in Trash', 'starhotel'),
        );
        $rewrite = array(
            'slug' => _x( 'room', 'URL slug', 'starhotel' ),
            'with_front'          => true,
            'pages'               => true,
            'feeds'               => true,
        );
        $args = array(
            'label' => __('room', 'starhotel'),
            'description' => __('Accommodation room pages', 'starhotel'),
            'labels' => $labels,
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
            ),
            'taxonomies' => array(
                'room type'
            ),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'rewrite' => $rewrite,
            'menu_icon' => 'dashicons-star-filled',
        );
        register_post_type('room', $args);
    }
}
// Register meta boxes
add_filter('rwmb_meta_boxes', 'mbr_register_meta_boxes');
function mbr_register_meta_boxes($meta_boxes)
{
    $prefix = 'mbr_';
    $meta_boxes[] = array(
        'id' => 'room',
        'title' => __('The preview block', 'meta-box'),
        'pages' => array(
            'room'
        ),
        'context' => 'side',
        'priority' => 'low',
        'autosave' => true,
        'fields' => array(
            // Price
            array(
                'name' => __('Price a night', 'meta-box'),
                'id' => "{$prefix}price1",
                'type' => 'text',
                'clone' => false,
                'size' => 12
            ),
            // TEXT
            array(
                'name' => __('Room subheading', 'meta-box'),
                'id' => "{$prefix}title1",
                'type' => 'text',
                'clone' => false,
            ),
            // TEXTAREA
            array(
                'name' => __('Room excerpt', 'meta-box'),
                'id' => "{$prefix}excerpt",
                'type' => 'textarea',
                'cols' => 20,
                'rows' => 3,
            ),
            // TEXT
            array(
                'name' => __('1st USP', 'meta-box'),
                'id' => "{$prefix}text1",
                'type' => 'text',
                'clone' => false,
            ),
            // TEXT
            array(
                'name' => __('2nd USP', 'meta-box'),
                'id' => "{$prefix}text2",
                'type' => 'text',
                'clone' => false,
            ),
            // TEXT
            array(
                'name' => __('3rd USP', 'meta-box'),
                'id' => "{$prefix}text3",
                'type' => 'text',
                'clone' => false,
            ),
            // TEXT
            array(
                'name' => __('4th USP', 'meta-box'),
                'id' => "{$prefix}text4",
                'type' => 'text',
                'clone' => false,
            ),
            // TEXT
            array(
                'name' => __('5th USP', 'meta-box'),
                'id' => "{$prefix}text5",
                'type' => 'text',
                'clone' => false,
            ),
            // TEXT
            array(
                'name' => __('6th USP', 'meta-box'),
                'id' => "{$prefix}text6",
                'type' => 'text',
                'clone' => false,
            ),
        ),
    );
    // Image imagegallery
    $meta_boxes[] = array(
        'id' => 'room2',
        'title' => __('Room image imagegallery - min width: 750px', 'meta-box'),
        'pages' => array(
            'room'
        ),
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => "{$prefix}thickbox",
                'type' => 'image_advanced',
            ),
        ),
    );
    return $meta_boxes;
}


// Roomtype
add_action('do_meta_boxes', 'replace_featured_image_box');
function replace_featured_image_box()
{
    remove_meta_box('postimagediv', 'room', 'side');
    add_meta_box('postimagediv', __('Preview image - w:356px h:228px', 'starhotel'), 'post_thumbnail_meta_box', 'room', 'side', 'low');
}

// Register Custom Taxonomy
if (!function_exists('custom_roomtypes')) {
    add_action('init', 'custom_roomtypes', 0);
    function custom_roomtypes()
    {
        $labels = array(
            'name' => _x('Roomtype', 'Taxonomy General Name', 'starhotel'),
            'singular_name' => _x('Roomtype', 'Taxonomy Singular Name', 'starhotel'),
            'menu_name' => __('Roomtype', 'starhotel'),
            'all_items' => __('All roomtypes', 'starhotel'),
            'parent_item' => __('Parent Roomtype', 'starhotel'),
            'parent_item_colon' => __('Parent Roomtype:', 'starhotel'),
            'new_item_name' => __('New Roomtype Name', 'starhotel'),
            'add_new_item' => __('Add New Roomtype', 'starhotel'),
            'edit_item' => __('Edit Roomtype', 'starhotel'),
            'update_item' => __('Update Roomtype', 'starhotel'),
            'separate_items_with_commas' => __('Separate items with commas', 'starhotel'),
            'search_items' => __('Search Roomtypes', 'starhotel'),
            'add_or_remove_items' => __('Add or remove roomtypes', 'starhotel'),
            'choose_from_most_used' => __('Choose from the most used roomtypes', 'starhotel'),
            'not_found' => __('Not Found', 'starhotel'),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );
        register_taxonomy('roomtype', array(
            'room'
        ), $args);
    }
}

/**
 * Shortcodes
 **/

// Shortcode: Button
function sh_button($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'link' => '#',
        'size' => 'btn-lg',
        'style' => 'btn-default'
    ), $atts);
    // Code
    $link = vc_build_link($atts['link']);
    $a_href = $link['url'];
    return '<a class="btn ' . esc_attr($atts['size']) . ' ' . esc_attr($atts['style']) . '" href="' . esc_url($a_href) . '">' . $content . '</a>';
}

add_shortcode('button', 'sh_button');

// Shortcode: Alert
function sh_alert($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'style' => 'alert-success'
    ), $atts);
    // Code
    return '<div class="alert ' . esc_attr($atts['style']) . ' alert-dismissable">
       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       ' . $content . '
       </div>';
}

add_shortcode('alert', 'sh_alert');

// Shortcode: call-to-action
function sh_cta($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'style' => 'alert-success'
    ), $atts);
    // Code
    return '
  <div id="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <h2>' . do_shortcode($content) . '</h2>
        </div>
      </div>
    </div>
  </div>
  ';
}

add_shortcode('calltoaction', 'sh_cta');

// Shortcode: Lightbox
function sh_lightbox($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'image' => 'image',
        'title' => '',
        'description' => ''

    ), $atts);
    $img = wp_get_attachment_image_src($atts["image"], "full");
    $imgSrc = $img[0];

    // Code
    return '

<div class="mfp_open"><a href="' . esc_url($imgSrc) . '" title="' . esc_html($atts['description']) . '"><img src="' . esc_url($imgSrc) . '" alt="' . esc_html($atts['title']) . '" class="img-thumbnail img-responsive"></a></div>
  ';
}

add_shortcode('lightbox', 'sh_lightbox');



// Shortcode: Carousel
function sh_carousel($atts, $content = null)
{
    // Attributes
    extract(shortcode_atts(array(
        'image' => 'image'
    ), $atts));


ob_start();

$img_ids = $atts["image"];
$img_array = array_map('intval', explode(',', $img_ids));

?>
<div class="carousel">
    <div id="owl-gallery" class="owl-carousel">
    <?php
    foreach ($img_array as $img_array_each => $value) {
    $image_attributes = wp_get_attachment_image_src( $attachment_id = $value, "full" );
     ?>   <div class="item mfp_open"><a href="<?php echo $image_attributes[0];?>"><img src="<?php echo $image_attributes[0];?>"/><i class="fa fa-search"></i></a></div> <?php
    }
    ?>
    </div>
</div>
<?php
return ob_get_clean();
};
add_shortcode('carousel', 'sh_carousel');

// Shortcode: Parallax
function sh_parallax($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'image' => 'image',
        'title' => 'title',
        'subtitle' => 'subtitle',
        'link' => '#',
        'btntext' => 'Button Text',
        'size' => 'btn-lg',
        'style' => 'btn-default'
    ), $atts);
    $img = wp_get_attachment_image_src($atts["image"], "full");
    $imgSrc = $img[0];
    $link = vc_build_link($atts['link']);
    $a_href = $link['url'];
    // Code
    return '
<script type="text/javascript">jQuery(document).ready(function(){jQuery("#parallax-image").parallax("50%", -0.25);});</script>
<div class="parallax-effect">
  <div id="parallax-image" style="background-image: url(' . esc_attr($imgSrc) . ');">
    <div class="color-overlay fadeIn appear" data-start="600">
      <div class="container">
        <div class="content">
          <h3 class="text-center">' . esc_html($atts['title']) . '</h3>
          <p class="text-center">' . esc_html($atts['subtitle']) . '
          <br>
          <a class="btn mt30 ' . esc_attr($atts['size']) . ' ' . esc_attr($atts['style']) . '" href="' . esc_url($a_href) . '">' . esc_html($atts['btntext']) . '</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
  ';
}

add_shortcode('parallax', 'sh_parallax');

// Shortcode: Lined heading
function sh_lined_heading($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'size' => 'h1'
    ), $atts);
    // Code
    return '
        <' . esc_attr($atts['size']) . ' class="lined-heading mt50">
            <span>
            ' . do_shortcode($content) . '
            </span>
        </' . esc_attr($atts['size']) . '>
        ';
}

add_shortcode('lined_heading', 'sh_lined_heading');

// Shortcode: Lined heading
function sh_heading($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'size' => 'h1'
    ), $atts);
    // Code
    return '
        <' . esc_attr($atts['size']) . ' class="mt100">
            ' . do_shortcode($content) . '
        </' . esc_attr($atts['size']) . '>
        ';
}

add_shortcode('heading', 'sh_heading');

// Shortcode: Table
function sh_table($atts, $content = null)
{
    return '
      <table class="table table-striped mt30">
        <tbody>
            ' . do_shortcode($content) . '
        </tbody>
        </table>
  ';
}

function sh_tr($atts, $content = null)
{
    return '
        <tr>
        ' . do_shortcode($content) . '
        </tr>
  ';
}

function sh_td($atts, $content = null)
{
    return '
        <td>
        ' . do_shortcode($content) . '
        </td>
  ';
}

add_shortcode('table', 'sh_table');
add_shortcode('tr', 'sh_tr');
add_shortcode('td', 'sh_td');

// Shortcode: Owl Slider
function sh_owl_testimonials($atts, $content = null)
{
    // Attributes
    extract(shortcode_atts(
            array(
        'testimonial_1_image' => '',
        'testimonial_1_testimonial' => 'The testimonial',
        'testimonial_1_source' => 'John Doe in CEO Travel',
        'testimonial_1_source_url' => '',
        'testimonial_2_image' => '',
        'testimonial_2_testimonial' => 'The testimonial',
        'testimonial_2_source' => 'John Doe in CEO Travel',
        'testimonial_2_source_url' => '',
        'testimonial_3_image' => '',
        'testimonial_3_testimonial' => 'The testimonial',
        'testimonial_3_source' => 'John Doe in CEO Travel',
        'testimonial_3_source_url' => '',
        'testimonial_4_image' => '',
        'testimonial_4_testimonial' => 'The testimonial',
        'testimonial_4_source' => 'John Doe in CEO Travel',
        'testimonial_4_source_url' => '',
    ), $atts));
    ob_start();

    $img1 = wp_get_attachment_image_src($testimonial_1_image, "full");
    $imgSrc1 = $img1[0];
    $img2 = wp_get_attachment_image_src($testimonial_2_image, "full");
    $imgSrc2 = $img2[0];
    $img3 = wp_get_attachment_image_src($testimonial_3_image, "full");
    $imgSrc3 = $img3[0];
    $img4 = wp_get_attachment_image_src($testimonial_4_image, "full");
    $imgSrc4 = $img4[0];

?>


    <div class="testimonials">
        <div id="owl-reviews" class="owl-carousel">
          <div class="item">
            <div class="row">
              <?php if (!empty($imgSrc1)) { ?><div class="col-lg-3 col-md-4 col-sm-2 col-xs-12"> <img src="<?php echo esc_url($imgSrc1) ?>" alt="Review 1" class="img-circle" /></div><?php ;} ?>
              <?php if (!empty($imgSrc1)) { ?><div class="col-lg-9 col-md-8 col-sm-10 col-xs-12"><?php ;} else { ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php ;} ?>
                <div class="text-balloon"><?php echo esc_html($testimonial_1_testimonial) ?><span><?php if (!empty($testimonial_1_source_url)) { ?><a href="<?php echo esc_url($testimonial_1_source_url) ?>"><?php ;} ?><?php echo esc_html($testimonial_1_source) ?><?php if (!empty($testimonial_1_source_url)) { ?></a><?php ;} ?></span> </div>
              </div>
            </div>
            <div class="row">
              <?php if (!empty($imgSrc2)) { ?><div class="col-lg-3 col-md-4 col-sm-2 col-xs-12"> <img src="<?php echo esc_url($imgSrc2) ?>" alt="Review 2" class="img-circle" /></div><?php ;} ?>
              <?php if (!empty($imgSrc2)) { ?><div class="col-lg-9 col-md-8 col-sm-10 col-xs-12"><?php ;} else { ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php ;} ?>
                <div class="text-balloon"><?php echo esc_html($testimonial_2_testimonial) ?><span><?php if (!empty($testimonial_2_source_url)) { ?><a href="<?php echo esc_url($testimonial_2_source_url) ?>"><?php ;} ?><?php echo esc_html($testimonial_2_source) ?><?php if (!empty($testimonial_2_source_url)) { ?></a><?php ;} ?></span> </div>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="row">
              <?php if (!empty($imgSrc3)) { ?><div class="col-lg-3 col-md-4 col-sm-2 col-xs-12"> <img src="<?php echo esc_url($imgSrc3) ?>" alt="Review 3" class="img-circle" /></div><?php ;} ?>
              <?php if (!empty($imgSrc3)) { ?><div class="col-lg-9 col-md-8 col-sm-10 col-xs-12"><?php ;} else { ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php ;} ?>
                <div class="text-balloon"><?php echo esc_html($testimonial_3_testimonial) ?><span><?php if (!empty($testimonial_3_source_url)) { ?><a href="<?php echo esc_url($testimonial_3_source_url) ?>"><?php ;} ?><?php echo esc_html($testimonial_3_source) ?><?php if (!empty($testimonial_3_source_url)) { ?></a><?php ;} ?></span> </div>
              </div>
            </div>
            <div class="row">
              <?php if (!empty($imgSrc4)) { ?><div class="col-lg-3 col-md-4 col-sm-2 col-xs-12"> <img src="<?php echo esc_url($imgSrc4) ?>" alt="Review 4" class="img-circle" /></div><?php ;} ?>
              <?php if (!empty($imgSrc4)) { ?><div class="col-lg-9 col-md-8 col-sm-10 col-xs-12"><?php ;} else { ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><?php ;} ?>
                <div class="text-balloon"><?php echo esc_html($testimonial_4_testimonial) ?><span><?php if (!empty($testimonial_4_source_url)) { ?><a href="<?php echo esc_url($testimonial_4_source_url) ?>"><?php ;} ?><?php echo esc_html($testimonial_4_source) ?><?php if (!empty($testimonial_4_source_url)) { ?></a><?php ;} ?></span> </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    <?php
    return ob_get_clean();
};


add_shortcode('testimonials', 'sh_owl_testimonials');

// Shortcode: Blockquote
function sh_quote($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'source' => 'John Doe in CEO Travel',

    ), $atts);
    // Code
    return '
<blockquote>
    <p><em>"' . do_shortcode($content) . ' "</em></p>
    <span>' . esc_html($atts['source']) . '</span>
</blockquote>';
}

add_shortcode('quote', 'sh_quote');

// Shortcode: Box icons
function sh_boxicon($atts, $content = null)
{
    $icon = $color = $size = $align = $el_class = $custom_color = $link = $background_style = $background_color =
    $type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons = '';
    // Attributes
    $defaults = shortcode_atts(array(
        'type' => 'fontawesome',
        'icon_fontawesome' => 'fa fa-adjust',
        'icon_openiconic' => '',
        'icon_typicons' => '',
        'icon_entypoicons' => '',
        'icon_linecons' => '',
        'icon_entypo' => '',
        'link' => '#'
    ), $atts);
    $atts = vc_shortcode_attribute_parse($defaults, $atts);
    extract($atts);

// Enqueue needed icon font.
    vc_icon_element_fonts_enqueue($type);

    $url = vc_build_link($link);
    $has_style = false;
    if (strlen($background_style) > 0) {
        $has_style = true;
        if (strpos($background_style, 'outline') !== false) {
            $background_style .= ' vc_icon_element-outline'; // if we use outline style it is border in css
        } else {
            $background_style .= ' vc_icon_element-background';
        }
    }
    // Code
    return '
    <div class="box-icon">
          <div class="circle"><i class="fa ' . esc_attr(${"icon_" . $type}) . ' fa-lg"></i></div>
    </div>
    ';
}

add_shortcode('boxicon', 'sh_boxicon');

// Shortcode: USP
function sh_usp($atts, $content = null)
{
$icon = $color = $size = $align = $el_class = $custom_color = $link = $background_style = $background_color =
$type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons = '';
    // Attributes
    $defaults = shortcode_atts(array(
        'type' => 'fontawesome',
        'icon_fontawesome' => 'fa fa-adjust',
        'icon_openiconic' => '',
        'icon_typicons' => '',
        'icon_entypoicons' => '',
        'icon_linecons' => '',
        'icon_entypo' => '',
        'link' => '#',
        'heading' => '',
        'text' => '',
    ), $atts);
    $atts = vc_shortcode_attribute_parse($defaults, $atts);
    extract($atts);

// Enqueue needed icon font.
    vc_icon_element_fonts_enqueue($type);

    $url = vc_build_link($link);
    $has_style = false;
    if (strlen($background_style) > 0) {
        $has_style = true;
        if (strpos($background_style, 'outline') !== false) {
            $background_style .= ' vc_icon_element-outline'; // if we use outline style it is border in css
        } else {
            $background_style .= ' vc_icon_element-background';
        }
    }
    // Code
    return '
    <div class="usp">
        <div class="box-icon">
                <div class="circle"><i class="fa ' . esc_attr(${"icon_" . $type}) . ' fa-lg"></i></div>
                <h3>' . esc_html($atts['heading']) . '</h3>
                <p>'  . do_shortcode($content) . '</p>
        </div>
    </div>
    ';
}

add_shortcode('usp', 'sh_usp');

// Shortcode: Address Card
function sh_address($atts, $content = null)
{
    // Attributes
    $atts = shortcode_atts(array(
        'panel_title' => ''
    ), $atts);
    // Code
    return '
        <!-- Panel -->
        <div class="panel panel-default text-center">
          <div class="panel-heading">
            <div class="panel-title"><strong>' . esc_html($atts['panel_title']) . '</strong></div>
          </div>
          <div class="panel-body">
            <address>'  . do_shortcode($content) . '</address>
          </div>
        </div>
        ';
}

add_shortcode('address', 'sh_address');

// Shortcode: Google Maps
function sh_gmap($atts)
{
    global $sh_redux;
    $google_maps_key = esc_attr($sh_redux['gmaps-api-key']);
    $google_maps_url = 'https://maps.google.com/maps/api/js?key='.$google_maps_key;

    wp_enqueue_script('gmap_js', get_template_directory_uri() . '/js/jquery.gmap.min.js', array('jquery'));
    wp_register_script('gmapsens_js', $google_maps_url, array('jquery'));
    wp_enqueue_script('gmapsens_js');
    // Code
    return '
    <div id="map">
    </div>';
}

add_shortcode('map', 'sh_gmap');

// Shortcode: Rooms
function sh_rooms($atts, $content = null)
{
    extract(shortcode_atts(
            array(
        'room_order' => 'rand',
        'room_amount' => '1',
            )
            , $atts)
    );
    ob_start();
    ?>

    <!-- Rooms -->
    <div class="rooms <?php if ( is_page_template( 'page-right-sidebar.php' ) ) {echo 'mt50';} else {echo 'mt110';};?>">
        <div class="row room-list">
            <?php
            $currentID = get_the_ID();
            // Load all rooms
            $args = array(
                'post_type' => 'room',
                'orderby' => $room_order,
                'order' => 'asc',
                'posts_per_page' => $room_amount,
                'post__not_in' => array($currentID)
            );
            global $wp_query;
            $post = $wp_query->post;

            $rooms = new WP_Query($args);
            if ($rooms->have_posts()) {
                while ($rooms->have_posts()) {
                    $rooms->the_post();
                    ?>

                    <!-- Room -->
                    <?php
                    $terms = wp_get_object_terms($post->ID, 'roomtype');
                    if ($terms && !is_wp_error($terms)) :
                        ?>
                        <?php foreach ($terms as $term) {
                        $termstriped = str_replace(" ", "-", $term->name);
                        $term_names[] = $termstriped;
                        $res = implode(' ', $term_names);
                    }
                     ?>
                    <?php endif;

                    ?>
                    <div class="col-sm-4 <?php if ( is_page_template( 'page-right-sidebar.php' ) or ( $maxrooms == 2 )) {echo 'col-md-6';}; ?><?php if ( $maxrooms == 1 ) {echo 'col-md-12';} else {}; ?>">
                        <?php  // Reset term array
                        unset($term_names);?>
                        <div class="room-thumb">
                            <?php
                            if (has_post_thumbnail())
                                the_post_thumbnail('full', array('class' => 'img-responsive'));
                            else
                                echo '<img src="' . esc_url(get_stylesheet_directory_uri()) . '/images/rooms/356x228.gif" alt="title" title="title" />';
                            ?>
                            <div class="mask">
                                <div class="main">
                                    <h5><?php the_title(); ?></h5>
                                    <?php
                                    $price1 = rwmb_meta('mbr_price1', 'type=text');
                                    if (!empty($price1)) {
                                        echo "<div class='price'> " . esc_html($price1) . "<span>" . esc_html__('a night', 'starhotel') . "</span></div>";
                                    }
                                    ?>
                                </div>
                                <div class="content">
                                    <?php
                                    $room_title = rwmb_meta('mbr_title1', 'type=text');
                                    $excerpt = rwmb_meta('mbr_excerpt', 'type=textarea');
                                    ?>
                                    <p><?php
                                        if (!empty($room_title)) {
                                            echo "<span>" . esc_html($room_title) . "</span>";
                                        }
                                        ?><?php echo esc_html($excerpt) ?></p>

                                    <div class="row">
                                        <div class="col-xs-6">
                                            <ul class="list-unstyled">
                                                <?php
                                                $usp1 = rwmb_meta('mbr_text1', 'type=text');
                                                $usp2 = rwmb_meta('mbr_text2', 'type=text');
                                                $usp3 = rwmb_meta('mbr_text3', 'type=text');
                                                if (!empty($usp1)) {
                                                    echo "<li><i class='fa fa-check-circle'></i> " . esc_html($usp1) . "</li>";
                                                }
                                                if (!empty($usp2)) {
                                                    echo "<li><i class='fa fa-check-circle'></i> " . esc_html($usp2) . "</li>";
                                                }
                                                if (!empty($usp3)) {
                                                    echo "<li><i class='fa fa-check-circle'></i> " . esc_html($usp3) . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="col-xs-6">
                                            <ul class="list-unstyled">
                                                <?php
                                                $usp4 = rwmb_meta('mbr_text4', 'type=text');
                                                $usp5 = rwmb_meta('mbr_text5', 'type=text');
                                                $usp6 = rwmb_meta('mbr_text6', 'type=text');
                                                if (!empty($usp4)) {
                                                    echo "<li><i class='fa fa-check-circle'></i> " . esc_html($usp4) . "</li>";
                                                }
                                                if (!empty($usp5)) {
                                                    echo "<li><i class='fa fa-check-circle'></i> " . esc_html($usp5) . "</li>";
                                                }
                                                if (!empty($usp6)) {
                                                    echo "<li><i class='fa fa-check-circle'></i> " . esc_html($usp6) . "</li>";
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-block"> <?php echo esc_html__('Book now', 'starhotel') ?> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            <?php
            } else {
                echo esc_html('<div class="pull-left">Please create your rooms in the WP-admin section</div>');
            }
            ?>
                        <?php wp_reset_query(); ?>

        </div>
    </div>
    <?php
    return ob_get_clean();
};

add_shortcode('rooms', 'sh_rooms');

// Shortcode: Reservationform horizontal
function sh_reservationform($atts)
{
    // Code
    extract(shortcode_atts(
            array(
                'orientation' => 'horizontal',
            )
            , $atts)
    );
    ob_start();
    if (strpos($orientation, 'horizontal') !== false) {
        ?>
        <!-- Reservation form -->
        <div id="reservation-form">
            <div class="row mt50">
                <div class="col-md-12">
                  <form class="form-inline reservation-horizontal clearfix" role="form" method="post"
                  <?php if ($GLOBALS['sh_redux']['opt-switch-method'] == phpmail) { ?>
                      action="<?php echo esc_url(get_template_directory_uri())?>/inc/sendmail/reservation.php"
                  <?php } ?>
                  <?php if ($GLOBALS['sh_redux']['opt-switch-method'] == smtpmail) { ?>
                      action="<?php echo esc_url(get_template_directory_uri())?>/inc/smtp/reservation.php"
                  <?php } ?>
                  <?php if ($GLOBALS['sh_redux']['opt-switch-method'] == wpmail OR $GLOBALS['sh_redux']['opt-switch-method'] == 0) { ?>
                      action="<?php echo esc_url(get_template_directory_uri())?>/inc/wpmail/reservation.php"
                  <?php }
                  ?> name="reservationform" id="reservationform">
                        <!-- Error message -->
                        <div id="message"></div>
                        <div class="row">
                            <div class="<?php if (true == ($GLOBALS['sh_redux']['switch-phone-form'])) { ?>col-sm-2"<?php } else { ?>col-sm-3"<?php } ?>">
                                <div class="form-group">
                                    <label for="email" accesskey="E"><?php esc_html_e('E-mail', 'starhotel'); ?></label>
                                    <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-mail'])) {
                                        ?>
                                        <div class="popover-icon" data-container="body" data-toggle="popover"
                                             data-trigger="hover" data-placement="right"
                                             data-content="<?php esc_html_e('Please fill in your email', 'starhotel'); ?>"><i
                                                class="fa fa-info-circle fa-lg"> </i></div>
                                    <?php } ?>
                                    <input name="email" type="text" id="email" value="" class="form-control"
                                           placeholder="<?php esc_html_e('Please enter your E-mail', 'starhotel'); ?>"/>
                                </div>
                            </div>
                            <?php if (true == ($GLOBALS['sh_redux']['switch-phone-form'])) { ?>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="phone" accesskey="P"><?php esc_html_e('Phone', 'starhotel'); ?></label>
                                    <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-phone'])) {
                                        ?>
                                        <div class="popover-icon" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php esc_html_e('Please add your country code' , 'starhotel' );?>"><i class="fa fa-info-circle fa-lg"> </i></div>
                                    <?php } ?>
                                    <input name="phone" type="text" id="phone" value="" class="form-control" placeholder="<?php _e('Your phone number', 'starhotel'); ?>"/>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="<?php if (true == ($GLOBALS['sh_redux']['switch-phone-form'])) { ?>col-sm-1"<?php } else { ?>col-sm-2"<?php } ?>">
                                <div class="form-group">
                                    <label for="room"><?php esc_html_e('Room Type', 'starhotel'); ?></label>
                                    <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-room'])) {
                                        ?>
                                        <div class="popover-icon" data-container="body" data-toggle="popover"
                                             data-trigger="hover" data-placement="right"
                                             data-content="<?php esc_html_e('Please select a room', 'starhotel'); ?>"><i
                                                class="fa fa-info-circle fa-lg"> </i></div>
                                    <?php } ?>

                                    <select class="form-control" name="room" id="room">
                                        <option selected="selected" disabled="disabled"><?php esc_html_e('Select a room', 'starhotel'); ?></option>
                                        <?php if (true == ($GLOBALS['sh_redux']['switch-no-preference-form'])) { ?>
                                            <option value="<?php esc_html_e('No preference', 'starhotel'); ?>"><?php esc_html_e('No preference', 'starhotel'); ?></option>
                                        <?php } ?>
                                        <?php if ($GLOBALS['sh_redux']['opt-select-room-format'] == rooms) {
                                                // Room names in selectbox
                                                $args = array(
                                                    'post_type' => 'room',
                                                );
                                                $rooms = new WP_Query($args);
                                                if ($rooms->have_posts()) {
                                                    while ($rooms->have_posts()) {
                                                        $rooms->the_post();
                                                        ?>
                                                        <option value="<?php echo the_title(); ?>"><?php echo the_title(); ?></option>
                                                    <?php }
                                                }; } ?>
                                        <?php if ($GLOBALS['sh_redux']['opt-select-room-format'] == roomtypes) {
                                                // Roomtypes in selectbox
                                                $termsfilter = get_terms("roomtype");
                                                if (!empty($termsfilter) && !is_wp_error($termsfilter)) {
                                                    foreach ($termsfilter as $termfilter) {
                                                        echo "<option value='" . esc_attr($termfilter->name) . "'>" . esc_html($termfilter->name) . "</option>";
                                                    }
                                                };
                                                } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="checkin"><?php esc_html_e('Check-in', 'starhotel'); ?></label>
                                    <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-checkin'])) {
                                        ?>
                                        <div class="popover-icon" data-container="body" data-toggle="popover"
                                             data-trigger="hover" data-placement="right"
                                             data-content="<?php esc_attr_e('Check-In is from 11:00', 'starhotel'); ?>"><i
                                                class="fa fa-info-circle fa-lg"> </i></div>
                                    <?php } ?>                                <i class="fa fa-calendar infield"></i>
                                    <input name="checkin" type="text" id="checkin" value="" class="form-control"
                                           placeholder="<?php esc_attr_e('Check-in', 'starhotel'); ?>"/>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="checkout"><?php esc_html_e('Check-out', 'starhotel'); ?></label>
                                    <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-checkout'])) {
                                        ?>
                                        <div class="popover-icon" data-container="body" data-toggle="popover"
                                             data-trigger="hover" data-placement="right"
                                             data-content="<?php esc_attr_e('Check-out is from 12:00', 'starhotel'); ?>"><i
                                                class="fa fa-info-circle fa-lg"> </i></div>
                                    <?php } ?>                                <i class="fa fa-calendar infield"></i>
                                    <input name="checkout" type="text" id="checkout" value="" class="form-control"
                                           placeholder="<?php esc_attr_e('Check-out', 'starhotel'); ?>"/>
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <div class="guests-select">
                                        <label><?php esc_html_e('Guests', 'starhotel'); ?></label>
                                        <i class="fa fa-user infield"></i>

                                        <div class="total form-control" id="test">1</div>
                                        <div class="guests">
                                            <div class="form-group adults">
                                                <label for="adults"><?php esc_html_e('Adults', 'starhotel'); ?></label>
                                                <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-guests-adults'])) {
                                                    ?>
                                                    <div class="popover-icon" data-container="body"
                                                         data-toggle="popover" data-trigger="hover"
                                                         data-placement="right"
                                                         data-content="<?php esc_attr_e('+18 years', 'starhotel'); ?>">
                                                        <i class="fa fa-info-circle fa-lg"> </i></div>
                                                <?php } ?>
                                                <select name="adults" id="adults" class="form-control">
                                                    <?php
                                                    $xa = 1;
                                                    $xamax = ($GLOBALS['sh_redux']['opt-select-max-adults']);
                                                    while ($xa <= $xamax) {
                                                        echo "<option value='$xa'>" . $xa . esc_html__(' Adult(s)', 'starhotel') . "</option>";
                                                        $xa++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group children">
                                                <label for="children"><?php esc_html_e('Children', 'starhotel'); ?></label>
                                                <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-guests-children'])) {
                                                    ?>
                                                    <div class="popover-icon" data-container="body"
                                                         data-toggle="popover" data-trigger="hover"
                                                         data-placement="right"
                                                         data-content="<?php esc_attr_e('0 till 18 years', 'starhotel'); ?>">
                                                        <i class="fa fa-info-circle fa-lg"> </i></div>
                                                <?php } ?>
                                                <select name="children" id="children" class="form-control">
                                                    <?php
                                                    $xc = 0;
                                                    $xcmax = ($GLOBALS['sh_redux']['opt-select-max-children']);
                                                    while ($xc <= $xcmax) {
                                                        echo "<option value='$xc'>" . $xc . esc_html__(' Child(ren)', 'starhotel') . "</option>";
                                                        $xc++;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="button" class="btn btn-ghost-color button-save btn-block"><?php esc_html_e('Save', 'starhotel'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary btn-block"><?php esc_html_e('Book Now', 'starhotel'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
    }
    if (strpos($orientation, 'vertical') !== false) {
        ?>
        <!-- Reservation form -->
        <div class="mt50">
            <div id="reservation-form" class="mt50 clearfix">
                <div class="row col-sm-12">
                  <form class="form-inline reservation-horizontal clearfix" role="form" method="post"
                  <?php if ($GLOBALS['sh_redux']['opt-switch-method'] == phpmail) { ?>
                      action="<?php echo esc_url(get_template_directory_uri())?>/inc/sendmail/reservation.php"
                  <?php } ?>
                  <?php if ($GLOBALS['sh_redux']['opt-switch-method'] == smtpmail) { ?>
                      action="<?php echo esc_url(get_template_directory_uri())?>/inc/smtp/reservation.php"
                  <?php } ?>
                  <?php if ($GLOBALS['sh_redux']['opt-switch-method'] == wpmail OR $GLOBALS['sh_redux']['opt-switch-method'] == 0) { ?>
                      action="<?php echo esc_url(get_template_directory_uri())?>/inc/wpmail/reservation.php"
                  <?php }
                  ?> name="reservationform" id="reservationform">

                        <h2 class="lined-heading"><span><?php esc_html_e('Reservation', 'starhotel'); ?></span></h2>

                        <!-- Error message -->
                        <div id="message"></div>
                        <div class="form-group">
                            <label for="email" accesskey="E"><?php esc_html_e('E-mail', 'starhotel'); ?></label>
                            <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-mail'])) {
                                ?>
                                <div class="popover-icon" data-container="body" data-toggle="popover"
                                     data-trigger="hover" data-placement="right"
                                     data-content="<?php esc_attr_e('Please fill in your email', 'starhotel'); ?>"><i
                                        class="fa fa-info-circle fa-lg"> </i></div>
                            <?php } ?>
                            <input name="email" type="text" id="email" value="" class="form-control"
                                   placeholder="<?php esc_attr_e('Please enter your E-mail', 'starhotel'); ?>"/>
                        </div>
                            <?php if (true == ($GLOBALS['sh_redux']['switch-phone-form'])) { ?>
                                <div class="form-group">
                                    <label for="phone" accesskey="P"><?php esc_html_e('Phone', 'starhotel'); ?></label>
                                    <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-phone'])) {
                                        ?>
                                        <div class="popover-icon" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<?php esc_html_e('Please add your country code' , 'starhotel' );?>"><i class="fa fa-info-circle fa-lg"> </i></div>
                                    <?php } ?>
                                    <input name="phone" type="text" id="phone" value="" class="form-control" placeholder="<?php _e('Your phone number', 'starhotel'); ?>"/>
                                </div>
                            <?php } ?>
                        <div class="form-group">
                            <label for="room"><?php esc_html_e('Room Type', 'starhotel'); ?></label>
                            <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-room'])) {
                                ?>
                                <div class="popover-icon" data-container="body" data-toggle="popover"
                                     data-trigger="hover" data-placement="right"
                                     data-content="<?php esc_attr_e('Please select a room', 'starhotel'); ?>"><i
                                        class="fa fa-info-circle fa-lg"> </i></div>
                            <?php } ?>
                                    <select class="form-control" name="room" id="room">
                                        <option selected="selected" disabled="disabled"><?php esc_html_e('Select a room', 'starhotel'); ?></option>
                                        <?php if (true == ($GLOBALS['sh_redux']['switch-no-preference-form'])) { ?>
                                            <option value="<?php esc_html_e('No preference', 'starhotel'); ?>"><?php esc_html_e('No preference', 'starhotel'); ?></option>
                                        <?php } ?>
                                        <?php if ($GLOBALS['sh_redux']['opt-select-room-format'] == rooms) {
                                                // Room names in selectbox
                                                $args = array(
                                                    'post_type' => 'room',
                                                );
                                                $rooms = new WP_Query($args);
                                                if ($rooms->have_posts()) {
                                                    while ($rooms->have_posts()) {
                                                        $rooms->the_post();
                                                        ?>
                                                        <option value="<?php echo the_title(); ?>"><?php echo the_title(); ?></option>
                                                    <?php }
                                                }; } ?>
                                        <?php if ($GLOBALS['sh_redux']['opt-select-room-format'] == roomtypes) {
                                                // Roomtypes in selectbox
                                                $termsfilter = get_terms("roomtype");
                                                if (!empty($termsfilter) && !is_wp_error($termsfilter)) {
                                                    foreach ($termsfilter as $termfilter) {
                                                        echo "<option value='" . esc_attr($termfilter->name) . "'>" . esc_html($termfilter->name) . "</option>";
                                                    }
                                                };
                                                } ?>
                                    </select>
                        </div>
                      <div class="form-group">
                            <label for="checkin"><?php esc_html_e('Check-in', 'starhotel'); ?></label>
                            <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-checkin'])) {
                                ?>
                                <div class="popover-icon" data-container="body" data-toggle="popover"
                                     data-trigger="hover" data-placement="right"
                                     data-content="<?php esc_attr_e('Check-In is from 11:00', 'starhotel'); ?>"><i
                                        class="fa fa-info-circle fa-lg"> </i></div>
                            <?php } ?>                                <i class="fa fa-calendar infield"></i>
                            <input name="checkin" type="text" id="checkin" value="" class="form-control"
                                   placeholder="<?php esc_attr_e('Check-in', 'starhotel'); ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="checkout"><?php esc_html_e('Check-out', 'starhotel'); ?></label>
                            <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-checkout'])) {
                                ?>
                                <div class="popover-icon" data-container="body" data-toggle="popover"
                                     data-trigger="hover" data-placement="right"
                                     data-content="<?php esc_attr_e('Check-out is from 12:00', 'starhotel'); ?>"><i
                                        class="fa fa-info-circle fa-lg"> </i></div>
                            <?php } ?>                                <i class="fa fa-calendar infield"></i>
                            <input name="checkout" type="text" id="checkout" value="" class="form-control"
                                   placeholder="<?php esc_attr_e('Check-out', 'starhotel'); ?>"/>
                        </div>
                        <div class="form-group">
                            <div class="guests-select">
                                <label><?php esc_html_e('Guests', 'starhotel'); ?></label>
                                <i class="fa fa-user infield"></i>
                                <div class="total form-control" id="test">1</div>
                                <div class="guests">
                                    <div class="form-group adults">
                                        <label for="adults"><?php esc_html_e('Adults', 'starhotel'); ?></label>
                                        <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-guests-adults'])) {
                                            ?>
                                            <div class="popover-icon" data-container="body" data-toggle="popover"
                                                 data-trigger="hover" data-placement="right"
                                                 data-content="<?php esc_attr_e('+18 years', 'starhotel'); ?>"><i
                                                    class="fa fa-info-circle fa-lg"> </i></div>
                                        <?php } ?>
                                        <select name="adults" id="adults" class="form-control">
                                            <?php
                                            $xa = 1;
                                            $xamax = ($GLOBALS['sh_redux']['opt-select-max-adults']);
                                            while ($xa <= $xamax) {
                                                echo "<option value='$xa'>" . $xa . esc_html__(' Adult(s)', 'starhotel') . "</option>";
                                                $xa++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group children">
                                        <label for="children"><?php esc_html_e('Children', 'starhotel'); ?></label>
                                        <?php if (true == ($GLOBALS['sh_redux']['reservation-hint-guests-children'])) {
                                            ?>
                                            <div class="popover-icon" data-container="body" data-toggle="popover"
                                                 data-trigger="hover" data-placement="right"
                                                 data-content="<?php esc_attr_e('0 till 18 years', 'starhotel'); ?>"><i
                                                    class="fa fa-info-circle fa-lg"> </i></div>
                                        <?php } ?>                                            <select
                                            name="children" id="children" class="form-control">
                                            <?php
                                            $xc = 0;
                                            $xcmax = ($GLOBALS['sh_redux']['opt-select-max-children']);
                                            while ($xc <= $xcmax) {
                                                echo "<option value='$xc'>" . $xc . esc_html__(' Child(ren)', 'starhotel') . "</option>";
                                                $xc++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-ghost-color button-save btn-block"><?php esc_html_e('Save', 'starhotel'); ?></button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><?php esc_html_e('Book Now', 'starhotel'); ?></button>
                </div>
                </form>
        </div>
        </div>
    <?php
    }
    return ob_get_clean();
};
add_shortcode('reservationform', 'sh_reservationform');
// Paragraph clean
function empty_paragraph($content)
{
    $array = array(
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']',
    );

    $content = strtr($content, $array);

    return $content;
}

add_filter('the_content', 'empty_paragraph');

?>
