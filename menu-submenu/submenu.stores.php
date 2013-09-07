<?php 
	if(!empty($_POST['store_logo'])){
		$postmec->events->save_store_logo($_POST['store_logo']);
	}
	
	$logo_victoria = $postmec->events->get_store_logo('victoria');
	$logo_6pm = $postmec->events->get_store_logo('6pm');
	
?>


<style>
	.storelogo-form input[type="text"]{
		width: 250px;
	}
</style>

<div class="wrap">
	<h2>Please upload logo for specific stores</h2>
	<form action="" method="post" class="storelogo-form">
		
		<table class="form-table">
			<tr valign="top" class="victoria_shop">
				<th scope="row" class="titledesc"><label for="shop_victoria">Victoria's Secret</label></th>
				<td> 
					<input id="victoria_text" type="text" name="store_logo[victoria]" value="<?php echo $logo_victoria; ?>" /> 
					&nbsp; &nbsp;<input id="victoria_button" type="button" value="Upload" class="button button-secondary" />
					<br/> 
					<img style='max-width: 150px; max-height: 100px; display:block' src="<?php echo $logo_victoria; ?>" id='victoria_preview'/>
				</td>
			</tr>
			
			<tr valign="top" class="sixpm_shop">
				<th scope="row" class="titledesc"><label for="shop_6pm"> 6 PM </label></th>
				<td> 
					<input id="sixpm_text" type="text" name="store_logo[6pm]" value="<?php echo $logo_6pm; ?>" /> 
					&nbsp; &nbsp;<input id="sixpm_button" type="button" value="Upload" class="button button-secondary" /> 
					<br/> 
					<img style='max-width: 150px; max-height: 100px; display:block' src="<?php echo $logo_6pm; ?>" id='sixpm_preview'/>
				</td>
			</tr>
			
		</table>
		
		<p> <input type="submit" value="Save"  class="button button-primary" /> </p>
		
	</form>
	
</div>