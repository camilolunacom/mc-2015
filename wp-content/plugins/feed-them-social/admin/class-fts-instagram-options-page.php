<?php
/**
 * Feed Them Social - Instagram Options Page
 *
 * This page is used to create the general options for Instagram Feeds
 * including setting access tokens.
 *
 * @package     feedthemsocial
 * @copyright   Copyright (c) 2012-2018, SlickRemix
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */

namespace feedthemsocial;

/**
 * Class FTS Instagram Options Page
 *
 * @package feedthemsocial
 */
class FTS_Instagram_Options_Page {

	/**
	 * Construct
	 *
	 * Instagram Style Options Page constructor.
	 *
	 * @since 1.9.6
	 */
	public function __construct() {
	}


	/**
	 * Feed Them Instagram Options Page
	 *
	 * @since 1.9.6
	 */
	public function feed_them_instagram_options_page() {
		$fts_functions                       = new feed_them_social_functions();
		$fts_instagram_access_token          = get_option( 'fts_instagram_custom_api_token' );
		$fts_instagram_custom_id             = get_option( 'fts_instagram_custom_id' );
		$fts_instagram_show_follow_btn       = get_option( 'instagram_show_follow_btn' );
		$fts_instagram_show_follow_btn_where = get_option( 'instagram_show_follow_btn_where' );
        $user_id_basic                       = isset( $_GET['access_token'], $_GET['feed_type']  ) && 'instagram_basic' === $_GET['feed_type'] ? sanitize_text_field( $_GET['user_id'] ) : $fts_instagram_custom_id;
        $access_token_basic                  = isset( $_GET['access_token'], $_GET['feed_type']  ) && 'instagram_basic' === $_GET['feed_type'] ? sanitize_text_field( $_GET['access_token'] ) : get_option( 'fts_instagram_custom_api_token' );
		$access_token                        = isset( $_GET['access_token'], $_GET['feed_type'] ) && 'original_instagram' === $_GET['feed_type'] ? sanitize_text_field( $_GET['access_token'] ) : $access_token_basic;

		if ( isset( $_GET['access_token'] ) ) { ?>
		<script>
			jQuery(document).ready(function ($) {

				$('#fts_instagram_custom_api_token').val('');
				$('#fts_instagram_custom_api_token').val($('#fts_instagram_custom_api_token').val() + '<?php echo esc_js( $access_token ); ?>');

                <?php if ( 'original_instagram' === $_GET['feed_type'] ){ ?>
                    $('#fts_instagram_custom_id').val('');
                    var str = '<?php echo esc_js( $access_token ); ?>';
                    $('#fts_instagram_custom_id').val($('#fts_instagram_custom_id').val() + str.split('.', 1));
                <?php }
                elseif ( 'instagram_basic' === $_GET['feed_type'] ){ ?>

                    $('#fts_instagram_custom_id').val('');
                    $('#fts_instagram_custom_id').val($('#fts_instagram_custom_id').val() + '<?php echo esc_js( $user_id_basic ); ?>');
               <?php } ?>
			});
		</script>
		<?php } ?>
		<div class="feed-them-social-admin-wrap">
			<h1>
				<?php esc_html_e( 'Instagram Feed Options', 'feed-them-social' ); ?>
			</h1>
			<div class="use-of-plugin">
				<?php esc_html_e( 'Get your Access Token and add a follow button and position it using the options below.', 'feed-them-social' ); ?>
			</div>
			<!-- custom option for padding -->
			<form method="post" class="fts-facebook-feed-options-form" action="options.php" id="fts-instagram-feed-options-form">
				<?php
				$fts_fb_options_nonce = wp_create_nonce( 'fts-instagram-options-page-nonce' );

				if ( wp_verify_nonce( $fts_fb_options_nonce, 'fts-instagram-options-page-nonce' ) ) {
					?>

				<div class="feed-them-social-admin-input-wrap" style="padding-top:0px; ">
					<div class="fts-title-description-settings-page">
					<?php
					// get our registered settings from the fts functions!
					settings_fields( 'fts-instagram-feed-style-options' );
					?>
						<h3>
						<?php esc_html_e( 'Instagram Basic API Token', 'feed-them-social' ); ?>
						</h3>
						<?php


                       // $insta_url = esc_url( 'https://api.instagram.com/v1/users/self/?access_token=' . $fts_instagram_access_token );

                        $insta_url = esc_url_raw( 'https://graph.instagram.com/me?fields=id,username&access_token=' . $fts_instagram_access_token );

						// Get Data for Instagram!
						$response = wp_remote_fopen( $insta_url );
						// Error Check!
						$test_app_token_response = json_decode( $response );

						//  echo '<pre>';
						//    print_r( $test_app_token_response );
						//   echo '</pre>';

						?>
						<p>
						<?php
						echo esc_html( 'This is required to make the Instagram Feed work. Click the button below and it will connect to your Instagram Account to get an access token. It will then return to this page and save it in the inputs below. After it finishes you will be able to generate your Instagram feed. Instagram Basic connections do not allow you to show Profile info or Heart/Comment counts. Please use the Instagram Business option to achieve that.', 'feed-them-social' );
						?>
						</p>
						<p>
						<?php

					    echo sprintf(
							esc_html( '%1$sLogin and get my Access Token%2$s', 'feed-them-social' ),
							'<a href="' . esc_url( 'https://api.instagram.com/oauth/authorize?app_id=206360940619297&redirect_uri=https://www.slickremix.com/instagram-basic-token/&response_type=code&scope=user_profile,user_media&state=' . admin_url( 'admin.php?page=fts-instagram-feed-styles-submenu-page' ) . '' ) . '" class="fts-instagram-get-access-token">',
							'</a>'
						);
						?>
						</p>
						<a href="<?php echo esc_url( 'mailto:support@slickremix.com' ); ?>" class="fts-admin-button-no-work" style="margin-top: 14px; display: inline-block"><?php esc_html_e( 'Button not working?', 'feed-them-social' ); ?></a>
					</div>

					<div class="fts-clear"></div>

					<div class="feed-them-social-admin-input-wrap" style="margin-bottom:0">
						<div class="feed-them-social-admin-input-label fts-instagram-border-bottom-color-label">
							<?php esc_html_e( 'Instagram ID', 'feed-them-social' ); ?>
						</div>
						<input type="text" name="fts_instagram_custom_id" class="feed-them-social-admin-input" id="fts_instagram_custom_id" value="<?php echo esc_attr( $fts_instagram_custom_id ); ?>"/>
						<div class="fts-clear"></div>
					</div>

					<div class="feed-them-social-admin-input-wrap">
						<div class="feed-them-social-admin-input-label fts-instagram-border-bottom-color-label">
							<?php
							esc_html_e( 'Access Token Required', 'feed-them-social' );

							if ( isset( $_GET['access_token'], $_GET['feed_type'] ) && 'original_instagram' === $_GET['feed_type'] || isset( $_GET['access_token'], $_GET['feed_type'] ) && 'instagram_basic' === $_GET['feed_type'] ) {
								// START AJAX TO SAVE TOKEN TO DB
                                $fts_functions->feed_them_instagram_save_token();
							}
							?>
						</div>

						<input type="text" name="fts_instagram_custom_api_token" class="feed-them-social-admin-input" id="fts_instagram_custom_api_token" value="<?php echo esc_attr( $access_token ); ?>"/>
						<div class="fts-clear"></div>
					</div>

					<div class="feed-them-social-admin-input-wrap fts-instagram-last-row" style="margin-top: 0; padding-top: 0">
						<?php
						// Error Check
						// if the combined streams plugin is active we won't allow the settings page link to open up the Instagram Feed, instead we'll remove the #feed_type=instagram and just let the user manually select the combined streams or single instagram feed.
						if ( is_plugin_active( 'feed-them-social-combined-streams/feed-them-social-combined-streams.php' ) ) {
							$custom_instagram_link_hash = '';
						} else {
							$custom_instagram_link_hash = '#feed_type=instagram';
						}

                        str_replace(".", ".", $fts_instagram_access_token, $count);

						if( ! empty( $fts_instagram_access_token ) && 0 !== $count ){
                            echo sprintf(
                                esc_html( '%1$sThe %2$sLegacy API will be depreciated as of March 31st, 2020%3$s in favor of the new Instagram Graph API and the Instagram Basic Display API. Please click the the button above to reconnect your account or you can connect as a Business account below. You must also generate a new shortcode and replace your existing one.%4$s', 'feed-them-social' ),
                                '<div class="fts-failed-api-token instagram-failed-message">',
                                '<a href="' . esc_url( 'https://www.instagram.com/developer/' ) . '" target="_blank">',
                                '</a>',
                                '</div>'
                            );
                        }
						elseif ( ! isset( $test_app_token_response->error ) && ! empty( $fts_instagram_access_token ) ) {
							echo sprintf(
								esc_html( '%1$sYour access token is working! Generate your shortcode on the %2$sSettings Page%3$s', 'feed-them-social' ),
								'<div class="fts-successful-api-token">',
								'<a href="' . esc_url( 'admin.php?page=feed-them-settings-page' . $custom_instagram_link_hash ) . '">',
								'</a></div>'
							);
						} elseif ( isset( $test_app_token_response->error ) && ! empty( $fts_instagram_access_token ) ) {
							$text = isset( $test_app_token_response->error->message ) ? $test_app_token_response->error->message : $test_app_token_response->error->message;
							echo sprintf(
								esc_html( '%1$sOh No something\'s wrong. %2$s Please try clicking the button again to get a new access token. If you need additional assistance please email us at support@slickremix.com %3$s', 'feed-them-social' ),
								'<div class="fts-failed-api-token instagram-failed-message">',
								esc_html( $text ),
								'</div>'
							);
						}

						$feed_type = isset( $_GET['feed_type'] ) ? $_GET['feed_type'] : '';

						if ( empty( $fts_instagram_access_token ) && 'original_instagram' !== $feed_type ) {
							echo sprintf(
								esc_html( '%1$sYou are required to get an access token to view your photos.%2$s', 'feed-them-social' ),
								'<div class="fts-failed-api-token instagram-failed-message">',
								'</div>'
							);
						}
						?>
					</div>
					<div class="fts-clear"></div>
				</div>





					<div id="fb-token-master-wrap" class="feed-them-social-admin-input-wrap" >
					<div class="fts-title-description-settings-page">
						<h3>
								<?php esc_html_e( 'Instagram Business API Token', 'feed-them-social' ); ?>
						</h3>
							<?php
							echo sprintf(
								esc_html( 'You must have your Instagram Account linked to a Facebook Business Page, this is required to make the Instagram Business Feed or Hashtag Feed work. %1$sRead Instructions%2$s. Once you have completed the instructions you can click the button below and it will connect to your Facebook Account to get an access token. It should return a Facebook page or list of pages you are admin of and display which ones are connected to Instagram. Choose one, then click save. The Instagram Business option will allow you to display your profile info and the Heart/Comment counts on your media.', 'feed-them-social' ),
								'<a target="_blank" href="' . esc_url( 'https://www.slickremix.com/docs/link-instagram-account-to-facebook/' ) . '">',
								'</a>'
							);
							?>
						<p>
							<?php

							// call to get instagram account attached to the facebook page
							// 1844222799032692 = slicktest fb page (dev user)
							// 1844222799032692?fields=instagram_business_account&access_token=
							// This redirect url must have an &state= instead of a ?state= otherwise it will not work proper with the fb app. https://www.slickremix.com/instagram-token/&state=.
							echo sprintf(
								esc_html( '%1$sLogin and get my Access Token%2$s', 'feed-them-social' ),
								'<a href="' . esc_url( 'https://www.facebook.com/dialog/oauth?client_id=1123168491105924&redirect_uri=https://www.slickremix.com/instagram-token/&state=' . admin_url( 'admin.php?page=fts-instagram-feed-styles-submenu-page' ) . '&scope=manage_pages,instagram_basic' ) . '" class="fts-facebook-get-access-token">',
								'</a>'
							);
							?>
						</p>

					</div>
					<a href="<?php echo esc_url( 'mailto:support@slickremix.com' ); ?>" target="_blank" class="fts-admin-button-no-work"><?php esc_html_e( 'Button not working?', 'feed-them-social' ); ?></a>
						<?php
						$test_app_token_id = get_option( 'fts_facebook_instagram_custom_api_token' );
						if ( ! empty( $test_app_token_id ) || ! empty( $test_app_token_id_biz ) ) {

							$test_app_token_url = array(
								'app_token_id' => 'https://graph.facebook.com/debug_token?input_token=' . $test_app_token_id . '&access_token=' . $test_app_token_id,
							);

							// Test App ID
							$test_app_token_response = $fts_functions->fts_get_feed_json( $test_app_token_url );
							$test_app_token_response = json_decode( $test_app_token_response['app_token_id'] );

							// echo '<pre>';
							// print_r($test_app_token_response);
							// echo '</pre>';
						}
						?>
					<div class="clear"></div>
					<div class="feed-them-social-admin-input-wrap fts-fb-token-wrap" id="fts-fb-token-wrap" style="margin-bottom:0px;">
						<div class="feed-them-social-admin-input-label fts-twitter-border-bottom-color-label">
							<?php esc_html_e( 'Instagram ID', 'feed-them-social' ); ?>
						</div>

						<input type="text" name="fts_facebook_instagram_custom_api_token_user_id" class="feed-them-social-admin-input" id="fts_facebook_instagram_custom_api_token_user_id" value="<?php echo esc_attr( get_option( 'fts_facebook_instagram_custom_api_token_user_id' ) ); ?>"/>
						<div class="clear" style="margin-bottom:10px;"></div>
						<div class="feed-them-social-admin-input-label fts-twitter-border-bottom-color-label">
							<?php esc_html_e( 'Access Token Required', 'feed-them-social' ); ?>
						</div>

						<input type="text" name="fts_facebook_instagram_custom_api_token" class="feed-them-social-admin-input" id="fts_facebook_instagram_custom_api_token" value="<?php echo esc_attr( get_option( 'fts_facebook_instagram_custom_api_token' ) ); ?>"/>
						<div class="clear"></div>

						<input type="text" hidden name="fts_facebook_instagram_custom_api_token_user_name" class="feed-them-social-admin-input" id="fts_facebook_instagram_custom_api_token_user_name" value="<?php echo esc_attr( get_option( 'fts_facebook_instagram_custom_api_token_user_name' ) ); ?>"/>
						<input type="text" hidden name="fts_facebook_instagram_custom_api_token_profile_image" class="feed-them-social-admin-input" id="fts_facebook_instagram_custom_api_token_profile_image" value="<?php echo esc_attr( get_option( 'fts_facebook_instagram_custom_api_token_profile_image' ) ); ?>"/>

						<div class="clear"></div>
						<?php
						if ( ! empty( $test_app_token_response ) && ! empty( $test_app_token_id ) ) {
							if ( isset( $test_app_token_response->data->is_valid ) || '(#100) You must provide an app access token or a user access token that is an owner or developer of the app' === $test_app_token_response->error->message ) {
								$fb_id   = get_option( 'fts_facebook_instagram_custom_api_token_user_id' );
								$fb_name = get_option( 'fts_facebook_instagram_custom_api_token_user_name' );
								echo '<div class="fts-successful-api-token fts-special-working-wrap">';

								if ( ! empty( $fb_id ) && ! empty( $fb_name ) && ! empty( $test_app_token_id ) ) {
									echo '<a href="' . esc_url( 'https://www.facebook.com/' . get_option( 'fts_facebook_instagram_custom_api_token_user_id' ) ) . '" target="_blank"><img border="0" height="50" width="50" class="fts-fb-page-thumb" src="' . get_option( 'fts_facebook_instagram_custom_api_token_profile_image' ) . '"/></a><h3><a href="' . esc_url( 'https://www.facebook.com/' . get_option( 'fts_facebook_custom_api_token_user_id' ) ) . '" target="_blank">' . wp_kses(
										$fb_name,
										array(
											'span' => array(
												'class' => array(),
											),
										)
									) . '</a></h3>';
								}

								echo sprintf(
									esc_html( 'Your access token is working! Generate your shortcode on the %1$sSettings Page%2$s', 'feed-them-social' ),
									'<a href="' . esc_url( 'admin.php?page=feed-them-settings-page' . $custom_instagram_link_hash ) . '">',
									'</a>'
								);

								echo '</div>';
							}
							if ( isset( $test_app_token_response->data->error->message ) && ! empty( $test_app_token_id ) || isset( $test_app_token_response->error->message ) && ! empty( $test_app_token_id ) && '(#100) You must provide an app access token or a user access token that is an owner or developer of the app' !== $test_app_token_response->error->message ) {
								if ( isset( $test_app_token_response->data->error->message ) ) {
									echo sprintf(
										esc_html( '%1$sOh No something\'s wrong. %2$s. Please click the button above to retrieve a new Access Token.%3$s', 'feed-them-social' ),
										'<div class="fts-failed-api-token">',
										esc_html( $test_app_token_response->data->error->message ),
										'</div>'
									);
								}
								if ( isset( $test_app_token_response->error->message ) ) {
									echo sprintf(
										esc_html( '%1$sOh No something\'s wrong. %2$s. Please click the button above to retrieve a new Access Token.%3$s', 'feed-them-social' ),
										'<div class="fts-failed-api-token">',
										esc_html( $test_app_token_response->error->message ),
										'</div>'
									);
								}

								if ( isset( $test_app_token_response->data->error->message ) && empty( $test_app_token_id ) || isset( $test_app_token_response->error->message ) && empty( $test_app_token_id ) ) {
									echo sprintf(
										esc_html( '%1$sTo get started, please click the button above to retrieve your Access Token.%2$s', 'feed-them-social' ),
										'<div class="fts-failed-api-token get-started-message">',
										'</div>'
									);
								}
							}
						} else {
							if ( ! isset( $_GET['return_long_lived_token'] ) || isset( $_GET['reviews_token'] ) ) {
								echo sprintf(
									esc_html( '%1$sTo get started, please click the button above to retrieve your Access Token.%2$s', 'feed-them-social' ),
									'<div class="fts-failed-api-token get-started-message">',
									'</div>'
								);
							}
						}
						?>
						<div class="clear"></div>

						<?php

						if ( isset( $_GET['return_long_lived_token'], $_GET['feed_type'] ) && ! isset( $_GET['reviews_token'] ) && 'instagram_basic' !== $_GET['feed_type'] ) {
							// Echo our shortcode for the page token list with loadmore button
							// These functions are on feed-them-functions.php!
							echo do_shortcode( '[fts_fb_page_token]' );

						}
						?>
					</div>

					<div class="clear"></div>
				</div>
				<!--/fts-facebook-feed-styles-input-wrap-->





				<div class="feed-them-social-admin-input-wrap">
					<div class="fts-title-description-settings-page">
						<h3>
						<?php esc_html_e( 'Follow Button Options', 'feed-them-social' ); ?>
						</h3>
					<?php esc_html_e( 'This will only show on regular feeds not combined feeds.', 'feed-them-social' ); ?>
					</div>
					<div class="feed-them-social-admin-input-label fts-instagram-text-color-label">
					<?php esc_html_e( 'Show Follow Button', 'feed-them-social' ); ?>
					</div>
					<select name="instagram_show_follow_btn" id="instagram-show-follow-btn" class="feed-them-social-admin-input">
						<option <?php echo selected( $fts_instagram_show_follow_btn, 'no', false ); ?> value="<?php echo esc_attr( 'no' ); ?>">
						<?php esc_html_e( 'No', 'feed-them-social' ); ?>
						</option>
						<option <?php echo selected( $fts_instagram_show_follow_btn, 'yes', false ); ?> value="<?php echo esc_attr( 'yes' ); ?>">
						<?php esc_html_e( 'Yes', 'feed-them-social' ); ?>
						</option>
					</select>
					<div class="fts-clear"></div>
				</div>
				<!--/fts-instagram-feed-styles-input-wrap-->

				<div class="feed-them-social-admin-input-wrap">
					<div class="feed-them-social-admin-input-label fts-instagram-text-color-label">
					<?php esc_html_e( 'Placement of the Buttons', 'feed-them-social' ); ?>
					</div>
					<select name="instagram_show_follow_btn_where" id="instagram-show-follow-btn-where" class="feed-them-social-admin-input">
						<option>
						<?php esc_html_e( 'Please Select Option', 'feed-them-social' ); ?>
						</option>
						<option
						'<?php echo selected( $fts_instagram_show_follow_btn_where, 'instagram-follow-above', false ); ?>
						'
						value="<?php echo esc_attr( 'instagram-follow-above' ); ?>">
					<?php esc_html_e( 'Show Above Feed', 'feed-them-social' ); ?>
						</option>
						<option
						'<?php echo selected( $fts_instagram_show_follow_btn_where, 'instagram-follow-below', false ); ?>
						'
						value="<?php echo esc_attr( 'instagram-follow-below' ); ?>">
					<?php esc_html_e( 'Show Below Feed', 'feed-them-social' ); ?>
						</option>
					</select>
					<div class="fts-clear"></div>
				</div>
				<!--/fts-instagram-feed-styles-input-wrap-->
					<?php if ( is_plugin_active( 'feed-them-premium/feed-them-premium.php' ) ) { ?>

				<div class="feed-them-social-admin-input-wrap">
					<div class="fts-title-description-settings-page">
						<h3>
							<?php esc_html_e( 'Load More Button Styles & Options', 'feed-them-social' ); ?>
						</h3>
					</div>
					<div class="feed-them-social-admin-input-wrap">
						<div class="feed-them-social-admin-input-label fts-fb-loadmore-background-color-label">
							<?php esc_html_e( 'Load More Button Color', 'feed-them-social' ); ?>
						</div>
						<input type="text" name="instagram_loadmore_background_color" class="feed-them-social-admin-input fb-loadmore-background-color-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}" id="instagram-loadmore-background-color-input" placeholder="#ddd" value="<?php echo esc_attr( get_option( 'instagram_loadmore_background_color' ) ); ?>"/>
						<div class="fts-clear"></div>
					</div>
					<!--/fts-instagram-feed-styles-input-wrap-->

					<div class="feed-them-social-admin-input-wrap">
						<div class="feed-them-social-admin-input-label fts-fb-border-bottom-color-label">
							<?php esc_html_e( 'Load More Button Text Color', 'feed-them-social' ); ?>
						</div>
						<input type="text" name="instagram_loadmore_text_color" class="feed-them-social-admin-input fb-loadmore-text-color-input color {hash:true,caps:false,required:false,adjust:false,pickerFaceColor:'#eee',pickerFace:3,pickerBorder:0,pickerInsetColor:'white'}" id="instagram-loadmore-text-color-input" placeholder="#ddd" value="<?php echo esc_attr( get_option( 'instagram_loadmore_text_color' ) ); ?>"/>
						<div class="fts-clear"></div>
					</div>
					<!--/fts-instagram-feed-styles-input-wrap-->

					<div class="feed-them-social-admin-input-wrap">
						<div class="feed-them-social-admin-input-label">
							<?php esc_html_e( '"Load More" Text', 'feed-them-social' ); ?>
						</div>
						<input type="text" name="instagram_load_more_text" class="feed-them-social-admin-input" id="instagram_load_more_text" placeholder="Load More" value="<?php echo esc_attr( get_option( 'instagram_load_more_text' ) ); ?>"/>
						<div class="clear"></div>
					</div>
					<!--/fts-instagram-feed-styles-input-wrap-->

					<div class="feed-them-social-admin-input-wrap">
						<div class="feed-them-social-admin-input-label">
							<?php esc_html_e( '"No More Photos" Text', 'feed-them-social' ); ?>
						</div>
						<input type="text" name="instagram_no_more_photos_text" class="feed-them-social-admin-input" id="instagram_no_more_photos_text" placeholder="No More Photos" value="<?php echo esc_attr( get_option( 'instagram_no_more_photos_text' ) ); ?>"/>
						<div class="clear"></div>
					</div>
					<!--/fts-instagram-feed-styles-input-wrap-->
					<?php } ?>
					<input type="submit" class="feed-them-social-admin-submit-btn" value="<?php esc_html_e( 'Save All Changes' ); ?>"/>
					<?php } ?>
			</form>
		</div>
		<!--/feed-them-social-admin-wrap-->

		<?php
	}
}//end class
