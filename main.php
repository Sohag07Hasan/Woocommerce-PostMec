<?php 
/*
 * Plugin Name: Postmec
 * author: ShakeMyWeb
 * plugin uri: http://www.shakemyweb.com/
 * author uri: http://www.shakemyweb.com/
 * Description: Do many things beyond discussion..........
 * */

define("POSTMEC_FILE", __FILE__);
define("POSTMEC_DIR", dirname(__FILE__) . '/');
define("POSTMEC_URI", plugins_url('/', __FILE__));


global $postmec;

include POSTMEC_DIR . 'classes/postmec.php';
$postmec = new PostMec()


?>