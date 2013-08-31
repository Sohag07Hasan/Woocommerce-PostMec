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
	
}

?>