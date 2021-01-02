<?php $do_not_duplicate = array(); ?>
					<?php $myPost = new WP_Query('posts_per_page=1'); ?>
					<?php while ($myPost->have_posts()) : $myPost->the_post(); ?>
					<?php $do_not_duplicate[] = $post->ID; ?>

						<div class="col-md-12">
							<article class="post" id="post-<?php the_ID(); ?>">
										
								<?php the_post_thumbnail('full', array('class' => 'img-responsive aligncenter') ); ?>
								
								<header class="text-center">
									<h2 class="post-title h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>				
								</header>
								<section class="post-body">
									<p><?php $words = get_the_excerpt(); lmd_limit_words($words, 40); ?></p>			
								</section>
								<footer class="text-center">
									<p class="post-meta"><i class="fa fa-clock-o"></i> <?php the_time('j F Y'); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-folder-open-o"></i> <?php the_category(', '); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-comment-o"></i> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?><?php edit_post_link( 'Edit', '&nbsp;&nbsp;&nbsp;<i class="fa fa-pencil"></i>&nbsp;', ''); ?></p>
								</footer>
							</article>
						</div>
					
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<div class="col-md-4">

				</div>
			</div>
			
			<!-- END -->
			<div class="row">
			
			
			<?php // 1st Loop
			$do_not_duplicate = array();
			$myPost = new WP_Query('posts_per_page=1');
			while ($myPost->have_posts()) : $myPost->the_post();
			$do_not_duplicate[] = $post->ID; ?>

				<div class="col-md-12">
					<article class="post" id="post-<?php the_ID(); ?>">
								
						<?php the_post_thumbnail('full', array('class' => 'img-responsive aligncenter') ); ?>
						
						<header class="text-center">
							<h2 class="post-title h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>				
						</header>
						<section class="post-body">
							<p><?php $words = get_the_excerpt(); lmd_limit_words($words, 40); ?></p>			
						</section>
						<footer class="text-center">
							<p class="post-meta"><i class="fa fa-clock-o"></i> <?php the_time('j F Y'); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-folder-open-o"></i> <?php the_category(', '); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-comment-o"></i> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?><?php edit_post_link( 'Edit', '&nbsp;&nbsp;&nbsp;<i class="fa fa-pencil"></i>&nbsp;', ''); ?></p>
						</footer>
					</article>
				</div>
			
			<?php endwhile; wp_reset_postdata(); ?>

			</div>
			<div class="row">
		

			<?php // 2nd Loop
			$myPost = new WP_Query(array('posts_per_page' => 2, 'post__not_in' => $do_not_duplicate ));
			while ($myPost->have_posts()) : $myPost->the_post();
			$do_not_duplicate[] = $post->ID; ?>

				<div class="col-md-12">
					<article class="post" id="post-<?php the_ID(); ?>">
								
						<?php the_post_thumbnail('full', array('class' => 'img-responsive aligncenter') ); ?>
						
						<header class="text-center">
							<h2 class="post-title h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>				
						</header>
						<section class="post-body">
							<p><?php $words = get_the_excerpt(); lmd_limit_words($words, 40); ?></p>			
						</section>
						<footer class="text-center">
							<p class="post-meta"><i class="fa fa-clock-o"></i> <?php the_time('j F Y'); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-folder-open-o"></i> <?php the_category(', '); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-comment-o"></i> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?><?php edit_post_link( 'Edit', '&nbsp;&nbsp;&nbsp;<i class="fa fa-pencil"></i>&nbsp;', ''); ?></p>
						</footer>
					</article>
				</div>
			
			<?php   endwhile; wp_reset_postdata(); ?>

			</div>
			<div class="row">

			<?php // 3rd Loop with inserting bootstrap grid
			$myPost = new WP_Query(array( 'posts_per_page' => 4, 'post__not_in' => $do_not_duplicate ));
			$count = 0; while ($myPost->have_posts()) : $myPost->the_post(); $count ++;
			$do_not_duplicate[] = $post->ID; ?>

				<div class="col-md-6">
					<article class="post" id="post-<?php the_ID(); ?>">
								
						<?php the_post_thumbnail('full', array('class' => 'img-responsive aligncenter') ); ?>
						
						<header class="text-center">
							<h2 class="post-title h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>				
						</header>
						<section class="post-body">
							<p><?php $words = get_the_excerpt(); lmd_limit_words($words, 40); ?></p>			
						</section>
						<footer class="text-center">
							<p class="post-meta"><i class="fa fa-clock-o"></i> <?php the_time('j F Y'); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-folder-open-o"></i> <?php the_category(', '); ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-comment-o"></i> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?><?php edit_post_link( 'Edit', '&nbsp;&nbsp;&nbsp;<i class="fa fa-pencil"></i>&nbsp;', ''); ?></p>
						</footer>
					</article>
				</div>
			
			<?php if ($count > 1 ) {				
				$count = 0;
				echo '</div><div class="row">';
			}
			
			endwhile; wp_reset_postdata(); ?>