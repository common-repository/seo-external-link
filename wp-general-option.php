<?php

if ( !defined( 'ABSPATH' ) ) exit;

class WP_Safe_External_Link_Settings {

	public function __construct() {
		add_action( 'admin_init' , array( $this , 'register_fields' ) );
	}

	public function register_fields( ) {
		register_setting( 'general', 'wp_safe_external_link' );
		add_settings_field(
			'wp_safe_external_link_id',
			'<label for="wp_safe_external_link_id">' . __( '安全链接设置' , 'wp_safe_external_link' ) . '</label>',
			array( $this, 'fields_html' ),
			'general'
		);
	}

	public function fields_html( ) {
		$options = get_option( 'wp_safe_external_link' );
	?>
		<p><label for="wp_safe_external_link_id">设置安全域名列表,只需要填写域名即可，无需 http 或 https 等协议，如: www.imahui.com，每个域名一行</label></p>
		<p><textarea name="wp_safe_external_link" rows="10" cols="50" id="wp_safe_external_link_id" class="large-text code"><?php echo esc_textarea( $options ); ?></textarea></p>
	<?php }

}