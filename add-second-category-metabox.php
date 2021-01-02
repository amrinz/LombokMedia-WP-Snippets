Basically, category is taxonomy
So second category mean we create new custom taxonomy for post
--------------------------------------------------------------

//Add Second Taxonomy for Post
	function create_pricerange_tax() {
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name' => _x( 'Price Range', 'taxonomy general name' ),
			'singular_name' => _x( 'Price Range', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Price Range' ),
			'all_items' => __( 'All types' ),
			'parent_item' => __( 'Parent Price Range' ),
			'parent_item_colon' => __( 'Parent Price Range:' ),
			'edit_item' => __( 'Edit Price Range' ), 
			'update_item' => __( 'Update Price Range' ),
			'add_new_item' => __( 'Add New Price Range' ),
			'new_item_name' => __( 'New Price Range Name' ),
			'menu_name' => __( 'Price Range' )
		); 	

		register_taxonomy('room-price',array('post'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'room-price' ),
			'show_in_nav_menus' => true,  
			'public' => true
		)); 
	}

	add_action( 'init', 'create_pricerange_tax', 10);