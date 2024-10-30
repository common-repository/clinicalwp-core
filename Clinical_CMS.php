<?php
/*
    Plugin Name: ClinicalWP Core
    Plugin URI: https://clinicalwp.com/
    Author: Code Clinic KreativAgentur
    Author URI: https://codeclinic.de/
    Description: Plugin for implementing ClinicalWP core customisations including; Speed Enhancements, Increased Security, Image Enhancements, Support Panels and much more.
    //OLD Version: 3.7.9
    Version: 1.0.5
    Requires at least: 3.9
    Tested up to: 5.2.2
    Requires PHP: 5.0
    Stable tag: 1.0.5
    Contributors: munklefish, missmanylayers, clinicalwp, codeclinic, freemius
    Text Domain: Clinical-CMS-Core
    Domain Path: /languages/
 */

/* Prevent loading this file directly and/or if the class is already defined */
if (!defined('ABSPATH'))
    return;

define('CWP_Version', "1.0.5");

//include titan-framework locally
//require_once(dirname(__FILE__) . '/titan-framework/titan-framework-embedder.php');
    
require_once('titan-framework-checker.php');

//register Freemius Deployment
if (!function_exists('ccp_fs')) {

    /* CWP CUSTOM FIX CODE - If this is free version*/
    //if (plugin_basename(__FILE__) == "clinicalwp-core/Clinical_CMS.php") {
        //fixes strange issue that results in no CWP menu showing
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        //force TitanFramework to reactivate
        //if (is_plugin_active('titan-framework/titan-framework.php')) {
            deactivate_plugins('titan-framework/titan-framework.php');
        //}
        //if (!is_plugin_active('titan-framework/titan-framework.php')) {
            activate_plugins('titan-framework/titan-framework.php');
        //}
    //} 

    // Create a helper function for easy SDK access.
    function ccp_fs()
    {
        global $ccp_fs;

        if ( ! isset( $ccp_fs ) ) {
            // Activate multisite network integration.
            if ( ! defined( 'WP_FS__PRODUCT_3712_MULTISITE' ) ) {
                define( 'WP_FS__PRODUCT_3712_MULTISITE', true );
            }

            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $ccp_fs = fs_dynamic_init( array(
                'id'                  => '3712',
                'slug'                => 'clinicalwp-core',
                'premium_slug'        => 'z_clinicalwp-core-pro',
                'type'                => 'plugin',
                'public_key'          => 'pk_54df5f65b15d69c5482864731e7b3',
                'is_premium'          => false,
                'has_addons'          => true,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'clinicalwp',
                    'first-path'     => 'plugins.php',
                ),
                'bundle_id'           => '3745', 
            ) );
        }

        return $ccp_fs;
    }

    // Init Freemius.
    ccp_fs();
    // Signal that SDK was initiated.
    do_action('ccp_fs_loaded');
}

/************************************************************************************/
/*                                                                                  */
/*                          WP CONFIG SETTINGS                                      */
/*                                                                                  */
/************************************************************************************/

/** Set the config values unless the constant was set in wp-config.php */

//require_once('titan-framework-checker.php');

