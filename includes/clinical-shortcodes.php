<?php
/* Prevent loading this file directly and/or if the class is already defined */
if( ! defined( 'ABSPATH' ) )
	return;

if(!class_exists('Clinical_Shortcodes')){
    class Clinical_Shortcodes
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {/* hook up actions */
            add_shortcode( 'email', array('Clinical_Shortcodes', 'clinical_obfuscate_email_shortcode'));
        }
        
        function clinical_obfuscate_email_shortcode( $atts , $content = null ) {
            if ( ! is_email( $content ) ) {
                return;
            }

            $a = shortcode_atts( array(
                'recipient' => $content,
            ), $atts );

            return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
        }

        //Usage: [email recipient='name@domain.com']link text here[/email]
    }
}

if( class_exists('Clinical_Shortcodes') )
{
    // instantiate the plugin class
    $clinical_shortcodes = new Clinical_Shortcodes();
}

?>