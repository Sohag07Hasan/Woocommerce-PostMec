<?php 
	
/**
 * Handle every class and stuffs
 * */
class PostMec{
	
	public $events;
	public $relation;
		
	function __construct(){
		$this->init();
		do_action('postmec_init', $this);
	}
	
	
	
	function init(){
		include $this->get_postmec_dir() . 'classes/class.events.php';
		include $this->get_postmec_dir() . 'classes/class.events-products.relation.php';
		
		$this->events = new PostMecEvents();
		$this->relation = new PostMecEventsProductsRelationship();	
		
	}
	
	
	function get_postmec_dir(){
		return POSTMEC_DIR;
	}

	
	//get the plugin url
	function get_postmec_url(){
		return POSTMEC_URI;
	}
		
	
	//get current page url
	function get_current_url(){
		$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
		if ($_SERVER["SERVER_PORT"] != "80"){
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else{
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
}

?>