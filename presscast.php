<?php

$presscast_db_version = "0.1";

/**
 * Create tables
 */
add_action( 'init', function () {
	global $wpdb;
	global $presscast_db_version;

	$installed_vesion = get_option( 'presscast_db_version' );
	if ( $installed_vesion != $presscast_db_version ) {
		$table_name      = $wpdb->prefix . 'presscast_tracks';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = <<<TAG
CREATE TABLE {$table_name} (
id bigint(20) NOT NULL AUTO_INCREMENT,
artist_id bigint(20) NOT NULL,
title text NOT NULL,
album text NOT NULL,
publication_year int(11) NOT NULL,
buy_link TEXT NOT NULL,
PRIMARY KEY  (id)
) {$charset_collate}
TAG;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		update_option( 'presscast_db_version', $presscast_db_version );
	}
} );

add_action('wp_ajax_presscast_add_track', function() {
	error_log("add track : " . $_REQUEST['title'], 4);
	error_log("add track : " . $_REQUEST['album'], 4);
	error_log("add track : " . $_REQUEST['publication'], 4);
	error_log("add track : " . $_REQUEST['buylink'], 4);
	wp_die();
});

/*
 * Register new post type
 */
add_action( 'init', function () {
	register_post_type( 'artist', array(
		'labels'      => array(
			'name'               => _x( 'Artists', 'post type general name', 'presscast' ),
			'singular_name'      => _x( 'Artist', 'post type singular name', 'presscast' ),
			'add_new'            => _x( 'Add New', 'artist', 'presscast' ),
			'add_new_item'       => __( 'Add New Artist', 'presscast' ),
			'edit_item'          => __( 'Edit Artist', 'presscast' ),
			'new_item'           => __( 'New Artist', 'presscast' ),
			'all_items'          => __( 'All Artists', 'presscast' ),
			'view_items'         => __( 'View Artists', 'presscast' ),
			'search_items'       => __( 'Search Artists', 'presscast' ),
			'not_found'          => __( 'No artists found' ),
			'not_found_in_trash' => __( 'No artists found in the Trash', 'presscast' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Artists', 'presscast' )
		),
		'description' => __( 'Holds our artists and artist specific data', 'presscast' ),
		'public'      => true,
		'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive' => true
	) );
} );

/**
 * Custom interaction messages
 */
add_filter( 'post_updated_messages', function () {
	global $post, $post_ID;

	$messages['product'] = array(
		0  => '',
		1  => sprintf( __( 'Artist updated. <a href="%s">View artist</a>', 'presscast' ), esc_url( get_permalink( $post_ID ) ) ),
		2  => __( 'Custom field updated', 'presscast' ),
		3  => __( 'Custom field deleted', 'presscast' ),
		4  => __( 'Artist updated', 'presscast' ),
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Artist restored to revision from %s', 'presscast' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => sprintf( __( 'Artist published. <a href="%s">View artist</a>', 'presscast' ), esc_url( get_permalink( $post_ID ) ) ),
		7  => __( 'Artist saved.', 'presscast' ),
		8  => sprintf( __( 'Artist submitted. <a target="_blank" href="%s">Preview artist</a>', 'presscast' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		9  => sprintf( __( 'Artist scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview artist</a>', 'presscast' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 => sprintf( __( 'Artist draft updated. <a target="_blank" href="%s">Preview artist</a>', 'presscast' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) )
	);

	return $messages;
} );

/**
 * Contextual help
 */
add_action( 'contextual_help', function ( $contextual_help, $screen_id, $screen ) {
	if ( 'artist' == $screen->id ) {
		$contextual_help = '<h2>Artists</h2>
<p>Artists show details of artists in the system. You can see a list of them on this page in reverse chronological order - the latest one we added is first.</p>
<p>You can view/edit the details of each artist by clicking on its name, or you can perform bulk actions using the dropdown menu and selecting multiple items.</p>';
	} else if ( 'edit-artist' == $screen->id ) {
		$contextual_help = '<h2>Editing artists</h2>
<p>This page allows you to view/modify artist details. Please make sure to fill out the available boxes with appropriate details (artist photo, tracks, ...) and <strong>not</strong> add these details to the artists bio.</p>';
	}

	return __( $contextual_help, 'presscast' );
}, 10, 3 );

/**
 * Custom taxonomy
 */
add_action( 'init', function () {
	register_taxonomy( 'artist_genre', 'artist', array(
		'labels'       => array(
			'name'              => _x( 'Artist Genres', 'taxonomy general name', 'presscast' ),
			'singular_name'     => _x( 'Artist Genre', 'taxonomy singular name', 'presscast' ),
			'search_items'      => __( 'Search Artist Genres', 'presscast' ),
			'all_items'         => __( 'All Artist Genres', 'presscast' ),
			'parent_item'       => __( 'Parent Artist Genre', 'presscast' ),
			'parent_item_colon' => __( 'Parent Artist Genre:', 'presscast' ),
			'edit_item'         => __( 'Edit Artist Genre', 'presscast' ),
			'update_item'       => __( 'Update Artist Genre', 'presscast' ),
			'add_new_item'      => __( 'Add New Artist Genre', 'presscast' ),
			'new_item_name'     => __( 'New Artist Genre', 'presscast' ),
			'menu_name'         => __( 'Artist Genres', 'presscast' ),
		),
		'hierarchical' => false
	) );
}, 0 );

add_action( 'add_meta_boxes', function () {
	error_log( json_encode( get_current_screen() ), 4 );
	add_meta_box( 'artist_website_box', __( 'Constacts', 'presscast' ), function ( $post ) {
		wp_nonce_field( plugin_basename( __FILE__ ), 'artist_website_box_content_nonce' );
		$artist_website  = get_post_meta( $post->ID, 'artist_website', true );
		$artist_facebook = get_post_meta( $post->ID, 'artist_facebook', true );
		$artist_twitter  = get_post_meta( $post->ID, 'artist_twitter', true );
		ob_start();
		include( dirname( __FILE__ ) . '/boxes/artist_main_meta.php' );
		echo ob_get_clean();
	}, 'artist', 'normal' );

	add_meta_box( 'artist_tracks_box', __( 'Tracks', 'presscast' ), function ( $post ) {
		wp_nonce_field( plugin_basename( __FILE__ ), 'artist_tracks_box_content_nonce' );
		ob_start();
		include( dirname( __FILE__ ) . '/boxes/artist_tracks.php' );
		echo ob_get_clean();
	}, 'artist', 'normal' );
} );

/**
 * Editor style
 */
$presscast_editor_style_and_script = function () {
	$screen = get_current_screen();
	if ( $screen->id == 'artist' ) {
		wp_register_style( 'presscast_admin_style', get_template_directory_uri() . '/css/admin.css' );
		wp_enqueue_style( 'presscast_admin_style' );
		wp_register_script( 'presscast_admin_script', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ) );
		wp_enqueue_script( 'presscast_admin_script' );
		wp_register_style( 'presscast_fontawesome', get_template_directory_uri() . '/css/font-awesome-4.6.3/css/font-awesome.min.css' );
		wp_enqueue_style( 'presscast_fontawesome' );
	}
};

add_action( 'load-post.php', $presscast_editor_style_and_script );
add_action( 'load-post-new.php', $presscast_editor_style_and_script );

/**
 * Save artist meta
 */
add_action( 'save_post', function ( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['artist_website_box_content_nonce'], plugin_basename( __FILE__ ) ) ) {
		return;
	}

	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	$artist_website  = $_POST['artist_website'];
	$artist_facebook = $_POST['artist_facebook'];
	$artist_twitter  = $_POST['artist_twitter'];

	update_post_meta( $post_id, 'artist_website', $artist_website );
	update_post_meta( $post_id, 'artist_facebook', $artist_facebook );
	update_post_meta( $post_id, 'artist_twitter', $artist_twitter );
} );
