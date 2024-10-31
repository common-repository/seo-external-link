<?php
/**
 * Plugin Name: SEO External Link
 * Plugin URI: https://www.imahui.com/design/2675.html
 * Description: 丸子小程序团队开发 WordPress 文章链接跳转安全提示页面，WordPress 网站 SEO 外部链接跳转功能
 * Version: 22.12.15
 * Author: 艾码汇
 * Author URI: https://www.imahui.com
 * requires at least: 6.1.1
 * tested up to: 5.9.3
 * requires PHP: 5.6
 * License: Dual licensed under the MIT and GPLv2+ licenses
 * Text Domain: seo-external-link
**/

define( 'EXTERNAL_LINK_FILE',  __FILE__ );
define( 'EXTERNAL_LINK_PATH', plugin_dir_path( __FILE__ ) );

include( EXTERNAL_LINK_PATH . 'wp-general-option.php' );
include( EXTERNAL_LINK_PATH . 'wp-external-golink.php' );

add_filter( 'plugin_action_links', function( $links, $file ) {
	if ( plugin_basename( __FILE__ ) !== $file ) {
		return $links;
	}
	$settings_link = '<a href="'.admin_url('options-general.php').'">' . esc_html(__( '设置', 'imahui' ) ). '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}, 10, 2 );

add_filter( 'plugin_row_meta', function( $links, $file ) {
	if ( plugin_basename( __FILE__ ) !== $file ) {
		return $links;
	}
	$minprogram_link = sprintf( '<a href="%s" target="%s" aria-label="%s" data-title="%s">%s</a>',
		esc_url( 'https://www.weitimes.com' ),
		esc_attr( "_blank" ),
		esc_attr( '更多关于 丸子小程序 的信息' ),
		esc_attr( '丸子小程序' ),
		esc_html( '丸子小程序' )
	);
	$mtheme_link = sprintf( '<a href="%s" target="%s" aria-label="%s" data-title="%s">%s</a>',
		esc_url( 'https://www.wpstorm.cn' ),
		esc_attr( "_blank" ),
		esc_attr( '更多关于 WordPress 小程序主题下载 的信息' ),
		esc_attr( 'WordPress 小程序主题下载' ),
		esc_html( ' WordPress 小程序' )
	);
	$more_link = array( 'miniprogram' => $minprogram_link, 'mtheme' => $mtheme_link );
	$links = array_merge( $links, $more_link );
	return $links;
}, 10, 2 );


add_action('init', function () {
    if( class_exists('WP_Safe_External_Link_Settings') ) {
        new WP_Safe_External_Link_Settings( );
    }
});

add_filter('the_content', function ( $content ) {
    $external = get_option( 'wp_safe_external_link' );
	$external = explode(PHP_EOL, $external);
	$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>";
	if( preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER) ) {
        for ( $i=0; $i < count($matches); $i++ ) {
			$target = '';
			$follow = '';
            $tag  = $matches[$i][0];
            $url  = $matches[$i][0];
			$pattern = '/target\s*=\s*"\s*_(blank|parent|self|top)\s*"/';
			if( preg_match($pattern, $url) === 0 ) {
				$target .= ' target="_blank"';
			}
			if( $target ) {
				$tag = substr_replace($tag, $target.'>', -1);
			}
			$content = str_replace($url, $tag, $content);
        }
	}
	preg_match_all('/href="(.*?)"/', $content, $links);
	if( $links ) {
		foreach($links[1] as $link) {
			$uri = wp_parse_url( $link );
		    if( in_array( $uri['host'], $external ) ) {
			    continue;
			}
			if( strpos( home_url( ), $uri['host'] ) === false && strpos( $link, "http" ) !== false && strpos( $link, "//" ) !== false  ) {
				$content = str_replace("href=\"$link\"", "href=\"" .esc_html( home_url( ). "/?target=" .str_replace('?', '&', $link) ). "\"", $content);
			}
		}
	}
	return $content;
}, 11);

add_filter( 'query_vars', function ( $vars ) {
    $vars[] = 'target';
	return $vars;
});
add_action('template_redirect', function ( ) {
    if( get_query_var('target') ) {
	    wp_seo_exterlnal_golink_html( );
	    exit;
	}
});
