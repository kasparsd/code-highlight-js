<?php
/*
	Plugin Name: Code Highlight.js
	Plugin URI: https://github.com/kasparsd/code-highlight-js
	GitHub URI: https://github.com/kasparsd/code-highlight-js
	Description: Automatic code syntax highlighting using the Highlight.js library.
	Version: 1.1
	Author: Kaspars Dambis
	Author URI: http://kaspars.net
*/


CodeHighlightJs::instance();


class CodeHighlightJs {

	
	static function instance() {

		static $instance;

		if ( ! $instance )
			$instance = new self();

		return $instance;

	}


	private function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );

		add_action( 'admin_init', array( $this, 'register_admin_settings' ) );

	}


	function add_scripts() {
		
		global $wp_scripts;

		$highlight_stylesheet = get_option( 'highlight-js-style', 'default.css' );

		wp_enqueue_style( 
			'highligh-js-style', 
			apply_filters( 'highlight-js-style-uri', plugins_url( '/styles/' . $highlight_stylesheet, __FILE__ ) ),
			null, 
			'8.4-default'
		);

		wp_enqueue_script( 
			'highligh-js', 
			plugins_url( '/js/highlight.min.js', __FILE__ ),
			null,
			'8.4', 
			true
		);

	}


	function register_admin_settings() {

		add_settings_field(
			'highlight-js-style',
			__( 'Highlight.js Stylesheet', 'highlight-js' ),
			array( $this, 'admin_settings_callback' ),
			'reading',
			'default'
		);

		register_setting( 
			'reading', 
			'highlight-js-style', 
			'esc_attr' 
		);

	}


	function admin_settings_callback() {

		$stylesheet = get_option( 'highlight-js-style', 'default.css' );
		$style_files = glob( dirname( __FILE__ ) . '/styles/*.css' );

		$options = array();

		foreach ( $style_files as $style_file ) {
			
			$id = basename( $style_file );

			$options[] = sprintf( 
				'<option value="%s" %s>%s</option>',
				esc_attr( $id ),
				selected( $id, $stylesheet, false ),
				esc_html( $id )
			);

		}

		printf(
			'<select name="highlight-js-style">
				%s
			</select>',
			implode( '', $options )
		);

	}


}

