<?php 
/*
* Template Name: Download
* Desc: Displays the content of referring post by ID 
*/
get_header(); 

	$lmd_sidebar = cmb2_get_option('lmd_main', 'layout', 'righsidebar');

		switch ($lmd_sidebar) {
			case "leftsidebar":
				$lmd_content_class = 'col-lg-9 order-2';
				break;
			case "onecolumn":
				$lmd_content_class = 'col-lg-12';
				break;
			default:
				$lmd_content_class = 'col-lg-9 order-1';
		}
?>
	
	<div class="section section-page">
		<div class="container">
			<div class="row">
				<div id="lmd-content" class="<?php echo $lmd_content_class; ?>">

					<?php if (!empty($_POST['refid'])) {
						$post_id = $_POST['refid'];
						$post_object = get_post( $post_id );
					?>
						<div class="post" role="article">
							<header class="post-header">
								<h1 class="post-title"><a href="<?php echo get_permalink($post_id); ?>">Download <?php echo $post_object->post_title; ?></a></h1>
							</header>

							<div class="post-body">
								<?php echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'alignleft' ) ); ?>

								<?php echo $post_object->post_content; ?>

								<a class="btn btn-primary" href="<?php echo get_post_meta($post_id, 'file_url', true); ?>"><?php echo get_post_meta($post_id, 'file_size', true); ?></a>
							</div>
						</div><!--/post-->
					
					<?php } else {
						
						get_template_part('lmd-nothing'); 
						
					} ?>

				</div><!--/lmd-content-->

				<?php get_sidebar(); ?>

		</div><!--/container-->
	</div><!--/section-->

<?php get_footer(); ?>