if (!class_exists('Clinical_CMS_Core_Plugin') && class_exists('TitanFramework') ) //only if class doesn't exist, Titan Framework (plugin) is activated and API activated
{

    //include titan-framework locally
    //require_once('titan-framework/titan-framework-embedder.php');

    
    
    require_once('includes/admin-colour-scheme/custom-admin-color-schemes.php');
    /**
     * Include the TGM_Plugin_Activation class.
     */
    require_once(dirname(__FILE__) . '/includes/tgmpa/class-tgm-plugin-activation.php');
    add_action('tgmpa_register', 'clinical_register_required_plugins');

    //include the sitemap scripts
    require_once(dirname(__FILE__) . '/includes/sitemap.php');

    //include the stats
    require_once(dirname(__FILE__) . '/includes/stats.php');

    //include browser caching & other wp-config based tweaks
    require_once(dirname(__FILE__) . '/includes/wp-config_htacess_scripts.php');

    //PH added this in to try and return missing features
    #require_once( dirname( __FILE__) . '/includes/caching-optimisations.php' );

    //load the Javascript & CSS sorting code
    require_once(dirname(__FILE__) . '/includes/optimise-styles-js.php');

    //include html minify
    require_once(dirname(__FILE__) . '/includes/html-minify.php');

    //include image alt generator
    require_once(dirname(__FILE__) . '/includes/generate-alt-tags.php');

        //include the WordPress core scripts replacement
        require_once(dirname(__FILE__) . '/includes/cdn-wordpress.php');

        //include cdn / subdomain script
        require_once(dirname(__FILE__) . '/includes/cdn-subdomain.php');

        //include GeoLocation data
        require_once(dirname(__FILE__) . '/includes/geolocation.php');

    //include appearance script
    require_once(dirname(__FILE__) . '/includes/appearance.php');

        //include external link script
        require_once(dirname(__FILE__) . '/includes/links.php');


    //include shortcodes script
    require_once(dirname(__FILE__) . '/includes/clinical-shortcodes.php');

    //include nag removal scripts
    require_once(dirname(__FILE__) . '/includes/nag-dismiss.php');

    //include nag removal scripts
    require_once(dirname(__FILE__) . '/includes/cron-schedules.php');

    //include update checker
    require_once(dirname(__FILE__) . '/includes/required-updates.php');

    /**
     * Register the required plugins for this theme.
     * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
     */
    function clinical_register_required_plugins()
    {
        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = /*$array1 =*/ array(
            'name' => 'cache-enabler',
            'slug' => 'cache-enabler',
            'required' => false,
        );
/*
        if (is_plugin_active('z_clinicalwp-core-pro/Clinical_CMS.php')) {
            $array2 = array(
                'name'      => 'clinicalwp-core',
                'slug'      => 'clinicalwp-core',
                'required'  => true,
            );
        }
        $plugins = array($array1, $array2);
*/
        /*
         * Array of configuration settings. Amend each line as needed.
         *
         * TGMPA will start providing localized text strings soon. If you already have translations of our standard
         * strings available, please help us make TGMPA even better by giving us access to these translations or by
         * sending in a pull-request with .po file(s) with the translations.
         *
         * Only uncomment the strings in the config array if you want to customize the strings.
         */
        $config = array(
            'id' => 'Clinical-CMS-Core',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu' => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug' => 'plugins.php',            // Parent menu slug.
            'capability' => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices' => true,                    // Show admin notices or not.
            'dismissable' => false,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => true,                   // Automatically activate plugins after installation or not.
            'message' => '',                      // Message to output right before the plugins table.

        );

        tgmpa($plugins, $config);
    }

    class Clinical_CMS_Core_Plugin
    {
        //var $c;
        /**
         * Construct the plugin object
         */
        public function __construct()
        {

            require_once(trailingslashit(plugin_dir_path(__FILE__)) . 'includes/shortcodes_tinyMCE.php');


            //our new collected function
            add_action('tf_create_options', array($this, 'clinical_tf_create_options'));
            //do this when options are saved in ClinicalWP
            add_action('tf_save_admin_clinical_cms', array($this, 'clinical_save_admin'), 10, 3);

            add_action('init', array($this, 'clinical_init'));
            add_action('admin_init', array($this, 'clinical_admin_init'));
            //add_action( 'admin_menu', array($this, 'clinical_admin_menu' ));
            add_action('admin_head', array($this, 'clinical_admin_head'));
            add_action('admin_enqueue_scripts', array($this, 'clinical_admin_enqueue_scripts'));
            //add_action('activity_box_end', array($this, 'clinical_add_activity_info'), 1);
            add_action('CCK_Status_Feed', array($this, 'clinical_add_activity_info'), 1);
            add_action('login_enqueue_scripts', array($this, 'clinical_login_enqueue_scripts'));
            //add_action('welcome_panel', array($this, 'clinical_welcome_panel'));
            add_action('wp_enqueue_scripts', array($this, 'clinical_wp_enqueue_scripts'));
            add_action('admin_notices', array($this, 'clinical_admin_notices'));
            add_action('wp_head', array($this, 'clinical_wp_head'));
            add_action('wp_dashboard_setup', array($this, 'clinical_wp_dashboard_setup'));
            add_action('admin_print_styles', array($this, 'clinical_admin_print_styles'));
            add_action('admin_bar_menu', array($this, 'clinical_admin_bar_menu'));
            add_action('wp_before_admin_bar_render', array($this, 'clinical_wp_before_admin_bar_render'));
            add_action('pre_ping', array($this, 'clinical_pre_ping'));
            add_action('login_head', array($this, 'clinical_login_head'));
            //add_action( 'media_upload_tab_slug', array($this, 'clinical_media_upload_tab_slug' ));
            //add_action( 'admin_footer', array($this, 'clinical_admin_footer' ));
            //add_action( 'after_setup_theme', array($this, 'clinical_after_setup_theme'), 999 );
            //add_action( 'tgmpa_register', array($this, 'clinical_tgmpa_register')  );


            remove_action('welcome_panel', 'wp_welcome_panel');

            // Remove the WordPress Generator
            //remove_action('wp_head', 'wp_generator');
            add_action('save_post', array($this, 'clinical_force_featured_image'));
            add_action('admin_notices', array($this, 'clinical_force_featured_error'));

            //add dashboard stats
            $cs = new Clinical_Stats(); //create new stats instance
            add_action('admin_head-index.php', array($cs, 'cc_add_JQuery_Script'));

            // register actions
            add_filter('CMS_Ver_ID', array($this, 'return_CMS_Ver_ID'));
            //add_action( 'admin_init', array($this, 'disable_drag_metabox' ) );
            add_filter('update_footer', array($this, 'change_footer_version'), 9999);
            //set the WP email sender name and account
            add_filter('wp_mail_from', array($this, 'clinical_mail_from'));
            add_filter('wp_mail_from_name', array($this, 'clinical_mail_from_name'));
            //set the SMTP server to use
            add_action('phpmailer_init', array($this, 'clinical_mail_override'));
            //add_filter('admin_footer_text', array($this, 'remove_footer_admin'), 999);
            add_filter('plugin_action_links', array($this, 'clinical_lock_plugins'), 50, 4);
            add_filter('tiny_mce_before_init', array($this, 'plaintextpaste_tinymce_default'));
            //add featured image yes/no column
            add_filter('manage_posts_columns', array($this, 'Clinical_add_post_thumbnail_column'), 5);
            add_filter('manage_pages_columns', array($this, 'Clinical_add_post_thumbnail_column'), 5);
            add_action('manage_posts_custom_column', array($this, 'Clinical_display_post_thumbnail_column'), 5);
            add_action('manage_pages_custom_column', array($this, 'Clinical_display_post_thumbnail_column'), 5);

            //resize the original uploaded image
            //add_filter('wp_generate_attachment_metadata',array($this, 'optimise_uploaded_image') );


            //to add defer to loading of scripts - use defer to keep loading order or async for race conditions
            add_filter('script_loader_tag', array($this, 'scripts_tag_defer'), 10, 2);
            //make all comments links 'nofollow' and open in external tab
            add_filter('get_comment_author_link', array($this, 'open_in_new_window'));
            add_filter('comment_text', array($this, 'open_in_new_window'));
            //add script to cache gravatars
            add_filter('get_avatar', array($this, 'get_gravcache'));
            //add function to remove version from querystring in script links
            if (!is_admin()) {
                add_filter('script_loader_src', array($this, 'remove_version_query'), 999);
                add_filter('style_loader_src', array($this, 'remove_version_query'), 999);

                    //Instant.Page
                    add_filter('script_loader_tag', array($this, 'clinical_script_tag'), 10, 3);
            }

            //delay new posts & pages showing in feeds
            add_filter('posts_where', array($this, 'clinical_delay_RSS_after_publish'), 999);
            //set a custom excerpt length
            add_filter('excerpt_length', array($this, 'clinical_custom_excerpt_length'), 999);
            //limit what posts can be searched
            add_filter('pre_get_posts', array($this, 'clinical_modify_search'), 999);

            //count updates performed
            add_action('upgrader_process_complete', array($this, 'clinical_upgrade_tally'), 10, 2);

            //runs only when click save button in ClinicalWP
            //add_action('tf_save_admin_mytheme', array($this, 'save_admin'), 10, 3);
            //run a ClinicalWP / titan framework ajax call
            add_action('wp_ajax_clinical_reset_security_logs', array($this, 'clinical_reset_logs'));
            //set email content to html
            //add_filter('wp_mail_content_type','clinical_set_content_type');

        } // END public function __construct

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        } // END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate

        /************************************************************************************/
        /*                                                                                  */
        /*                          PLUGIN CONFIG SETTINGS                                  */
        /*                                                                                  */
        /************************************************************************************/

        //deactivate W3 Total Cache
        /*
        function deactivate_plugin_conditional() {
            deactivate_plugins('w3-total-cache/w3-total-cache.php');  
        }
         */

        //Set / display the ClinicalWP version number
        function return_CMS_Ver_ID($arg = '')
        {
            return CWP_Version; //for legacy calls to this function
            //echo apply_filters( 'CMS_Ver_ID', '' );
        }

        function change_footer_version()
        {
            //return 'ClinicalWP Version '.$this->return_CMS_Ver_ID();

            //get cms version
            $cs = new Clinical_Stats();
            $cmsInfo = $cs->cc_get_cmsVersion();
            $cmsVersion = $cmsInfo['mods'];

            return 'ClinicalWP ' . $cmsVersion . ' ' . CWP_Version;
        }

        //set the WP sender email name and address
        function clinical_mail_from($old)
        {
            /* Get values from titan options framework */
            $titan = TitanFramework::getInstance('clinical_cms');
            $emailAccount = $titan->getOption('clinical_admin_email_account');
            if ($emailAccount !== '') {
                return $emailAccount;
            } else {
                return $old;
            }
        }
        function clinical_mail_from_name($old)
        {
            /* Get values from titan options framework */
            $titan = TitanFramework::getInstance('clinical_cms');
            $emailName = $titan->getOption('clinical_admin_email_Name');
            if ($emailName !== '') {
                return $emailName;
            } else {
                return $old;
            }
        }
        /*
				//set email to html formatting
				function clinical_set_content_type($content_type){
            /* Get values from titan options framework * /
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $emailHTML = $titan->getOption( 'clinical_admin_email_html' );
            if($emailHTML === true){
                return 'text/html';
            } else {
                return 'text/plain';
            }
				}  
         */
        /* PHP MAILER OVERRIDE */
        function clinical_mail_override($phpmailer)
        {
            /* Get values from titan options framework */
            $titan = TitanFramework::getInstance('clinical_cms');
            $emailExternal = TitanFramework::getInstance('clinical_admin_email_External');
            if ($emailExternal) {
                $emailHost = $titan->getOption('clinical_admin_email_host');
                $emailPort = $titan->getOption('clinical_admin_email_port');
                $emailAuth = $titan->getOption('clinical_admin_email_auth');
                $emailSecurity = $titan->getOption('clinical_admin_email_security');
                $emailUser = $titan->getOption('clinical_admin_email_username');
                $emailPass = $titan->getOption('clinical_admin_email_password');

                $phpmailer->isSMTP();
                if ($emailHost) $phpmailer->Host = $emailHost;
                if ($emailAuth) $phpmailer->SMTPAuth = $emailAuth; // Force it to use Username and Password to authenticate
                if ($emailPort) $phpmailer->Port = $emailPort; //SendGrid Ports - Unencrypted & TLS: 25 and 587, SSL: 465
                if ($emailUser) $phpmailer->Username = $emailUser;
                if ($emailPass) $phpmailer->Password = $emailPass;

                // Additional settings…
                // Choose SSL or TLS, as necessary for your server
                $flag = 0;
                switch ($emailSecurity) {
                    case 2:
                        $phpmailer->SMTPSecure = "ssl";
                        $flag = 1;
                        break;
                    case 3:
                        $phpmailer->SMTPSecure = "tls";
                        $flag = 1;
                        break;
                    default:
                        $flag = 0;
                        break;
                }

                if ($flag == 1 && $emailHost == "smtp.sendgrid.com") {
                    $phpmailer->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                }

                //$phpmailer->From = "";
                //$phpmailer->FromName = "";
                //$mail->SMTPDebug  = 0; // enables SMTP debug information (for testing)
                // 1 = errors and messages
                // 2 = messages only
            }
        }

        /************************************************************************************/
        /*                                                                                  */
        /*                          ADMIN / DASHBOARD SETTINGS                              */
        /*                                                                                  */
        /************************************************************************************/

        //Disable drag n drop boxes on dashboard
        /*
        function disable_drag_metabox() {
            if(!is_super_admin()){
                wp_deregister_script('postbox');
            }
        } 
         */

        //show a message in admin to all users
        function showMessage($message, $type)
        {
            if ($type == 'true') {
                echo '<div id="message" class="error">';
            } else {
                echo '<div id="message" class="updated fade">';
            }
            echo "<p><strong>$message</strong></p></div>";
        }

        //only show admin bar to admins?
        // if (!current_user_can('manage_options')) {
        //     add_filter('show_admin_bar', '__return_false');
        // }

        // Custom WordPress Footer
        function remove_footer_admin()
        {
            //get cms version
            //$cs = new Clinical_Stats();
            //$cmsInfo = $cs->cc_get_cmsVersion();
            //$cmsVersion = $cmsInfo['mods'];

            //echo __('<!-- Need Assistance? Get support 09:30-16:00 weekdays via the chat widget on the bottom right of this page, via telephone on <a href="tel:+4401614084759">+44 (0)161-408-4759</a> or <a href="mailto:hallo@codeclinic.de?subject=Client Support">Email</a> --><style>#fb_widget .label{position:relative;float:left;color:#005f46;min-width:20%} #fb_widget .field{position:relative;float:left} #fb_widget .element{border:0 dotted red;margin:12px;padding:5px;min-height:25px;clear:both} #fb_widget .field input{margin:0;padding:0} #fb_link.disabled{opacity:0;visibility:hidden;}#fb_link.disabled .tooltiptext{font-size:0} #fb_link.disabled .tooltiptext:after{content:"OFFLINE";font-size:12px} #fb_link.email_us .tooltiptext{font-size:0} #img_email{display:none;} #fb_link.email_us .tooltiptext:after{content:"Support Offline";font-size:12px;color:red;font-weight:800} .fbmessenger{position:fixed;bottom:15px;right:15px;z-index:999999999} .fbmessenger span{z-index:999999999;position: absolute;} .fbmessenger.wpostop_left{left:2px;right:initial;top:0;bottom:initial} .tooltiptext.wpostop_left{left:60px;right:initial;top:8px;bottom:initial} .fbmessenger.wpostop_right{left:initial;right:15px;top:0;bottom:initial} .tooltiptext.wpostop_right{left:initial;right:60px;top:8px;bottom:initial} .fbmessenger.wposbottom_left{left:2px;right:initial;top:initial;bottom:0} .tooltiptext.wposbottom_left{left:60px;right:initial;top:initial;bottom:10px} .fbmessenger.wposbottom_right{left:initial;right:15px;top:initial;bottom:0} .tooltiptext.wposbottom_right{left:initial;right:60px;top:initial;bottom:10px} .fbmessenger img{width:50px;filter:drop-shadow(2px 6px 4px rgba(0,0,0,.3));-webkit-filter:drop-shadow(2px 6px 4px rgba(0,0,0,.3))} .tooltiptext{width:120px;background-color:#fff;color:#2c2c2c;text-align:center;padding:5px 0;border:1px solid #eee;border-radius:6px;position:fixed;bottom:30px;right:75px;font-family:inherit;font-size:inherit;text-transform:uppercase;filter:drop-shadow(2px 6px 4px rgba(0,0,0,.3));-webkit-filter:drop-shadow(2px 6px 4px rgba(0,0,0,.3))}</style><div class="code"> <a id="fb_link" href="mailto:hallo@codeclinic.de" target="_self" class="email_us" style="display: inline;"> <div class="fbmessenger wposbottom_right"><img id="img_msg" src="https://cdn.supple.com.au/wp-content/themes/supple/img/msg.png" style="display: none;"><img id="img_email" src="https://cdn.supple.com.au/wp-content/themes/supple/img/emailc.png"> <span class="tooltiptext wposbottom_right" style="color:green;font-weight:800">Support Online</span> </div> </a> </div>', 'Clinical-CMS-Core');
        }
/*
        //get the ClinicalWP version
        function cc_get_cmsVersion()
        {
            //$cmsData;
            switch (CC_Plan) {
                case "Premium+":
                    //    $cmsData['mods'] = "Premium+";
                    //    break;
                case "Pro":
                    $cmsData['mods'] = "Pro";
                    break;
                case "Basics":
                    //$cmsData['mods'] = "Basics";
                    //break;
                default:
                    $cmsData['mods'] = "FREE";
                    break;
            }
            return $cmsData;
        }
*/
        // Add a widget in WordPress Dashboard
        function clinical_dashboard_widget_function()
        {
            // Entering the text between the quotes
            $cs = new Clinical_Stats();
            $memory = $cs->cc_get_memory();
            $memPercent = $memory['memory_percentage'];
            $memUsage = $memory['memory_usage'];
            $memLimit = $memory['memory_limit'];
            $memFront = str_replace('M', '', WP_MEMORY_LIMIT);
            $phpEnv = $cs->cc_get_PHP();
            $phpVersion = $phpEnv['version'];
            $phpOS = $phpEnv['OS'];
            $phpOSBit = $phpEnv['OSBit'];
            $disk = $cs->cc_get_fileSize();
            $diskTotal = $disk['total'];

            //echo 'CURRENT USER: '.get_current_user();
            $cmsDisk = $cs->getUserQuotaInfo(get_current_user());
            $cmsDiskTotal = $cmsDisk['total'];
            $cmsDiskUsed = $cmsDisk['used'];
            $cmsDiskFree = $cmsDisk['free'];
            $cmsMultiplier = 1024;

            $cmsInfo = $cs->cc_get_cmsVersion();
            $cmsVersion = $cmsInfo['mods'];
            if ($cmsDiskTotal == 0) {
                $cmsDiskTotal = $cmsInfo['diskTotal'];
            }
            if ($cmsDiskFree == 0) {
                $cmsDiskFree = $cmsInfo['diskFree'];
            }
            if ($cmsDiskUsed == 0 || $cmsDiskUsed === false) {
                //$cmsDiskUsed = $cs->ConvertBytes(($cmsDiskTotal - $cmsDiskFree));
                //$cmsDiskUsedPercent = $cmsDiskUsed / 100;
                //$cmsDiskTotal = $cs->ConvertBytes($cmsDiskTotal);
                //$cmsMultiplier = 0;

                $cmsMultiplier = 1;
                $cmsDiskUsed = $cmsDiskTotal - $cmsDiskFree;
            }

            //echo "RAM: " . $cmsInfo['diskTotal'] . " / " . $cmsInfo['diskFree'];
            echo "<a href='https://codeclinic.de'><img src='" . plugin_dir_url(__FILE__) . "clinical_custom/clinicalWP-dash-logo.jpg' class='dash-logo'></a><ul><!-- <li><Strong>" . sprintf(__('Hosting Environment [%s]', 'Clinical-CMS-Core'), '<span style="font-size:x-small;">PHP ' . $phpVersion . ' on ' . $phpOS . ' ' . $phpOSBit . 'Bit OS</span>') . "</strong></li>
            <li><hr/></li>-->
            <li style='text-align: center; display: inline-block; width:29%;'><strong>WP Admin RAM</strong><br/>
            <span class=\"donut\" data-peity='{ \"fill\": [\"darkgray\", \"#ace8dc\"],  \"innerRadius\": 10, \"radius\": 28 }'>$memPercent/100</span>
            <br/>$memUsage / $memLimit MB</li>
            <li style='text-align: center; display: inline-block; width:29%;'><strong>WP Site RAM</strong><br/>
            <span class=\"donut\" data-peity='{ \"fill\": [\"darkgray\", \"#ace8dc\"],  \"innerRadius\": 10, \"radius\": 28 }'>$memUsage/$memFront</span>
            <br/>$memUsage / $memFront MB</li>
            <li style='text-align: center; display: inline-block; width:38%;'><strong>Disk Usage</strong><br/>";
            //"<span class=\"donut\" data-peity='{ \"fill\": [\"#20E1F4\", \"#f5f5f5\"],  \"innerRadius\": 20, \"radius\": 25 }'>" . /*str_replace(' Gb', '', $cmsDiskUsed ) . "/" . str_replace(' Gb', '', $cmsDiskTotal ) . */ "</span>";
            echo "<span class=\"donut\" data-peity='{ \"fill\": [\"darkgray\", \"#ace8dc\"],  \"innerRadius\": 10, \"radius\": 28 }'>" . $cmsDiskUsed . "/" . $cmsDiskTotal . "</span>";
            if ($cmsMultiplier == 0) {
                echo "<br/>" . strtoupper($cmsDiskUsed) . " / " . strtoupper($cmsDiskTotal) . "</li>";
            } else {
                echo "<br/>" . $cs->formatBytes($cmsDiskUsed * $cmsMultiplier) . " / " . $cs->formatBytes($cmsDiskTotal * $cmsMultiplier) . "</li>";
            }
            //echo "<li>&nbsp;</li><li><strong>".sprintf( __('<!--Welcome To -->ClinicalWP %s %s ', 'Clinical-CMS-Core'), apply_filters('CMS_Ver_ID',''), $cmsVersion )."</strong> [<span style='font-size:x-small;'>".sprintf( __('enhancing WordPress %s', 'Clinical-CMS-Core'), get_bloginfo('version'))."</span>]</li>";

            //echo "<!-- <li><hr/></li> -->"
            //    . "<li>&nbsp;</li>"
            //<li>".__('A Project By: ', 'Clinical-CMS-Core')."<a href='http://bizclinic.de/' target='_external'>Biz Clinic Business Support Agentur</a></li>"
            //    . "<li>" . __('ClinicalWP is a suite of modular tools that enhance WordPress via an easy to use control panel. Features include added security, image optimisation, improved page loading times, SEO, caching & much more.  ', 'Clinical-CMS-Core') . "</li>
            //		<!--<li>" . __('A Project Developed By: ', 'Clinical-CMS-Core') . "<a href='https://codeclinic.de/' target='_external'>Code Clinic KreativAgentur</a></li>-->
            //";

            //Check Module Status
            $core = "enabled";
            $security = $spam = $cache = $images = $notif = "disabled";

            $caution = "<span class='button__badge' title='" . __('Issue(s) detected!', 'Clinical-CMS-Core') . "'>&#33;</span>";
            $titan = TitanFramework::getInstance('clinical_cms');
            $objectCache = $titan->getOption('clinical_cache_objects');

            if (function_exists('limit_login_setup') && (get_option('cwpGoogleResult', 'test') === 'fail' || get_option('cwpSucuriResult', 'test') === 'fail')) {
                $security = "enabled";
                $warn_security = $caution;
            } else if (function_exists('limit_login_setup')) {
                $security = "enabled";
            }
            if (function_exists('antispam_check_comment')) { } else if (function_exists('antispam_check_comment')) { }
            if (function_exists('antispam_check_comment')) { } else if (function_exists('antispam_check_comment')) {
                $spam = "enabled";
            }
            if (class_exists('dummyClinicalWPDataCache') && $objectCache && (class_exists('Memcached') || class_exists('Memcache'))) {
                $cache = "enabled";
            } else if (class_exists('dummyClinicalWPDataCache') && (($objectCache && !class_exists('Memcached') && !class_exists('Memcache')) || (!$objectCache))) {
                $cache = "enabled";
                $warn_cache = $caution;
            } else if (!class_exists('dummyClinicalWPDataCache')) {
                $cache = "disabled";
            }
            if (class_exists('Clinical_Image_Tools_Plugin')) { } else if (class_exists('Clinical_Image_Tools_Plugin')) {
                $images = "enabled";
            }
            if (class_exists('Clinical_Status_Agent_Plugin')) { } else if (class_exists('Clinical_Status_Agent_Plugin')) {
                $notify = "enabled";
            }

            echo "<li>&nbsp;</li>
                <li><h2>" . __('Module Status', 'Clinical-CMS-Core') . "</h2></li>
                <li><hr/></li>
						<a href='admin.php?page=clinicalwp' class='mod'><img src='" . plugin_dir_url(__FILE__) . "clinical_custom/modules/enabled/clinicalWP-Modules-corepro.jpg' class='module-icons " . $core . "' /></a>
						<a href='#' class='mod'><img src='" . plugin_dir_url(__FILE__) . "clinical_custom/modules/enabled/clinicalWP-Modules-security.jpg' class='module-icons " . $security . "'  />" . $warn_security . "</a>
						<a href='#' class='mod'><img src='" . plugin_dir_url(__FILE__) . "clinical_custom/modules/enabled/clinicalWP-Modules-spam.jpg' class='module-icons " . $spam . "'  />" . $warn_spam . "</a>
                        <a href='#' class='mod'><img src='" . plugin_dir_url(__FILE__) . "clinical_custom/modules/enabled/clinicalWP-Modules-caching.jpg' class='module-icons " . $cache . "'  />" . $warn_cache . "</a>"
                . "<div style='height:10px;'> </div>"
                . "<a href='#' class='mod'><img src='" . plugin_dir_url(__FILE__) . "clinical_custom/modules/enabled/clinicalWP-Modules-images.jpg' class='module-icons " . $images . "'  /></a>
						<a href='#' class='mod'><img src='" . plugin_dir_url(__FILE__) . "clinical_custom/modules/enabled/clinicalWP-Modules-notifications.jpg' class='module-icons " . $notify . "'  /></a>
						";

            echo "<li>&nbsp;</li>
                        <li><h2>" . __('Site Updates', 'Clinical-CMS-Core') . "</h2></li>
                        <li><hr/></li>";
            echo "<li>" . CCK_available_updates() . "</li>";
            if (CCK_available_updates() != '<strong>No core updates</strong>, <strong>0 plugin </strong>and <strong>0 theme</strong> updates available.') {
                echo "<li> </li><li><a href='/wp-admin/update-core.php' class='CWP_btn'>Update Now!</a></li>";
            }

            if (function_exists('CWP_get_blocked_regions')) {
                echo "<li>&nbsp;</li>
                        <li><h2>" . __('Manual Region Blocks', 'Clinical-CMS-Core') . "</h2></li>
                        <li><hr/></li>
                        <li>Access to WP-Admin is currently blocked for users in the following regions:</li>";
                echo "<li>&nbsp;</li><li>" . CWP_get_blocked_regions() . "</li>";
                echo "<li> </li><li><a href='/wp-admin/admin.php?page=clinicalwp&tab=security-%2F-firewall' class='CWP_btn'>Modify Blocking Rules</a></li>";
            }

            if (function_exists('CWP_get_blocked_ips')) {
                echo "<li>&nbsp;</li>
                        <li><h2>" . __('Top 5 IP\'s Blocked', 'Clinical-CMS-Core') . "</h2></li>
                        <li><hr/></li>
                        <li>Access to WP-Admin is currently blocked for users in the following regions:</li>";
                echo "<li>&nbsp;</li><li>" . CWP_get_blocked_ips() . "</li>";
                echo "<li> </li><li><a href='/wp-admin/admin.php?page=clinicalwp&tab=security-%2F-firewall' class='CWP_btn'>Modify Blocking Rules</a></li>";
            }
            echo "<li>&nbsp;</li>
                        <li><h2>" . __('Activity Feed', 'Clinical-CMS-Core') . "</h2></li>
                        <li><hr/></li>";
            echo "<li>";
            do_action('CCK_Status_Feed');
            echo "</li>";

            echo "
            <li>&nbsp;</li>
            <li><h2>" . __('Write A Review', 'Clinical-CMS-Core') . "</h2></li>
            <li><hr/></li>
						<li>" . __('As a small digital creative studio we rely heavily on the quality of our work and the great reputation this builds. Please help us grow by spreading the word and letting others know about us.', 'Clinical-CMS-Core') . "</li>
            <li>&nbsp;</li><li><strong>" . __('We\'d really appreciate it if you could place a review/rating on', 'Clinical-CMS-Core') . " <a href=\"https://wordpress.org/support/plugin/clinicalwp-core/reviews/#new-post\" title=\"Rate & Review ClinicalWP\" target='_external'>WordPress Plugin Directory.</a></strong></li></ul>";
        }

        // Disable 'Deactivate' For Named Plugins http://sltaylor.co.uk/blog/disabling-wordpress-plugin-deactivation-theme-changing/
        function clinical_lock_plugins($actions, $plugin_file, $plugin_data, $context)
        {
            // Remove edit link for all
            if (array_key_exists('edit', $actions))
                unset($actions['edit']);

            // Remove deactivate link for crucial plugins
            if (array_key_exists('deactivate', $actions) && in_array($plugin_file, array()))
                unset($actions['deactivate']);
            return $actions;
        }

        //Remove The Appearance > Editor Option From Admin
        /*
        function remove_editor_menu() {
            remove_action('admin_menu', '_add_themes_utility_last', 101);
        }
         */

        /*
        Set TinyMCE editor to plain text by default.
        Thanks to Dariusz Lyson for the solution on Stack Overflow
        http://stackoverflow.com/questions/2695731/how-to-make-tinymce-paste-in-plain-text-by-default
         */
        function plaintextpaste_tinymce_default($settings)
        {
            $titan = TitanFramework::getInstance('clinical_cms');
            $adminEditorPaste = $titan->getOption('clinical_admin_editor_textmode');
            if ($adminEditorPaste == true) {
                $settings['paste_text_sticky'] = 'true';
                $settings['setup'] = 'function(ed) { ed.onInit.add(function(ed) { ed.pasteAsPlainText = true; }); }';
            }
            return $settings;
        }

        // Display the featured images of posts in the "All Posts" view in the admin via http://www.instantshift.com/2012/03/06/21-most-useful-wordpress-admin-page-hacks/
        // Add the posts and pages columns filter. They can both use the same function.

        // Add the column
        function Clinical_add_post_thumbnail_column($columns)
        {
            $titan = TitanFramework::getInstance('clinical_cms');
            $adminPostThumb = $titan->getOption('clinical_admin_post_thumb');
            if ($adminPostThumb == true) {
                $columns['feat-image'] = 'Has Image?';
            }
            return $columns;
        }

        // Grab featured-thumbnail size post thumbnail and display it.
        function Clinical_display_post_thumbnail_column($column_name)
        {
            $titan = TitanFramework::getInstance('clinical_cms');
            $adminPostThumb = $titan->getOption('clinical_admin_post_thumb');
            if ($adminPostThumb == true) {
                global $post;
                if ('feat-image' == $column_name && has_post_thumbnail($post->ID))
                    echo "<span style='color:green'>Yes</span>";
                else if ('feat-image' == $column_name && !has_post_thumbnail($post->ID))
                    echo "<span style='color:orange);'>No</span>";
            }
        }

        /*
        function allow_Widget_shortcodes(){
            //allow shortcode usage in widgets
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $widgetShortcodes = $titan->getOption( 'clinical_widget_Shortcodes' );
            if($widgetShortcodes == true)
            {
                add_filter('widget_text', 'do_shortcode'); 
            }
        }
         */

        //Keep a record of how many updates have been performed
        function clinical_upgrade_tally($upgrader_object, $options)
        {
            //$current_plugin_path_name = plugin_basename( __FILE__ );

            if ($options['action'] == 'update' /* && $options['type'] == 'plugin' */ && (!empty($options['plugins']))) {
                foreach ($options['plugins'] as $each_plugin) {
                    //if ($each_plugin==$current_plugin_path_name){
                    /*
                        if ( get_option( 'clinical_cms_updates_tally' ) != false ) {
                            $clinical_cms_updates_tally = (int)get_option( 'clinical_cms_updates_tally', 0 );
                            // The option already exists, so we just update it.
                            $clinical_cms_updates_tally = $clinical_cms_updates_tally+1;
                            update_option( 'clinical_cms_updates_tally',  $clinical_cms_updates_tally);
                        } else {
                            // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
                            add_option( 'clinical_cms_updates_tally', 1, 0, 'no' );
                        }
                     */

                    if (get_option('clinical_cms_updates_tally', null) !== null) {
                        // The option already exists, so update it.
                        $updates_tally = get_option('clinical_cms_updates_tally', 0);
                        $updates_tally++;
                        update_option('clinical_cms_updates_tally', $updates_tally);
                    } else {
                        // The option hasn't been created yet, so add it with $autoload set to 'no'.
                        add_option('clinical_cms_updates_tally', 0, 'no');
                    }

                    //}
                }
            }
        }


        /************************************************************************************/
        /*                                                                                  */
        /*                          GENERAL / SEO OPTIMISATIONS                             */
        /*                                                                                  */
        /************************************************************************************/

        //add defer attribute to enqued scripts
        function scripts_tag_defer($tag, $handle)
        {
            $titan = TitanFramework::getInstance('clinical_cms');
            $scriptsdefer = $titan->getOption('clinical_scripts_defer');
            if ($scriptsdefer == 1 || $scriptsdefer == 2) {
                if (is_admin()) {
                    return $tag;
                } else if (strpos($tag, '/wp-includes/js/jquery/jquery')) {
                    return $tag;
                } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.') !== false) {
                    return $tag;
                } else if ($scriptsdefer == 1) {
                    return str_replace(' src', ' defer src', $tag);
                } else if ($scriptsdefer == 2) {
                    return str_replace(' src', ' async src', $tag);
                }
            } else {
                return $tag;
            }
        }

        //Opens links in comments section in new tab & adds a nofollow for seo purposes
        function open_in_new_window($text)
        {
            $titan = TitanFramework::getInstance('clinical_cms');
            $commentLinks = $titan->getOption('clinical_comment_links_enable');
            if ($commentLinks == true) {
                $return_url = str_replace('<a', '<a title="external-link" rel="nofollow" target="_external"', $text);
                return $return_url;
            } else {
                return $text;
            }
        }

        //Add SEO metaboxes to pages & posts
        function clinical_enable_seo_metaboxes()
        {
            $titan = TitanFramework::getInstance('clinical_cms');
            $seoFields = $titan->getOption('clinical_seo_fields');
            $seoFacebook = $titan->getOption('clinical_seo_facebook');
            $seoTwitter = $titan->getOption('clinical_seo_twitter');
            $seoGoogle = $titan->getOption('clinical_seo_google');

            if ($seoFields == true) {
                // Create relevant 
                $seoMetaBox = $titan->createMetaBox(array(
                    'name' => 'Standard SEO',
                    'post_type' => array('page', 'post'),
                ));
                $seoMetaBox->createOption(array(
                    'name' => 'Page Description',
                    'id' => 'clinical_seo_description',
                    'type' => 'text',
                    'desc' => ''
                ));
                $seoMetaBox->createOption(array(
                    'name' => 'Page Keywords',
                    'id' => 'clinical_seo_keywords',
                    'type' => 'text',
                    'desc' => ''
                ));
            }
            if ($seoFacebook == true) {
                // Create relevant 
                $facebookMetaBox = $titan->createMetaBox(array(
                    'name' => 'Facebook SEO',
                    'post_type' => array('page', 'post'),
                ));
                $facebookMetaBox->createOption(array(
                    'name' => 'Title',
                    'id' => 'clinical_seo_fb_title',
                    'type' => 'text',
                    'desc' => __('Title for page(will use site title if empty)', 'Clinical-CMS-Core')
                ));
                $facebookMetaBox->createOption(array(
                    'name' => 'Description',
                    'id' => 'clinical_seo_fb_description',
                    'type' => 'text',
                    'desc' => __('Description for page(will use site title if empty)', 'Clinical-CMS-Core'),
                ));
                $facebookMetaBox->createOption(array(
                    'name' => 'Facebook ID',
                    'id' => 'clinical_seo_fb_aminID',
                    'type' => 'text',
                    'desc' => __('The ID number from your <a href="http://findmyfbid.com/" target= "_external">Fb profile</a> (will use link from \'Social Profile\' settings if empty)', 'Clinical-CMS-Core')
                ));
                $facebookMetaBox->createOption(array(
                    'name' => 'Image',
                    'id' => 'clinical_seo_fb_image',
                    'type' => 'upload',
                    'desc' => __('Image to be used by Facebook(will use featured image if empty)', 'Clinical-CMS-Core'),
                ));
                //$screen = get_current_screen();
                //if( $screen->post_type == "post" ){
                $facebookMetaBox->createOption(array(
                    'name' => 'Publisher Profile[Posts Only]',
                    'id' => 'clinical_seo_fb_publisher',
                    'type' => 'text',
                    'desc' => __('Full link to Author profile on Facebook(will use link from \'Social Profile\' settings if empty)', 'Clinical-CMS-Core')
                ));
                $facebookMetaBox->createOption(array(
                    'name' => 'Author Profile[Posts Only]',
                    'id' => 'clinical_seo_fb_author',
                    'type' => 'text',
                    'desc' => __('Full link to Author profile on Facebook(will use link from \'Social Profile\' settings if empty)', 'Clinical-CMS-Core')
                ));
                //}
            }
            if ($seoTwitter == true) {
                // Create relevant
                $twitterMetaBox = $titan->createMetaBox(array(
                    'name' => 'Twitter SEO',
                    'post_type' => array('page', 'post'),
                ));
                $twitterMetaBox->createOption(array(
                    'name' => 'Page title',
                    'id' => 'clinical_seo_twit_title',
                    'type' => 'text',
                    'desc' => __('Title for page(will use site title if empty)', 'Clinical-CMS-Core')
                ));
                $twitterMetaBox->createOption(array(
                    'name' => 'Description',
                    'id' => 'clinical_seo_twit_description',
                    'type' => 'text',
                    'desc' => __('Description for page(will use site title if empty)', 'Clinical-CMS-Core'),
                ));
                $twitterMetaBox->createOption(array(
                    'name' => 'Publisher Handle',
                    'id' => 'clinical_seo_twit_Publisher',
                    'type' => 'text',
                    'desc' => __('Twitter username of publisher(exclude @ symbol)', 'Clinical-CMS-Core')
                ));
                $twitterMetaBox->createOption(array(
                    'name' => 'Author Handle',
                    'id' => 'clinical_seo_twit_author',
                    'type' => 'text',
                    'desc' => __('Twitter username of author(exclude @ symbol)', 'Clinical-CMS-Core')
                ));
                $twitterMetaBox->createOption(array(
                    'name' => 'Image',
                    'id' => 'clinical_seo_twit_image',
                    'type' => 'upload',
                    'desc' => __('Image to be used by Twitter(will use featured image if empty)', 'Clinical-CMS-Core'),
                ));
            }
            if ($seoGoogle == true) {
                // Create relevant 
                $googleMetaBox = $titan->createMetaBox(array(
                    'name' => 'Google+ SEO',
                    'post_type' => array('page', 'post'),
                ));
                $googleMetaBox->createOption(array(
                    'name' => 'Page Title',
                    'id' => 'clinical_seo_g_name',
                    'type' => 'text',
                    'desc' => __('Title for page(will use site title if empty)', 'Clinical-CMS-Core'),
                ));
                $googleMetaBox->createOption(array(
                    'name' => 'Description',
                    'id' => 'clinical_seo_g_description',
                    'type' => 'text',
                    'desc' => __('Description for page(will use site title if empty)', 'Clinical-CMS-Core'),
                ));
                $googleMetaBox->createOption(array(
                    'name' => 'Image',
                    'id' => 'clinical_seo_g_image',
                    'type' => 'upload',
                    'desc' => __('Image to be used by Google+(will use featured image if empty)', 'Clinical-CMS-Core'),
                ));
            }
        }


        //add the seo data to page / post html
        function clinical_add_seo_to_head()
        {
            $titan = TitanFramework::getInstance('clinical_cms');
            $seoFields = $titan->getOption('clinical_seo_fields');
            $seoDesc = $titan->getOption('clinical_seo_description', get_the_ID());
            $seoWords = $titan->getOption('clinical_seo_keywords', get_the_ID());

            if ($seoFields == true) {
                $gName = $titan->getOption('clinical_seo_g_name', get_the_ID());
                if (trim($gName) == "") {
                    $gName = get_the_title();
                }
                $gDescription = $titan->getOption('clinical_seo_g_description', get_the_ID());
                if (trim($gDescription) == "") {
                    $gDescription = $seoDesc;
                }
                $gImage = $titan->getOption('clinical_seo_g_image', get_the_ID());
                $gImageSrc = $gImage; // For the default value
                if (is_numeric($gImage)) {
                    $imageAttachment = wp_get_attachment_image_src($gImage);
                    $gImageSrc = $imageAttachment[0];
                } elseif (trim($gImageSrc) == "") {
                    $gImageSrc = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                }

                $twitTitle = $titan->getOption('clinical_seo_twit_title', get_the_ID());
                if (trim($twitTitle) == "") {
                    $twitTitle = get_the_title();
                }
                $twitDescription = $titan->getOption('clinical_seo_twit_description', get_the_ID());
                if (trim($twitDescription) == "") {
                    $twitDescription = $seoDesc;
                }
                $twitPublisher = $titan->getOption('clinical_seo_twit_Publisher', get_the_ID());
                if (trim($twitPublisher) == "") {
                    $twitPublisher = $titan->getOption('clinical_twit_publisher');
                }
                if (strpos($twitPublisher, "@") === false) {
                    $twitPublisher = "@" . $twitPublisher;
                }
                $twitAuthor = $titan->getOption('clinical_seo_twit_author', get_the_ID());
                if (trim($twitAuthor) == "") {
                    $twitAuthor = $titan->getOption('clinical_twit_author');
                }
                if (strpos($twitAuthor, "@") === false) {
                    $twitAuthor = "@" . $twitAuthor;
                }
                $twitImage = $titan->getOption('clinical_seo_twit_image', get_the_ID());
                $twitImageSrc = $twitImage; // For the default value
                if (is_numeric($twitImage)) {
                    $imageAttachment = wp_get_attachment_image_src($twitImage);
                    $twitImageSrc = $imageAttachment[0];
                } elseif (trim($twitImageSrc) == "") {
                    $twitImageSrc = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                }


                $fbTitle = $titan->getOption('clinical_seo_fb_title', get_the_ID());
                if (trim($fbTitle) == "") {
                    $fbTitle = get_the_title();
                }
                $fbDescription = $titan->getOption('clinical_seo_fb_description', get_the_ID());
                if (trim($fbDescription) == "") {
                    $fbDescription = $seoDesc;
                }
                $fbAdminID = $titan->getOption('clinical_seo_fb_aminID', get_the_ID());
                if (trim($fbAdminID) == "") {
                    $fbAdminID = $titan->getOption('clinical_fb_aminID');
                }
                $fbImage = $titan->getOption('clinical_seo_fb_image', get_the_ID());
                $fbImageSrc = $fbImage; // For the default value
                if (is_numeric($fbImage)) {
                    $imageAttachment = wp_get_attachment_image_src($fbImage);
                    $fbImageSrc = $imageAttachment[0];
                } elseif (trim($fbImageSrc) == "") {
                    $fbImageSrc = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                }
                $fbType = ((is_single() and !is_page()) ? "article" : "website"); /* website or, article if blog post */
                global $wp;
                //$fbURL = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
                $fbURL = get_permalink();
                $fbSiteName = get_bloginfo('name');

                if (is_single() and !is_page()) {
                    $fbAuthor = $titan->getOption('clinical_seo_fb_author', get_the_ID());
                    if (trim($fbAuthor) == "") {
                        $fbAuthor = $titan->getOption('clinical_fb_author');
                    }
                    $fbPublisher = $titan->getOption('clinical_seo_fb_publisher', get_the_ID());
                    if (trim($fbPublisher) == "") {
                        $fbPublisher = $titan->getOption('clinical_fb_publisher');
                    }
                }

                $fbAppID = $titan->getOption('clinical_fb_appID');

                if (trim($seoWords) != "") { ?>
                <meta name="keywords" content="<?php echo $seoWords; ?>">
            <?php
            }
            if (trim($seoDesc) != "") { ?>
                <meta name="description" content="<?php echo $seoDesc; ?>">
            <?php
            } ?>
            <meta name="googlebot" content="noodp"> <!-- tell Google to not use Moz Dir description -->

            <!-- Schema.org markup for Google+ -->
            <?php if (trim($gName) != "") { ?>
                <meta itemprop="name" content="<?php echo $gName; ?>">
            <?php
            }
            if (trim($gDescription) != "") { ?>
                <meta itemprop="description" content="<?php echo $gDescription; ?>">
            <?php
            }
            if (trim($gImageSrc) != "") { ?>
                <meta itemprop="image" content="<?php echo $gImageSrc; ?>">
            <?php
            } ?>
            <!-- Twitter Card data -->
            <meta name="twitter:card" content="summary_large_image">
            <?php if (trim($twitPublisher) != "") { ?>
                <meta name="twitter:site" content="<?php echo $twitPublisher; ?>">
            <?php
            }
            if (trim($twitTitle) != "") { ?>
                <meta name="twitter:title" content="<?php echo $twitTitle; ?>">
            <?php
            }
            if (trim($twitDescription) != "") { ?>
                <meta name="twitter:description" content="<?php echo $twitDescription; ?>">
            <?php
            }
            if (trim($twitAuthor) != "") { ?>
                <meta name="twitter:creator" content="<?php echo $twitAuthor; ?>">
            <?php
            }
            if (trim($twitImageSrc) != "") { ?>
                <!-- Twitter summary card with large image must be at least 280x150px -->
                <meta name="twitter:image:src" content="<?php echo $twitImageSrc; ?>">
            <?php
            } ?>
            <!-- Open Graph data -->

            <?php if (trim($fbType) != "") { ?>
                <meta property="og:type" content="<?php echo $fbType; ?>" />
            <?php
            }
            if (trim($fbTitle) != "") { ?>
                <meta property="og:title" content="<?php echo $fbTitle; ?>" />
            <?php
            }
            if (trim($fbURL) != "") { ?>
                <meta property="og:url" content="<?php echo trailingslashit($fbURL); ?>" />
            <?php
            }
            if (trim($fbImageSrc) != "") { ?>
                <meta property="og:image" content="<?php echo $fbImageSrc; ?>" />
            <?php
            }
            if (trim($fbDescription) != "") { ?>
                <meta property="og:description" content="<?php echo $fbDescription; ?>" />
            <?php
            }
            if (trim($fbSiteName) != "") { ?>
                <meta property="og:site_name" content="<?php echo $fbSiteName; ?>" />
            <?php
            } ?>
            <!-- 
                                    <meta property="article:published_time" content="2013-09-17T05:59:00+01:00" />
                                     <meta property="article:modified_time" content="2013-09-16T19:08:47+01:00" />
                                    <meta property="article:section" content="Article Section" />
                                    <meta property="article:tag" content="Article Tag" />
                                    -->
            <?php if (trim($fbAdminID) != "") { ?>
                <meta property="fb:admins" content="<?php echo $fbAdminID; ?>" />
            <?php
            }
            if (trim($fbAppID) != "") { ?>
                <meta property="fb:app_id" content="<?php echo $fbAppID; ?>" />
            <?php
            }

            if (is_single() and !is_page()) {
                if (trim($fbPublisher) != "") { ?>
                    <meta property="article:publisher" content="<?php echo $fbPublisher; ?>" />
                <?php
                }
                if (trim($fbAuthor) != "") { ?>
                    <meta property="article:author" content="<?php echo $fbAuthor; ?>" />
                <?php
                }
            }
            ?>

        <?php
        }
    }

    function clinical_add_activity_info()
    {
        echo '<p>' . sprintf(__('<a href="admin.php?page=clinicalwp">ClinicalWP Core</a>: <span class="flag-green"><span class="dashicons dashicons-yes"></span><strong>%u</strong> updates applied', 'Clinical-CMS-Core'), number_format(get_option('clinical_cms_updates_tally', 0))) . '.</span></p>';

        /**
         * Get Titan Framework / ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $objectCache = $titan->getOption('clinical_cache_objects');
        if ($objectCache && (class_exists('Memcached') || class_exists('Memcache'))) {
            echo '<p>' . __('<a href="admin.php?page=clinicalwp&tab=performance">') . __('ClinicalWP Data Cache', 'Clinical-CMS-Core') . '</a>: <span class="flag-green"><span class="dashicons dashicons-yes"></span> ' . __('Enabled', 'clinical-image-tools') . '.</span></p>';
        } else {
            echo '<p>' . __('<a href="admin.php?page=clinicalwp&tab=performance">') . __('ClinicalWP Data Cache', 'Clinical-CMS-Core') . '</a>: <span class="flag-orange"><span class="dashicons dashicons-flag"></span> ' . __('Disabled!', 'clinical-image-tools') . '</span></p>';
        }
    }

    // cache gravatar avatars
    function get_gravcache($source)
    {
        $titan = TitanFramework::getInstance('clinical_cms');
        $cacheGravatar = $titan->getOption('clinical_cache_gravatar');
        //is caching enabled?
        if ($cacheGravatar == true) {
            //check if a custom site avatar is set
            $grav = $titan->getOption('clinical_admin_profile_gravatar');
            if ($grav == true) {
                //use this site's custom gravatar
                $gravImage = $titan->getOption('clinical_admin_profile_gravatar_image');
                // The value may be a URL to the image (for the default parameter)
                // or an attachment ID to the selected image.
                if (is_numeric($gravImage)) {
                    $imageAttachment = wp_get_attachment_image_src($gravImage);
                    //set as default
                    $default = $imageAttachment[0];
                }
            } else {
                //use plugin default.jpg instead
                $default = plugin_dir_url(__FILE__) . 'gravcache/' . 'default.jpg';
            }
            //do the caching
            $time = 1209600; //The time of cache(seconds)
            preg_match('/avatar\/([a-z0-9]+)\?s=(\d+)/', $source, $tmp);
            $abs = dirname(__FILE__) . '/gravcache/' . $tmp[1] . '.jpg';
            $url = plugin_dir_url(__FILE__) . 'gravcache/' . $tmp[1] . '.jpg';
            if (!is_file($abs) || (time() - filemtime($abs)) > $time) {
                copy('https://www.gravatar.com/avatar/' . $tmp[1] . '?s=256&d=' . $default . '&r=G', $abs);
            }
            if (is_file($abs) && filesize($abs) < 500) {
                copy($default, $abs);
            }

            return '<img alt="" src="' . $url . '" class="avatar avatar-' . $tmp[2] . '" width="' . $tmp[2] . '" height="' . $tmp[2] . '" />';
        }
        return $source; //return the original image if this cache is disabled
    }

    //remove the version marker from querystring
    function remove_version_query($src)
    {
        $titan = TitanFramework::getInstance('clinical_cms');
        $removeVer = $titan->getOption('clinical_remove_versions');
        if ($removeVer == true && !is_admin()) {
            $rqs = explode('&ver=', $src);
            $rqs = explode('?ver=', $rqs[0]);
            $rqs = explode('?v=', $rqs[0]);
            $rqs = explode('&v=', $rqs[0]);
            $rqs = explode('?_t=', $rqs[0]);
            return $rqs[0];
        } else {
            return $src;
        }
    }

    function optimise_uploaded_image($image_data)
    {
        $titan = TitanFramework::getInstance('clinical_cms');
        $optimiseOrigImg = $titan->getOption('clinical_optimise_uploaded_img');
        $optimiseOrigImgHeight = $titan->getOption('clinical_optimise_uploaded_img_height');
        $optimiseOrigImgWidth = $titan->getOption('clinical_optimise_uploaded_img_width');
        if ($optimiseOrigImg == true) {

            // if there is no large image : return
            if (!isset($image_data['sizes']['large'])) return $image_data;

            // path to the uploaded image and the large image
            $upload_dir = wp_upload_dir();
            $uploaded_image_location = $upload_dir['basedir'] . '/' . $image_data['file'];
            $large_image_location = $upload_dir['path'] . '/' . $image_data['sizes']['large']['file'];

            // delete the uploaded image
            //unlink($uploaded_image_location);

            // rename the large image
            rename($large_image_location, $uploaded_image_location);

            if ((int) $image_data['width'] > (int) $optimiseOrigImgWidth) {
                // update image metadata and return them
                $image_data['width'] = $optimiseOrigImgWidth;
            }
            if ((int) $image_data['height'] > (int) $optimiseOrigImgHeight) {
                // update image metadata and return them
                $image_data['height'] = $optimiseOrigImgHeight;
            }
            unset($image_data['sizes']['large']);
        }
        return $image_data;
    }


    function clinical_force_featured_image($post_id)
    {
        $titan = TitanFramework::getInstance('clinical_cms');
        $forceFeatured = $titan->getOption('clinical_force_featured_image_enable');
        $forcePages = $titan->getOption('clinical_force_featured_image_pages');
        $forcePosts = $titan->getOption('clinical_force_featured_image_posts');

        //get the post
        $post = get_post($post_id);
        // If this is a revision, get real post ID
        if ($parent_id = wp_is_post_revision($post_id))
            $post_id = $parent_id;

        if ($forceFeatured == true) {
            // change to any custom post type 
            if (get_post_type($post_id) != 'post' && get_post_type($post_id) != 'page')
                return;

            if ((!has_post_thumbnail($post_id)) && 'trash' !== $post->post_status && 'auto-draft' !== $post->post_status) {

                //allocate image to worker array
                if (get_post_type($post_id) == 'page') {
                    $a = explode(',', $forcePages);
                } else if (get_post_type($post_id) == 'post') {
                    $a = explode(',', $forcePosts);
                }


                //remove any empty values
                foreach ($a as $key => $value) {
                    if (empty($value)) {
                        unset($a[$key]);
                    }
                }

                //do we have img collection or do we set as draft post/page
                //if( !empty($playerlist) ){
                if (!empty($a)) {
                    //find one random image from collection   
                    $random_image = $a[mt_rand(0, count($a) - 1)];
                    //attach the featured image
                    set_post_thumbnail($post_id, $random_image);
                } else {
                    //set a transient to show the users an admin message
                    set_transient("has_post_featured", "no");
                    // unhook this function so it doesn't loop infinitely
                    remove_action('save_post', array($this, 'clinical_force_featured_image'));
                    // update the post set it to draft
                    wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
                    //re-hook the function
                    add_action('save_post', array($this, 'clinical_force_featured_image'));
                }
            } else {
                delete_transient("has_post_featured");
            }
        }
    }
    function clinical_force_featured_error()
    {
        $titan = TitanFramework::getInstance('clinical_cms');
        $forceFeatured = $titan->getOption('clinical_force_featured_image_enable');
        if ($forceFeatured == true) {
            // check if the transient is set, and display the error message
            if (get_transient("has_post_featured") == "no") {
                echo "<div id='message' class='error'><p><strong>Featured images are required!<br/>These are used to represent your page on Social Media, so are really valuable. Your post has been saved, it just won't be published until you add a 'Featured Image'.</strong></p></div>";
                delete_transient("has_post_featured");
            }
        }
    }


    function clinical_delay_RSS_after_publish($where)
    {
        //sets a delay on adding new pages / posts to rss feeds
        $titan = TitanFramework::getInstance('clinical_cms');
        $delayFeed = $titan->getOption('clinical_rss_feed_delay_enable');
        if ($delayFeed == true) {
            $delayFeedUnits = $titan->getOption('clinical_rss_feed_delay_units');
            global $wpdb;
            if (is_feed()) {
                $now = gmdate('Y-m-d H:i:s');
                $delay = $delayFeedUnits;
                $unit = 'HOUR';
                $where .= " AND TIMESTAMPDIFF($unit, $wpdb->posts.post_date_gmt, '$now') > $delay ";
            }
        }
        return $where;
    }

    function clinical_custom_excerpt_length($length)
    {
        //set a custom excerpt length
        $titan = TitanFramework::getInstance('clinical_cms');
        $enable = $titan->getOption('clinical_excerpt_enable');
        if ($enable == true) {
            $length = $titan->getOption('clinical_excerpt_length');
        }
        return $length;
    }

    function clinical_modify_search($query)
    {
        //prevent certain post types from showing in searches
        if ($query->is_search) { //only run this if a search
            $titan = TitanFramework::getInstance('clinical_cms');
            $hidePostTypes = $titan->getOption('clinical_hide_post_types');
            if (count($hidePostTypes) !== 0) {
                //get registered post types
                $args = array(
                    'public' => true
                );
                $reg_post_types = get_post_types($args);
                //remove exclude post type(s)
                $result = array_diff($reg_post_types, $hidePostTypes);
                $result = implode(",", $result);
                //set query to return
                $query->set('post_type', $result);
            }
        }
        return $query;
    }


    /************************************************************************************/
    /*                                                                                  */
    /*                          THE NEW COLLECTED FUNCTIONS                             */
    /*                                                                                  */
    /************************************************************************************/

    function clinical_tf_create_options()
    {

        /* CREATE THE OPTIONS TABS FOR ClinicalWP SUITE */
        $titan = TitanFramework::getInstance('clinical_cms');

        $adminPanel = $titan->createAdminPanel(array(
            'name' => 'ClinicalWP',
            'icon' => 'dashicons-shield',
            'position' => '3',
        ));
        /*
            $layoutPanel = $adminPanel->createAdminPanel( array(
                'name' => 'My Layout Panel',
            ) );
             */
        //to recall options later
        //$myValue = $titan->getOption( 'clinical_activation_code' );

        /**
         * Create an admin panel where we can edit some options.
         */
        /*
            $shortcodePanel = $adminPanel->createAdminPanel( array(
                'name' => 'Settings',
                'desc' => '<h1>'.__('Configure the settings and options for ClinicalWP by', 'Clinical-CMS-Core').' <a href="http://codeclinic.de" target="_external">Code Clinic</a></h1>',
                'icon' => 'dashicons-shield',
            ) );
             */
        $panel = $adminPanel->createTab(array(
            'name' => 'Overview',
            'desc' => '<h2>' . __('ClinicalWP - The perfect remedy for WordPress aches & pains.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('General Settings', 'Clinical-CMS-Core'),
        ));
        $panel->createOption(array(
            'type' => 'custom',
            'custom' => '<div class="clinical-welcome-head"><img src="' . plugin_dir_url(__FILE__) . 'clinical_custom/clinicalWP-logoV2.jpg"/></div><div><p>&nbsp;</p><h3>' . __('Welcome to ClinicalWP', 'Clinical-CMS-Core') . '</h3><!-- <div class="left"></div><div class="center"></div><div class="right"></div> --><div><p>' . __('<strong>ClinicalWP</strong> brings the power of WordPress & combines it with the expert knowledge of Code Clinic\'s award winning development team to create the <strong>Ultimate CMS</strong> user experience.</p><p>Tweaks to core features and settings significantly improve the \'out of box\' experience for novice and expert users alike. In addition to <strong>performance upgrades</strong>, ClinicalWP brings much needed <strong>security features</strong>, unrivaled <strong>SEO & Social Media</strong> sharing alongside a great <strong>new admin experience</strong>, <strong>image optimisation tools</strong>, <strong>advanced settings</strong>, <strong>maintenance options</strong>, and much more.</p><p>&nbsp;</p><h3>Upgrades & Extensions</h3><p>For special pricing and offers on <a href="' . ccp_fs()->_get_admin_page_url( 'addons' ) . '" title="Upgrade Now & SAVE!" target="_external">ClinicalWP Pro Extensions</a> please take a look at <a href="https://clinicalwp.com" title="Upgrade Now & SAVE!" target="_external">https://clinicalwp.com</a></p><p>&nbsp;</p><p>&nbsp;</p><p><strong>PLEASE NOTE: </strong><br/>The ClinicalWP Toolkit offers a number of system tweaks that require edits to the WordPress config file (\'wp-config.php\') and your Server\'s \'.htacess\' file. As such it\'s strongly recommended that you make a precautionary backup of your website prior to making changes.', 'Clinical-CMS-Core') . '</p><p>&nbsp;</p></div></div>',
        ));

        //build a tab for general settings
        $generalPanel = $adminPanel->createTab(array(
            'name' => __('General', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Fine tune ClinicalWP to meet your requirements.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('General Settings', 'Clinical-CMS-Core'),
        ));

        //WP HouseKeeping
        $generalPanel->createOption(array(
            'name' => __('Housekeeping', 'Clinical-CMS-Core'),
            'id' => 'clinical_housekeeping_heading',
            'type' => 'heading',
        ));
        $generalPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Useful settings for keeping the system optimised.', 'Clinical-CMS-Core'),
        ));
        $generalPanel->createOption(array(
            'name' => 'Max Page / Post Revisions',
            'id' => 'clinical_revision_limit',
            'type' => 'number',
            'desc' => __('Define the max number of revisions WP keeps for each page/post.', 'Clinical-CMS-Core'),
            'default' => '5',
            'max' => '50',
        ));
        $generalPanel->createOption(array(
            'name' => 'Trash Removal Period',
            'id' => 'clinical_trash_days',
            'type' => 'number',
            'desc' => __('Define how often the page/post trash is emptied. Emptying trash regularly keeps your database smaller. (Value in Days)', 'Clinical-CMS-Core'),
            'default' => '30',
            'max' => '90',
        ));
        $generalPanel->createOption(array(
            'name' => 'AutoSave Time Interval',
            'id' => 'clinical_autosave_interval',
            'type' => 'number',
            'desc' => __('How often WordPress should auto-save pages & posts. (Value in seconds)', 'Clinical-CMS-Core'),
            'default' => '60',
            'max' => '600',
        ));
        //Save settings button
        $generalPanel->createOption(array(
            'type' => 'save',
            'id' => 'opopopopopopopofbmntpopopo',
        ));

        //WP System email account
        $generalPanel->createOption(array(
            'name' => __('System Email', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_email_heading',
            'type' => 'heading',
        ));
        $generalPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Override the default WordPress email address and sender name for better branding and clarity.', 'Clinical-CMS-Core'),
        ));
        $generalPanel->createOption(array(
            'name' => __('Email address', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_email_account',
            'desc' => __('Set the email address used by WordPress', 'Clinical-CMS-Core'),
            'placeholder' => __('Enter valid email', 'Clinical-CMS-Core'),
        ));
        $generalPanel->createOption(array(
            'name' => __('Email sender name', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_email_name',
            'desc' => __('The senders name to display', 'Clinical-CMS-Core'),
            'placeholder' => __('eg Company name', 'Clinical-CMS-Core'),
        ));
        /*
            $generalPanel->createOption( array(
                'name' => __('HTML Formatting', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_html',
                'desc' => __('Send emails with html formatting. <strong>NOTE:</strong> Can cause issue with WordPress <a href="https://codex.wordpress.org/Plugin_API/Filter_Reference/wp_mail_content_type" title="Learn More" target="_external">system emails</a>.', 'Clinical-CMS-Core'),
								'default' => false,
								'type' => 'enable',
            ) );
             */
        //Save settings button
        $generalPanel->createOption(array(
            'type' => 'save',
            'id' => 'opopopopopopopopopopo',
        ));

        //Admin messages
        $generalPanel->createOption(array(
            'name' => __('Admin Message', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_header_message',
            'type' => 'heading',
        ));
        $generalPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Show a message to all logged-in users using the site admin.', 'Clinical-CMS-Core'),
        ));
        $generalPanel->createOption(array(
            'name' => __('Display \'Admin\' message', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_message',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $generalPanel->createOption(array(
            'name' => __('\'Admin\' message type', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_message_type',
            'desc' => __('The message type', 'Clinical-CMS-Core'),
            'type' => 'select',
            'options' => array(
                'true' => 'Alert',
                'false' => 'Notice',
            ),
            'default' => 'false',
        ));
        $generalPanel->createOption(array(
            'name' => __('\'Admin\' message', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_message_text',
            'type' => 'textarea',
            'desc' => __('The message text to display', 'Clinical-CMS-Core'),
            'placeholder' => __('Type your message here', 'Clinical-CMS-Core'),
        ));
        //Save settings button
        $generalPanel->createOption(array(
            'type' => 'save',
            'id' => 'rtrtrtrtrtrttttttttttt',
        ));

        //redirect non-admins away from WP Admin area
        $generalPanel->createOption(array(
            'name' => __('Admin Bar Tweaks', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_non_admin_redirect_header',
            'type' => 'heading',
        ));
        $generalPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Control the appearance of the Admin bar.', 'Clinical-CMS-Core'),
        ));
        $generalPanel->createOption(array(
            'name' => __('Redirect non-admins?', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_non_admin_redirect',
            'desc' => __('Prevent users from vieweing your WP admin area after logging-in.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $generalPanel->createOption(array(
            'name' => __('Hide the \'Admin\' bar?', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_bar_remove',
            'desc' => __('Choose whether to show or hide the admin bar from logged-in non-admins.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $generalPanel->createOption(array(
            'name' => __('Remove \'edit profile\' link?', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_non_admin_remove',
            'desc' => __('Hide the edit profile and dashboard links from \'Admin\' bar.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $generalPanel->createOption(array(
            'name' => __('Remove \'Comments\' link?', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_comment_link',
            'desc' => __('Hide comments link from \'Admin\' bar if comments are disabled.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save settings button
        $generalPanel->createOption(array(
            'type' => 'save',
        ));

        //page & post editor
        $generalPanel->createOption(array(
            'name' => __('Pages & Posts', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_editor',
            'type' => 'heading',
        ));
        $generalPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Useful settings relating to the Page & Post editor screens.', 'Clinical-CMS-Core')
        ));
        $generalPanel->createOption(array(
            'name' => __('Set simple paste mode', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_editor_textmode',
            'desc' => __('Set TinyMCE editor to plain text by default. This options removes hidden code from MS Office programs etc.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $generalPanel->createOption(array(
            'name' => __('Add Featured Image column?', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_post_thumb',
            'desc' => __('Add column on the \'view all\' pages/posts screen showing which have a \'Featured Image\'.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $generalPanel->createOption(array(
            'name' => __('Enable ClinicalWP Shortcodes', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_editor_shortcodes',
            'desc' => __('Adds a dropdownlist with useful legacy shortcodes to the default page & post editor. [Deprecated]', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save settings button
        $generalPanel->createOption(array(
            'type' => 'save',
            'id' => 'aaaaaaaaaazzzzs',
        ));

        //widgets
        $generalPanel->createOption(array(
            'name' => __('Widgets', 'Clinical-CMS-Core'),
            'id' => 'clinical_widget',
            'type' => 'heading',
        ));
        $generalPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Allow the use of shortcodes in widgets.', 'Clinical-CMS-Core'),
        ));
        $generalPanel->createOption(array(
            'name' => __('Allow Shortcodes', 'Clinical-CMS-Core'),
            'id' => 'clinical_widget_Shortcodes',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save settings button
        $generalPanel->createOption(array(
            'type' => 'save',
            'id' => 'xxxxxxxxxxx',
        ));


        //create appearance panel
        $appearancePanel = $adminPanel->createTab(array(
            'name' => __('Appearance', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Customise the look of your site.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('Appearance', 'Clinical-CMS-Core'),
        ));
        //front-end css
        $appearancePanel->createOption(array(
            'name' => __('Frontend custom CSS', 'Clinical-CMS-Core'),
            'id' => 'clinical_custom_css_heading',
            'type' => 'heading',
        ));
        $appearancePanel->createOption(array(
            'type' => 'note',
            'desc' => __('Custom CSS rules added here will be applied to the site front-end', 'Clinical-CMS-Core'),
        ));
        $appearancePanel->createOption(array(
            'name' => 'Custom CSS',
            'id' => 'clinical_custom_css',
            'type' => 'code',
            'desc' => __('CSS and SCSS formats supported', 'Clinical-CMS-Core'),
            'lang' => 'css',
        ));
        //Save settings button
        $appearancePanel->createOption(array(
            'type' => 'save',
            'id' => 'uuuuuuuqqqqqqqqquuju',
        ));

        //Login screen logo
        $appearancePanel->createOption(array(
            'name' => __('Login screen customisation', 'Clinical-CMS-Core'),
            'id' => 'clinical_login_logo',
            'type' => 'heading',
        ));
        $appearancePanel->createOption(array(
            'type' => 'note',
            'desc' => __('Customise the appearance of the login screen.', 'Clinical-CMS-Core'),
        ));
        $appearancePanel->createOption(array(
            'name' => __('Custom login image', 'Clinical-CMS-Core'),
            'id' => 'clinical_login_logo_image',
            'desc' => __('Add your company logo to the login screen.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $appearancePanel->createOption(array(
            'name' => __('Upload image', 'Clinical-CMS-Core'),
            'id' => 'clinical_login_upload_image',
            'type' => 'upload',
            'placeholder' => __('File location', 'Clinical-CMS-Core'),
            'size' => '292,92',
            'desc' => __('Recommended size: 92px(h) x 292px(w).', 'Clinical-CMS-Core'),
            //'default' => ''.plugins_url( '../clinical_custom/login.css' , __FILE__ ).'', 
        ));
        $appearancePanel->createOption(array(
            'name' => __('Login background colour', 'Clinical-CMS-Core'),
            'id' => 'clinical_login_background_color',
            'type' => 'color',
            'desc' => __('Select a colour for the login screen background. To disable this feature, simply delete the value field', 'Clinical-CMS-Core'),
        ));
        //Save settings button
        $appearancePanel->createOption(array(
            'type' => 'save',
            'id' => 'uuuuuuuqqqqqqqqqqqquuju',
        ));

        //admin design
        $appearancePanel->createOption(array(
            'name' => __('Admin colour options', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_colours',
            'type' => 'heading',
        ));
        $appearancePanel->createOption(array(
            'type' => 'note',
            'desc' => __('Control the colour scheme(s) available to users of the WordPress Dashboard / admin areas.', 'Clinical-CMS-Core'),
        ));
        $appearancePanel->createOption(array(
            'name' => __('ClinicalWP colour scheme', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_skin',
            'desc' => __('Add the ClinicalWP custom \'Admin\' colour scheme as an option in your profile settings? ', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $appearancePanel->createOption(array(
            'name' => __('Remove Colour schemes', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_colour_scheme',
            'desc' => __('Prevent users from changing their admin colour scheme? If ClinicalWP colour scheme is also enabled, all users will use the ClinicalWP scheme.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save settings button
        $appearancePanel->createOption(array(
            'type' => 'save',
            'id' => 'uuuuuuusssssqqqqqqqquuju',
        ));

        //Set default Gravatar
        $appearancePanel->createOption(array(
            'name' => __('Default User Avatar', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_profile',
            'type' => 'heading',
        ));
        $appearancePanel->createOption(array(
            'type' => 'note',
            'desc' => __('Hate seeing user comments and profiles missing a photo/image? Would you rather use your company logo or other image instead of the boring \'Mystery Man\'? Upload your prefered avatar to make it the default & maximise your branding opportunities', 'Clinical-CMS-Core'),
        ));
        $appearancePanel->createOption(array(
            'name' => __('Custom profile image', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_profile_gravatar',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $appearancePanel->createOption(array(
            'name' => __('Upload image', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_profile_gravatar_image',
            'type' => 'upload',
            'placeholder' => __('File location', 'Clinical-CMS-Core'),
        ));
        //Save settings button
        $appearancePanel->createOption(array(
            'type' => 'save',
            'id' => 'uuuuuuuuuuuuuju',
        ));


        //force featured images
        $appearancePanel->createOption(array(
            'name' => __('Featured Images', 'Clinical-CMS-Core'),
            'id' => 'clinical_force_featured_image',
            'type' => 'heading',
        ));
        $appearancePanel->createOption(array(
            'type' => 'note',
            'desc' => __('Every page & post should have a featured image! This image is used by social media and websites when someone shares a link to your page. It\'s also great for SEO puirposes.<br/>When set, any pages/posts missing a featured image will be allocated one from the relavent collection below. If no images are available, pages/posts will be saved as \'Drafts\' rather than being published. To publish the page / post a featured image will be required.', 'Clinical-CMS-Core'),
        ));
            $appearancePanel->createOption(array(
                'name' => __('Require Images?', 'Clinical-CMS-Core'),
                'id' => 'clinical_force_featured_image_enable',
                'desc' => __('Force posts / pages to have a \'Featured Image\' before being published.', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $appearancePanel->createOption(array(
                'name' => 'Default Image Pool: Pages',
                'id' => 'clinical_force_featured_image_pages',
                'desc' => __('When a page is published without a \'Featured Image\' one is automatically added from these images.', 'Clinical-CMS-Core'),
                'type' => 'gallery',
            ));
            $appearancePanel->createOption(array(
                'name' => 'Default Image Pool: Posts',
                'id' => 'clinical_force_featured_image_posts',
                'desc' => __('When a post is published without a \'Featured Image\' one is automatically added from these images.', 'Clinical-CMS-Core'),
                'type' => 'gallery',
            ));
        //Save settings button
        $appearancePanel->createOption(array(
            'type' => 'save',
            'id' => 'uoplikmujnyhbtvrecxuuuju',
        ));




        /*
            //custom css 
            $appearancePanel->createOption( array(
                'name' => __('Custom CSS Markup', 'Clinical-CMS-Core'),
                'id' => 'clinical_css_markup',
                'type' => 'heading',
            ) );
            $appearancePanel->createOption( array(
                'type' => 'note',
                'desc' => __('Add your custom css markup to alter the appearance of your website', 'Clinical-CMS-Core'),
            ) );          
            $appearancePanel->createOption( array(
                'name' => 'Custom CSS',
                'id' => 'custom_css',
                'type' => 'code',
                'desc' => 'Put your custom CSS rules here',
                'lang' => 'css',
                'height' => '300',
            ) );
            //Save settings button
            $appearancePanel->createOption( array(
                'type' => 'save',
                'id' => 'uuuuuuuddllkkuuuuuuju',
            ) );
             */


        //create SEO / optimisations panel
        $seoPanel = $adminPanel->createTab(array(
            'name' => __('S.E.O.', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Improve Search Engine ranking.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('S.E.O.', 'Clinical-CMS-Core'),
        ));
        //sitemap
        $seoPanel->createOption(array(
            'name' => __('Sitemap', 'Clinical-CMS-Core'),
            'id' => 'clinical_sitemap',
            'type' => 'heading',
        ));
        $seoPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Automatically generate a sitemap of all pages, posts and categories. Also adds a reference to <strong>' . site_url() . '/sitemap-index.xml</strong> in the head of each page for seo purposes.', 'Clinical-CMS-Core'),
        ));
        $seoPanel->createOption(array(
            'name' => __('Generate Sitemaps', 'Clinical-CMS-Core'),
            'id' => 'clinical_sitemap_create',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => true,
            'type' => 'enable',
        ));
        //Save Button
        $seoPanel->createOption(array(
            'type' => 'Save',
            'id' => 'swssese',
        ));
        //add seo metaboxes
        $seoPanel->createOption(array(
            'name' => __('SEO Meta Tags', 'Clinical-CMS-Core'),
            'id' => 'clinical_seo',
            'type' => 'heading',
        ));
        $seoPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Add SEO fields to the Page / Post edit screens & render as Meta data on your website.', 'Clinical-CMS-Core'),
        ));
        $seoPanel->createOption(array(
            'name' => __('Standard MetaTags', 'Clinical-CMS-Core'),
            'id' => 'clinical_seo_fields',
            'desc' => __('Add SEO Keyword & Description fields to pages & posts.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $seoPanel->createOption(array(
            'name' => __('Facebook MetaTags', 'Clinical-CMS-Core'),
            'id' => 'clinical_seo_facebook',
            'desc' => __('Add Facebook OpenGraph fields to pages & posts. Requires \'Standard MetaTags\' to be enabled.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $seoPanel->createOption(array(
            'name' => __('Twitter MetaTags', 'Clinical-CMS-Core'),
            'id' => 'clinical_seo_twitter',
            'desc' => __('Add Twitter Card fields to pages & posts. Requires \'Standard MetaTags\' to be enabled.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $seoPanel->createOption(array(
            'name' => __('Google+ MetaTags', 'Clinical-CMS-Core'),
            'id' => 'clinical_seo_google',
            'desc' => __('Add Google+ fields to pages & posts. Requires \'Standard MetaTags\' to be enabled.', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save Button
        $seoPanel->createOption(array(
            'type' => 'Save',
            'id' => 'swsjnlknpnibsese',
        ));
        //social profiles
        $seoPanel->createOption(array(
            'name' => __('Social Media Profiles', 'Clinical-CMS-Core'),
            'id' => 'clinical_twit_profiles',
            'type' => 'heading',
        ));
        $seoPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Add your default Twitter credentials, you can override these on individual pages.', 'Clinical-CMS-Core'),
        ));
        $seoPanel->createOption(array(
            'name' => __('Twitter Publisher', 'Clinical-CMS-Core'),
            'id' => 'clinical_twit_publisher',
            'desc' => __('Twitter username of publisher(exclude @ symbol)', 'Clinical-CMS-Core'),
            'type' => 'text',
        ));
        $seoPanel->createOption(array(
            'name' => __('Twitter Author', 'Clinical-CMS-Core'),
            'id' => 'clinical_twit_author',
            'desc' => __('Twitter username of author(exclude @ symbol)', 'Clinical-CMS-Core'),
            'type' => 'text',
        ));
        $seoPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Add your default Facebook credentials, you can override these on individual posts.', 'Clinical-CMS-Core'),
        ));
        $seoPanel->createOption(array(
            'name' => __('Facebook Admin ID', 'Clinical-CMS-Core'),
            'id' => 'clinical_fb_aminID',
            'desc' => __('The ID number from your <a href="http://findmyfbid.com/" target= "_external">Fb profile</a>', 'Clinical-CMS-Core'),
            'type' => 'text',
        ));
        $seoPanel->createOption(array(
            'name' => __('Facebook Publisher', 'Clinical-CMS-Core'),
            'id' => 'clinical_fb_publisher',
            'desc' => __('Full link to Publisher profile on Facebook', 'Clinical-CMS-Core'),
            'type' => 'text',
        ));
        $seoPanel->createOption(array(
            'name' => __('Facebook Author', 'Clinical-CMS-Core'),
            'id' => 'clinical_fb_author',
            'desc' => __('Full link to Author profile on Facebook', 'Clinical-CMS-Core'),
            'type' => 'text',
        ));
        $seoPanel->createOption(array(
            'name' => __('Facebook AppID', 'Clinical-CMS-Core'),
            'id' => 'clinical_fb_appID',
            'desc' => __('Your Facebook AppID', 'Clinical-CMS-Core'),
            'type' => 'text',
        ));
        //Save Button
        $seoPanel->createOption(array(
            'type' => 'Save',
            'id' => 'swsjccwrwfbsese',
        ));

        //Image alt tags
        if (class_exists('Clinical_Generate_Alts_Plugin')) {
            //create image alt tags
            $seoPanel->createOption(array(
                'name' => __('Image Alt Tags', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $seoPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Automatically generate SEO rich image alt tags based on post / page data.', 'Clinical-CMS-Core')
            ));
            $seoPanel->createOption(array(
                'name' => __('Auto Generate Tags', 'Clinical-CMS-Core'),
                'id' => 'clinical_alt_enable',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $seoPanel->createOption(array(
                'name' => __('Alt Tag Content', 'Clinical-CMS-Core'),
                'id' => 'clinical_alt_tags',
                'desc' => __('Drag the boxes to create your custom alt tag content and order. To remove any option from the alt tag simply click the \'eye\' icon alongside it.', 'Clinical-CMS-Core'),
                'type' => 'sortable',
                'options' => array(
                    /*'current' => 'Current Alt Tag',*/
                    'post_title' => 'Page / Post Title',
                    'site_title' => 'Site Title',
                    'category' => 'Page / Post Category',
                    'number' => 'Random Number',
                )
            ));
            // Create options in My Layout Panel
            $seoPanel->createOption(array(
                'type' => 'Save',
                'id' => 'aaqaaaaaaaaaaa',
            ));
        }

        //Comment Link Optimisation
        $seoPanel->createOption(array(
            'name' => __('Comment Links', 'Clinical-CMS-Core'),
            'id' => 'clinical_comment_links',
            'type' => 'heading',
        ));
        $seoPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Open all links and author urls in comments section in a seperate tab, and add \'nofollow\' attribute for SEO purposes.', 'Clinical-CMS-Core'),
        ));
            $seoPanel->createOption(array(
                'name' => __('Optimise Comment Links', 'Clinical-CMS-Core'),
                'id' => 'clinical_comment_links_enable',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
        //Save Button
        $seoPanel->createOption(array(
            'type' => 'Save',
            'id' => 'zszszszszszs',
        ));

        //External links
        $seoPanel->createOption(array(
            'name' => __('External Page Links', 'Clinical-CMS-Core'),
            'id' => 'clinical_external_links',
            'type' => 'heading',
        ));
        $seoPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Use Javascript to force links to external sites to open in a new tab. If you use multiple domains for your site, this may cause issues.', 'Clinical-CMS-Core'),
        ));
            $seoPanel->createOption(array(
                'name' => __('Optimise external Links', 'Clinical-CMS-Core'),
                'id' => 'clinical_external_links_enable',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
        //Save Button
        $seoPanel->createOption(array(
            'type' => 'Save',
            'id' => 'zszszszszszsasxcddf',
        ));


        //create optimisations panel
        $speedPanel = $adminPanel->createTab(array(
            'name' => __('Performance', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Increase the speed with which your site loads.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('PErformance', 'Clinical-CMS-Core'),
        ));

        //Modify ETag headers
        $speedPanel->createOption(array(
            'name' => __('Persistent Connections', 'Clinical-CMS-Core'),
            'id' => 'clinical_keep_alive_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Performs tweaks to the \'.htaccess\' file to enable persistent connections allowing multiple files to be transferred per connection. We will attempt to make a backup before modifying \'.htaccess\'.', 'Clinical-CMS-Core'),
        ));
        $speedPanel->createOption(array(
            'name' => __('Keep Alive', 'Clinical-CMS-Core'),
            'id' => 'clinical_keep_alive_enable',
            'desc' => __('Send instruction to server.', 'Clinical-CMS-Core'),
            'default' => true,
            'type' => 'enable',
        ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'iokpok',
        ));

        //Instant Page
        $speedPanel->createOption(array(
            'name' => __('Instant Page', 'Clinical-CMS-Core'),
            'id' => 'clinical_instant_page_header',
            'type' => 'heading',
        ));
            $speedPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Before a user clicks on a link, they hover their mouse over that link. When a user has hovered for 65 ms there is one chance out of two that they will click on that link, so instant.page starts preloading at this moment, leaving on average over 300 ms for the page to preload. On mobile, a user starts touching their display before releasing it, leaving on average 90 ms for the page to preload.', 'Clinical-CMS-Core'),
            ));
            $speedPanel->createOption(array(
                'name' => __('Preload Pages [Beta]', 'Clinical-CMS-Core'),
                'id' => 'clinical_instant_page_enable',
                'desc' => __('Preload links/page using Instant.Page script [<a href="https://instant.page/" target="_external">More info</a>].', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $speedPanel->createOption(array(
                'name' => __('Script Source', 'Clinical-CMS-Core'),
                'id' => 'clinical_instant_page_source',
                'options' => array(
                    '1' => __('Local(default)', 'Clinical-CMS-Core'),
                    '2' => 'CDN' . __("(recommended EU)", 'Clinical-CMS-Core'),
                    '3' => 'CDN-JS' . __("(recommended none-EU)", 'Clinical-CMS-Core'),
                ),
                'default' => '1',
                'type' => 'radio',
            ));
            $speedPanel->createOption(array(
                'name' => __('Query Strings', 'Clinical-CMS-Core'),
                'id' => 'clinical_instant_page_strings_enable',
                'desc' => __(' By default, pages with a query string (a "?") in their URL aren’t preloaded. This is to avoid loading logout pages, etc. Enable this to allow these pages to be preloaded. Use caution and be sure to add exclusions below as necessary. (default: Disabled).', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $speedPanel->createOption(array(
                'name' => 'Exclusion Tags',
                'id' => 'clinical_instant_page_exclusion',
                'type' => 'textarea',
                'desc' => 'Add a comma separated list of query selectors here that you wish to exclude from preloading.',
                'placeholder' => '#logout, .linkclass-to-ignore, ul > li > a',
            ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'iogdgskpok',
        ));

        //Browser Caching
        $speedPanel->createOption(array(
            'name' => __('Browser Caching', 'Clinical-CMS-Core'),
            'id' => 'clinical_browser_caching',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Performs tweaks to the \'.htaccess\' file to enable browser level file caching. Alternatively set Cache-Control/Expires headers if mod_deflate is not installed. We will attempt to make a backup before modifying \'.htaccess\'.', 'Clinical-CMS-Core'),
        ));
        $speedPanel->createOption(array(
            'name' => __('Enable Browser Caching', 'Clinical-CMS-Core'),
            'id' => 'clinical_browser_caching_enable',
            'options' => array(
                '1' => 'ExpiresByType' . __("(recommended)", 'Clinical-CMS-Core'),
                '2' => 'Cache-Control/Expires',
                '3' => __('None', 'Clinical-CMS-Core'),
            ),
            'default' => '3',
            'type' => 'radio',
        ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'fcytffftm',
        ));

        //Modify ETag headers
        $speedPanel->createOption(array(
            'name' => __('ETag header', 'Clinical-CMS-Core'),
            'id' => 'clinical_ETag_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Performs tweaks to the \'.htaccess\' file to remove the ETag. Alternatively modify the ETag header for greater compatibility. We will attempt to make a backup before modifying \'.htaccess\'.', 'Clinical-CMS-Core'),
        ));
        $speedPanel->createOption(array(
            'name' => __('Optimise ETag header', 'Clinical-CMS-Core'),
            'id' => 'clinical_ETag_enable',
            'options' => array(
                '1' => 'Disable' . __('(recommended)', 'Clinical-CMS-Core'),
                '2' => 'Modify' . __('(experimental)', 'Clinical-CMS-Core'),
                '3' => __('None', 'Clinical-CMS-Core'),
            ),
            'default' => '3',
            'type' => 'radio',
        ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'iouojjjjpokpok',
        ));

        //Remove version info from CSS & JS
        $speedPanel->createOption(array(
            'name' => __('Remove Version Querystrings', 'Clinical-CMS-Core'),
            'id' => 'clinical_remove_versions_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Improve cachability of static resources such as JS & CSS by removing version id\'s.', 'Clinical-CMS-Core'),
        ));
            $speedPanel->createOption(array(
                'name' => __('Remove Versions', 'Clinical-CMS-Core'),
                'id' => 'clinical_remove_versions',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'wsdoooodqd',
        ));

        //object Caching
        $speedPanel->createOption(array(
            'name' => __('Data Object Caching', 'Clinical-CMS-Core'),
            'id' => 'clinical_cache_object_header',
            'type' => 'heading',
        ));
        if (class_exists('dummyClinicalWPDataCache')) {
            $speedPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Cache data objects and reduce calls to the Database, to help boost page load speeds.', 'Clinical-CMS-Core'),
            ));
            $speedPanel->createOption(array(
                'name' => __('Cache Data Objects', 'Clinical-CMS-Core'),
                'id' => 'clinical_cache_objects',
                'desc' => __('It\'s recommended that this be temporarily disabled if changing other settings.', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $speedPanel->createOption(array(
                'name' => __('Cache Server IP', 'Clinical-CMS-Core'),
                'id' => 'clinical_cache_objects_server_ip',
                'desc' => __('Enter the IP of the Memcache(d) Server (eg 127.0.0.1)', 'Clinical-CMS-Core'),
                'default' => '127.0.0.1',
                'type' => 'text',
            ));
            $speedPanel->createOption(array(
                'name' => __('Cache Server Port', 'Clinical-CMS-Core'),
                'id' => 'clinical_cache_objects_server_port',
                'desc' => __('Enter the PORT of the Memcache(d) Server (eg 11211)', 'Clinical-CMS-Core'),
                'default' => '11211',
                'type' => 'text',
            ));
        } //end data cache plugin requirement
        else { //data cache plugin so show reminder
            $speedPanel->createOption(array(
                'id' => 'clinical_speed_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-data-cache-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Data Cache Pro, Not Installed!</a></h1><p>You are missing out on significant WP speed boosts! Cache data and save calls to the database, so pages load quicker.</p>', 'Clinical-CMS-Core'),
            ));
        }
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'fcytsventmthgrwecqwemjujujujujimnimikffftm',
        ));

        //Gravatar Caching
        $speedPanel->createOption(array(
            'name' => __('Gravatar Caching', 'Clinical-CMS-Core'),
            'id' => 'clinical_cache_gravatar_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Load Gravatar images from a locally created cache.', 'Clinical-CMS-Core'),
        ));
        $speedPanel->createOption(array(
            'name' => __('Cache Gravatar Images', 'Clinical-CMS-Core'),
            'id' => 'clinical_cache_gravatar',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'fcytmimnimikffftm',
        ));


        //HTML / JSS / CSS Minify
        $speedPanel->createOption(array(
            'name' => __('Minify Output HTML / JS / CSS', 'Clinical-CMS-Core'),
            'id' => 'clinical_minify_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Minify the inline html content output for each page, but not referenced external files. This makes the file size smaller and will reduce page load times.', 'Clinical-CMS-Core'),
        ));
        $speedPanel->createOption(array(
            'name' => __('Enable Minify', 'Clinical-CMS-Core'),
            'id' => 'clinical_minify_enable',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $speedPanel->createOption(array(
            'name' => __('Ignore Content', 'Clinical-CMS-Core'),
            'id' => 'clinical_minify_ignores',
            'type' => 'multicheck',
            'desc' => __('Specify inline content type(s) to ignore', 'Clinical-CMS-Core'),
            'options' => array(
                '1' => __('Ignore  CSS', 'Clinical-CMS-Core'),
                '2' => __('Ignore JavaScript', 'Clinical-CMS-Core'),
                '3' => __('Ignore comments', 'Clinical-CMS-Core'),
            ),
            'default' => array('2',),
        ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'wsdqwdwqdqd',
        ));

        //Loads core WP scripts from wp.com
        $speedPanel->createOption(array(
            'name' => __('WP Core CDN', 'Clinical-CMS-Core'),
            'id' => 'clinical_swap_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Loading the core WordPress scripts and styles from WordPress.com may improve site load times for visitors that have these scripts cached after visiting other WordPress websites.<br/>
								<!-- Alternatively load just JQuery from the Google CDN leaving all other core scripts served locally.<br/>
								Cloudflare CDN can also deliver other JQuery files for added performance. In cases where the WP JQuery version is not available on the CDN the file will be loaded from your server. -->', 'Clinical-CMS-Core'),
        ));
        $speedPanel->createOption(array(
            'name' => __('Script Replacement', 'Clinical-CMS-Core'),
            'id' => 'clinical_swap_enable',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'radio',
            'options' => array(
                '1' => 'Disable' . __('(default)', 'Clinical-CMS-Core'),
                '2' => 'WordPress.com' . __('(recommended)', 'Clinical-CMS-Core'),
                /*'3' => 'JQuery CDN'.  __('(replace only JQuery core file)', 'Clinical-CMS-Core'),
                    '4' => 'Cloudflare / CDNJS'.  __('(best for sites using Cloudflare)', 'Clinical-CMS-Core'),*/
            ),
            'default' => '1',
        ));
        /*
            $speedPanel->createOption( array(
                'name' => __('Extra Scripts', 'Clinical-CMS-Core'),
                'id' => 'clinical_CDNJS_extra',
                'desc' => __('When using CDNJS / Cloudflare option, ClinicalWP can try to replace additional scripts from the network.', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ) );
             */
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'cewcwecwcwc',
        ));


        //Use a CDN or subdomain CDN
        $speedPanel->createOption(array(
            'name' => __('Content Delivery Network', 'Clinical-CMS-Core'),
            'id' => 'clinical_CDN_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Deliver frontend static content via a CDN or a subdomain (Pseudo CDN) to improve page load speeds.', 'Clinical-CMS-Core'),
        ));
            $speedPanel->createOption(array(
                'name' => __('Use CDN', 'Clinical-CMS-Core'),
                'id' => 'clinical_CDN_enable',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $speedPanel->createOption(array(
                'name' => __('CDN URL', 'Clinical-CMS-Core'),
                'id' => 'clinical_CDN_uri',
                'desc' => __('Enter CDN URL or SUBDOMAIN in full (eg http://subdomain.domain.com)', 'Clinical-CMS-Core'),
                'default' => 'http://subdomain.domain.com',
                'type' => 'text',
            ));
            $speedPanel->createOption(array(
                'name' => __('Ignore Content', 'Clinical-CMS-Core'),
                'id' => 'clinical_CDN_ignores',
                'type' => 'multicheck',
                'desc' => __('Specify any content types to ignore', 'Clinical-CMS-Core'),
                'options' => array(
                    '1' => __('Ignore themes files', 'Clinical-CMS-Core'),
                    '2' => __('Ignore plugin files', 'Clinical-CMS-Core'),
                    '3' => __('Ignore scripts', 'Clinical-CMS-Core'),
                    '4' => __('Ignore styles', 'Clinical-CMS-Core'),
                ),
            ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'coksdkcsdkco',
        ));

        //javascript
        $speedPanel->createOption(array(
            'name' => __('Javascript & CSS Optimisations', 'Clinical-CMS-Core'),
            'id' => 'clinical_scripts',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Optimise the CSS  & JavaScript in your site html. Sort scripts and styles to run in the most efficient order. Load scripts in the footer, header or leave as default. Add defer or Async directives for best performance to both loaded scripts and inline scripts. ', 'Clinical-CMS-Core'),
        ));
            $speedPanel->createOption(array(
                'name' => __('Order scripts & styles', 'Clinical-CMS-Core'),
                'id' => 'clinical_scripts_enable',
                'default' => false,
                'type' => 'enable',
                'desc' => __('Optimise the order of scripts & styles.', 'Clinical-CMS-Core'),
            ));
            $speedPanel->createOption(array(
                'name' => __('Defer / Async JavaScript', 'Clinical-CMS-Core'),
                'id' => 'clinical_scripts_defer',
                'options' => array(
                    '1' => 'Defer' . __("(recommended)", 'Clinical-CMS-Core'),
                    '2' => 'Async' . __("(fastest)", 'Clinical-CMS-Core'),
                    '3' => __('Default', 'Clinical-CMS-Core'),
                ),
                'default' => '3',
                'type' => 'radio',
                'desc' => __('Try to add \'defer\' or \'async\' attribute to all JavaScript loaded (excludes IE9, JQuery and Admin scripts).', 'Clinical-CMS-Core'),
            ));
            $speedPanel->createOption(array(
                'name' => __('Apply Settings to Inline JavaScripts', 'Clinical-CMS-Core'),
                'id' => 'clinical_scripts_defer_inline',
                'default' => false,
                'type' => 'enable',
                'desc' => __('Try to apply same \'defer\' / \'async\' to inline scripts.', 'Clinical-CMS-Core'),
            ));
            $speedPanel->createOption(array(
                'name' => __('Move Scripts', 'Clinical-CMS-Core'),
                'id' => 'clinical_scripts_location',
                'desc' => __("Use footer if not using 'defer' option above.", 'Clinical-CMS-Core'),
                'options' => array(
                    '1' => 'Head' . __("(recommended)", 'Clinical-CMS-Core'),
                    '2' => 'Footer',
                    '3' => __('Default', 'Clinical-CMS-Core'),
                ),
                'default' => '3',
                'type' => 'radio',
                'desc' => __('Attempt to place all JavaScript in header or footer', 'Clinical-CMS-Core'),
            ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'ppppppppppp',
        ));

        //Compression
        $speedPanel->createOption(array(
            'name' => __('File Compression', 'Clinical-CMS-Core'),
            'id' => 'clinical_gzip_header',
            'type' => 'heading',
        ));
        $speedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Performs tweaks to the \'.htaccess\' file to enable GZip/DEFLATE file compression. Alternatively try to use php Zlib module to perform compression. We will attempt to make a backup before modifying \'.htaccess\'. This helps improve front-end load times.', 'Clinical-CMS-Core'),
        ));
            $speedPanel->createOption(array(
                'name' => __('Enable Compression', 'Clinical-CMS-Core'),
                'id' => 'clinical_gzip_enable',
                'options' => array(
                    '1' => 'Web Server' . __("(recommended)", 'Clinical-CMS-Core'),
                    '2' => 'php',
                    '3' => __('None', 'Clinical-CMS-Core'),
                ),
                'default' => '3',
                'type' => 'radio',
            ));
        //Save Button
        $speedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'nnknknn',
        ));

        /*
            //Add options for the Page Builder
            if(class_exists('WR_Pb_Init')){
                $generalPanel->createOption( array(
                    'name' => 'Enable Visual Editor',
                    'id' => 'clinical_visual_editor',
                    'desc' => 'Use Page Builder in the editor?',
                'default' => false,
                'type' => 'enable',
                ) );

                // Create options in My Layout Panel
                $generalPanel->createOption( array(
                    'type' => 'save',
                ) );
            }
             */

        //build a tab for Image Tools
        $toolsPanel = $adminPanel->createTab(array(
            'name' => __('Images Pro', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Advanced image optimisation settings.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('Images Pro', 'Clinical-CMS-Core'),
        ));
        if (class_exists('Clinical_Image_Tools_Plugin')) {
            // Create options in My Layout Panel
            $toolsPanel->createOption(array(
                'name' => __('Server Advice', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $toolsPanel->createOption(array(
                'id' => 'clinical_tools_status',
                'name' => __('Recommended libraries', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => get_option('CIT_Libraries'),
            ));
            //Save settings button
            $toolsPanel->createOption(array(
                'type' => 'Save',
                'id' => 'qqqaauuiolefwentynaqq',
            ));

            $toolsPanel->createOption(array(
                'name' => __('Image Enhancements', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $toolsPanel->createOption(array(
                'name' => __('Automatic Contrast Leveling?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_contrast',
                'desc' => __('', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => true,
            ));
            $toolsPanel->createOption(array(
                'name' => __('Automatic Enhance?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_enhance',
                'desc' => __('', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => true,
            ));
            $toolsPanel->createOption(array(
                'name' => __('Flatten Layers?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_flatten',
                'desc' => __('', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => true,
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Remove Exif data from JPGs, Colour profile is maintained (requires ImageMagick PHP library).', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Remove Exif Data?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_exif',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Optimise JPGs for web.', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Progressive JPG?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_progressive',
                'desc' => __('', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => true,
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Use slow / cpu intensive GD compression method (requires PHP GD library).', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Use GD Compression?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_usegd',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Reduce png file sizes (requires PNGQuant library).', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Compress PNGs?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_pngquant',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Make images look sharper (requires ImageMagick PHP library).', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Sharpen Images?', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_unsharp_mask',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            //Save settings button
            $toolsPanel->createOption(array(
                'type' => 'Save',
                'id' => 'qqqaaaqq',
            ));

            $toolsPanel->createOption(array(
                'name' => __('Advanced User Settings', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Set values for unsharp mask (requires ImageMagick PHP library).', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Unsharp Mask - Radius', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_radius',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'default' => '0',
                'step' => '0.01',
            ));
            $toolsPanel->createOption(array(
                'name' => __('Unsharp Mask - Sigma', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_sigma',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'default' => '0.5',
                'step' => '0.01',
            ));
            $toolsPanel->createOption(array(
                'name' => __('Unsharp Mask - Sharpening', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_sharpening',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'default' => '1.00',
                'step' => '0.01',
            ));
            $toolsPanel->createOption(array(
                'name' => __('Unsharp Mask - Threshold', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_threshold',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'default' => '0.05',
                'step' => '0.01',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Set JPG compression level (requires Imagick PHP library).', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Imagick JPG Compression', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_jpgcompression',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'default' => '92.00',
                'step' => '1',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Set GIF compression level (requires Imagick PHP library).', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Imagick GIF Compression', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_gifcompression',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'default' => '92.00',
                'step' => '1',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Set GD image quality for JPG (requires PHP GD library). Higher quality = bigger file size.', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('GD JPEG Quality', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_gdjpeg_compression',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '100',
                'default' => '75',
                'step' => '1',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Set GD PNG compression level (requires PHP GD library). Higher compression levels may cause issues.', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('GD PNG Compression', 'Clinical-CMS-Core'),
                'id' => 'clinical_tools_gdpng_compression',
                'desc' => '',
                'type' => 'number',
                'min' => '0',
                'max' => '9',
                'default' => '6',
                'step' => '1',
            ));
            //Save settings button
            $toolsPanel->createOption(array(
                'type' => 'Save',
                'id' => 'yuyyu',
            ));

            //uploaded original images
            $toolsPanel->createOption(array(
                'name' => __('Uploaded Images', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('WordPress keeps a full size unoptimised copy of every image uploaded. Crop these images to a useable size and save disk space.', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Optimise Image', 'Clinical-CMS-Core'),
                'id' => 'clinical_optimise_uploaded_img',
                'desc' => 'Optimise original images',
                'type' => 'enable',
                'default' => false,
            ));
            $toolsPanel->createOption(array(
                'name' => __('Maximum Height', 'Clinical-CMS-Core'),
                'id' => 'clinical_optimise_uploaded_img_height',
                'desc' => 'Any uploaded image higher than this will be resized',
                'type' => 'number',
                'min' => '1024',
                'max' => '3000',
                'default' => '2048',
                'step' => '1',
            ));
            $toolsPanel->createOption(array(
                'name' => __('Maximum Width', 'Clinical-CMS-Core'),
                'id' => 'clinical_optimise_uploaded_img_width',
                'desc' => 'Any uploaded image wider than this will be resized',
                'type' => 'number',
                'min' => '1024',
                'max' => '3000',
                'default' => '2048',
                'step' => '1',
            ));
            $toolsPanel->createOption(array(
                'name' => __('Image Quality', 'Clinical-CMS-Core'),
                'id' => 'clinical_optimise_uploaded_img_quality',
                'desc' => 'Sets the image quality',
                'type' => 'number',
                'min' => '1',
                'max' => '100',
                'default' => '90',
                'step' => '1',
            ));
            //Save settings button
            $toolsPanel->createOption(array(
                'type' => 'Save',
                'id' => 'yuninhihiuoooyyu',
            ));
            //uploaded original images
            $toolsPanel->createOption(array(
                'name' => __('Image Backups', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Whenever an image is manipulated via the \'Media Library\', a backup is created. This uses additional disk space and has a cumulative impact on the Database performance.', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Cleanup Image Edits', 'Clinical-CMS-Core'),
                'id' => 'clinical_limit_image_editor',
                'desc' => __('Keep only one set of image edits and remove these on image restore.', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            //Save settings button
            $toolsPanel->createOption(array(
                'type' => 'Save',
                'id' => 'yullplplplplplplplplplyyu',
            ));

            //uploaded original images
            $toolsPanel->createOption(array(
                'name' => __('Watermark', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $toolsPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Add a watermark to all images with the defined class [<a href="https://www.patrick-wied.at/static/watermarkjs/" target="_external">More info</a>]. Note, this will break animated gif images.', 'Clinical-CMS-Core'),
            ));
            $toolsPanel->createOption(array(
                'name' => __('Add Watermark', 'Clinical-CMS-Core'),
                'id' => 'clinical_watermark_enable',
                'desc' => 'Display a watermark on images',
                'type' => 'enable',
                'default' => false,
            ));
            /*
								$toolsPanel->createOption( array(
										'name' => 'CSS Class',
										'id' => 'clinical_watermark_class',
										'type' => 'text',
										'default' => 'watermark',
										'desc' => 'Watermark will only be added to images with this CSS class'
								) );
                 */
            $toolsPanel->createOption(array(
                'name' => 'Watermark Position',
                'id' => 'clinical_watermark_position',
                'options' => array(
                    '1' => 'top-left',
                    '2' => 'top-right',
                    '3' => 'bottom-right',
                    '4' => 'bottom-left',
                ),
                'type' => 'radio',
                'desc' => 'Select one',
                'default' => '3',
            ));
            $toolsPanel->createOption(array(
                'name' => 'Opacity',
                'id' => 'clinical_watermark_opacity',
                'type' => 'number',
                'desc' => 'Set the opacity of the watermark',
                'default' => '70',
                'max' => '100',
            ));
            $toolsPanel->createOption(array(
                'name' => 'Watermark Image',
                'id' => 'clinical_watermark_img',
                'type' => 'upload',
                'desc' => 'Upload an image to be used as the watermark'
            ));
            $toolsPanel->createOption(array(
                'type' => 'Save',
                'id' => 'yuninhjjjjihiuoooyyu',
            ));
        } //end image tools extension check
        else { //image tools not installed so show reminder
            $toolsPanel->createOption(array(
                'name' => __('Image Tools Extension', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $toolsPanel->createOption(array(
                'id' => 'clinical_tools_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-images-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Images Pro, Not Installed!</a></h1><p>You are missing out on more than 20 image optimisations, that make your site load faster, look great, and save you money.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //Login Security
        $securityPanel = $adminPanel->createTab(array(
            'name' => __('Security / Firewall', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Secure Your Site.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('Login Security', 'Clinical-CMS-Core'),
        ));

        $securityPanel->createOption(array(
            'name' => __('Basic Hardening', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        if (function_exists('limit_login_setup')) {
            $securityPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Some safe first steps to securing your site.', 'Clinical-CMS-Core'),
            ));
            $securityPanel->createOption(array(
                'name' => __('Force Admin SSL', 'Clinical-CMS-Core'),
                'id' => 'clinical_enable_ssl_admin',
                'desc' => __('Force all admin traffic over a secure SSL connection [<a href="https://codex.wordpress.org/Administration_Over_SSL" target="_external" title="WordPress Codex">More info</a>].', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Lock Admin Editors', 'Clinical-CMS-Core'),
                'id' => 'clinical_filesplugins_editor',
                'desc' => __('Prevents editing of Plugins & Themes via the admin based editors.', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('File Modification', 'Clinical-CMS-Core'),
                'id' => 'clinical_theme_editor',
                'desc' => __('Enable to prevent updates & installation of Plugins & Themes via the admin area. Note: the \'Lock Files & Themes Editor\' option will also be considered enabled.', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Hide WP Version', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_wpversion',
                'desc' => __('Removes references to the WordPress version from site header & RSS feed. Hackers could use this info to target known version specific WordPress weaknesses.', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Hide WP ReadMe', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_readme',
                'desc' => __('Prevent the readme.html file being accessed directly. This file contains info about the WordPress version.', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Directory Listing', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_indexes',
                'desc' => __('Prevent viewing of directories (folders) when no index file is available.', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            //Save settings button
            $securityPanel->createOption(array(
                'type' => 'Save',
                'id' => 'sdvtrjmntmyiuio',
            ));
        } //end security extension check
        else { //security extension not installed so show reminder
            $securityPanel->createOption(array(
                'id' => 'clinical_basic_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-security-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Security Pro, Not Installed!</a></h1><p>You are missing out on crucial security features, that make your site safer, protect your reputation, and potentially save you money.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //Hardening options
        $securityPanel->createOption(array(
            'name' => __('Advanced Hardening', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        if (function_exists('limit_login_setup')) {
            $securityPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Make your site more secure by reducing the options for hackers to cause damage.', 'Clinical-CMS-Core'),
            ));

            $securityPanel->createOption(array(
                'name' => __('Secure Includes Folder', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_includes',
                'desc' => __('Prevent files in the wp-includes folder being accessed directly. Hackers may try to target core WordPress files in this folder.', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Secure Content Folder', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_content',
                'desc' => __('Prevent files in the wp-content folder being accessed directly. Hackers may try to target core WordPress files in this folder.', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Secure Uploads Folder', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_uploads',
                'desc' => __('Prevent files in the wp-content folder being accessed directly. Hackers may try to target theme/plugin files in this folder. <strong>Note: This may cause issues with some poorly coded themes/plugins!</strong>. ', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('MIME-sniffing', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_sniffing',
                'desc' => __('Prevents attempts at MIME-sniffing a response from the declared content-type [<a href="http://msdn.microsoft.com/en-us/library/ie/gg622941(v=vs.85).aspx" target="_external" >More info</a>].', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Click Jacking', 'Clinical-CMS-Core'),
                'id' => 'clinical_click_jacking',
                'desc' => __('Improve the security of your site against Click-Jacking [<a href="https://blog.mozilla.org/security/2013/12/12/on-the-x-frame-options-security-header/" target="_external" >More info</a>].', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('X-XSS-Protection', 'Clinical-CMS-Core'),
                'id' => 'clinical_xss_protection',
                'desc' => __('Improve the security of your site against some types of XSS (cross-site scripting) attacks.', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('HTTP Trace Method', 'Clinical-CMS-Core'),
                'id' => 'clinical_trace_method',
                'desc' => __('This method has no real-life usage and can be misused for XST (cross-site tracing) attacks [<a href="https://www.owasp.org/index.php/Test_HTTP_Methods_(OTG-CONFIG-006)" target="_external" >More info</a>].', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Protect XML-RPC', 'Clinical-CMS-Core'),
                'id' => 'clinical_disable_xmlrpc',
                'desc' => __('<strong>Not recommended!</strong> Enable to prevent access / use of XML-RPC functionality [<a href="https://www.wordfence.com/blog/2015/10/should-you-disable-xml-rpc-on-wordpress/" target="_external" >More info</a>].', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            //Save settings button
            $securityPanel->createOption(array(
                'type' => 'Save',
                'id' => 'sdvtrjmntvdsvymyiuio',
            ));
        } //end security extension check
        else { //security extension not installed so show reminder
            $securityPanel->createOption(array(
                'id' => 'clinical_advanced_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-security-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Security Pro, Not Installed!</a></h1><p>You are missing out on advanced security features, that make your site safer, protect your reputation, and potentially save you money.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //external security monitors
        $securityPanel->createOption(array(
            'name' => __('Site Monitors', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        if (function_exists('limit_login_setup')) {
            $securityPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Perform weekly checks against 3rd Party tools to verify your site status. Results will be shown on your <a href="/wp-admin" title="Go to dashboard">Admin Dashboard</a> under the At A Glance panel.', 'Clinical-CMS-Core'),
            ));
            $securityPanel->createOption(array(
                'name' => __('Google Safe Browsing', 'Clinical-CMS-Core'),
                'id' => 'clinical_external_verify_google',
                'desc' => __('Google’s Safe Browsing technology examines billions of URLs per day looking for unsafe websites.', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => false,
            ));
            $securityPanel->createOption(array(
                'name' => __('Securi SiteCheck', 'Clinical-CMS-Core'),
                'id' => 'clinical_external_verify_sucuri',
                'desc' => 'Sucuri SiteCheck scanner will check the website for known malware, blacklisting status, website errors, and out-of-date software.',
                'type' => 'enable',
                'default' => false,
            ));
            //Save settings button
            $securityPanel->createOption(array(
                'type' => 'Save',
                'id' => 'sdvtrjntvdsvymyiuio',
            ));
        } //end security extension check
        else { //security extension not installed so show reminder
            $securityPanel->createOption(array(
                'id' => 'clinical_monitors_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-security-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Security Pro, Not Installed!</a></h1><p>You are missing out on site reputation monitors, that keep your site safe, protect your reputation, and potentially save you money.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //login / registration monitors
        $securityPanel->createOption(array(
            'name' => __('User Account Monitor', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        if (function_exists('limit_login_setup')) {
            $securityPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Track creation of new users and the latest successfull logins of registered <a href="users.php">user accounts</a>.', 'Clinical-CMS-Core'),
            ));
            $securityPanel->createOption(array(
                'name' => __('Display Registration Date', 'Clinical-CMS-Core'),
                'id' => 'clinical_user_registration_date',
                'desc' => 'Add a sortable column to the users page showing date/time each user account was created.',
                'type' => 'enable',
                'default' => true,
            ));
            $securityPanel->createOption(array(
                'name' => __('Display Last Login', 'Clinical-CMS-Core'),
                'id' => 'clinical_user_last_login',
                'desc' => 'Add a sortable column to the users page showing date/time each user logged-in to the site.',
                'type' => 'enable',
                'default' => true,
            ));
            $securityPanel->createOption(array(
                'name' => __('Email Notification', 'Clinical-CMS-Core'),
                'id' => 'clinical_user_logged_notify',
                'desc' => 'Send an email to the site admin when any user signs-in. Not recommended on high traffic sites.',
                'type' => 'enable',
                'default' => false,
            ));
            //Save settings button
            $securityPanel->createOption(array(
                'type' => 'Save',
                'id' => 'sdvtrjntvdsvsvuymyiuio',
            ));
        } //end security extension check
        else { //security extension not installed so show reminder
            $securityPanel->createOption(array(
                'id' => 'clinical_security_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-security-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Security Pro, Not Installed!</a></h1><p>You are missing out on crucial user security features, that make your site safer, protect your reputation, and potentially save you money.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //Block access to admin - IP GeoLocation
        $securityPanel->createOption(array(
            'name' => __('Firewall', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        if (function_exists('limit_login_setup')) {
            $securityPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Block access to your site admin based on the user\'s IP / GeoLocation.', 'Clinical-CMS-Core'),
            ));
            $securityPanel->createOption(array(
                'name' => __('Geo-Location Blocking', 'Clinical-CMS-Core'),
                'id' => 'clinical_geoloc_enable',
                'desc' => 'Add a sortable column to the users page showing date/time each user account was created.',
                'type' => 'enable',
                'default' => false,
            ));

            if (function_exists('limit_login_setup')) {
                $securityPanel->createOption(array(
                    'name' => 'Blocked Countries',
                    'id' => 'clinical_geoloc_locs',
                    'type' => 'select',
                    'desc' => 'Click inside the box to begin adding Countries that should be blocked from accessing WP-admin pages.',
                    'options' => clinical_GeoLocs(),
                    'multiple' => true,
                ));
            }
        } else { //security extension not installed so show reminder
            $securityPanel->createOption(array(
                'id' => 'clinical_geoloc_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-security-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Security Pro, Not Installed!</a></h1><p>You are missing out on blocking users by IP & Country.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //Brute force / WAF
        $securityPanel->createOption(array(
            'name' => __('Brute Force Login Protection', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        if (function_exists('limit_login_setup')) {
            $securityPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Brute Force Hacks use automated tools to try and login to your site by using lots of username / password combinations in a short time. This extension detects failed logins and temporarily blocks those IP\'s used by the attacker. This slows down the hackers and potentially blocks valid passwords from being used.', 'Clinical-CMS-Core'),
            ));
            $securityPanel->createOption(array(
                'name' => 'Level 1 Retries',
                'id' => 'clinical_login_retries',
                'type' => 'number',
                'desc' => __('The number of failed attempts before IP is blocked.', 'Clinical-CMS-Core'),
                'default' => '3',
                'min' => '1',
                'max' => '10',
            ));
            $securityPanel->createOption(array(
                'name' => 'Level 1 Lockout',
                'id' => 'clinical_login_lockout_time_1',
                'type' => 'number',
                'desc' => __('How long the IP should be locked out (mins)', 'Clinical-CMS-Core'),
                'default' => '10',
                'min' => '1',
                'max' => '1440',
            ));
            $securityPanel->createOption(array(
                'name' => 'Level 2 Retries',
                'id' => 'clinical_login_retries_2',
                'type' => 'number',
                'desc' => __('If failed logins continue, lock IP after another X lockouts', 'Clinical-CMS-Core'),
                'default' => '3',
                'min' => '1',
                'max' => '10',
            ));
            $securityPanel->createOption(array(
                'name' => 'Level 2 Lockout',
                'id' => 'clinical_login_lockout_time_2',
                'type' => 'number',
                'desc' => __('How long the IP should be locked out after further failed attempts (hours)', 'Clinical-CMS-Core'),
                'default' => '1',
                'min' => '1',
                'max' => '120',
            ));
            $securityPanel->createOption(array(
                'name' => 'Lockout Reset',
                'id' => 'clinical_login_lockout_time_reset',
                'type' => 'number',
                'desc' => __('Failed login counter will be reset after this time period (hours)', 'Clinical-CMS-Core'),
                'default' => '24',
                'min' => '1',
                'max' => '120',
            ));
            $securityPanel->createOption(array(
                'name' => 'Site Connection Type',
                'id' => 'clinical_login_site_connection',
                'options' => array(
                    'REMOTE_ADDR' => 'Direct',
                    'HTTP_X_FORWARDED_FOR' => 'Reverse Proxy',
                ),
                'type' => 'radio',
                'desc' => 'Use alternate IP tracking for sites using Reverse Proxy connections',
                'default' => 'REMOTE_ADDR',
            ));
            $securityPanel->createOption(array(
                'name' => 'Lockout Notifications',
                'id' => 'clinical_login_lockout_notify',
                'type' => 'multicheck',
                'desc' => 'Notify admin(s) when failed login attempts result in lockouts',
                'options' => array(
                    'log' => 'Log IP',
                    'email' => 'Send Email To Admin',
                ),
                'default' => array('log', 'email'),
            ));
            $securityPanel->createOption(array(
                'name' => __('Network Reporting', 'Clinical-CMS-Core'),
                'id' => 'clinical_f2b_report',
                'desc' => __('Level 2 Lockouts are reported to your webserver to create a database of high risk IP\'s. The server can then pro-actively block these IP\'s from accessing all sites hosted on the server. Learn more via our blog post: <a href="xxxxxxxxxxx">Network Level Security</a>', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $securityPanel->createOption(array(
                'name' => __('Auto Reset Logs', 'Clinical-CMS-Core'),
                'id' => 'clinical_login_Auto_Reset',
                'desc' => __('Automatically delete local logs every 90 days. Recommended if you have lots of failed logins.', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            //Save settings button
            $securityPanel->createOption(array(
                'type' => 'Save',
                'id' => 'sdvtrjntuymyiuio',
            ));
        } else { //security extension not installed so show reminder
            $securityPanel->createOption(array(
                'id' => 'clinical_bruteforce_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-security-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Security Pro, Not Installed!</a></h1><p>You are missing out on blocking hackers and brute force log-in attempts.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //Login Security
        $spamPanel = $adminPanel->createTab(array(
            'name' => __('SPAM Guard', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Adds extra layers of SPAM protection to WordPress.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('SPAM Guard', 'Clinical-CMS-Core'),
        ));
        if (function_exists('antispam_check_comment')) {
            //Hardening options
            $spamPanel->createOption(array(
                'name' => __('SPAM Protection', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $spamPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Prevent spambots from leaving fake comments, which can make your site appear to be low quality, untrustworthy and of little value to your audience.', 'Clinical-CMS-Core'),
            ));
            $spamPanel->createOption(array(
                'name' => __('Email Notification', 'Clinical-CMS-Core'),
                'id' => 'clinical_spam_notify',
                'desc' => __('Send an email to the site admin whenever a spam comment is blocked. Not recommended on high traffic sites.', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => false,
            ));
            $spamPanel->createOption(array(
                'name' => __('Log Rejections', 'Clinical-CMS-Core'),
                'id' => 'clinical_spam_log',
                'desc' => __('Rejected comments will be logged to your wp-content {or equivalent} folder.', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => false,
            ));
            $spamPanel->createOption(array(
                'name' => __('Trackbacks', 'Clinical-CMS-Core'),
                'id' => 'clinical_spam_trackbacks',
                'desc' => __('Prevents trackbacks from being registered, but leaves pingbacks active [<a href="http://web-profile.net/web/trackback-vs-pingback/" target="_external" title="Trackbacks v Pingbacks">More info</a>].', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => true,
            ));
            //Save settings button
            $spamPanel->createOption(array(
                'type' => 'Save',
                'id' => 'sdvtrvdsvsymyiuio',
            ));
            //Comment blacklist options
            $spamPanel->createOption(array(
                'name' => __('Comments Blacklist', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $spamPanel->createOption(array(
                'type' => 'note',
                'desc' => __('Use a blacklist of common SPAM terms, to identify and block SPAM comments from being posted to your site.', 'Clinical-CMS-Core'),
            ));
            $spamPanel->createOption(array(
                'name' => __('Automatic Updates', 'Clinical-CMS-Core'),
                'id' => 'clinical_spam_blacklist_download',
                'desc' => __('Automatically check for updates to the master blacklist, and download when new SPAM keywords are added.', 'Clinical-CMS-Core'),
                'type' => 'enable',
                'default' => false,
            ));
            $spamPanel->createOption(array(
                'name' => 'Blacklist Source',
                'id' => 'clinical_spam_blacklist_source',
                'options' => array(
                    '1' => __('ClinicalWP Blacklist [Recommended]', 'Clinical-CMS-Core'),
                    '2' => __('SPLORP Extensive Blacklist', 'Clinical-CMS-Core'),
                ),
                'type' => 'radio',
                'desc' => __('SPLORP Extensive Blacklist is only suitable for sites experiencing a high volume of SPAM comments.', 'Clinical-CMS-Core'),
                'default' => '1',
            ));
            $spamPanel->createOption(array(
                'name' => 'Blacklist Usage',
                'id' => 'clinical_spam_blacklist_usage',
                'options' => array(
                    '1' => __('Send blacklisted comments to moderation [Recommended]', 'Clinical-CMS-Core'),
                    '2' => __('Send blacklisted comments to trash', 'Clinical-CMS-Core'),
                ),
                'type' => 'radio',
                'desc' => __('Choose what to do with comments containing keywords found in the blacklist.', 'Clinical-CMS-Core'),
                'default' => '1',
            ));
            //Save settings button
            $spamPanel->createOption(array(
                'type' => 'Save',
                'id' => 'sdvtrsvsymyiuio',
            ));
        } //end anti-spam panel
        else { //anti-spamextension not installed so show reminder
            $spamPanel->createOption(array(
                'name' => __('SPAM Extension', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $spamPanel->createOption(array(
                'id' => 'clinical_spam_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-spam-guard-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: SPAM Guard Pro, Not Installed!</a></h1><p>You are missing out on beneficial anti-spam features, that make your site safer & easier to read, protect your reputation, and potentially save you money.</p>', 'Clinical-CMS-Core'),
            ));
        }

        //Advanced Users
        $advancedPanel = $adminPanel->createTab(array(
            'name' => __('Advanced', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Options for developers and advanced users.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('Advanced', 'Clinical-CMS-Core'),
        ));
        $advancedPanel->createOption(array(
            'name' => __('System Memory', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        $advancedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Adjust the memory available to your website and admin dashboard to enable effective operation.', 'Clinical-CMS-Core'),
        ));
            $advancedPanel->createOption(array(
                'name' => 'Max Memory Limit',
                'id' => 'clinical_memory_limit',
                'type' => 'number',
                'desc' => __('Set the Memory Limit for WordPress. Your Server Level Settings may override this. (Value in MB)', 'Clinical-CMS-Core'),
                'default' => '512',
                'min' => '40',
                'max' => '2048'
            ));
            $advancedPanel->createOption(array(
                'name' => 'Max Admin Memory Limit',
                'id' => 'clinical_admin_memory_limit',
                'type' => 'number',
                'desc' => __('Set the Memory Limit for WordPress Admin Dashboard. Your Server Level Settings may override this. (Value in MB)', 'Clinical-CMS-Core'),
                'default' => '512',
                'min' => '64',
                'max' => '2048'
            ));
        //Save section button
        $advancedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'ebtbiiiiiepuusdncadc',
        ));
        $advancedPanel->createOption(array(
            'name' => __('System Updates & Modifications', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        $advancedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Control how your website handles updates and modifications.', 'Clinical-CMS-Core'),
        ));
        $advancedPanel->createOption(array(
            'name' => __('Core Updates', 'Clinical-CMS-Core'),
            'id' => 'clinical_advanced_automated',
            'desc' => __('', 'Clinical-CMS-Core'),
            'options' => array(
                '1' => __('No Updates', 'Clinical-CMS-Core'),
                '2' => __('Minor Updates', 'Clinical-CMS-Core'),
                '3' => __('All Updates', 'Clinical-CMS-Core'),
            ),
            'type' => 'radio',
            'default' => '3',
            'desc' => __('Set the Core Update method.', 'Clinical-CMS-Core'),
        ));
        $advancedPanel->createOption(array(
            'name' => __('Auto Plugin Updates', 'Clinical-CMS-Core'),
            'id' => 'clinical_auto_plugins',
            'desc' => __('Update all plugins automatically. (Use with caution)', 'Clinical-CMS-Core'),
            'type' => 'enable',
            'default' => false,
        ));
        $advancedPanel->createOption(array(
            'name' => __('Auto Theme Updates', 'Clinical-CMS-Core'),
            'id' => 'clinical_auto_themes',
            'desc' => __('Update all themes automatically. (Use with caution)', 'Clinical-CMS-Core'),
            'type' => 'enable',
            'default' => false,
        ));
        //Save section button
        $advancedPanel->createOption(array(
            'type' => 'Save',
            'id' => 'ebtbepuusdncadc',
        ));

        //WP System email Rerouting
        $advancedPanel->createOption(array(
            'name' => __('Email Server', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_email_heading_advanced',
            'type' => 'heading',
        ));
        $advancedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Override the default WordPress localhost email server. Use these settings to route emails via your company email server or trusted 3rd parties such as SendGrid.', 'Clinical-CMS-Core'),
        ));
            $advancedPanel->createOption(array(
                'name' => __('SMTP Auth', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_External',
                'desc' => __('Use the following settings to send email', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ));
            $advancedPanel->createOption(array(
                'name' => __('Host', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_host',
                'desc' => __('The email server hostname', 'Clinical-CMS-Core'),
                'placeholder' => __('Enter valid hostname', 'Clinical-CMS-Core'),
            ));
            $advancedPanel->createOption(array(
                'name' => __('Port', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_port',
                'desc' => __('The server port', 'Clinical-CMS-Core'),
                'placeholder' => __('Enter valid port', 'Clinical-CMS-Core'),
                'type' => 'number',
                'default' => '25',
            ));
            $advancedPanel->createOption(array(
                'name' => __('SMTP Auth', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_auth',
                'desc' => __('Validate the account credentials', 'Clinical-CMS-Core'),
                'default' => true,
                'type' => 'enable',
            ));
            $advancedPanel->createOption(array(
                'name' => __('Security', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_security',
                'desc' => __('Connection security type', 'Clinical-CMS-Core'),
                'options' => array(
                    '1' => __('None', 'Clinical-CMS-Core'),
                    '2' => __('SSL', 'Clinical-CMS-Core'),
                    '3' => __('TLS (recommended)', 'Clinical-CMS-Core'),
                ),
                'type' => 'radio',
                'default' => '1',
            ));
            $advancedPanel->createOption(array(
                'name' => __('Username', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_username',
                'desc' => __('The email account username', 'Clinical-CMS-Core'),
                'placeholder' => __('Enter valid username', 'Clinical-CMS-Core'),
            ));
            $advancedPanel->createOption(array(
                'name' => __('Password', 'Clinical-CMS-Core'),
                'id' => 'clinical_admin_email_password',
                'desc' => __('The email account password', 'Clinical-CMS-Core'),
                'placeholder' => __('Enter valid password', 'Clinical-CMS-Core'),
                'is_password' => true,
            ));
        //Save settings button
        $advancedPanel->createOption(array(
            'type' => 'save',
            'id' => 'opopopefwefwefwefopopopopopopopo',
        ));

        //delay showing new pages/posts in RSS feed
        $advancedPanel->createOption(array(
            'name' => __('Delay RSS Feed', 'Clinical-CMS-Core'),
            'id' => 'clinical_rss_feed_delay_header',
            'type' => 'heading',
        ));
        $advancedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Delay new posts and pages from showing in your RSS & Atom feeds. Use this to provide a period of exclusivity or just to give yourself time to check for typos and bad links.', 'Clinical-CMS-Core'),
        ));
        $advancedPanel->createOption(array(
            'name' => __('Enable Delay', 'Clinical-CMS-Core'),
            'id' => 'clinical_rss_feed_delay_enable',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $advancedPanel->createOption(array(
            'name' => 'Feed Delay Period',
            'id' => 'clinical_rss_feed_delay_units',
            'type' => 'number',
            'desc' => __('How long should we wait before showing new posts / pages (Value in Hours).', 'Clinical-CMS-Core'),
            'default' => '1',
            'max' => '168',
            'step' => '0.5',
        ));
        //Save settings button
        $advancedPanel->createOption(array(
            'type' => 'save',
            'id' => 'uoplikmuhbtvrecxuuuju',
        ));

        //custom excerpt length
        $advancedPanel->createOption(array(
            'name' => __('Custom Excerpt Length', 'Clinical-CMS-Core'),
            'id' => 'clinical_excerpt',
            'type' => 'heading',
        ));
        $advancedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Set a custom length for the excerpts of pages and posts to replace the WordPress default length of 55 words.', 'Clinical-CMS-Core'),
        ));
        $advancedPanel->createOption(array(
            'name' => __('Enable Custom Excerpt Length', 'Clinical-CMS-Core'),
            'id' => 'clinical_excerpt_enable',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $advancedPanel->createOption(array(
            'name' => 'Custom Excerpt Length',
            'id' => 'clinical_excerpt_length',
            'type' => 'number',
            'desc' => __('(Value in words)', 'Clinical-CMS-Core'),
            'default' => '55',
            'max' => '300',
            'min' => '0',
        ));
        //Save settings button
        $advancedPanel->createOption(array(
            'type' => 'save',
            'id' => 'uoplhbtvrecxuuuju',
        ));

        //custom excerpt length
        $advancedPanel->createOption(array(
            'name' => __('Sitewide Searches', 'Clinical-CMS-Core'),
            'id' => 'clinical_hide_post_types_header',
            'type' => 'heading',
        ));
        $advancedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Restrict which post types are listed in on-site search results.', 'Clinical-CMS-Core'),
        ));
            $advancedPanel->createOption(array(
                'name' => __('Hide Posts Types', 'Clinical-CMS-Core'),
                'id' => 'clinical_hide_post_types',
                'type' => 'multicheck-post-types',
                'desc' => __('Select which post types to hide from search results.', 'Clinical-CMS-Core'),
            ));
        //Save settings button
        $advancedPanel->createOption(array(
            'type' => 'save',
            'id' => 'clinical_hide_post_types_save',
        ));

        //pingbacks
        $advancedPanel->createOption(array(
            'name' => __('Ping & Trackback', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_pings',
            'type' => 'heading',
        ));
        $advancedPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Ignore pingbacks from this site that link back to other pages on this same site.', 'Clinical-CMS-Core'),
        ));
        $advancedPanel->createOption(array(
            'name' => __('Ignore Self Pingbacks', 'Clinical-CMS-Core'),
            'id' => 'clinical_admin_pings_self',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save settings button
        $advancedPanel->createOption(array(
            'type' => 'save',
            'id' => 'ccccccggggggggggttttt',
        ));


        //maintenance tab
        $maintenancePanel = $adminPanel->createTab(array(
            'name' => __('Maintenance', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Maintain, Debug, Repair & Optimise your ClinicalWP (WordPress) installation.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('Maintenance', 'Clinical-CMS-Core'),
        ));

        if (class_exists('Clinical_Status_Agent_Plugin')) {
            //status alerts
            $maintenancePanel->createOption(array(
                'name' => __('Update Alerts', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $maintenancePanel->createOption(array(
                'type' => 'note',
                'desc' => __('Send Plugin, Theme & WordPress update alerts to your <a href="https://slack.com">slack</a> channel.', 'Clinical-CMS-Core'),
            ));
            $maintenancePanel->createOption(array(
                'name' => __('Enable Slack Alerts', 'Clinical-CMS-Core'),
                'id' => 'clinical_slack_enable',
                'desc' => __('', 'Clinical-CMS-Core'),
                'type' => 'enable',
            ));
            $maintenancePanel->createOption(array(
                'name' => __('Channel', 'Clinical-CMS-Core'),
                'id' => 'clinical_slack_channel',
                'desc' => __('Enter the name of the slack channel to send notifications to.', 'Clinical-CMS-Core'),
                'placeholder' => __('#channel', 'Clinical-CMS-Core'),
            ));
            $maintenancePanel->createOption(array(
                'name' => __('Webhook Endpoint', 'Clinical-CMS-Core'),
                'id' => 'clinical_slack_endpoint',
                'desc' => __('Enter the URL of your webhook endpoint found in your slack settings.', 'Clinical-CMS-Core'),
                'placeholder' => __('https://hooks.slack.com/services/xxxx/xxxx', 'Clinical-CMS-Core'),
            ));
            //Save section button
            $maintenancePanel->createOption(array(
                'type' => 'Save',
                'id' => 'etbe4334rrtyncadc',
            ));
        } //end anti-spam panel
        else { //Status Monitor extension not installed so show reminder
            //status alerts
            $maintenancePanel->createOption(array(
                'name' => __('Update Alerts', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $maintenancePanel->createOption(array(
                'id' => 'clinical_alerts_notice',
                'name' => __('Notice', 'Clinical-CMS-Core'),
                'type' => 'note',
                'desc' => __('<h1><a href="' . ccp_fs()->addon_url( 'z_clinicalwp-slack-pro' ) . '" title="Upgrade Now & SAVE!">ClinicalWP Extension: Status Monitor Pro, Not Installed!</a></h1><p>You are missing out on daily update notifications. Keeping your WordPress site, plugins & themes up-to-date helps keep your site secure.</p>', 'Clinical-CMS-Core'),
            ));
        }
        //debug modes
        $maintenancePanel->createOption(array(
            'name' => __('Debug WordPress', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        $maintenancePanel->createOption(array(
            'type' => 'note',
            'desc' => __('Display & log WordPress debug messages.', 'Clinical-CMS-Core'),
        ));
        $maintenancePanel->createOption(array(
            'name' => __('Enable Debug Mode', 'Clinical-CMS-Core'),
            'id' => 'clinical_debug_enable',
            'desc' => __('', 'Clinical-CMS-Core'),
            'type' => 'enable',
        ));
        $maintenancePanel->createOption(array(
            'name' => __('Output Method', 'Clinical-CMS-Core'),
            'id' => 'clinical_debug_output',
            'options' => array(
                '1' => __('Save To Log File(recommended)', 'Clinical-CMS-Core'),
                '2' => __('Display In Browser', 'Clinical-CMS-Core'),
                '3' => __('Both', 'Clinical-CMS-Core'),
            ),
            'default' => '1',
            'type' => 'radio',
        ));
        $maintenancePanel->createOption(array(
            'name' => __('Log Protection', 'Clinical-CMS-Core'),
            'id' => 'clinical_debug_protection',
            'desc' => __('Secure Mode prevents Debug log url from being accessed directly and viewed in browser. [<a href="../wp-content/debug.log" target="_external">Test here</a>]', 'Clinical-CMS-Core'),
            'type' => 'enable',
        ));
        //Save section button
        $maintenancePanel->createOption(array(
            'type' => 'Save',
            'id' => 'etbe43t43t34rrtyncadc',
        ));

        $maintenancePanel->createOption(array(
            'name' => __('Optimise Database', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
        $maintenancePanel->createOption(array(
            'type' => 'note',
            'desc' => __('It\'s highly recommended that you disable this option after use. Making a backup, would also be a wise thing to do prior to doing a repair/optimise.', 'Clinical-CMS-Core'),
        ));
            $maintenancePanel->createOption(array(
                'name' => __('Enable Maintenance Mode', 'Clinical-CMS-Core'),
                'id' => 'clinical_maintenance_enable',
                'desc' => __('', 'Clinical-CMS-Core'),
                'type' => 'enable',
            ));
            if (defined('WP_ALLOW_REPAIR') && WP_ALLOW_REPAIR === true) {
                $maintenancePanel->createOption(array(
                    'type' => 'note',
                    'desc' => '<a href="maint/repair.php" target="_external">' . __('Proceed to the maintenance system (opens in a new browser tab)', 'Clinical-CMS-Core') . '</a>',
                ));
            }
        //Save section button
        $maintenancePanel->createOption(array(
            'type' => 'Save',
            'id' => 'ebtbertntyncadc',
        ));

        //view WP options table
        $maintenancePanel->createOption(array(
            'name' => __('Options Data', 'Clinical-CMS-Core'),
            'type' => 'heading',
        ));
            $maintenancePanel->createOption(array(
                'type' => 'note',
                'desc' => __('To view/edit the contents of the WordPress \'Options\' table <a  href="/wp-admin/options.php" target="_external">click here</a>.', 'Clinical-CMS-Core'),
            ));
        //Save section button
        $maintenancePanel->createOption(array(
            'type' => 'Save',
            'id' => 'etbertyncadc',
        ));

        /*
            $maintenancePanel->createOption( array(
                'type' => 'iframe',
                'url' => 'maint/repair.php',
                'height' => '500'
            ) );
             */
        /*
            $maintenancePanel->createOption( array(
                'custom' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/A9JV0EvCkMI" frameborder="0" allowfullscreen></iframe>',
            ) );
             */

        /*
            //store the main clients details here
            $registerPanel = $adminPanel->createTab( array(
                'name' => __('Product Registration', 'Clinical-CMS-Core'),
                'desc' => '<h2>'.__('Enter your license details here, to receive updates and access to the support portal.', 'Clinical-CMS-Core').'</h2>',
                'title' => __('Product Registration', 'Clinical-CMS-Core'),
            ) );
            //build a tab for the portal
            if(class_exists('Clinical_Customer_Portal_Plugin')){
                //store the main clients details here
                $registerPanel->createOption( array(
                    'name' => __('Customer Portal', 'Clinical-CMS-Core'),
                    'type' => 'heading',
                ) );
                $registerPanel->createOption( array(
                    'type' => 'note',
                    'desc' => __('Gain access to the Code Clinic support system.', 'Clinical-CMS-Core')
                ) );
                $registerPanel->createOption( array(
                    'name' => __('Usename', 'Clinical-CMS-Core'),
                    'id' => 'clinical_portal_username',
                    'desc' => __('You should only change these details if told to do so by Code Clinic, or you change your details on the portal.', 'Clinical-CMS-Core'),
                    'placeholder' => __('The registered username (email).', 'Clinical-CMS-Core'),
                ) );
                / *
                $portalPanel->createOption( array(
                    'name' => __('Password', 'Clinical-CMS-Core'),
                    'id' => 'clinical_portal_password',
                    'desc' => __('The registered password', 'Clinical-CMS-Core'),
                    'placeholder' => __('Unique password', 'Clinical-CMS-Core'),
                ) );
             * /
                // Create options in My Layout Panel
                $registerPanel->createOption( array(
                    'type' => 'Save',
                    'id' => 'uytutytuty',
                ) );
            }
             */
        /*
            //build a tab for Status Agent
            if(class_exists('Clinical_Status_Agent_Plugin')){
                // Create options in My Layout Panel
                //$agentPanel = $adminPanel->createTab( array(
                 //   'name' => __('System Status', 'Clinical-CMS-Core'),
                 //   'desc' => '<h2>'.__('Add your unique Status Agent key if you have a support or hosting plan for ClinicalWP', 'Clinical-CMS-Core').'</h2>',
                 //   'title' => __('Activate System Monitoring', 'Clinical-CMS-Core'),
                //) );
                $registerPanel->createOption( array(
                    'name' => __('System Monitor', 'Clinical-CMS-Core'),
                    'type' => 'heading',
                ) );
                $registerPanel->createOption( array(
                    'type' => 'note',
                    'desc' => __('Provide access to the Code Clinic security monitoring system.', 'Clinical-CMS-Core')
                ) );
                $registerPanel->createOption( array(
                    'name' => __('Enable Clinical Status Agent', 'Clinical-CMS-Core'),
                    'id' => 'clinical_status_agent',
                    'desc' => '***'.__('Only change this if you have been asked to do so by', 'Clinical-CMS-Core').' <a href="http://codeclinic.de" target="_external">Code Clinic</a>.***',
                    //'default' => 'Key Not Found!',
                    'placeholder' => __('Enter activation code', 'Clinical-CMS-Core'),
                ) );

                // Create options in My Layout Panel
                $registerPanel->createOption( array(
                    'type' => 'Save',
                    'id' => 'gerrgergheger',
                ) );
            }
             */
        /*
            //product update service
            //$registerPanel = $adminPanel->createTab( array(
            //    'name' => __('Register', 'Clinical-CMS-Core'),
            //    'desc' => '<h2>'.__('Enter your Activation Code if you have a support plan for ClinicalWP', 'Clinical-CMS-Core').'</h2>',
            //    'title' => __('Activate Updates', 'Clinical-CMS-Core'),
            //) );
            $registerPanel->createOption( array(
                'name' => __('Product Activation', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ) );
            $registerPanel->createOption( array(
                'type' => 'note',
                'desc' => __('Enable ClinicalWP update notifications.', 'Clinical-CMS-Core')
            ) );
            $registerPanel->createOption( array(
                'name' => __('Enable Plugin Updates', 'Clinical-CMS-Core'),
                'id' => 'clinical_activation_code',
                'desc' => '***'.__('Only change this if you have been asked to do so by', 'Clinical-CMS-Core').' <a href="http://codeclinic.de" target="_external">Code Clinic</a>.***',
                //'default' => 'Key Not Found!',
                'placeholder' => __('Enter activation code', 'Clinical-CMS-Core'),
            ) );
            //Save section button
            $registerPanel->createOption( array(
                    'type' => 'Save',
                    'id' => 'gerrrgheger',
            ) );

             */
        /* CREATE THE PAGE EDITOR METABOXES FOR SEO ETC */
        $titan = TitanFramework::getInstance('clinical_cms');
        $seoFields = $titan->getOption('clinical_seo_fields');
        $seoFacebook = $titan->getOption('clinical_seo_facebook');
        $seoTwitter = $titan->getOption('clinical_seo_twitter');
        $seoGoogle = $titan->getOption('clinical_seo_google');

        if ($seoFields == true) {
            // Create relevant 
            $seoMetaBox = $titan->createMetaBox(array(
                'name' => 'Standard SEO',
                'post_type' => array('page', 'post'),
            ));
            $seoMetaBox->createOption(array(
                'name' => 'Page Description',
                'id' => 'clinical_seo_description',
                'type' => 'text',
                'desc' => ''
            ));
            $seoMetaBox->createOption(array(
                'name' => 'Page Keywords',
                'id' => 'clinical_seo_keywords',
                'type' => 'text',
                'desc' => ''
            ));
        }
        if ($seoFacebook == true) {
            // Create relevant 
            $facebookMetaBox = $titan->createMetaBox(array(
                'name' => 'Facebook SEO',
                'post_type' => array('page', 'post'),
            ));
            $facebookMetaBox->createOption(array(
                'name' => 'Title',
                'id' => 'clinical_seo_fb_title',
                'type' => 'text',
                'desc' => __('Title for page(will use site title if empty)', 'Clinical-CMS-Core')
            ));
            $facebookMetaBox->createOption(array(
                'name' => 'Description',
                'id' => 'clinical_seo_fb_description',
                'type' => 'text',
                'desc' => __('Description for page(will use site title if empty)', 'Clinical-CMS-Core'),
            ));
            $facebookMetaBox->createOption(array(
                'name' => 'Facebook ID',
                'id' => 'clinical_seo_fb_aminID',
                'type' => 'text',
                'desc' => __('The ID number from your <a href="http://findmyfbid.com/" target= "_external">Fb profile</a> (will use link from \'Social Profile\' settings if empty)', 'Clinical-CMS-Core')
            ));
            $facebookMetaBox->createOption(array(
                'name' => 'Image',
                'id' => 'clinical_seo_fb_image',
                'type' => 'upload',
                'desc' => __('Image to be used by Facebook(will use featured image if empty)', 'Clinical-CMS-Core'),
            ));
            //$screen = get_current_screen();
            //if( $screen->post_type == "post" ){
            $facebookMetaBox->createOption(array(
                'name' => 'Publisher Profile[Posts Only]',
                'id' => 'clinical_seo_fb_publisher',
                'type' => 'text',
                'desc' => __('Full link to Author profile on Facebook(will use link from \'Social Profile\' settings if empty)', 'Clinical-CMS-Core')
            ));
            $facebookMetaBox->createOption(array(
                'name' => 'Author Profile[Posts Only]',
                'id' => 'clinical_seo_fb_author',
                'type' => 'text',
                'desc' => __('Full link to Author profile on Facebook(will use link from \'Social Profile\' settings if empty)', 'Clinical-CMS-Core')
            ));
            //}
        }
        if ($seoTwitter == true) {
            // Create relevant
            $twitterMetaBox = $titan->createMetaBox(array(
                'name' => 'Twitter SEO',
                'post_type' => array('page', 'post'),
            ));
            $twitterMetaBox->createOption(array(
                'name' => 'Page title',
                'id' => 'clinical_seo_twit_title',
                'type' => 'text',
                'desc' => __('Title for page(will use site title if empty)', 'Clinical-CMS-Core')
            ));
            $twitterMetaBox->createOption(array(
                'name' => 'Description',
                'id' => 'clinical_seo_twit_description',
                'type' => 'text',
                'desc' => __('Description for page(will use site title if empty)', 'Clinical-CMS-Core'),
            ));
            $twitterMetaBox->createOption(array(
                'name' => 'Publisher Handle',
                'id' => 'clinical_seo_twit_Publisher',
                'type' => 'text',
                'desc' => __('Twitter username of publisher(exclude @ symbol)', 'Clinical-CMS-Core')
            ));
            $twitterMetaBox->createOption(array(
                'name' => 'Author Handle',
                'id' => 'clinical_seo_twit_author',
                'type' => 'text',
                'desc' => __('Twitter username of author(exclude @ symbol)', 'Clinical-CMS-Core')
            ));
            $twitterMetaBox->createOption(array(
                'name' => 'Image',
                'id' => 'clinical_seo_twit_image',
                'type' => 'upload',
                'desc' => __('Image to be used by Twitter(will use featured image if empty)', 'Clinical-CMS-Core'),
            ));
        }
        if ($seoGoogle == true) {
            // Create relevant 
            $googleMetaBox = $titan->createMetaBox(array(
                'name' => 'Google+ SEO',
                'post_type' => array('page', 'post'),
            ));
            $googleMetaBox->createOption(array(
                'name' => 'Page Title',
                'id' => 'clinical_seo_g_name',
                'type' => 'text',
                'desc' => __('Title for page(will use site title if empty)', 'Clinical-CMS-Core'),
            ));
            $googleMetaBox->createOption(array(
                'name' => 'Description',
                'id' => 'clinical_seo_g_description',
                'type' => 'text',
                'desc' => __('Description for page(will use site title if empty)', 'Clinical-CMS-Core'),
            ));
            $googleMetaBox->createOption(array(
                'name' => 'Image',
                'id' => 'clinical_seo_g_image',
                'type' => 'upload',
                'desc' => __('Image to be used by Google+(will use featured image if empty)', 'Clinical-CMS-Core'),
            ));
        }

        //Login Security Admin Panel
        $loginSecurityPanel = $adminPanel->createAdminPanel(array(
            'name' => __('Failed Logins', 'Clinical-CMS-Core'),
            /*'desc' => '<h1>'.__('Clinical Login Security Logs', 'Clinical-CMS-Core').'</h1>',*/
            'icon' => 'dashicons-shield',
        ));
        $lsPanel = $loginSecurityPanel->createTab(array(
            'name' => __('Login Security', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Blocked Login Attempts', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('Email Harvesting Protection', 'Clinical-CMS-Core'),
        ));
        $lsPanel->createOption(array(
            'type' => 'note',
            'desc' => __('The following attempts to login to your site have been prevented by <a href="' . ccp_fs()->get_upgrade_url() . '">ClinicalWP Security Pro</a> based on your settings. The logs identify the username used to attempt to login and may not be a valid username for your site. The associated IP is that linked to the visitor, however hackers typically use methods to hide their real IP.', 'Clinical-CMS-Core'),
        ));
        $lsPanel->createOption(array(
            'name' => __('Security Log', 'Clinical-CMS-Core'),
            'type' => 'custom',
            'custom' => '<div class="limit-login-log"><table class="form-table" style="width:100%;"><col width="1*"><col width="2*">' . $this->limit_login_show_log(get_option('limit_login_logged')) . '</table></div>',
        ));
        $lsPanel->createOption(array(
            'name' => 'Reset Log',
            'type' => 'ajax-button',
            'action' => 'clinical_reset_security_logs',
            'label' => __('Reset Security Logs', 'default'),
            'success_callback' => 'clinical_ajax_success_refresh',
        ));

        //Tutorial Admin Panel
        /*
    $tutorialPanel = $adminPanel->createAdminPanel(array(
        'name' => __('Video Tutorials (Beta)', 'Clinical-CMS-Core'),
        /*'desc' => '<h1>'.__('Clinical Login Security Logs', 'Clinical-CMS-Core').'</h1>',* /
        'icon' => 'dashicons-shield',
    ));
    $vidsDEPanel = $tutorialPanel->createTab(array(
        'name' => __('Deutsch', 'Clinical-CMS-Core'),
        'desc' => '<h2>' . __('ClinicalWP User Guides', 'Clinical-CMS-Core') . '</h2>',
    ));
    $vidsDEPanel->createOption(array(
        'type' => 'note',
        'desc' => __('Unsere kurzen ClinicalWP Video Guides zeigen Ihnen, wie Sie oben auf Ihrer Website bleiben, problemlos.', 'Clinical-CMS-Core'),
    ));
    $vidsDEPanel->createOption(array(
        'name' => __('Security Log', 'Clinical-CMS-Core'),
        'type' => 'custom',
        'custom' => '<div class="><iframe width="560" height="315" src="https://www.youtube.com/embed/qDeYvZFjB0w" frameborder="0" allowfullscreen></iframe>&nbsp;<iframe width="560" height="315" src="https://www.youtube.com/embed/FCwMD607WL4" frameborder="0" allowfullscreen></iframe>&nbsp;<iframe width="560" height="315" src="https://www.youtube.com/embed/Aq1XP6Z4GqQ" frameborder="0" allowfullscreen></iframe></div>',
    ));
    $vidsENPanel = $tutorialPanel->createTab(array(
        'name' => __('English', 'Clinical-CMS-Core'),
        'desc' => '<h2>' . __('ClinicalWP User Guides', 'Clinical-CMS-Core') . '</h2>',
    ));
    $vidsENPanel->createOption(array(
        'type' => 'note',
        'desc' => __('Our short ClinicalWP Video Guides show you how to keep on top of your website, hassle free.', 'Clinical-CMS-Core'),
    ));
    $vidsENPanel->createOption(array(
        'name' => __('Security Log', 'Clinical-CMS-Core'),
        'type' => 'custom',
        'custom' => '<div class="><iframe width="560" height="315" src="https://www.youtube.com/embed/qDeYvZFjB0w" frameborder="0" allowfullscreen></iframe>&nbsp;<iframe width="560" height="315" src="https://www.youtube.com/embed/FCwMD607WL4" frameborder="0" allowfullscreen></iframe>&nbsp;<iframe width="560" height="315" src="https://www.youtube.com/embed/Aq1XP6Z4GqQ" frameborder="0" allowfullscreen></iframe></div>',
    ));
    */
        /*
    //The Manual
    $ManualPanel = $adminPanel->createAdminPanel(array(
        'name' => __('WordPress Manual', 'Clinical-CMS-Core'),
        /*'desc' => '<h1>'.__('Clinical Login Security Logs', 'Clinical-CMS-Core').'</h1>',* /
        'icon' => 'dashicons-shield',
    ));
    $manDEPanel = $ManualPanel->createTab(array(
        'name' => __('Deutsch', 'Clinical-CMS-Core'),
        'desc' => '<h2>' . __('ClinicalWP User Guides', 'Clinical-CMS-Core') . '</h2>',
    ));
    $manDEPanel->createOption(array(
        'type' => 'note',
        'desc' => 'Der komplette Anfängerführer zu WordPress in leicht verständlicher Sprache.',
    ));
    $manDEPanel->createOption(array(
        'name' => __('User Guide', 'Clinical-CMS-Core'),
        'type' => 'iframe',
        'url' => '#',
    ));
    $manENPanel = $ManualPanel->createTab(array(
        'name' => __('English', 'Clinical-CMS-Core'),
        'desc' => '<h2>' . __('ClinicalWP User Guides', 'Clinical-CMS-Core') . '</h2>',
    ));
    $manENPanel->createOption(array(
        'type' => 'note',
        'desc' => 'The complete beginners guide to WordPress in easy to understand language.',
    ));
    $manENPanel->createOption(array(
        'name' => __('User Guide', 'Clinical-CMS-Core'),
        'type' => 'iframe',
        'url' => '#',
    ));
    */
        if (function_exists('wordpress_memcached_get_stats')) {
            //debug panel

            $debugPanel = $adminPanel->createAdminPanel(array(
                'name' => 'Debug Info',
                /*'desc' => '<h1>'.__('Use these shortcodes for additional functionality in your site layout and content.', 'Clinical-CMS-Core').'</h1>',*/
                'icon' => 'dashicons-shield',
            ));
            $dbPanel = $debugPanel->createTab(array(
                'name' => __('Debug Info', 'Clinical-CMS-Core'),
                'desc' => '<h2>' . __('You may be asked to submit this info to aid your support ticket resolution.', 'Clinical-CMS-Core') . '</h2>',
                'title' => __('Debug Information', 'Clinical-CMS-Core'),
            ));
            $dbPanel->createOption(array(
                'name' => __('Memcache(d) Stats', 'Clinical-CMS-Core'),
                'type' => 'heading',
            ));
            $stats_text = wordpress_memcached_get_stats();
            $dbPanel->createOption(array(
                'type' => 'note',
                'desc' => '' . nl2br($stats_text),
            ));
            //Save section button
            $dbPanel->createOption(array(
                'type' => 'Save',
                'id' => 'etbertyncnnnadc',
            ));
        }

        //Nag Notices
        $nagPanel = $adminPanel->createAdminPanel(array(
            'name' => 'Nag Notices',
            /*'desc' => '<h1>'.__('Clinical Login Security Logs', 'Clinical-CMS-Core').'</h1>',*/
            'icon' => 'dashicons-shield',
        ));
        $noNagsPanel = $nagPanel->createTab(array(
            'name' => __('Popular', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Remove the \'Nag Notices\' from the admin screens', 'Clinical-CMS-Core') . '</h2>',
        ));
        $noNagsPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Many plugins add an annoying \'Nag Notice\' to the WordPress admin screens, asking you to register the plugin, buy addons or upgrade. Use the options below to turn off some of these from most popular plugins.', 'Clinical-CMS-Core'),
        ));
        /*
            $noNagsPanel->createOption( array(
                'name' => __('WordPress Core', 'Clinical-CMS-Core'),
                'id' => 'clinical_nag_core',
                'desc' => __('WP Core update notifications & reminders', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ) );
             */
        $noNagsPanel->createOption(array(
            'name' => __('WP Bakery (Visual Composer)', 'Clinical-CMS-Core'),
            'id' => 'clinical_nag_viscomp',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        /*
            $noNagsPanel->createOption( array(
                'name' => __('Vis Comp Ultimate Addons', 'Clinical-CMS-Core'),
                'id' => 'clinical_viscomp_ultaddons',
                'desc' => __('', 'Clinical-CMS-Core'),
                'default' => false,
                'type' => 'enable',
            ) );
             */
        $noNagsPanel->createOption(array(
            'name' => __('WooThemes', 'Clinical-CMS-Core'),
            'id' => 'clinical_nag_woo',
            'desc' => __('WooCommerce / WooThemes update notifications', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $noNagsPanel->createOption(array(
            'name' => __('Revolution Slider', 'Clinical-CMS-Core'),
            'id' => 'clinical_nag_revslide',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $noNagsPanel->createOption(array(
            'name' => __('BackupBuddy', 'Clinical-CMS-Core'),
            'id' => 'clinical_nag_backupbuddy',
            'desc' => __('', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        $noNagsPanel->createOption(array(
            'name' => __('TGMPA', 'Clinical-CMS-Core'),
            'id' => 'clinical_nag_tgmpa',
            'desc' => __('Used for required and recommended plugins notifications [Not Recommended]', 'Clinical-CMS-Core'),
            'default' => false,
            'type' => 'enable',
        ));
        //Save settings button
        $noNagsPanel->createOption(array(
            'type' => 'save',
            'id' => 'uoplikmecxuuuju',
        ));

        //Shortcodes Admin Panel
        $shortcodesPanel = $adminPanel->createAdminPanel(array(
            'name' => 'Shortcodes',
            /*'desc' => '<h1>'.__('Use these shortcodes for additional functionality in your site layout and content.', 'Clinical-CMS-Core').'</h1>',*/
            'icon' => 'dashicons-shield',
        ));
        $scPanel = $shortcodesPanel->createTab(array(
            'name' => __('Anti Spam & Security', 'Clinical-CMS-Core'),
            'desc' => '<h2>' . __('Add additional security and anti-spam features to your site.', 'Clinical-CMS-Core') . '</h2>',
            'title' => __('Email Harvesting Protection', 'Clinical-CMS-Core'),
        ));
        $scPanel->createOption(array(
            'type' => 'note',
            'desc' => __('Use a shortcode to display email addresses that are safe from email collecting spambots. The shortocde formats email addresses using specially encoded text. This means that your email links are still clickable and look like real email addresses. However, they will be meaningless to the programmes that search websites looking for email address to add to spam mailoing lists.', 'Clinical-CMS-Core'),
        ));
        $scPanel->createOption(array(
            'name' => __('Usage', 'Clinical-CMS-Core'),
            'type' => 'custom',
            'custom' => '<p>[email recipient="name@domain.com"]link text here[/email]</p>',
        ));
        //Usage: [email recipient='name@domain.com']link text here[/email]
        /*
            $scPanel->createOption( array(
                'type' => 'note',
                'desc' => __('Use a shortcode to display the last time a page / post author logged in to the site.', 'Clinical-CMS-Core'),
            ) );
            $scPanel->createOption( array(
                'name' => __('Usage', 'Clinical-CMS-Core'),
                'type' => 'custom',
                'custom' => '<p>[CC_last_loggedin]</p>',
            ) );
            //Usage: [CC_last_loggedin] 
             */
    }

    /* Show log on admin page */
    function limit_login_show_log($log)
    {
        if (!is_array($log) || count($log) == 0) {
            return;
        }

        /* Get the Geo Location cache array */
        $geoloc = get_option('limit_login_geolocation', array());

        $output = "";
        $geoname = "";
        $geocode = "";

        $output = '<tr><th scope="col">' . _x("IP", "Internet address", 'clinical-login-security') . '</th><th scope="col">' . __('Tried to log in as', 'clinical-login-security') . '</th></tr>';
        foreach ($log as $ip => $arr) {
            $geo = "";
            if (isset($geoloc[$ip])) {
                $geo =  $geoloc[$ip];
                list($geocode, $geoname) = explode(":", $geo);
                $geoname = ucwords($geoname);
            }

            $output .= '<tr><td class="limit-login-ip"><img src="' . plugin_dir_url(__DIR__) . 'z_clinicalwp-security-pro/assets/flags/svg/' . $geocode . '.svg" alt="[' . $geoname . ']" title="' . $geoname . '" style="height:15px">&nbsp;<strong>' . $ip . '</strong></td><td class="limit-login-max">';
            $first = true;
            foreach ($arr as $user => $count) {
                $count_desc = sprintf(_n('%d lockout', '%d lockouts', $count, 'clinical-login-security'), $count);
                if (!$first) {
                    $output .= ', ' . $user . ' (' . $count_desc . ')';
                } else {
                    $output .= $user . ' (' . $count_desc . ')';
                }
                $first = false;
            }
            $output .= '</td></tr>';
        }

        return $output;
    }

    //add_action( 'wp_ajax_reset_security_logs', 'clinical_reset_logs' );
    function clinical_reset_logs()
    {
        // Do something
        $result = $this->clinical_clear_security_logs();
        if ($result) {
            //header("Refresh:0");
            wp_send_json_success(__('Success!', 'clinical-login-security'));
        }
        wp_send_json_error(__('Failed!', 'clinical-login-security'));
    }

    function clinical_clear_security_logs()
    {
        //reset the lockout counter
        update_option('limit_login_lockouts_total', 0);
        //remove all current lockouts
        update_option('limit_login_lockouts', array());
        //clear logs
        delete_option('limit_login_logged');
        //clear the data object cache (memcache(d))
        $this->clinical_clear_data_cache();
        return true;
    }

    function clinical_init()
    {
        /* Get values from titan options framework */
        $titan = TitanFramework::getInstance('clinical_cms');
        $myValue = $titan->getOption('clinical_activation_code');
        $widgetShortcodes = $titan->getOption('clinical_widget_Shortcodes');
        $adminBarRemove = $titan->getOption('clinical_admin_bar_remove');
        $autoUpPlugins = $titan->getOption('clinical_auto_plugins');
        $autoUpThemes = $titan->getOption('clinical_auto_themes');

        /**
         * Automatically update ALL plugins
         */
        if ($autoUpPlugins == true) {
            add_filter('auto_update_plugin', '__return_true');
        }
        /**
         * Automatically update ALL themes
         */
        if ($autoUpThemes == true) {
            add_filter('auto_update_theme', '__return_true');
        }

        /**
         *   load translation domain
         */
        //load_plugin_textdomain( 'Clinical-CMS-Core', false, basename( dirname( __FILE__ ) ) . '/languages' );

        /**
         * allow shortcode usage in widgets
         */
        if ($widgetShortcodes == true) {
            //add_filter( 'widget_text', 'shortcode_unautop' );
            add_filter('widget_text', 'do_shortcode');
        }

        /**
         * Remove admin bar for all none ADMINs
         */
        if (!current_user_can('administrator') && !is_admin() && $adminBarRemove == true) { //or current_user_can( 'manage_options' ) ???
            show_admin_bar(false);
            //add_filter('show_admin_bar', '__return_false');
        }
    }

    function clinical_admin_init()
    {
        /**
         * Get Titan Framework / ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $widgetShortcodes = $titan->getOption('clinical_widget_Shortcodes');
        $adminRedirect = $titan->getOption('clinical_admin_non_admin_redirect');
        $adminCustomTheme = $titan->getOption('clinical_admin_skin');
        $objectCache = $titan->getOption('clinical_cache_objects');

        /**
         * Allow shortcodes in widgets 
         */
        if ($widgetShortcodes == true) {
            add_filter('widget_text', 'do_shortcode');
        }

        /**
         * Hide ClinicalWP Alert / Message
         */
        global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if (isset($_GET['clinical_nag']) && '0' == $_GET['clinical_nag']) {
            add_user_meta($user_id, 'clinical_ignore_notice', 'true', true);
        }

        /**
         * Redirect User To Specific Page After Login
         */
        if (!current_user_can('manage_options') && !current_user_can('edit_pages') && !(defined('DOING_AJAX') && DOING_AJAX) && $adminRedirect == true) {
            wp_redirect(home_url());
            exit;
        }

        /**
         * Remove Dashboard Elements
         */
        /*remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );*/
        /*remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );*/
        remove_meta_box('dashboard_primary', 'dashboard', 'normal');
        /*remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );*/
        /*remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );*/
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
        /*remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );*/
        /*remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );*/
        /*remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );*/
        remove_meta_box('dashboard_activity', 'dashboard', 'normal');
        remove_meta_box('icl_dashboard_widget', 'dashboard', 'normal');


        //if($adminCustomTheme == true)
        //{
        /*
                if (is_plugin_active('materially-flat-admin-theme/materially-flat-admin-theme.php')) {
                    //plugin is active so remove menu
                    remove_menu_page('mfat-main');
                }
             */

        //use the new colour scheme method
        //require_once( 'includes/admin-colour-scheme/custom-admin-color-schemes.php' );
        //}

        if ($objectCache == true) {
            if (is_plugin_active('memcached-is-your-friend/memcached-is-your-friend.php')) {
                //plugin is active so remove menu
                remove_submenu_page('tools.php', 'wordpress_memcached_support_admin_page');
            }
        }
    }

    /*
        function clinical_admin_menu(){

        }
         */
    function clinical_after_setup_theme()
    { }


    function clinical_tgmpa_register()
    {
        /**
         * Get ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $adminCustomTheme = $titan->getOption('clinical_admin_skin');
        $objectCache = $titan->getOption('clinical_cache_objects');

        /*    
            if($adminCustomTheme == true){
                //custom admin theme on
                
                $plugins = array(
                // This is an example of how to include a plugin from the WordPress Plugin Repository.
                    array(
                        'name'      => 'materially-flat-admin-theme',
                        'slug'      => 'materially-flat-admin-theme',
                        'required'  => true,
                    )
                );
                $config = array(
                    'id'           => 'Clinical-CMS-Core',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                    'default_path' => '',                      // Default absolute path to bundled plugins.
                    'menu'         => 'tgmpa-install-plugins', // Menu slug.
                    'parent_slug'  => 'plugins.php',            // Parent menu slug.
                    'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
                    'has_notices'  => true,                    // Show admin notices or not.
                    'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
                    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                    'is_automatic' => true,                   // Automatically activate plugins after installation or not.
                    'message'      => '',                      // Message to output right before the plugins table.

                );
                tgmpa( $plugins, $config );    
            }
             */
        /*
            if($objectCache == true)
            {//memcached on
                $plugins = array(
                    // This is an example of how to include a plugin from the WordPress Plugin Repository.
                    array(
                        'name'      => 'memcached-is-your-friend',
                        'slug'      => 'memcached-is-your-friend',
                        'required'  => true,
                    )
                );
                $config = array(
                    'id'           => 'Clinical-CMS-Core',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                    'default_path' => '',                      // Default absolute path to bundled plugins.
                    'menu'         => 'tgmpa-install-plugins', // Menu slug.
                    'parent_slug'  => 'plugins.php',            // Parent menu slug.
                    'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
                    'has_notices'  => true,                    // Show admin notices or not.
                    'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
                    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                    'is_automatic' => true,                   // Automatically activate plugins after installation or not.
                    'message'      => '',                      // Message to output right before the plugins table.

                );
                tgmpa( $plugins, $config );
            }
             */
    }

    function clinical_admin_head()
    {
        /**
         * Get ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $adminColourSelector = $titan->getOption('clinical_admin_colour_scheme');
        $adminCustomTheme = $titan->getOption('clinical_admin_skin');
        $objectCache = $titan->getOption('clinical_cache_objects');

        //TESTING THIS OUT
        //echo "<link rel='stylesheet' href='" . plugins_url( 'clinical_custom/admin.css?ver=' . apply_filters('CMS_Ver_ID','') , __FILE__, '' ) . "' type='text/css' media='all' />";

        /**
         * Remove Profile Colour Scheme Selector
         */
        if ($adminColourSelector == true) {
            global $_wp_admin_css_colors;
            $_wp_admin_css_colors = 0;
        }

        /**
         * Add scripts and style if custom skin selected
         * Remove enqued scripts and style if custom skin not selected
         */
        if ($adminCustomTheme == true) {
            //use the new colour scheme method
            //include_once( 'includes/admin-colour-scheme/custom-admin-color-schemes.php' );

            //include_once( 'slate_css/dynamic.php' ); //from old slate theme no longer needed

            //register theme plugin as required plugin 
            /*
                if (is_plugin_inactive('materially-flat-admin-theme/materially-flat-admin-theme.php')) {
                    //plugin is inactive
                }
                 */
            //if plugin is available then activate it
            /*
                activate_plugins('materially-flat-admin-theme/materially-flat-admin-theme.php');
                
                if (is_plugin_active('materially-flat-admin-theme/materially-flat-admin-theme.php')) {
                    //plugin is active so output css etc
                    echo "<link rel='stylesheet' href='" . plugins_url( 'clinical_custom/admin.css?ver=' . apply_filters('CMS_Ver_ID','') , __FILE__, '' ) . "' type='text/css' media='all' />";
                }
                 */ } /*
            else
            {
                if (is_plugin_active('materially-flat-admin-theme/materially-flat-admin-theme.php')) {
                    //plugin is active so deactivate
                    deactivate_plugins('materially-flat-admin-theme/materially-flat-admin-theme.php');
                }
            }*/

        /**
         * Set tasks based on Object Caching enabled-disabled
         */
        if ($objectCache == true) {
            //register theme plugin as required plugin 
            if (is_plugin_inactive('memcached-is-your-friend/memcached-is-your-friend.php')) {
                //plugin is inactive
                /*
                    if ( class_exists( 'Memcached' ) ) {
                        /* flush all items in x seconds * /
                        $m = new Memcached();
                        $m->addServer('localhost', 11211);
                        $m->flush();
                    }
                    else if ( class_exists( 'Memcache' ) ) {
                        // flush memcache 
                        $memcache_obj = new Memcache;
                        $memcache_obj->connect('localhost', 11211);
                        $memcache_obj->flush();
                    }
                     */
                //if plugin is available then activate it
                activate_plugins('memcached-is-your-friend/memcached-is-your-friend.php');
            }
        } else {
            if (is_plugin_active('memcached-is-your-friend/memcached-is-your-friend.php')) {
                /* flush all items in 10 seconds */
                //$m = new Memcache();
                //$m = new Memcached();
                //$m->addServer('localhost', 11211);
                //$m->flush();

                //plugin is active so deactivate
                deactivate_plugins('memcached-is-your-friend/memcached-is-your-friend.php');
                //rename the object-cache file in wp-content
                rename(WP_CONTENT_DIR . '/object-cache.php', WP_CONTENT_DIR . '/object-cache.backup.php');
            }
        }
    }

    function clinical_admin_enqueue_scripts()
    {
        /**
         * Get ClinicalWP Options
         */
        //$titan = TitanFramework::getInstance( 'clinical_cms' );
        //$adminCustomTheme = $titan->getOption( 'clinical_admin_skin' );

        //enqueue ajax btn page refresh
        wp_enqueue_script('ajax_success_refresh', plugins_url('js/ajaxSuccessRefresh.js', __FILE__));
        //enqueue facebook messenger in admin
        //wp_enqueue_script('fb-messenger', plugins_url('js/fb-messenger.min.js', __FILE__));
    }

    function clinical_login_enqueue_scripts()
    {
        /**
         * Get ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        //$adminCustomTheme = $titan->getOption( 'clinical_admin_skin' );
        $loginBackColour = $titan->getOption('clinical_login_background_color');

        /**
         * Add Custom Background Colour To Login Screen
         */
        if ($loginBackColour !== '') {
            echo '<style type="text/css">body {background-color: ' . $loginBackColour . ' !important;}</style>';
        }
    }

    function clinical_welcome_panel()
    {
        //get cms version
        $cs = new Clinical_Stats();
        $cmsInfo = $cs->cc_get_cmsVersion();
        $cmsVersion = $cmsInfo['mods'];

        echo /* '<input type="hidden" id="welcomepanelnonce" name="welcomepanelnonce" value="b5def5c707" />' */
            /* '<!-- <a class="welcome-panel-close" href="'.get_bloginfo('wpurl').'/wp-admin/?welcome=0">' . __('Dismiss', 'Clinical-CMS-Core') . '</a> -->' */
            '<div class="welcome-panel-content">'
                . '<h1>' . sprintf(__('Welcome to ClinicalWP %s', 'Clinical-CMS-Core'), $cmsVersion) . '</h1>'
                . '<p class="about-description">' . __('Introducing the World\'s most popular CMS, enhanced with tweaks, optimisations, improved ease of use, and many completely new features!', 'Clinical-CMS-Core') . '</p>'
                . '<div class="welcome-panel-column-container">'
                . '<div class="welcome-panel-column">'
                . '<h4>' . __('Get Started', 'Clinical-CMS-Core') . '</h4>'
                . '<a class="button button-primary button-hero " href="' . get_bloginfo('wpurl') . '/wp-admin\admin.php?page=clinicalwp-tutorials"><span class="dashicons dashicons-video-alt3"></span> ' . __('Watch Video Tutorials (Beta!)', 'Clinical-CMS-Core') . '</a>'
                . '<li><a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=clinicalwp-wordpress-manual" class="welcome-icon dashicons-welcome-learn-more" style="display:inline-block;padding:10px 0 0 0;text-align:center;width:276px;">' . __('Read The Manual (Coming Soon!)', 'Clinical-CMS-Core') . '</a></li>'
                . '</div>'
                . '<div class="welcome-panel-column">'
                . '<h4>' . __('Next Steps', 'Clinical-CMS-Core') . '</h4>'
                . '<ul>'
                . '<li><a href="' . get_bloginfo('wpurl') . '/wp-admin/post-new.php" class="welcome-icon welcome-write-blog">' . __('Write your first blog post', 'Clinical-CMS-Core') . '</a></li>'
                . '<li><a href="' . get_bloginfo('wpurl') . '/wp-admin/post-new.php?post_type=page" class="welcome-icon welcome-add-page">' . __('Add an new page', 'Clinical-CMS-Core') . '</a></li>'
                . '<li><a href="' . get_bloginfo('wpurl') . '" class="welcome-icon welcome-view-site">' . __('View your site', 'Clinical-CMS-Core') . '</a></li>'
                . '</ul>'
                . '</div>'
                . '<div class="welcome-panel-column welcome-panel-last">'
                . '<h4>' . __('More Actions', 'Clinical-CMS-Core') . '</h4>'
                . '<ul>'
                . '<li><a href="admin.php?page=clinicalwp" class="welcome-icon dashicons-dashboard">' . __('ClinicalWP: Optimise Your Site', 'Clinical-CMS-Core') . '</a></li>'
                . '<li><div class="welcome-icon welcome-widgets-menus">' . __('Manage', 'Clinical-CMS-Core') . ' <a href="' . get_bloginfo('wpurl') . '/wp-admin/widgets.php">widgets</a> ' . __('or', 'Clinical-CMS-Core') . ' <a href="/wp-admin/nav-menus.php">' . __('menus', 'Clinical-CMS-Core') . '</a></div></li>'
                . '<li><a href="' . get_bloginfo('wpurl') . '/wp-admin/options-discussion.php" class="welcome-icon welcome-comments">' . __('Turn comments on or off', 'Clinical-CMS-Core') . '</a></li>'
                . '</ul>'
                . '</div>'
                . '</div>'
                . '</div>';
    }

    function clinical_wp_enqueue_scripts()
    {
        /**
         * Get Clinical Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $scriptsLoc = $titan->getOption('clinical_scripts_location');
        $inst_page = $titan->getOption('clinical_instant_page_enable');

        /**
         * Move Script To Head / Foot / Dont Move
         */
        //$scriptsdefer = $titan->getOption( 'clinical_scripts_defer' );
        if ($scriptsLoc == 1) {
            remove_action('wp_footer', 'wp_print_scripts');
            remove_action('wp_footer', 'wp_print_footer_scripts', 9);
            remove_action('wp_footer', 'wp_enqueue_scripts', 1);
            add_action('wp_head', 'wp_print_scripts', 5);
            add_action('wp_head', 'wp_print_footer_scripts', 5);
            add_action('wp_head', 'wp_enqueue_scripts', 5);
        } else if ($scriptsLoc == 2) {
            remove_action('wp_head', 'wp_print_scripts');
            remove_action('wp_head', 'wp_print_head_scripts', 9);
            remove_action('wp_head', 'wp_enqueue_scripts', 1);
            add_action('wp_footer', 'wp_print_scripts', 5);
            add_action('wp_footer', 'wp_enqueue_scripts', 5);
            add_action('wp_footer', 'wp_print_head_scripts', 5);
        }
        /* else{ Do Nothhing } */

            /**
             * If instant.page is enabled
             */
            if ($inst_page && !is_admin()) {
                $inst_source = $titan->getOption('clinical_instant_page_source');
                $inst_strings = $titan->getOption('clinical_instant_page_strings_enable');
                $inst_exclusion = $titan->getOption('clinical_instant_page_exclusion');
                $inst_exclusion = str_replace(',', ', ', $inst_exclusion); //split & standardise spacing

                //enqueue instant.page
                if ($inst_source == 1) { //Option 1 : local
                    wp_enqueue_script('instantpage', plugin_dir_url(__FILE__) . 'js/instantpage1.2.2.min.js', '', '', true);
                } else if ($inst_source == 2) { //Option 2 : direct from creator
                    wp_enqueue_script('instantpage', 'https://instant.page/1.2.2', '', '', true);
                } else { //Option 3 : CDNJS
                    wp_enqueue_script('instantpage', 'https://cdnjs.cloudflare.com/ajax/libs/instant.page/1.2.2/instantpage.min.js', '', '', true);
                }

                if ($inst_exclusion && !empty($inst_exclusion)) {
                    $inst_exclusion = "var wpil_isSupported = prefetcher.relList && prefetcher.relList.supports && prefetcher.relList.supports('prefetch')
                    wpil_isSupported && window.addEventListener('load', function() {
                        elementsExcluded = document.querySelectorAll('{inst_exclusion}');
                        window.window.wpInstantLinks_showExclusions && console.log('Elements Excluded: ', elementsExcluded);
                        elementsExcluded.forEach(function(elm) {
                            elm.dataset.noInstant = true;
                        });
                    });";
                }

                //if debugging
                //$exclusions_script .= "window.wpInstantLinks_showExclusions = true;";
                //$exclusions_script .= "window.wpInstantLinks_showStatus = true;";
                
                wp_add_inline_script('instantpage', $inst_exclusion);

                if ($inst_strings) {
                    wp_add_inline_script('instantpage', "document.body.dataset.instantAllowQueryString = true;", 'before');
                }
                /*
                if ($inst_external) {
                    wp_add_inline_script('wp-instant-links.js', "document.body.dataset.instantAllowExternalLinks = true;", 'before');
                }
    */
            }
    }

    /**
     * Adds additional attributes to the script
     */
    function clinical_script_tag($tag, $handle, $src)
    {
            if ('instantpage' === $handle) {
                $tag = str_replace('text/javascript', 'module', $tag);
            }
        return $tag;
    }

    function clinical_admin_notices()
    {
        /**
         * Get values from titan options framework
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $messageShow = $titan->getOption('clinical_admin_message');
        $messageText = $titan->getOption('clinical_admin_message_text');
        $messageType = $titan->getOption('clinical_admin_message_type');

        /**
         * Show Custom Note / Alert In Admin
         */
        if ($messageShow == 'true') {
            $this->showMessage($messageText, $messageType);
        }

        /**
         * Display The Code Clinic Thanks Admin Alert
         */
        /*
            global $current_user;
            $user_id = $current_user->ID;
            //global $pagenow;
            //if ( $pagenow == 'index.php' ) {
                /* Check that the user hasn't already clicked to ignore the message * /
            if (!get_user_meta($user_id, 'clinical_ignore_notice')) {
                echo '<div class="updated"><div style="float:right;margin-top:5px;"><a href="?clinical_nag=0">Dismiss</a></div><p>';
                printf('<strong>' . __('Thanks for being an awesome client!', 'Clinical-CMS-Core') . '</strong><br>' . __('If you like what we\'ve created for you please join <strong>Code Clinic KreativAgentur</strong> on %s or leave a review for us on %s.', 'Clinical-CMS-Core'), '<a href="https://www.facebook.com/codeclinicde?sk=reviews" title="Like Code Clinic Neumarkt" target="_external">Facebook</a>', '<a href=\"https://www.google.de/maps/place/Code+Clinic+KreativAgentur/@49.279113,11.4543233,17z/data=!4m5!3m4!1s0x479f6ffef75c77d9:0xe9695fff2782943a!8m2!3d49.279113!4d11.456512?hl=en\" title=\"Review Code Clinic Neumarkt\" target="_external">Google</a>');
                echo "</p></div>";
            }
            */
        //}
    }

    function clinical_wp_head()
    {
        /**
         * Get ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $seoFields = $titan->getOption('clinical_seo_fields');
        $seoDesc = $titan->getOption('clinical_seo_description', get_the_ID());
        $seoWords = $titan->getOption('clinical_seo_keywords', get_the_ID());

        /**
         * Add The SEO Data To Pages
         */
        if ($seoFields == true) {
            $gName = $titan->getOption('clinical_seo_g_name', get_the_ID());
            if (trim($gName) == "") {
                $gName = get_the_title();
            }
            $gDescription = $titan->getOption('clinical_seo_g_description', get_the_ID());
            if (trim($gDescription) == "") {
                $gDescription = $seoDesc;
            }
            $gImage = $titan->getOption('clinical_seo_g_image', get_the_ID());
            $gImageSrc = $gImage; // For the default value
            if (is_numeric($gImage)) {
                $imageAttachment = wp_get_attachment_image_src($gImage);
                $gImageSrc = $imageAttachment[0];
            } elseif (trim($gImageSrc) == "") {
                $gImageSrc = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
            }

            $twitTitle = $titan->getOption('clinical_seo_twit_title', get_the_ID());
            if (trim($twitTitle) == "") {
                $twitTitle = get_the_title();
            }
            $twitDescription = $titan->getOption('clinical_seo_twit_description', get_the_ID());
            if (trim($twitDescription) == "") {
                $twitDescription = $seoDesc;
            }
            $twitPublisher = $titan->getOption('clinical_seo_twit_Publisher', get_the_ID());
            if (trim($twitPublisher) == "") {
                $twitPublisher = $titan->getOption('clinical_twit_publisher');
            }
            if (strpos($twitPublisher, "@") === false) {
                $twitPublisher = "@" . $twitPublisher;
            }
            $twitAuthor = $titan->getOption('clinical_seo_twit_author', get_the_ID());
            if (trim($twitAuthor) == "") {
                $twitAuthor = $titan->getOption('clinical_twit_author');
            }
            if (strpos($twitAuthor, "@") === false) {
                $twitAuthor = "@" . $twitAuthor;
            }
            $twitImage = $titan->getOption('clinical_seo_twit_image', get_the_ID());
            $twitImageSrc = $twitImage; // For the default value
            if (is_numeric($twitImage)) {
                $imageAttachment = wp_get_attachment_image_src($twitImage);
                $twitImageSrc = $imageAttachment[0];
            } elseif (trim($twitImageSrc) == "") {
                $twitImageSrc = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
            }


            $fbTitle = $titan->getOption('clinical_seo_fb_title', get_the_ID());
            if (trim($fbTitle) == "") {
                $fbTitle = get_the_title();
            }
            $fbDescription = $titan->getOption('clinical_seo_fb_description', get_the_ID());
            if (trim($fbDescription) == "") {
                $fbDescription = $seoDesc;
            }
            $fbAdminID = $titan->getOption('clinical_seo_fb_aminID', get_the_ID());
            if (trim($fbAdminID) == "") {
                $fbAdminID = $titan->getOption('clinical_fb_aminID');
            }
            $fbImage = $titan->getOption('clinical_seo_fb_image', get_the_ID());
            $fbImageSrc = $fbImage; // For the default value
            if (is_numeric($fbImage)) {
                $imageAttachment = wp_get_attachment_image_src($fbImage);
                $fbImageSrc = $imageAttachment[0];
            } elseif (trim($fbImageSrc) == "") {
                $fbImageSrc = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
            }
            $fbType = ((is_single() and !is_page()) ? "article" : "website"); /* website or, article if blog post */
            global $wp;
            //$fbURL = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
            $fbURL = get_permalink();
            $fbSiteName = get_bloginfo('name');

            if (is_single() and !is_page()) {
                $fbAuthor = $titan->getOption('clinical_seo_fb_author', get_the_ID());
                if (trim($fbAuthor) == "") {
                    $fbAuthor = $titan->getOption('clinical_fb_author');
                }
                $fbPublisher = $titan->getOption('clinical_seo_fb_publisher', get_the_ID());
                if (trim($fbPublisher) == "") {
                    $fbPublisher = $titan->getOption('clinical_fb_publisher');
                }
            }

            $fbAppID = $titan->getOption('clinical_fb_appID');

            if (trim($seoWords) != "") { ?>
                <meta name="keywords" content="<?php echo $seoWords; ?>">
            <?php
            }
            if (trim($seoDesc) != "") { ?>
                <meta name="description" content="<?php echo $seoDesc; ?>">
            <?php
            } ?>
            <meta name="googlebot" content="noodp"> <!-- tell Google to not use Moz Dir description -->

            <!-- Schema.org markup for Google+ -->
            <?php if (trim($gName) != "") { ?>
                <meta itemprop="name" content="<?php echo $gName; ?>">
            <?php
            }
            if (trim($gDescription) != "") { ?>
                <meta itemprop="description" content="<?php echo $gDescription; ?>">
            <?php
            }
            if (trim($gImageSrc) != "") { ?>
                <meta itemprop="image" content="<?php echo $gImageSrc; ?>">
            <?php
            } ?>
            <!-- Twitter Card data -->
            <meta name="twitter:card" content="summary_large_image">
            <?php if (trim($twitPublisher) != "") { ?>
                <meta name="twitter:site" content="<?php echo $twitPublisher; ?>">
            <?php
            }
            if (trim($twitTitle) != "") { ?>
                <meta name="twitter:title" content="<?php echo $twitTitle; ?>">
            <?php
            }
            if (trim($twitDescription) != "") { ?>
                <meta name="twitter:description" content="<?php echo $twitDescription; ?>">
            <?php
            }
            if (trim($twitAuthor) != "") { ?>
                <meta name="twitter:creator" content="<?php echo $twitAuthor; ?>">
            <?php
            }
            if (trim($twitImageSrc) != "") { ?>
                <!-- Twitter summary card with large image must be at least 280x150px -->
                <meta name="twitter:image:src" content="<?php echo $twitImageSrc; ?>">
            <?php
            } ?>
            <!-- Open Graph data -->

            <?php if (trim($fbType) != "") { ?>
                <meta property="og:type" content="<?php echo $fbType; ?>" />
            <?php
            }
            if (trim($fbTitle) != "") { ?>
                <meta property="og:title" content="<?php echo $fbTitle; ?>" />
            <?php
            }
            if (trim($fbURL) != "") { ?>
                <meta property="og:url" content="<?php echo trailingslashit($fbURL); ?>" />
            <?php
            }
            if (trim($fbImageSrc) != "") { ?>
                <meta property="og:image" content="<?php echo $fbImageSrc; ?>" />
            <?php
            }
            if (trim($fbDescription) != "") { ?>
                <meta property="og:description" content="<?php echo $fbDescription; ?>" />
            <?php
            }
            if (trim($fbSiteName) != "") { ?>
                <meta property="og:site_name" content="<?php echo $fbSiteName; ?>" />
            <?php
            } ?>
            <!-- 
                                                                                                                                                                                                                                                    <meta property="article:published_time" content="2013-09-17T05:59:00+01:00" />
                                                                                                                                                                                                                                                    <meta property="article:modified_time" content="2013-09-16T19:08:47+01:00" />
                                                                                                                                                                                                                                                    <meta property="article:section" content="Article Section" />
                                                                                                                                                                                                                                                    <meta property="article:tag" content="Article Tag" />
                                                                                                                                                                                                                                                    -->
            <?php if (trim($fbAdminID) != "") { ?>
                <meta property="fb:admins" content="<?php echo $fbAdminID; ?>" />
            <?php
            }
            if (trim($fbAppID) != "") { ?>
                <meta property="fb:app_id" content="<?php echo $fbAppID; ?>" />
            <?php
            }

            if (is_single() and !is_page()) {
                if (trim($fbPublisher) != "") { ?>
                    <meta property="article:publisher" content="<?php echo $fbPublisher; ?>" />
                <?php
                }
                if (trim($fbAuthor) != "") { ?>
                    <meta property="article:author" content="<?php echo $fbAuthor; ?>" />
                <?php
                }
            }
            ?>

        <?php
        }
    }

    function clinical_wp_dashboard_setup()
    {
        //get cms version
        $cs = new Clinical_Stats();
        $cmsInfo = $cs->cc_get_cmsVersion();
        $cmsVersion = $cmsInfo['mods'];
        wp_add_dashboard_widget('wp_dashboard_widget', sprintf(__('<!--Welcome To -->ClinicalWP Core %s %s ', 'Clinical-CMS-Core'),  $cmsVersion, apply_filters('CMS_Ver_ID', '')) . "[<span style='font-size:x-small;'>" . sprintf(__('enhancing WordPress %s', 'Clinical-CMS-Core'), get_bloginfo('version')) . "</span>]", array($this, 'clinical_dashboard_widget_function')); // add a custom dashboard widget
        //wp_add_dashboard_widget('wp_dashboard_widget', __('Platform Information', 'Clinical-CMS-Core'), array($this, 'clinical_dashboard_widget_function') ); // add a custom dashboard widget
        //echo "<li>&nbsp;</li><li><strong>".sprintf( __('<!--Welcome To -->ClinicalWP %s %s ', 'Clinical-CMS-Core'), apply_filters('CMS_Ver_ID',''), $cmsVersion )."</strong> [<span style='font-size:x-small;'>".sprintf( __('enhancing WordPress %s', 'Clinical-CMS-Core'), get_bloginfo('version'))."</span>]</li>";

        //wp_add_dashboard_widget('dashboard_custom_feed', 'Code Clinic Tips & News', array($this, 'dashboard_custom_feed')); //add new RSS feed output
    }

    //adds a custom dashboard news feed. Called in dashboard_setup
    /*
    function dashboard_custom_feed()
    {
        echo '<div class="rss-widget">';
        if (get_locale() == 'de_DE' || get_locale() == 'de_DE-formal' || get_locale() == 'de_CH' || ICL_LANGUAGE_CODE == "de" || ICL_LANGUAGE_CODE == 'de_DE-formal' || ICL_LANGUAGE_CODE == 'de_CH') {
            wp_widget_rss_output(array(
                'url' => 'http://feeds.feedburner.com/CodeClinicKreativagentur', //Deutsch feed
                'title' => 'Code Clinic Tipps & Aktuelles',
                'items' => 8, //how many posts to show
                'show_summary' => 0,
                'show_author' => 0,
                'show_date' => 1
            ));
        } else {
            wp_widget_rss_output(array(
                'url' => 'http://feeds.feedburner.com/codeclinickreativangentur-en', //English feed
                'title' => 'Code Clinic Tips & News',
                'items' => 8, //how many posts to show
                'show_summary' => 0,
                'show_author' => 0,
                'show_date' => 1
            ));
        }
        echo "</div>";
    }
    */

    function clinical_admin_print_styles()
    {
        //wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/clinical_custom/admin.css' );
        //wp_enqueue_style( 'admin_css',  get_bloginfo('wpurl'). '/wp-content/clinical_custom/admin.css' );
        //wp_enqueue_style( 'admin_css',  plugins_url( 'clinical_custom/admin.css' , __FILE__, '1.0' ) );

        //wp_enqueue_style( 'admin_css',  plugins_url( 'clinical_custom/clinicalWP-admin.css' , __FILE__, $this->return_CMS_Ver_ID() ) );
        wp_enqueue_style('admin_css', plugins_url('clinical_custom/clinicalWP-admin.min.css', __FILE__, CWP_Version));
    }

    function clinical_admin_bar_menu()
    {
        /**
         * Get ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $adminComments = $titan->getOption('clinical_admin_comment_link');
        $default_comment_status = get_option('default_comment_status');

        global $wp_admin_bar;
        /**
         * Add Code Clinic Links To Admin Bar
         */
        /*
            global $wp_admin_bar;
            if (!is_super_admin() || !is_admin_bar_showing())
                return;
            $wp_admin_bar->add_menu(array(
                'id' => 'clinical-menu',
                'title' => '<span class="ab-icon"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAE9ElEQVRYhcWXb2hVZRjAf+977rn37i4359rFocM5myixHKktWxLUIJWkJKgQJJXKIirrgxJhmBAoFFZfpD8QiEUhFKJ9iFAqK6eIf6aSto1ay5mbOrfp7s6957xPH87dubu72+51CD1wOIdznj+/933e93mfo27sqk4AIf4fcUPp4PkB7GJ0vB7Ew3Q1++/Cd6DL70bZsUBN3CHM5RPgOQURFDRyXVFHdMXnqOg0nJ/exHQ1Y9dvwF74albwYTH9nQwdWIP0d+T3XQhAuHErqqgck+jBvbAXq7oJu2HzmMEBdEkV4YZNhbguZAYUuuwuAKSvA8Qgg1dJ/vxWrmYsjr3wFZS20NPm3i4AQCn/blz/1n0S031ybIdzn0CVVmds8khBKbglEbkl9UkD6MoGoiu/JLryC1RZYdNdIIDKvpROPw9/trBqHye67BOsGUuwZjxA9LHdWLMeBm2P7ye4RkW7sas6BYR0RR3hxq3ostpRegrsYpRSeBePkGzeTtGT+wAQEdSIXIvrgGWjlEbEQOpmdjQRTM8ZnMNbkL4/IV2IwC7293lRef45SwcU45E69h4qFidUtxalFCoUGaGmITwlx9ya2Uh0+ackvn4UxPN3gY7XB8HFTWC6W0BMYKQrF6O0zyqJqySPf4Tbth+53gaA2/otVs0KdFntuLXBjx5GT61BT52DKp2NXG/zAZQVDnRSxz8kderjEUYRYutb/ODJAWTgH1LHd2b5NT1nMD1n/JGXzkZFSkBM8C5LtI294LkgzTl1QJID2dCzlwWA5ur58UeXFrt+A/b8pxERhvavzpwbgDVzKWJcUid3ZXgmcqYr7yOydJsPZjzctv15AdzWfcHijDyyE10+P+Nv+iKiK/dg1a7KBhg96mEJL9qIipQgIqSOvR/kfCIxXUdwz+72nRdPx17wfNZ3pTTh+zent3cawFw5hzh9Y7iTtJFCxSryBg+CjNAVciujjsVRU6oyALgJkr+96+/dEeL88g7m5mUAQnVr0RV1eYNbs5qwapYDYHrbSR17fwxCFeyWYA24F/Yy9M0qvH9PZOh7//BPvXROhx1PJKE5K1BKISI4B19DbnRNrA9gVT2EjteTavksp3p5HYcY3LPEB0oN5gVQZbW+7s1LmCvnsr+NkcYQgHhJwos3Yt/7EnKzOzh2c0WQ5A3M1d9xW/dhuo4A/rSH5qzA+XUbyi72gxXdSdEzhzKm2gryLiKIO5QBMJdPYPo70SVVqJKqvKO04vcQmvcU7tndqFgFVs1ylFIkj+7IjNYKo6bOHtPe9JxB+v7KAOA5DB1YQ7hhk9/JZDUTClVa7R8wqQSS7EfF4iilsOuezcyNSFYvIF4SGegcFdng9bSQat7B8A4LKqH0d+D88PIYvIrY+tMQnoLpPsXQ/tXoygYiTR+gi6f7fnvbcQ5uRAa7MwADnSS+ahp3FodlUv8D5tJRnO/WYde/gJAuUnlW+20FADDXzuMcemOy5oHcWkumb/8PVGEe04tLx+sJN76NOLlnh/f3j36nPHy0G5OjM0kAwfS0YM18EGXZ2HXrcjW8JG77AYhMRcXiPlBPS0EABaXAObwFc709N7AIpq8D5/sXkd5WwotfBx3C6z5Nqnl7QQBBU5pf0/K7HSvT+fod0kWCU3PaPPCcdJEp6P/ADQHj1d1sEQ+53jahW7mWv2MaDfAfS6vje9Yi8HUAAAAASUVORK5CYII=" /></span><span class="ab-label">' . __('ClinicalWP', 'Clinical-CMS-Core') . '</span>',
                'href' => __('http://codeclinic.de'),
            ));
*/
        /*
            // Add sub menu link "Biz Clinic"
            $wp_admin_bar->add_menu( array(
                'parent' => 'clinical-menu',
                'id'     => 'biz-clinic',
                'title' => __('Biz Clinic - Business Support Agentur','Clinical-CMS-Core'),
                'href' => __('https://bizclinic.de/'),
            ));
             */
        /*
            // Add sub menu link "Code Clinic"
            $wp_admin_bar->add_menu(array(
                'parent' => 'clinical-menu',
                'id' => 'code-clinic',
                'title' => __('Code Clinic KreativAgentur', 'Clinical-CMS-Core'),
                'href' => __('https://codeclinic.de'),
            ));
*/
        /**
         * Remove Comments Link In Admin Bar If Comments 'Closed'
         */
        if ($default_comment_status == 'closed' && $adminComments == true) {
            //$wp_admin_bar->remove_menu('comments');
            $wp_admin_bar->remove_node( 'comments' );
        } else {
            return;
        }
    }

    function clinical_wp_before_admin_bar_render()
    {
        /**
         * Get ClinicalWP Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $adminBarLinksRemove = $titan->getOption('clinical_admin_non_admin_remove');

        /**
         * Remove Elements From Admin Bar
         */
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
        //$wp_admin_bar->remove_menu('updates');

        /**
         * Remove Profile Edit Links From Admin Bar
         */
        //useful if remove admin bar for non-admins & set via Titan Framework
        if (!current_user_can('administrator') && !is_admin() && $adminBarLinksRemove == true) { //or current_user_can( 'manage_options' ) ???
            echo '<style>#wp-admin-bar-user-actions>li#wp-admin-bar-edit-profile{display: none;} .ab-top-menu>li#wp-admin-bar-site-name{
display: none;}</style>';
        }
    }

    function clinical_pre_ping(&$links)
    {
        /**
         * Get Clinical Options
         */
        $titan = TitanFramework::getInstance('clinical_cms');
        $adminPingSelf = $titan->getOption('clinical_admin_pings_self');

        /**
         * Prevent On Site PingBacks
         */
        if ($adminPingSelf == true) {
            $home = get_option('home');
            foreach ($links as $l => $link)
                if (0 === strpos($link, $home))
                    unset($links[$l]);
        }
    }

    function clinical_login_head()
    {
        /**
         * Get ClinicalWP Options
         */
        //$titan = TitanFramework::getInstance( 'clinical_cms' );
        //$adminCustomTheme = $titan->getOption( 'clinical_admin_skin' );

        /**
         * remove enqued scripts and style if custom skin not selected
         */
        //if($adminCustomTheme == true)
        //{
        //include_once( 'slate_css/dynamic.php' );        
        //}
    }
    /*
        function clinical_media_upload_tab_slug(){

        }
        function clinical_admin_footer(){

        }
         */


    //this runs when saving options in ClinicalWP
    function clinical_save_admin($container, $activeTab, $options)
    {
        //if ( $activeTab == 'general' ) {
        //    delete_transient( 'some_old_transient' );
        //}

        //get Titan Framework settings
        $titan = TitanFramework::getInstance('clinical_cms');
        $clinical_script_replace = $titan->getOption('clinical_swap_enable');

        /*
            $client_type_guess = limit_login_guess_proxy();

            if ($client_type_guess == LIMIT_LOGIN_DIRECT_ADDR) {
                $client_type_message = sprintf(__('It appears the site is reached directly (from your IP: %s)','clinical-login-security'), limit_login_get_address(LIMIT_LOGIN_DIRECT_ADDR));
            } else {
                $client_type_message = sprintf(__('It appears the site is reached through a proxy server (proxy IP: %s, your IP: %s)','clinical-login-security'), limit_login_get_address(LIMIT_LOGIN_DIRECT_ADDR), limit_login_get_address(LIMIT_LOGIN_PROXY_ADDR));
            }
            $client_type_message .= '<br />';

            $client_type_warning = '';
            if ($client_type != $client_type_guess) {
                $faq = 'http://wordpress.org/extend/plugins/limit-login-attempts/faq/';

                $client_type_warning = '<br /><br />' . sprintf(__('<strong>Current setting appears to be invalid</strong>. Please make sure it is correct. Further information can be found <a href="%s" title="FAQ">here</a>','clinical-login-security'), $faq);
            }
             */
        //delete the cached options before updating
        wp_cache_delete('alloptions', 'options');

        /*
    //ClinicalWP Licenses: titan -> wp options
    $coreLic = $titan->getOption('licCore');
    $dcacheLic = $titan->getOption('licData');
    $imgLic = $titan->getOption('licImage');
    $secLic = $titan->getOption('licSecurity');
    $spamLic = $titan->getOption('licSpam');
    $agentLic = $titan->getOption('licSlack');
    update_option('edd_CCK_Core_License', $coreLic);
    update_option('edd_CCK_DCache_License', $dcacheLic);
    update_option('edd_CCK_Image_License', $imgLic);
    update_option('edd_CCK_Security_License', $secLic);
    update_option('edd_CCK_Spam_License', $spamLic);
    update_option('edd_CCK_Agent_License', $agentLic);
    */

        //Clinical Login Tools Options
        $loginRetries = $titan->getOption('clinical_login_retries');
        $loginLockout = $titan->getOption('clinical_login_lockout_time_1');
        $loginLockoutNum = $titan->getOption('clinical_login_retries_2');
        $loginLockout2 = $titan->getOption('clinical_login_lockout_time_2');
        $loginReset = $titan->getOption('clinical_login_lockout_time_reset');
        $loginConn = $titan->getOption('clinical_login_site_connection');
        $loginNotify = $titan->getOption('clinical_login_lockout_notify');
        $addF2B = $titan->getOption('clinical_f2b_report');
        //Convert to WP based options

        update_option('limit_login_client_type', $loginConn);
        update_option('limit_login_allowed_retries', $loginRetries);
        update_option('limit_login_lockout_duration', $loginLockout * 60);
        update_option('limit_login_allowed_lockouts', $loginLockoutNum);
        update_option('limit_login_long_duration', $loginLockout2 * 3600);
        update_option('limit_login_valid_duration', $loginReset * 3600);
        update_option('limit_login_lockout_notify', implode(",", $loginNotify));
        update_option('limit_login_notify_email_after', $loginLockout2);
        update_option('limit_login_cookies', '1'); //always use cookies
        //update_option('limit_login_cookies', limit_login_option('cookies') ? '1' : '0');
        update_option('clinical_f2b_report', $addF2B); //add lockouts to server log wp_f2b.log


        //Set wp-config tweaks
        $this->clinical_create_config();
        //set htacess tweaks
        $clinical_browser_cache_plugin = new Clinical_Browser_Cache_Plugin();
        $clinical_browser_cache_plugin->Clinical_caching_configure();


        //check if JQuery replacement available / requested
        if ($clinical_script_replace == 3) {
            //just load JQuery from Google CDN
            $jquery_version = wp_scripts()->registered['jquery']->ver;
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

            $clinical_replace_core = new Clinical_Replace_Core();
            if ($clinical_replace_core->URL_exists('https://ajax.googleapis.com/ajax/libs/jquery/' . $jquery_version . '/jquery' . $suffix . '.js')) { //set WP option to activate
                update_option('clinical_cms_jquery_cdn', true);
            } else {
                //set WP option to activate
                update_option('clinical_cms_jquery_cdn', false);
            }
        }
        //clear the data object cache (memcache(d))
        $this->clinical_clear_data_cache();
    }

    function clinical_clear_data_cache()
    {
        //lets clear object cache so settings stick
        $titan = TitanFramework::getInstance('clinical_cms');
        $value = $titan->getOption( 'clinical_cache_objects' );
        $ip = $titan->getOption('clinical_cache_objects_server_ip');
        $port = $titan->getOption('clinical_cache_objects_server_port');
        if (class_exists('Memcached') && ($value)) {
            /* flush all items in x seconds */
            $m = new Memcached();
            $m->addServer($ip, $port);
            $m->flush();
        } else if (class_exists('Memcache') && ($value)) {
            // flush memcache 
            $memcache_obj = new Memcache;
            $memcache_obj->connect($ip, $port);
            $memcache_obj->flush();
        }
    }

    function clinical_create_config()
    {

        if (!defined('ABSPATH')) {
            define('ABSPATH', dirname(dirname(__FILE__)) . '/');
        }

        $config_file = file(ABSPATH . 'wp-config.php');

        $path_to_wp_config_Backup = ABSPATH . 'wp-config-backup.php';
        $path_to_wp_config_Original = ABSPATH . 'wp-config.php';
        $wpOriginal_Content = file_get_contents($path_to_wp_config_Original);
        file_put_contents($path_to_wp_config_Backup, $wpOriginal_Content, LOCK_EX);

        $customConstants = array(/*"CC_Plan", */"WP_DEBUG", "WP_DEBUG_LOG", "WP_DEBUG_DISPLAY", "WP_ALLOW_REPAIR", "WP_POST_REVISIONS", "WP_MEMORY_LIMIT", "WP_MAX_MEMORY_LIMIT", "EMPTY_TRASH_DAYS", "DISALLOW_FILE_EDIT", "DISALLOW_FILE_MODS", "IMAGE_EDIT_OVERWRITE", "AUTOSAVE_INTERVAL", "WP_AUTO_UPDATE_CORE", "FORCE_SSL_ADMIN", "ULTIMATE_NO_EDIT_PAGE_NOTICE", "ULTIMATE_NO_PLUGIN_PAGE_NOTICE", "MEMCACHED_SERVER", "SLACK_ENABLE", "SLACK_CHANNEL", "SLACK_CALLBACK");
        //string to show when weve processed a declaration
        $done = "";

        foreach ($config_file as $line_num => $line) {

            if (!preg_match('/^define\(\'([A-Z_]+)\',([ ]+)/', $line, $match))
                continue;

            $constant = $match[1];
            $padding = $match[2];

            // echo '<br/>Constant: ' . $constant . ' / Padding: ' . $padding;
            if (strpos($done, ';' . $constant . ';') === false) {
                switch (trim($constant)) {
                        //THIS BLOCK REMAINS UNCHANGED
                    case 'WP_CACHE':
                    case 'DB_COLLATE':
                    case 'DB_NAME':
                    case 'DB_USER':
                    case 'DB_PASSWORD':
                    case 'DB_HOST':
                    case 'DB_CHARSET':
                    case 'AUTH_KEY':
                    case 'SECURE_AUTH_KEY':
                    case 'LOGGED_IN_KEY':
                    case 'NONCE_KEY':
                    case 'AUTH_SALT':
                    case 'SECURE_AUTH_SALT':
                    case 'LOGGED_IN_SALT':
                    case 'NONCE_SALT':
                        # case 'WP_DEBUG_LOG'     :
                        # case 'WP_DEBUG_DISPLAY' :
                    case 'SCRIPT_DEBUG':
                    case 'WPLANG':
                    case 'WP_LANG_DIR':
                    case 'SAVEQUERIES':
                        break;
                        //CODE CLINIC ADDED VALUES
/*                    case 'CC_Plan':
                        //don't do anything if not empty, otherwise set value as 'Awesome'
                        if (CC_Plan == '') {
                            $config_file[$line_num1] = "define('" . $value . "', 'Awesome');\r\n";
                        }
                        break;
*/                  
                    //THIS BLOCK GETS REMOVED
                    case 'WP_DEBUG':
                    case 'WP_DEBUG_LOG':
                    case 'WP_DEBUG_DISPLAY':
                    case 'WP_ALLOW_REPAIR':
                    case 'WP_POST_REVISIONS':
                    case 'WP_MEMORY_LIMIT':
                    case 'WP_MAX_MEMORY_LIMIT':
                    case 'EMPTY_TRASH_DAYS':
                    case 'DISALLOW_FILE_EDIT':
                    case 'DISALLOW_FILE_MODS':
                    case 'IMAGE_EDIT_OVERWRITE':
                    case 'AUTOSAVE_INTERVAL':
                    case 'WP_AUTO_UPDATE_CORE':
                    case 'FORCE_SSL_ADMIN':
                    case 'ULTIMATE_NO_EDIT_PAGE_NOTICE':
                    case 'ULTIMATE_NO_PLUGIN_PAGE_NOTICE':
                    case 'MEMCACHED_SERVER':
                    case 'SLACK_ENABLE':
                    case 'SLACK_CHANNEL':
                    case 'SLACK_CALLBACK':
                        $config_file[$line_num] = "";
                        break;
                    default:
                        //remove this line to erase the definition
                        //$config_file[ $line_num ] = "";
                        break;
                }

                //add declaration to 'processed' list
                $done .= ";" . $constant . ";";
            } else {
                //remove this line to erase the definition
                $config_file[$line_num] = "";
            }
        }

        unset($line);

        //Now re-enter our custom values
        $customValues = "";
        foreach ($customConstants as &$value) {

            switch (trim($value)) {
                    //CODE CLINIC ADDED VALUES
                    //"define('" . $constant . "'," . $padding . "'" . $this-->getValue($constant) . "');\r\n";
/*               
                case 'CC_Plan': //custom tag
                    break;
*/
                case 'WP_DEBUG':
                case "WP_DEBUG_LOG":
                case "WP_DEBUG_DISPLAY":
                case 'WP_ALLOW_REPAIR':
                case 'WP_POST_REVISIONS':
                case 'WP_MEMORY_LIMIT':
                case 'WP_MAX_MEMORY_LIMIT':
                case 'EMPTY_TRASH_DAYS':
                case 'DISALLOW_FILE_EDIT':
                case 'DISALLOW_FILE_MODS':
                case 'IMAGE_EDIT_OVERWRITE':
                case 'AUTOSAVE_INTERVAL':
                case 'WP_AUTO_UPDATE_CORE':
                case 'FORCE_SSL_ADMIN':
                case 'ULTIMATE_NO_EDIT_PAGE_NOTICE':
                case 'ULTIMATE_NO_PLUGIN_PAGE_NOTICE':
                case 'MEMCACHED_SERVER':
                case 'SLACK_ENABLE':
                case 'SLACK_CHANNEL':
                case 'SLACK_CALLBACK':
                    //$config_file[ $line_num1 ] = $this->getValue($value);
                    $customValues = $customValues . $this->getValue($value);
                    break;
                default:
                    //remove this line to erase the definition
                    //$config_file[ $line_num ] = "";
                    break;
            }
        }

        unset($value);

        $path_to_wp_config = ABSPATH . 'wp-config.php';
        $handle = fopen($path_to_wp_config, 'w');

        foreach ($config_file as $line) {

            //string replace
            if (strpos($line, "/* That's all, stop editing! Happy blogging. */") !== false) {
                $line = str_replace("/* That's all, stop editing! Happy blogging. */", $customValues . "/* That's all, stop editing! Happy blogging. */", $line);
            } else if (strpos($line, "/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß beim Bloggen. */") !== false) {
                $line = str_replace("/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß beim Bloggen. */", $customValues . "/* Das war’s, Schluss mit dem Bearbeiten! Viel Spaß beim Bloggen. */", $line);
            }
            fwrite($handle, $line);
        }

        fclose($handle);
        chmod($path_to_wp_config, 0660);
    }


    function getValue($constant)
    {
        $titan = TitanFramework::getInstance('clinical_cms');
        $output = "";

        switch ($constant) {
            case 'WP_DEBUG':
                $value = $titan->getOption('clinical_debug_enable');
                if ($value == '1') {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'WP_DEBUG_LOG':
                $value = $titan->getOption('clinical_debug_output');
                if ($value == '1' || $value == '3') {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'WP_DEBUG_DISPLAY':
                $value = $titan->getOption('clinical_debug_output');
                if ($value == '2' || $value == '3') {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'WP_ALLOW_REPAIR':
                $value = $titan->getOption('clinical_maintenance_enable');
                if ($value == '1') {
                    $value = 'true';
                    $output = "define('" . $constant . "', " . $value . ");\r\n";
                } else {
                    $value = 'false';
                }
                //$output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'WP_POST_REVISIONS':
                $value = $titan->getOption('clinical_revision_limit');
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'WP_MEMORY_LIMIT':
                $value = $titan->getOption('clinical_memory_limit');
                $output = "define('" . $constant . "', '" . $value . "M');\r\n";
                break;
            case 'WP_MAX_MEMORY_LIMIT':
                $value = $titan->getOption('clinical_admin_memory_limit');
                $output = "define('" . $constant . "', '" . $value . "M');\r\n";
                break;
            case 'EMPTY_TRASH_DAYS':
                $value = $titan->getOption('clinical_trash_days');
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'DISALLOW_FILE_EDIT':
                $value = $titan->getOption('clinical_filesplugins_editor');
                if ($value == '1') {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'DISALLOW_FILE_MODS':
                $value = $titan->getOption('clinical_theme_editor');
                if ($value == '1') {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'IMAGE_EDIT_OVERWRITE':
                $value = $titan->getOption('clinical_limit_image_editor');
                if ($value == '1') {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'AUTOSAVE_INTERVAL':
                $value = $titan->getOption('clinical_autosave_interval');
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'WP_AUTO_UPDATE_CORE':
                $value = $titan->getOption('clinical_advanced_automated');
                if ($value == 1) {
                    $value = 'false';
                } else if ($value == 2) {
                    $value = "'minor'";
                } else {
                    $value = 'true';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
            case 'FORCE_SSL_ADMIN':
                $value = $titan->getOption('clinical_enable_ssl_admin');
                if ($value == '1') {
                    $value = 'true';
                } else {
                    $value = 'false';
                }
                $output = "define('" . $constant . "', " . $value . ");\r\n";
                break;
                /*
                case 'ULTIMATE_NO_EDIT_PAGE_NOTICE' :
                    $value = $titan->getOption( 'clinical_viscomp_ultaddons' );
                    if($value == '1'){$value = 'true';}
                    else{$value = 'false';}
                    $output = "define('" . $constant . "', " . $value . ");\r\n";
                    break;
                case 'ULTIMATE_NO_PLUGIN_PAGE_NOTICE' :
                    $value = $titan->getOption( 'clinical_viscomp_ultaddons' );
                    if($value == '1'){$value = 'true';}
                    else{$value = 'false';}
                    $output = "define('" . $constant . "', " . $value . ");\r\n";
                    break;
                 */
            case 'MEMCACHED_SERVER':
                $value = $titan->getOption('clinical_cache_objects');
                $ip = $titan->getOption('clinical_cache_objects_server_ip');
                $port = $titan->getOption('clinical_cache_objects_server_port');
                if ($value == '1') {
                    $output = "define('" . $constant . "', '" . $ip . ":" . $port . "');\r\n";
                }
                break;
            case 'SLACK_ENABLE':
                $value = $titan->getOption('clinical_slack_enable');
                if ($value == '1') {
                    //$value = 'true';
                    $output = "define('" . $constant . "', true);\r\n";
                }
                break;
            case 'SLACK_CHANNEL':
                $value = $titan->getOption('clinical_slack_channel');
                if (trim($value)) {
                    $output = "define('" . $constant . "', '" . $value . "');\r\n";
                }
                break;
            case 'SLACK_CALLBACK':
                $value = $titan->getOption('clinical_slack_endpoint');
                if (trim($value)) {
                    $output = "define('" . $constant . "', '" . $value . "');\r\n";
                }
                break;
        }
        return $output;
    }
} // END class WP_Plugin_Template
} // END if(!class_exists('WP_Plugin_Template'))

if (!function_exists('is_plugin_active'))
    require_once(ABSPATH . '/wp-admin/includes/plugin.php');

if (class_exists('Clinical_CMS_Core_Plugin')) {

    // instantiate the plugin class
    $clinical_cms_core_plugin = new Clinical_CMS_Core_Plugin();

    /**
     *   load translation domain
     */
    load_plugin_textdomain('Clinical-CMS-Core', false, basename(dirname(__FILE__)) . '/languages');
}


//remove_action('publish_post','generic_ping'); 
//would prevent your weblog from sending pings whenever a new post is created.

?>