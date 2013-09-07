<?php 
/*
 * Events Handler 
 * */
class PostMecEvents{
	
	public $event;
	public $post_type;
	
	function __construct(){
		$this->post_type = 'event';
		
		add_action('init', array($this, 'register_post_type'));
		add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
		add_action('save_post', array(get_class(), 'save_meta_info'), 10, 2);
		//add_filter('post_type_link', array($this, 'my_post_type_link_filter_function', 1, 3));
		
		//add sub menu page to manage stores
		add_action('admin_menu', array(&$this, 'admin_menu'), 100);
		
		//add scritps to handle stores
		add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_script'));
		
	}
	
	function get_posts($args = array()){
		$query = $this->get_query($args);
		wp_reset_query();
		return $query->posts;
	}
	
	function get_query($args = array()){
		$args['post_type'] = $this->post_type;
		
		if(isset($args['orderby'])){
			if($args['orderby'] == 'end'){
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = '_end_time';
				$args['order'] = 'ASC';
			}
		}
		
		$query = new WP_Query($args);		
		return $query;
	}
	
	
	function add_meta_boxes(){
		add_meta_box('event_start_end_defining', 'Event Start and End', array($this, 'metabox_date_time'), $this->post_type, 'side', 'high');
		add_meta_box('event_vendor_selector', 'Select a Store', array($this, 'metabox_store'), $this->post_type, 'side', 'high');
	}	
	
	
	//startup date and ending date selector
	function metabox_date_time($post){
		global $postmec;
		include $postmec->get_postmec_dir() . 'metaboxes/event_start_end_defining.php';
	}
	
	
	//shop selector like (Victoria's fasions, 6PM etc)
	function metabox_store($post){
		global $postmec;
		include $postmec->get_postmec_dir() . 'metaboxes/metabox.store.php';
	}
	
	
	function save_meta_info($post_id, $post){
		//date and time		
		if(isset($_POST['start_time'])) update_post_meta($post_id, '_start_time', strtotime($_POST['start_time']));
		if(isset($_POST['end_time'])) update_post_meta($post_id, '_end_time', strtotime($_POST['end_time']));
		
		//store info
		if(isset($_POST['store'])) update_post_meta($post_id, '_store', $_POST['store']);
	}
	
	
	
	function register_post_type(){
		register_post_type( $this->post_type,
		array(
		'labels' => array(
		'name' 					=> __( 'Events', 'postmec' ),
		'singular_name' 		=> __( 'Event', 'postmec' ),
		'menu_name'				=> _x( 'Events', 'Admin menu name', 'postmec' ),
		'add_new' 				=> __( 'Add event', 'postmec' ),
		'add_new_item' 			=> __( 'Add New event', 'postmec' ),
		'edit' 					=> __( 'Edit', 'postmec' ),
		'edit_item' 			=> __( 'Edit event', 'postmec' ),
		'new_item' 				=> __( 'New event', 'postmec' ),
		'view' 					=> __( 'View event', 'postmec' ),
		'view_item' 			=> __( 'View event', 'postmec' ),
		'search_items' 			=> __( 'Search events', 'postmec' ),
		'not_found' 			=> __( 'No events found', 'postmec' ),
		'not_found_in_trash' 	=> __( 'No events found in trash', 'postmec' ),
		'parent' 				=> __( 'Parent ', 'postmec' )
		),
		'description' 			=> __( 'This is where you can add new events to your store.', 'postmec' ),
		'public' 				=> true,
		'show_ui' 				=> true,
		'map_meta_cap'			=> true,
		'publicly_queryable' 	=> true,
		'exclude_from_search' 	=> false,
		'hierarchical' 			=> false, // Hierarchical causes memory issues - WP loads all records!
		'query_var' 			=> true,
		'supports' 				=> array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'has_archive' 			=> false,
		'show_in_nav_menus' 	=> true,
		'menu_position'         => 55,
		'rewrite' => array(
			'slug' => 'event',
			'with_front' => false
		),
	
		)
					
		);
				
	}
	
	//un used
	function my_post_type_link_filter_function($post_link, $id = 0, $leavename = FALSE){
		if ( strpos('%event%', $post_link) === 'FALSE' ) {
			return $post_link;
		}
		$post = get_post($id);
		if ( !is_object($post) || $post->post_type != 'event' ) {
			return $post_link;
		}
		
		return $post_link;
	}
	
	
	//get event start time
	function get_event_start_time($post_id){
		return get_post_meta($post_id, '_start_time', true);		
	}
	
	
	//get event ending time
	function get_event_end_time($post_id){
		return get_post_meta($post_id, '_end_time', true);
	}
	
	
	//get the store of the event
	function get_associated_store($post_id){
		return get_post_meta($post_id, '_store', true);
	}
	
	
	//add a submenu page
	function admin_menu(){
		add_submenu_page('edit.php?post_type=event', 'Store Management', 'Stores', 'manage_woocommerce', 'stores-management', array(&$this, 'store_management'));
	}
	
	
	//submneu page content
	function store_management(){
		global $postmec;
		include $postmec->get_postmec_dir() . 'menu-submenu/submenu.stores.php';
	}
	
	//enqueue scripts to use default logo uploader
	function admin_enqueue_script(){
		global $postmec;
		
		if($_GET['page'] == 'stores-management'){
			wp_enqueue_script('jquery');
			wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );
			wp_register_script('store-media-upload', $postmec->get_postmec_url() . 'js/plugin.media-uploader.js', array('jquery', 'thickbox', 'media-upload'));
			wp_enqueue_script('store-media-upload');
		
			//wp_register_script('media-uploader-activator', $commentbar->get_this_url() . 'js/uploader.activator.js', array('jquery'));
			//wp_enqueue_script('media-uploader-activator');
		}
	}
	
	
	//save the store logo
	function save_store_logo($logo = array()){
		update_option('stores_logo', $logo);		
	}
	
	
	//get the store logo
	function get_store_logo($store = ''){
		$logo = get_option('stores_logo');		
		return isset($logo[$store]) ? $logo[$store] : '';
		
	}
	
}


?>