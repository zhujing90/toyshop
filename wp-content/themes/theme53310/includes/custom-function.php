<?php
	// Loading child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, get_stylesheet_directory() . '/languages' );

	// Remove phone styles for IOS
	add_action( 'wp_head', 'tm_remove_phone_styles' );
	function tm_remove_phone_styles() {
		echo '<meta name="format-detection" content="telephone=no" />';
	}

	// Include scripts and styles for Child Theme
	add_action( 'wp_enqueue_scripts', 'tm_enqueue_assets', 40 );
	function tm_enqueue_assets() {
		global $wp_styles;
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-script.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'fullwidth-stretcher', get_stylesheet_directory_uri() . '/js/fullwidth-stretcher.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'theme_ie', get_stylesheet_directory_uri() . '/css/ie.css' );
		$wp_styles->add_data( 'theme_ie', 'conditional', 'lt IE 9' );
		wp_enqueue_script( 'jquery.equalheights', get_stylesheet_directory_uri() . '/js/jquery.equalheights.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'wow', get_stylesheet_directory_uri() . '/js/wow.js', array( 'jquery' ), '1.0', true );
	}

	//Layot change
	add_filter( 'cherry_layout_content_column', 'tm_content_column' );
	add_filter( 'cherry_layout_sidebar_column', 'tm_sidebar_column' );
	function tm_content_column() {
		return "span9";
	}
	function tm_sidebar_column() {
		return "span3";
	}

	//Change Slider Parameters
	add_filter( 'cherry_slider_params', 'tm_rewrite_slider_params' );
	function tm_rewrite_slider_params( $params ) {

		$params['height'] = "'47.4%'";
		$params['minHeight'] = "'100px'";

		return $params;
	}


//Change product on catalog page
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 50 );

	// Include additional files
	include_once( 'options-management.php' );
	include_once( 'live-chat.php' );
	include_once( 'shop-functions.php' );


	// WP Pointers
	add_action('admin_enqueue_scripts', 'myHelpPointers');
	function myHelpPointers() {
	//First we define our pointers 
	$pointers = array(
	   	array(
	       'id' => 'xyz1',   // unique id for this pointer
	       'screen' => 'options-permalink', // this is the page hook we want our pointer to show on
	       'target' => '#submit', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("submit_permalink"),
	       'content' => theme_locals("submit_permalink_desc"),
	       'position' => array( 
	                          'edge' => 'top', //top, bottom, left, right
	                          'align' => 'left', //top, bottom, left, right, middle
	                          'offset' => '0 5'
	                          )
	       ),

	    array(
	       'id' => 'xyz2',   // unique id for this pointer
	       'screen' => 'themes', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc"),
	       'position' => array( 
	                          'edge' => 'bottom', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 -10'
	                          )
	       ),

	    array(
	       'id' => 'xyz3',   // unique id for this pointer
	       'screen' => 'toplevel_page_options-framework', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => theme_locals("import_sample_data"),
	       'content' => theme_locals("import_sample_data_desc_2"),
	       'position' => array( 
	                          'edge' => 'left', //top, bottom, left, right
	                          'align' => 'top', //top, bottom, left, right, middle
	                          'offset' => '0 18'
	                          )
	       )
	    // more as needed
	    );
		//Now we instantiate the class and pass our pointer array to the constructor 
		$myPointers = new WP_Help_Pointer($pointers); 
	};
?>
