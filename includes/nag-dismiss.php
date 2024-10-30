<?php
/* Loads static resources from CDN or subdomain
*/
/* Prevent loading this file directly and/or if the class is already defined */
if ( ! defined( 'ABSPATH' ) )
	return;

if(!class_exists('Clinical_Nag_Dismiss') /*&& class_exists( 'TitanFramework' )*/ )//only if class doesn't exist and Titan Framework (plugin) is activated
{
        class Clinical_Nag_Dismiss
        {
            public function __construct(){
                add_action( 'init', array( $this, 'set_hook_functions' ), 99 );
                
            }
            
            function set_hook_functions(){
                if(is_admin()){
                    //get Clinical CMS options and add relevant hooks
                    $titan = TitanFramework::getInstance( 'clinical_cms' );
                    $nagVisComp = $titan->getOption( 'clinical_nag_viscomp' );
                    $nagTGMPA = $titan->getOption( 'clinical_nag_tgmpa' );
                    //'clinical_viscomp_ultaddons_nag' - used in wp-config for ultimate vis comp addons
                    $nagWPCore = $titan->getOption( 'clinical_nag_core' );
                    $nagWooThemes = $titan->getOption( 'clinical_nag_woo' );
                    $nagRevSlide = $titan->getOption( 'clinical_nag_revslide' );
                    $nagBackupBuddy = $titan->getOption( 'clinical_nag_backupbuddy' );

                    if( $nagVisComp ){
                        add_action( 'admin_head', array( $this, 'hide_viscomp' ) );
                    }
                    if( $nagTGMPA ){
                        add_action( 'admin_head', array( $this, 'hide_tgmpa' ), 99 );
                    }
                    /*
                    if( $nagWPCore ){
                        add_filter( 'admin_init', array( $this, 'set_wp_core_nag_admins' ), 1 );    
                    }
                    */        
                    if( $nagWooThemes ){
                        add_action( 'admin_head', array( $this, 'remove_woothemes_nag' ), 1 );    
                    }       
                    if( $nagRevSlide ){
                        add_action( 'admin_head', array( $this, 'hide_rev_slider' ), 1 );    
                    }       
                    if( $nagBackupBuddy ){
                        add_action( 'admin_head', array( $this, 'hide_backupbuddy_nag' ), 1 );    
                    }
                    
                }
            }
            
            function hide_viscomp(){
                //hide the visual composer dashboard nag
                echo "<style>#vc_license-activation-notice{display:none}</style>";
            }
            function hide_tgmpa(){
                echo "<style>#setting-error-tgmpa{display:none}</style>";
            }
            /*
            function set_wp_core_nag_admins(){
                //make core update notice only visible to admins
                //if(!current_user_can('update_core')){
                    remove_action( 'admin_notices', 'update_nag', 3 );
                    remove_action( 'admin_notices', 'maintenance_nag', 10 );
                    remove_action( 'network_admin_notices', 'maintenance_nag', 10 );
                //}
            }
            */
            function remove_woothemes_nag(){
                // Remove WooCommerce general nags
                echo "<style>.updated.woocommerce-message{display:none}</style>";
            }
            function hide_rev_slider(){
                // Remove WooCommerce general nags
                echo "<style>.rs-update-notice-wrap{display:none !important}</style>";
            }
            function hide_backupbuddy_nag(){
                //removes the update notice but may need css for other type if present
                echo "<style>.pb_backupbuddy_alert{display:none !important}</style>";
            }
            
        } // END class Clinical_Nag_Dismiss
}
if(class_exists('Clinical_Nag_Dismiss'))
{// instantiate the plugin class
    $clinical_nag_dismiss = new Clinical_Nag_Dismiss();
}

?>