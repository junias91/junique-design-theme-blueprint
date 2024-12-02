<?php 

/**
 * Custom Avatar Without a Plugin
 * https://userswp.io/wordpress-profile-picture/
 */

// 1. Enqueue the needed scripts.
add_action( "admin_enqueue_scripts", "junique_enqueue" );
function junique_enqueue( $hook ){
	// Load scripts only on the profile page.
	if( $hook === 'profile.php' || $hook === 'user-edit.php' ){
		add_thickbox();
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_media();
	}
}

// 2. Scripts for Media Uploader.
function junique_admin_media_scripts() {
	?>
	<script>
		jQuery(document).ready(function ($) {
			$(document).on('click', '.avatar-image-upload', function (e) {
				e.preventDefault();
				var $button = $(this);
				var file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select or Upload an Custom Avatar',
					library: {
						type: 'image' // mime type
					},
					button: {
						text: 'Select Avatar'
					},
					multiple: false
				});
				file_frame.on('select', function() {
					var attachment = file_frame.state().get('selection').first().toJSON();
					$button.siblings('#junique-custom-avatar').val( attachment.sizes.thumbnail.url );
					$button.siblings('.custom-avatar-preview').attr( 'src', attachment.sizes.thumbnail.url );
				});
				file_frame.open();
			});
		});
	</script>
	<?php
}
add_action( 'admin_print_footer_scripts-profile.php', 'junique_admin_media_scripts' );
add_action( 'admin_print_footer_scripts-user-edit.php', 'junique_admin_media_scripts' );


// 3. Adding the Custom Image section for avatar.
function custom_user_profile_fields( $profileuser ) {
	?>
	<h3><?php _e('Local Avatar', 'junique'); ?></h3>
	<table class="form-table junique-avatar-upload-options">
		<tr>
			<th>
				<label for="image"><?php _e('Local Avatar', 'junique'); ?></label>
			</th>
			<td>
				<?php
				// Check whether we saved the custom avatar, else return the default avatar.
				$custom_avatar = get_the_author_meta( 'junique-custom-avatar', $profileuser->ID );
				if ( $custom_avatar == '' ){
					$custom_avatar = get_avatar_url( $profileuser->ID );
				}else{
					$custom_avatar = esc_url_raw( $custom_avatar );
				}
				?>
				<img style="width: 96px; height: 96px; display: block; margin-bottom: 15px;" class="custom-avatar-preview" src="<?php echo $custom_avatar; ?>">
				<input type="text" name="junique-custom-avatar" id="junique-custom-avatar" value="<?php echo esc_attr( esc_url_raw( get_the_author_meta( 'junique-custom-avatar', $profileuser->ID ) ) ); ?>" class="regular-text" />
				<input type='button' class="avatar-image-upload button-primary" value="<?php esc_attr_e("Upload Image","junique");?>" id="uploadimage"/><br />
				<span class="description">
					<?php _e('Please upload a custom avatar for your profile, to remove the avatar simple delete the URL and click update.', 'junique'); ?>
				</span>
			</td>
		</tr>
	</table>
	<?php
}
add_action( 'show_user_profile', 'custom_user_profile_fields', 1, 1 );
add_action( 'edit_user_profile', 'custom_user_profile_fields', 1, 1 );


// 4. Saving the values.
add_action( 'personal_options_update', 'junique_save_local_avatar_fields' );
add_action( 'edit_user_profile_update', 'junique_save_local_avatar_fields' );
function junique_save_local_avatar_fields( $user_id ) {
	if ( current_user_can( 'edit_user', $user_id ) ) {
		if( isset($_POST[ 'junique-custom-avatar' ]) ){
			$avatar = esc_url_raw( $_POST[ 'junique-custom-avatar' ] );
			update_user_meta( $user_id, 'junique-custom-avatar', $avatar );
		}
	}
}


// 5. Set the uploaded image as default gravatar.
add_filter( 'get_avatar_url', 'junique_get_avatar_url', 10, 3 );
function junique_get_avatar_url( $url, $id_or_email, $args ) {
	$id = '';
	if ( is_numeric( $id_or_email ) ) {
		$id = (int) $id_or_email;
	} elseif ( is_object( $id_or_email ) ) {
		if ( ! empty( $id_or_email->user_id ) ) {
			$id = (int) $id_or_email->user_id;
		}
	} else {
		$user = get_user_by( 'email', $id_or_email );
		$id = !empty( $user ) ?  $user->data->ID : '';
	}
	
	//Preparing for the launch.
	$custom_url = $id ? get_user_meta( $id, 'junique-custom-avatar', true ) : '';
	
	// If there is no custom avatar set, return the normal one.
	if( $custom_url == '' || !empty($args['force_default'])) {
		return LINK . '/assets/img/default-avatar.jpg'; 
	}else{
		return esc_url_raw($custom_url);
	}
}
