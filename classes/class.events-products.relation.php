<?php 

class PostMecEventsProductsRelationship{

	function __construct(){
		add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
		add_action('save_post', array(&$this, 'attach_events_with_products'), 100, 2);

		//modify the query parameer based on events
		//add_action('woocommerce_product_query', array($this, 'woocommerce_product_query'), 100, 2);
		add_action('pre_get_posts', array($this, 'pre_get_posts'), 0);
		
		//changing page title
		add_action('woocommerce_page_title', array($this, 'woocommerce_page_title'));
		
		add_action('woocommerce_before_single_product', array($this, 'woocommerce_before_single_product'), 0);
		
		add_action('woocommerce_before_shop_loop', array($this, 'woocommerce_event_description'), 0);
		
		//changing the template for shop page
		add_filter('template_include', array(&$this, 'change_page_template'));
	}
	
	//change the page template of shop page
	function change_page_template($template){
		
		//var_dump($template);
		
		if(is_shop() && !isset($_GET['event_id'])){
			$template_dir = get_template_directory();				
			$template = $template_dir . '/tpl-shopping.php';
			include $template; 
			exit;			
		}	
	
		
		return $template;
	}
	
	
	function pre_get_posts($q){
		
		if(isset($_GET['event_id']) && $_GET['event_id'] > 0){
			$meta_query = $q->get( 'meta_query' );	
			if(!$meta_query) $meta_query = array();
			$meta_query[] = array('key' => '_product-event-relationship',
							'value' => trim($_GET['event_id']),
							'compare' => '='
						);
			$q->set('meta_query', $meta_query);
		}
		
	}

	
	function woocommerce_event_description(){
		if(isset($_GET['event_id']) && $_GET['event_id'] > 0){
			get_template_part('event', 'header');
		}
	}
	
	
	
	function add_meta_boxes(){
		add_meta_box('Eventlists', 'Events', array($this, 'metabox_eventlists'), 'product', 'side', 'high');
	}
	
	function metabox_eventlists($post){
		global $postmec;
		include $postmec->get_postmec_dir() . 'metaboxes/product-events-relationship.php';
	}
	
	function attach_events_with_products($post_id, $post){
		if(isset($_POST['product-event-relationship']) && count($_POST['product-event-relationship']) > 0):
			delete_post_meta($post_id, '_product-event-relationship');
			foreach($_POST['product-event-relationship'] as $event_id){
				add_post_meta($post_id, '_product-event-relationship', $event_id);
			}			
		endif;
	}
	
	
	function get_events($post_id = null){
		global $wpdb;
		$events = get_post_meta($post_id, '_product-event-relationship', false);
		
		if(empty($events)) $events = array();
		return $events;		
	}
	
	function woocommerce_page_title($title){
		if(isset($_GET['event_id']) && $_GET['event_id'] > 0){
			$event = get_post($_GET['event_id']);
			if($event){
				$title = $event->post_title;
			}
		}
		
		return $title;
	}
	
	function woocommerce_before_single_product(){
		$referer = wp_get_referer();
		
		$parsed = parse_url($referer);
		$ultimate = array();
		
		if($parsed['query']){
			$queries = explode('&', $parsed['query']);
			if($queries){
				foreach($queries as $q){
					$query = explode('=', $q);
					$ultimate[$query[0]] = $query[1];
				}
			}
		}

		if(isset($ultimate['event_id'])){
			$url = $parsed['scheme'] . '://' . $parsed['host'] . $parsed['path'];
						
			$url = add_query_arg(array('event_id' => $ultimate['event_id']), $url);
			?>
				<div class="header-home-msg header-events header-events-title">
					<div class="container">
						<span class="refereral_url">
							<a href="<?php echo $url; ?>">&laquo; Back to The Event</a>
						</span>
					</div>
				</div>
			<?php 
		}
		
		else{
			$url = $shop_page_url = get_permalink(woocommerce_get_page_id( 'shop' ));
			?>
				<div class="header-home-msg header-events header-events-title">
					<div class="container">
						<span class="refereral_url">
							<a href="<?php echo $url; ?>">&laquo; Back to The Event</a>
						</span>
					</div>
				</div>
			<?php 
		}
		
	}
	
}
	

?>