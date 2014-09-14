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

	
	public function instance() {

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
				plugins_url( '/styles/default.css', __FILE__ ),
			);

		wp_enqueue_style( 
			'highligh-js-style', 
			$highlight_css,
			array(), 
			'8.2'
		);

		wp_register_script( 
			'highligh-js', 
			plugins_url( '/js/highlight.min.js', __FILE__ ),
			false,
			'8.2', 
			true
		);

		$init_script = apply_filters(
				'highlight-js-init',
				'hljs.initHighlightingOnLoad();'
			);

		$wp_scripts->add_data( 
				'highligh-js', 
				'data', 
				 $init_script
			);

		wp_enqueue_script( 'highligh-js' );

	}


}

