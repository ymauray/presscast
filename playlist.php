<ul>
<?php
if (have_tracks()): while(have_tracks()): the_track();
	get_template_part( 'track' );
endwhile;
endif;
?>
</ul>
