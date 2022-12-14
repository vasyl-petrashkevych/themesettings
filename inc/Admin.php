<?php

namespace ThemeSettings {
	class Admin {
		private const OPTIONS_PAGE_URL = 'options-general.php?page=theme_options';

		public static function init() {
			add_action( 'admin_menu', [ 'ThemeSettings\Admin', 'admin_menu' ] );
			add_action( 'admin_init', [ 'ThemeSettings\Admin', 'admin_init' ] );
			add_action( 'admin_enqueue_scripts', [ 'ThemeSettings\Admin', 'register_scripts' ] );

			add_filter( 'plugin_action_links_themeoptions/index.php', [
				'ThemeSettings\Admin',
				'add_action_links'
			] );
		}

		public static function admin_init() {
			load_plugin_textdomain( Helpers::TEXT_DOMAIN );
		}

		public static function admin_menu() {
			add_options_page(
				Helpers::__( 'Theme Options' ),
				Helpers::__( 'Theme Options' ),
				'manage_options',
				'theme_options',
				[ 'ThemeSettings\Admin', 'options_page_content' ],
			);
		}

		public static function add_action_links( $actions ): array {
			$links = [
				'<a href="' . admin_url( self::OPTIONS_PAGE_URL ) . '">' . Helpers::__( 'Settings' ) . '</a>',
				'<a href="' . Helpers::README_LINK . '" target="_blank">' . Helpers::__( 'Documentation' ) . '</a>',
			];

			return array_merge( $links, $actions );
		}

		public static function admin_bar_menu( \WP_Admin_Bar $admin_bar ) {
			$admin_bar->add_menu( [
				'id'     => 'menu-id',
				'parent' => null,
				'group'  => null,
				'title'  => Helpers::__( 'Theme Options' ),
				'href'   => admin_url( self::OPTIONS_PAGE_URL ),
				'meta'   => [
					'title' => Helpers::__( 'Theme Options' ), //This title will show on hover
				]
			] );
		}

		public static function register_scripts() {
			if ( THEME_OPTIONS_ENV === 'development' ) {
				wp_register_style( Helpers::TEXT_DOMAIN, THEME_OPTIONS_URI . 'assets/css/main.css', [], THEME_OPTIONS_VERSION );
				wp_register_style( Helpers::TEXT_DOMAIN . '_vendor', THEME_OPTIONS_URI . 'assets/css/vendor.css', [], THEME_OPTIONS_VERSION );
				wp_register_script( Helpers::TEXT_DOMAIN, THEME_OPTIONS_URI . 'assets/js/main.js', [], THEME_OPTIONS_VERSION, true );
				wp_register_script( Helpers::TEXT_DOMAIN . '_vendor', THEME_OPTIONS_URI . 'assets/js/vendor.js', [], THEME_OPTIONS_VERSION, true );
			} else {
				wp_register_style( Helpers::TEXT_DOMAIN, THEME_OPTIONS_URI . 'assets/css/main.min.css', [], THEME_OPTIONS_VERSION );
				wp_register_style( Helpers::TEXT_DOMAIN . '_vendor', THEME_OPTIONS_URI . 'assets/css/vendor.min.css', [], THEME_OPTIONS_VERSION );
				wp_register_script( Helpers::TEXT_DOMAIN, THEME_OPTIONS_URI . 'assets/js/main.min.js', [], THEME_OPTIONS_VERSION, true );
				wp_register_script( Helpers::TEXT_DOMAIN . '_vendor', THEME_OPTIONS_URI . 'assets/js/vendor.min.js', [], THEME_OPTIONS_VERSION, true );
			}
			wp_enqueue_media();
			wp_localize_script(
				Helpers::TEXT_DOMAIN,
				Helpers::TEXT_DOMAIN . 'Plugin',
				[
					'version' => THEME_OPTIONS_VERSION,
					'title'   => Helpers::__( 'Theme Options' ),
					'url'     => THEME_OPTIONS_URI,
				]
			);
			wp_localize_script(
				Helpers::TEXT_DOMAIN,
				Helpers::TEXT_DOMAIN . 'ApiNonce',
				[
					'root'  => esc_url_raw( rest_url() ),
					'nonce' => wp_create_nonce( 'wp_rest' ),
				]
			);
		}

		public static function options_page_content() { ?>
            <div class="wrap">
                <div id="root"></div>
            </div>
			<?php
			wp_enqueue_script( Helpers::TEXT_DOMAIN );
			wp_enqueue_script( Helpers::TEXT_DOMAIN . '_vendor' );
			wp_enqueue_style( Helpers::TEXT_DOMAIN );
			wp_enqueue_style( Helpers::TEXT_DOMAIN . '_vendor' );
		}
	}
}
