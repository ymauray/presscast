<?php
?>
<div id="artist-main-meta">
	<div class="artist-meta">
		<div class="form-input">
			<label for="website"><?php _e('Website', 'presscast'); ?></label>
			<input type="text" id="artist_website" name="artist_website" placeholder="http://..." value="<?php echo $artist_website; ?>"/>
		</div>
	</div>
	<div class="artist-meta">
		<div class="form-input">
			<label for="facebook"><?php _e('Facebook', 'presscast'); ?></label>
			<input type="text" id="artist_facebook" name="artist_facebook" placeholder="https://facebook.com/..." value="<?php echo $artist_facebook; ?>"/>
		</div>
	</div>
	<div class="artist-meta">
		<div class="form-input">
			<label for="twitter"><?php _e('Twitter', 'presscast'); ?></label>
			<input type="text" id="artist_twitter" name="artist_twitter" placeholder="@..." value="<?php echo $artist_twitter; ?>"/>
		</div>
	</div>
</div>
