<?php

/**
 * This file is part of EksellChild, eksell child theme.
 *
 * All functions of this file will be loaded before of parent theme functions.
 * Learn more at https://codex.wordpress.org/Child_Themes.
 *
 * Note: this function loads the parent stylesheet before, then child theme stylesheet
 * (leave it in place unless you know what you are doing.)
 *
 * @package eksell
 */

if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {

	/**
	 * Enqueue styles.
	 */
	function suffice_child_enqueue_child_styles() {
		// loading parent style.
		wp_register_style(
			'parente2-style',
			get_template_directory_uri() . '/style.css'
		);

		wp_enqueue_style( 'parente2-style' );

		// loading child style.
		wp_register_style(
			'childe2-style',
			get_stylesheet_directory_uri() . '/style.css'
		);
		wp_enqueue_style( 'childe2-style' );
	}
}
add_action( 'wp_enqueue_scripts', 'suffice_child_enqueue_child_styles' );

if ( ! class_exists( 'AmpMenu' ) ) {

	/**
	 * Class AMP Menu.
	 */
	class AmpMenu extends Walker_Nav_Menu {

		/**
		 * Starts the element output.
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param int    $depth Depth of menu item. Used for padding.
		 * @param array  $args An object of wp_nav_menu() arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "\n<div class='sub-menu-holder '>$indent<ul class=\"sub-menu\"  aria-expanded=\"true\" [class]=\"'sub-menu' + (ampsubmenu ? ' ampsubmenu_visible' : ' ampsubmenu_not_visible ') \">\n";

		}

		/**
		 * End of the element output.
		 *
		 * @param string $output Used to append additional content (passed by reference).
		 * @param int    $depth Depth of menu item. Used for padding.
		 * @param array  $args An object of wp_nav_menu() arguments.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			$output .= "$indent</ul></div>\n";

		}
	}

}

	/**
	* Don't run scripts on AMP URLs
	*/
	add_action(
		'wp_enqueue_scripts',
		function() {
			if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
				wp_dequeue_script( 'ajaxurl' );
				wp_dequeue_script( 'eksell-construct' );

			}
		},
		15
	);

	add_action(
		'wp',
		function() {
			if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
				remove_action( 'wp_head', 'eksell_no_js_class', 0 );
			};

			/* remove fuction from parent */
			remove_filter( 'nav_menu_item_args', 'eksell_filter_nav_menu_item_args', 10, 3 );
			/* and replace with AMP compatible alternative */
		}
	);

	if ( ! function_exists( 'eksell_filter_nav_menu_item_args' ) ) :
		/**
		 *
		 * FILTER NAV MENU ITEM ARGUMENTS
		 * Add a sub navigation toggle to the main menu.
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		function eksell_filter_nav_menu_item_args_ampchildtheme( $args, $item, $depth ) {

			// Add sub menu toggles to the main menu with toggles.
			if ( $args->theme_location == 'main' && isset( $args->show_toggles ) ) {

				// Wrap the menu item link contents in a div, used for positioning.
				$args->before = '<div class="ancestor-wrapper">';
				$args->after  = '';

				// Add a toggle to items with children.
				if ( in_array( 'menu-item-has-children', $item->classes ) ) {

					$toggle_target_string = '.menu-modal .menu-item-' . $item->ID . ' &gt; .sub-menu';

					// Add the sub menu toggle.
					$args->after .= '<div class="sub-menu-toggle-wrapper" ><a href="#" on="tap:AMP.setState({ampsubmenu: !ampsubmenu})" class="toggle sub-menu-toggle stroke-cc" [class]="\'toggle sub-menu-toggle stroke-cc\' + (ampsubmenu ? \' active \' : \'  \')" data-toggle-target="' . $toggle_target_string . '" data-toggle-type="slidetoggle" data-toggle-duration="250" [aria-pressed]="ampsubmenu ? \'true\' : \'false\'" ><span class="screen-reader-text">' . esc_html__( 'Show sub menu', 'eksell' ) . '</span>' . eksell_get_theme_svg( 'ui', 'chevron-down', 18, 10 ) . '</a></div>';

				}

				// Close the wrapper.
				$args->after .= '</div><!-- .ancestor-wrapper -->';

			}

			return $args;

		}
		add_filter( 'nav_menu_item_args', 'eksell_filter_nav_menu_item_args_ampchildtheme', 10, 3 );
endif;
