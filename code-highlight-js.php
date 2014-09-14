<?php
/*
	Plugin Name: Code Highlight.js
	Plugin URI: https://github.com/kasparsd/code-highlight-js
	GitHub URI: https://github.com/kasparsd/code-highlight-js
	Description: Automatic code syntax highlighting using the Highlight.js library.
	Version: 0.1
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

	}


	function add_scripts() {
		
		global $wp_scripts;

		$highlight_css = apply_filters( 
				'highlight-js-style-uri', 
				plugins_url( '/styles/default.css', __FILE__ )
			);

		wp_enqueue_style( 
			'highligh-js-style', 
			$highlight_css,
			array(), 
			'8.2'
		);

		wp_enqueue_script( 
			'highligh-js', 
			plugins_url( '/js/highlight.min.js', __FILE__ ),
			null,
			'8.2', 
			true
		);

	}


}

