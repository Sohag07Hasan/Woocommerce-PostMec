<?php 
	$start_time = get_post_meta($post->ID, 'start_time', true);
	$end_time = get_post_meta($post->ID, 'end_time', true);
?>

<div>
	
	<p>Staring: <input type="text" name="start_time" value="<?php echo date("m/d/Y", $start_time); ?>" /> </p>
	<p>Ending: <input type="text" name="end_time" value="<?php echo date("m/d/Y", $end_time); ?>" /> </p>
	
</div>