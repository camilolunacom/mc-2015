<?php
/**
 * Dropbox Destination
 *
 * Incoming vars:
 *     $destination_settings
 *     $mode
 *     $destination_id
 *     $settings_form
 *
 * @author Brian DiChiara
 * @package BackupBuddy
 */

global $pb_hide_save, $pb_hide_test, $pb_backupbuddy_destination_errors;

// Init settings as static property.
pb_backupbuddy_destination_dropbox3::add_settings( $destination_settings );

$code  = pb_backupbuddy_destination_dropbox3::$settings['oauth_code'];
$state = pb_backupbuddy_destination_dropbox3::get_state( false );
$token = pb_backupbuddy_destination_dropbox3::$settings['oauth_token'];

if ( 'auth_dropbox' === pb_backupbuddy::_POST( 'dropbox_action' ) ) {
	$state = pb_backupbuddy::_POST( 'oauth_state' );
	$code  = pb_backupbuddy::_POST( 'oauth_code' );

	if ( $code ) {
		pb_backupbuddy_destination_dropbox3::set_state( $state );
		pb_backupbuddy_destination_dropbox3::$settings['oauth_code'] = $code;

		if ( false === pb_backupbuddy_destination_dropbox3::connect() ) {
			pb_backupbuddy::alert( 'Error #2020022701: Could not connect to Dropbox.', true );
			$code = false;
		} else {
			// Refresh state and token var for hidden input.
			$state = pb_backupbuddy_destination_dropbox3::get_state( false );
			$token = pb_backupbuddy_destination_dropbox3::$settings['oauth_token'];
		}
	}
}

