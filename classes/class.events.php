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
	}
	
	function get_posts($args = array()){
		$query = $this->get_query($args);
		wp_reset_query();
		return $query->posts;
	}
	
	function get_query($args = array()){
		$args['post_type'] = $this->post_type;				
		$query = new WP_Query($args);		
		return $query;
	}
	
	
	function add_meta_boxes(){
		add_meta_box('event_start_end_defining', 'Starting and Ending', array($this, 'metabox_date_time'), $this->post_type, 'side', 'high');
	}	
	
	function metabox_date_time($post){
		global $postmec;
		include $postmec->get_postmec_dir() . 'metaboxes/event_start_end_defining.php';
	}
	
	function save_meta_info($post_id, $post){
		if(isset($_POST['start_time'])) update_post_meta($post_id, 'start_time', strtotime($_POST['start_time']));
		if(isset($_POST['end_time'])) update_post_meta($post_id, 'end_time', strtotime($_POST['end_time']));
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
	
}


?>