<?php 
	$store = $postmec->events->get_associated_store($post->ID);
?>

<div class="store-managment">
	
	<p> <input <?php checked($store, 'victoria'); ?> type="radio" name="store" id="victoria_secret" value="victoria"> &nbsp; &nbsp;<label for="victoria_secret" > Victoria's Secret </label></p>
	<p> <input <?php checked($store, '6pm'); ?> type="radio" name="store" id="6_pm" value="6pm"> &nbsp; &nbsp;<label for="6_pm" > 6 PM</label></p>
	
</div>