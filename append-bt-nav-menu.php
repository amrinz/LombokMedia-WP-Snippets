<?php
// Append items wrapping in <li>...</li>
add_filter('wp_nav_menu_items', 'append_menu_link', 10, 2);
	function append_menu_link ($items, $args) {
		$tw = ot_get_option('twitter_profile_url');
		$fb = ot_get_option('facebook_profile_url');
		$gp = ot_get_option('googleplus_profile_url');
		$ig = ot_get_option('instagram_profile_url');


		if($args->theme_location == 'main-menu') {
			$items .= '<li class="visible-xs"><div class="lmd-append">';
				if(!empty($tw)) { 
				$items .= '<a href="'.$tw.'"><i class="fa fa-twitter"></i></a>'; 
				}
				if(!empty($fb)) { 
				$items .= '<a href="'.$fb.'"><i class="fa fa-facebook"></i></a>';
				}
				if(!empty($gp)) {
				$items .= '<a href="'.$gp.'"><i class="fa fa-google-plus"></i></a>';
				}
				if(!empty($ig)) {
				$items .= '<a href="'.$ig.'"><i class="fa fa-instagram"></i></a>';
				}
			$items .= '</div></li>';
		}
		return $items;
	}