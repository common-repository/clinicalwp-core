<?php
/**
Plugin Name: ClinicalWP Custom Admin
Description: Custom color schemes for the admin area.
Version: 1.0
Author: Code Clinic KreativAgentur
Text Domain: admin_schemes
Domain Path: /languages
*/

/*
Copyright 2013 Dave Warfel

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class Custom_Color_Schemes {

	/**
	 * List of colors registered in this plugin.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $colors List of colors registered in this plugin. 
	 *                    Needed for registering colors-fresh dependency.
	 */
	private $colors = array( 
		'ClinicalWP'
	);

	function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'load_clinical_default_css' ) );
		add_action( 'admin_init' , array( $this, 'add_clinical_colors' ) );
	}

	/**
	 * Register color schemes.
	 */
	function add_clinical_colors() {
		/**
		* Get Titan Framework / ClinicalWP Options
		*/
		$titan = TitanFramework::getInstance( 'clinical_cms' );
		$adminCustomTheme = $titan->getOption( 'clinical_admin_skin' );
		$adminColorScheme = $titan->getOption( 'clinical_admin_colour_scheme' );
		
		if($adminCustomTheme){
			$suffix = is_rtl() ? '-rtl' : '';

			wp_admin_css_color( 
				'ClinicalWP', __( 'ClinicalWP', 'admin_schemes' ), 
				plugins_url( "clinicalwp/colors$suffix.css", __FILE__ ),
				array( '#26292C', '#2EE3F5', '#FF8D3B', '#f47920' ),
				array( 'base' => '#26292C', 'focus' => '#f47920', 'current' => '#20E1F4' )
			);
			
			if($adminColorScheme){
				// remove the color scheme picker
				//remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
				// force all users to use the "Ectoplasm" color scheme
				add_filter( 'get_user_option_admin_color', function() {
					return 'ClinicalWP';
				});
			}
			
		}
		

	}

	/**
	 * Make sure core's default `colors.css` gets enqueued, since we can't
	 * @import it from a plugin stylesheet. Also force-load the default colors 
	 * on the profile screens, so the JS preview isn't broken-looking.
	 */ 
	function load_clinical_default_css() {
		/**
		* Get Titan Framework / ClinicalWP Options
		*/
		$titan = TitanFramework::getInstance( 'clinical_cms' );
		$adminCustomTheme = $titan->getOption( 'clinical_admin_skin' );
		
		if($adminCustomTheme){
			global $wp_styles, $_wp_admin_css_colors;

			$color_scheme = get_user_option( 'admin_color' );

			$scheme_screens = apply_filters( 'acs_picker_allowed_pages', array( 'profile', 'profile-network' ) );
			if ( in_array( $color_scheme, $this->colors ) || in_array( get_current_screen()->base, $scheme_screens ) ){
				$wp_styles->registered[ 'colors' ]->deps[] = 'colors-fresh';
			}
		}
	}
	

}
global $acs_colors;
$acs_colors = new Custom_Color_Schemes;