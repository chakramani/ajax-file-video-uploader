<?php

add_action('wp_ajax_uploading_videos_landing_page', 'uploading_videos_landing_page');
add_action('wp_ajax_nopriv_uploading_videos_landing_page', 'uploading_videos_landing_page');

function uploading_videos_landing_page()
{
	$upload_overrides = array( 'test_form' => false );
	if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {

		// WordPress environmet
		require(ABSPATH. '/wp-load.php');
		// it allows us to use wp_handle_upload() function
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		// validation
		if (empty($_FILES['file'])) {
			wp_die('No files selected.');
		}
		$upload_landing_video = wp_handle_upload( $_FILES['file'],$upload_overrides );
		// var_dump($upload_landing_video);
		if (!empty($upload_landing_video['error'])) {
			echo 'error vo';
			wp_die($upload_landing_video['error']);
		}
		// it is time to add our uploaded image into WordPress media library
		$banner_attachment_id = wp_insert_attachment(
			[
				'guid' => $upload_landing_video['url'],
				'post_mime_type' => $upload_landing_video['type'],
				'post_title' => basename($upload_landing_video['file']),
				'post_content' => '',
				'post_status' => 'inherit',
			],
			$upload_landing_video['file']
		);
		if (is_wp_error($banner_attachment_id) || !$banner_attachment_id) {
			wp_die('Upload error.');
		}
		update_post_meta(get_the_ID(), 'lp_video', $banner_attachment_id);
	}
	die();
}
