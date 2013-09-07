<?php 
	
	global $postmec;
	$events = $postmec->events->get_posts(array());	
	$attached_events = $postmec->relation->get_events($post->ID);

		
?>

<div>
	<?php if(count($events) > 0) :?>
		<?php foreach($events as $event): ?>
			<?php $checked = in_array($event->ID, $attached_events) ? 1 : 0; ?>
			<p>
				<input <?php checked(1, $checked); ?> name="product-event-relationship[]" type="checkbox" value="<?php echo $event->ID; ?>" id="event-<?php echo $event->ID; ?>" > 
				<label for="event-<?php echo $event->ID; ?> "> <?php echo $event->post_title ?> </label>
			</p>
		<?php endforeach;?>
	<?php endif; ?>
</div>