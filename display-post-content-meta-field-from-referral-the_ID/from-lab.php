<?php 
/*
* Template Name: Lab
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
			
					<?php if (have_posts()) : the_post(); ?>
						
						<div id="post-<?php the_ID(); ?>" class="post" role="article">
							<header class="post-header">
								<h1 class="post-title"><?php the_title(); ?></h1>
								<?php edit_post_link( 'Edit', '<ul class="post-meta post-date list-inline"><li class="list-inline-item"><i class="fa fa-edit"></i>&nbsp;&nbsp;', '</li></ul>'); ?>
							</header>

							<div class="post-body">
								<form action="<?php echo home_url('/downloads'); ?>" method="post">
									<input type="submit" />
									<input type="hidden" name="refid" value="<?php the_ID(); ?>" />
								</form>

								<?php the_content(); ?>
							</div>
						</div><!--/post-->
							
					<?php endif; ?>

				</div><!--/lmd-content-->

				<?php get_sidebar(); ?>

		</div><!--/container-->
	</div><!--/section-->

<?php get_footer(); ?>