if ( 'add' === $mode && ! $code ) {
	$pb_hide_save = true;
	$pb_hide_test = true;

	// If plugin not licensed, throw error and stop.
	if ( ! backupbuddy_get_package_license() ) {
		if ( count( $pb_backupbuddy_destination_errors ) ) {
			pb_backupbuddy::alert( $pb_backupbuddy_destination_errors[0], true );
		} else {
			pb_backupbuddy::alert( __( 'Plugin license information could not be found. Please contact support for further assistance.', 'it-l10n-backupbuddy' ), true );
		}
		return;
	}

	$dropbox_action = pb_backupbuddy::ajax_url( 'destination_picker' ) . '&add=dropbox3&callback_data=' . pb_backupbuddy::_GET( 'callback_data' );
	$redirect_url   = admin_url( 'admin.php?page=pb_backupbuddy_destinations&dropbox-authorize=1' );
	if ( 'auth_dropbox' === pb_backupbuddy::_POST( 'dropbox_action' ) && ! pb_backupbuddy::_POST( 'oauth_code' ) ) {
		pb_backupbuddy::alert( 'Error #2019091902: Missing required fields.', true );
	}
	?>
	<script type="text/javascript">
		( function( $ ) {
			'use strict';

			function open_window( url, title, w, h ) {
				// Fixes dual-screen position                         Most browsers      Firefox
				var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX,
					dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY,

					width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width,
					height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height,

					systemZoom = width / window.screen.availWidth,
					left = (width - w) / 2 / systemZoom + dualScreenLeft,
					top = (height - h) / 2 / systemZoom + dualScreenTop,
					newWindow = window.open( url, title, 'scrollbars=no, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left );

				// Puts focus on the newWindow.
				if ( window.focus ) {
					newWindow.focus();
				}

				return newWindow;
			}

			function backupbuddy_dropbox_init() {
				$( '.dropbox-authorize' ).on( 'click', function( e ) {
					e.preventDefault();
					var win = open_window( $( this ).attr( 'href' ), 'Dropbox Authorization', 400, 500 ),
						$btn = $( this ),
						$input = $( '.dropbox-oauth-code' ),
						$footer = $( '.form-footer' );

					if ( ! $input.length ) {
						return;
					}

					$btn.addClass( 'hidden' );
					$input.removeClass( 'hidden' );
					$footer.removeClass( 'hidden' );
				});
			}

			$( function() {
				backupbuddy_dropbox_init();
			});

		})( jQuery );
	</script>
	<style type="text/css">
		.dropbox-auth {
			padding-top: 15px;
		}
		.dropbox-auth label {
			display: block;
		}
		.dropbox-auth input.large {
			width: 100%;
			max-width: 700px;
		}
		.dropbox-auth .form-footer {
			padding: 15px 0;
		}
	</style>
	<form method="post" action="<?php echo esc_attr( $dropbox_action ); ?>" class="dropbox-auth">
		<input type="hidden" name="dropbox_action" value="auth_dropbox">
		<input type="hidden" name="oauth_state" value="<?php echo esc_attr( $state ); ?>" />
		<p>
			<?php printf( '<a href="%s" target="_blank" class="button dropbox-authorize">%s</a>', esc_attr( $redirect_url ), esc_html__( 'Click here to log into Dropbox', 'it-l10n-backupbuddy' ) ); ?>
		</p>
		<p class="dropbox-oauth-code hidden">
			<label>
				<span class="label"><?php esc_html_e( 'Paste Your Code Here:', 'it-l10n-backupbuddy' ); ?></span>
				<span class="field"><input type="text" name="oauth_code" class="large" /></span>
			</label>
		</p>
		<footer class="form-footer hidden">
			<input type="submit" class="button button-primary" value="Link Account">
		</footer>
	</form>
	<?php
	// End early for this step.
	return;
}

if ( 'edit' === $mode && false === pb_backupbuddy_destination_dropbox3::connect() ) {
	pb_backupbuddy::alert( 'Error #2020022702: Dropbox Connection is no longer valid. Please re-setup this destination.', true );
	$pb_hide_save = true;
	$pb_hide_test = true;
	return;
}

$settings_form->add_setting(
	array(
		'type'    => 'text',
		'name'    => 'title',
		'title'   => __( 'Destination name', 'it-l10n-backupbuddy' ),
		'tip'     => __( 'Name of the new destination to create. This is for your convenience only.', 'it-l10n-backupbuddy' ),
		'rules'   => 'required|string[1-45]',
		'default' => __( 'My Dropbox (v3)', 'it-l10n-backupbuddy' ),
	)
);

$settings_form->add_setting(
	array(
		'type'    => 'hidden',
		'name'    => 'oauth_code',
		'default' => $code,
	)
);
$settings_form->add_setting(
	array(
		'type'    => 'hidden',
		'name'    => 'oauth_state',
		'default' => $state,
	)
);
$settings_form->add_setting(
	array(
		'type'    => 'hidden',
		'name'    => 'oauth_token',
		'default' => $token,
	)
);

$folder_id   = $destination_settings['dropbox_folder_id'];
$folder_path = $destination_settings['dropbox_folder_path'];
$folder_name = $destination_settings['dropbox_folder_name'];
if ( ! $folder_path ) {
	$folder_path = '/';
}

$settings_form->add_setting(
	array(
		'type'      => 'text',
		'name'      => 'dropbox_folder_path',
		'title'     => __( 'Storage Folder Path', 'it-l10n-backupbuddy' ),
		'tip'       => __( 'Folder to store files within. Leave blank (or /) to store in the root. Use the folder picker or get the path from the folder URL in your web browser.', 'it-l10n-backupbuddy' ),
		'rules'     => '',
		'default'   => $folder_path,
		'css'       => 'width: 300px;',
		'after'     => ' <span class="description">Leave blank (or /) to store in root folder.</span>',
		'row_class' => 'backupbuddy-dropbox-folder-row',
	)
);

$settings_form->add_setting(
	array(
		'type'    => 'hidden',
		'name'    => 'dropbox_folder_id',
		'default' => $folder_id,
	)
);

$settings_form->add_setting(
	array(
		'type'    => 'hidden',
		'name'    => 'dropbox_folder_name',
		'default' => $folder_name,
	)
);

if ( 'save' !== $mode && '1' !== $destination_settings['disable_file_management'] ) {
	pb_backupbuddy_destination_dropbox3::folder_selector( $destination_id );
}

/**
 * Archive Limits.
 */
$settings_form->add_setting(
	array(
		'type'    => 'text',
		'name'    => 'full_archive_limit',
		'title'   => __( 'Full backup limit', 'it-l10n-backupbuddy' ) . ' <span class="required">*</span>',
		'tip'     => __( '[Example: 5] - Enter 0 for no limit. This is the maximum number of Full (complete) backup archives to be stored in this specific destination. If this limit is met the oldest backup of this type will be deleted.', 'it-l10n-backupbuddy' ),
		'rules'   => 'required|int[0-9999999]',
		'default' => 5,
		'css'     => 'width: 50px;',
		'after'   => ' backups',
	)
);

$settings_form->add_setting(
	array(
		'type'    => 'text',
		'name'    => 'db_archive_limit',
		'title'   => __( 'Database only limit', 'it-l10n-backupbuddy' ) . ' <span class="required">*</span>',
		'tip'     => __( '[Example: 5] - Enter 0 for no limit. This is the maximum number of Database Only backup archives to be stored in this specific destination. If this limit is met the oldest backup of this type will be deleted.', 'it-l10n-backupbuddy' ),
		'rules'   => 'required|int[0-9999999]',
		'default' => 5,
		'css'     => 'width: 50px;',
		'after'   => ' backups',
	)
);

$settings_form->add_setting(
	array(
		'type'  => 'text',
		'name'  => 'themes_archive_limit',
		'title' => __( 'Themes only limit', 'it-l10n-backupbuddy' ),
		'tip'   => __( '[Example: 5] - Enter 0 for no limit. This is the maximum number of this type of archive to be stored in this specific destination. If this limit is met the oldest backup of this type will be deleted.', 'it-l10n-backupbuddy' ),
		'rules' => 'int[0-9999999]',
		'css'   => 'width: 50px;',
		'after' => ' backups. &nbsp;<span class="description">0 or blank for no limit.</span>',
	)
);

$settings_form->add_setting(
	array(
		'type'  => 'text',
		'name'  => 'plugins_archive_limit',
		'title' => __( 'Plugins only limit', 'it-l10n-backupbuddy' ),
		'tip'   => __( '[Example: 5] - Enter 0 for no limit. This is the maximum number of this type of archive to be stored in this specific destination. If this limit is met the oldest backup of this type will be deleted.', 'it-l10n-backupbuddy' ),
		'rules' => 'int[0-9999999]',
		'css'   => 'width: 50px;',
		'after' => ' backups. &nbsp;<span class="description">0 or blank for no limit.</span>',
	)
);

$settings_form->add_setting(
	array(
		'type'  => 'text',
		'name'  => 'media_archive_limit',
		'title' => __( 'Media only limit', 'it-l10n-backupbuddy' ),
		'tip'   => __( '[Example: 5] - Enter 0 for no limit. This is the maximum number of this type of archive to be stored in this specific destination. If this limit is met the oldest backup of this type will be deleted.', 'it-l10n-backupbuddy' ),
		'rules' => 'int[0-9999999]',
		'css'   => 'width: 50px;',
		'after' => ' backups. &nbsp;<span class="description">0 or blank for no limit.</span>',
	)
);

$settings_form->add_setting(
	array(
		'type'  => 'text',
		'name'  => 'files_archive_limit',
		'title' => __( 'Files only limit', 'it-l10n-backupbuddy' ),
		'tip'   => __( '[Example: 5] - Enter 0 for no limit. This is the maximum number of this type of archive to be stored in this specific destination. If this limit is met the oldest backup of this type will be deleted.', 'it-l10n-backupbuddy' ),
		'rules' => 'int[0-9999999]',
		'css'   => 'width: 50px;',
		'after' => ' backups. &nbsp;<span class="description">0 or blank for no limit.</span>',
	)
);

/**
 * Advanced Settings.
 */
$settings_form->add_setting(
	array(
		'type'      => 'title',
		'name'      => 'advanced_begin',
		'title'     => '<span class="dashicons dashicons-arrow-right"></span> ' . __( 'Advanced Options', 'it-l10n-backupbuddy' ),
		'row_class' => 'advanced-toggle-title',
	)
);

$settings_form->add_setting(
	array(
		'type'      => 'text',
		'name'      => 'max_chunk_size',
		'title'     => __( 'Max chunk size', 'it-l10n-backupbuddy' ),
		'tip'       => __( '[Example: 5] - Enter 0 for no chunking; minimum of 5 if enabling. This is the maximum file size to send in one whole piece. Files larger than this will be transferred in pieces up to this file size one part at a time. This allows to transfer of larger files than you server may allow by breaking up the send process. Chunked files may be delayed if there is little site traffic to trigger them. Default is 80 and maximum is 150.', 'it-l10n-backupbuddy' ),
		'rules'     => 'required|int[5-150]',
		'css'       => 'width: 50px;',
		'after'     => ' MB (recommended; leave at 80MB if unsure)',
		'row_class' => 'advanced-toggle',
	)
);

if ( 'edit' !== $mode || '0' == $destination_settings['disable_file_management'] ) {
	$settings_form->add_setting(
		array(
			'type'      => 'checkbox',
			'name'      => 'disable_file_management',
			'options'   => array(
				'unchecked' => '0',
				'checked'   => '1',
			),
			'title'     => __( 'Disable file management', 'it-l10n-backupbuddy' ),
			'tip'       => __( '[[Default: unchecked] - When checked, selecting this destination disables browsing or accessing files stored at this destination from within BackupBuddy. NOTE: Once enabled this cannot be disabled without deleting and re-creating this destination. NOTE: Once enabled this cannot be disabled without deleting and re-creating this destination.', 'it-l10n-backupbuddy' ),
			'css'       => '',
			'rules'     => '',
			'after'     => __( 'Once disabled you must recreate the destination to re-enable.', 'it-l10n-backupbuddy' ),
			'row_class' => 'advanced-toggle',
		)
	);
}

$settings_form->add_setting(
	array(
		'type'      => 'checkbox',
		'name'      => 'disabled',
		'options'   => array(
			'unchecked' => '0',
			'checked'   => '1',
		),
		'title'     => __( 'Disable destination', 'it-l10n-backupbuddy' ),
		'tip'       => __( '[Default: unchecked] - When checked, this destination will be disabled and unusable until re-enabled. Use this if you need to temporary turn a destination off but don\t want to delete it.', 'it-l10n-backupbuddy' ),
		'css'       => '',
		'after'     => '<span class="description"> ' . __( 'Check to disable this destination until re-enabled.', 'it-l10n-backupbuddy' ) . '</span>',
		'rules'     => '',
		'row_class' => 'advanced-toggle',
	)
);
