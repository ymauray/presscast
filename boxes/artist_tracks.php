<div class="presscast">
	<table class="table">
		<thead>
		<tr>
			<th><?php _e( 'Title', 'presscast' ); ?></th>
			<th><?php _e( 'Album', 'presscast' ); ?></th>
			<th><?php _e( 'Publication', 'presscast' ); ?></th>
			<th><?php _e( 'Buy link', 'presscast' ); ?></th>
			<th><?php _e( 'ID', 'presscast' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $tracks as $track ): ?>
			<tr class="data">
				<td><div><?php echo $track->title; ?></div></td>
				<td><div><?php echo $track->album; ?></div></td>
				<td><div><?php echo $track->publication_year; ?></div></td>
				<td><div><a href="<?php echo $track->buy_link; ?>"><?php echo substr( $track->buy_link, 0, 50 ); ?></a></div></td>
				<td><div><?php echo $track->id; ?></div></td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td><input title="title" name="newtitle" id="newtitle" type="text"></td>
			<td><input title="album" name="newalbum" id="newalbum" type="text"></td>
			<td><input title="publication" name="newpublication" id="newpublication" type="text"></td>
			<td><input title="link" name="newbuylink" id="newbuylink" type="text"></td>
			<td>
				<button class="button" id="savetrackbtn" disabled="disabled"><i class="fa fa-floppy-o"
				                                                                aria-hidden="true"></i></button>
			</td>
		</tr>
		</tbody>
		<tfoot>
		<tr>
			<th><?php _e( 'Title', 'presscast' ); ?></th>
			<th><?php _e( 'Album', 'presscast' ); ?></th>
			<th><?php _e( 'Publication', 'presscast' ); ?></th>
			<th><?php _e( 'Buy link', 'presscast' ); ?></th>
			<th><?php _e( 'ID', 'presscast' ); ?></th>
		</tr>
		</tfoot>
	</table>
</div>