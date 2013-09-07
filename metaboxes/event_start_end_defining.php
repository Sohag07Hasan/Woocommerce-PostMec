<?php 
	
	$start_time = $postmec->events->get_event_start_time($post->ID);
	$end_time = $postmec->events->get_event_end_time($post->ID);
	
	$start_time = empty($start_time) ? '' : date("Y-m-d g.i A", $start_time);
	$end_time = empty($end_time) ? '' : date("Y-m-d g.i A", $end_time);
?>

<div>
	
	<p>Staring: <input placeholder="yyyy-mm-dd 6.30 PM" type="text" name="start_time" value="<?php echo $start_time ?>" /> </p>
	<p>Ending: <input placeholder="yyyy-mm-dd 5.05 AM" type="text" name="end_time" value="<?php echo $end_time ?>" /> </p>
	
</div>