<?php
/* Loads core scripts from wordpress.com rather than locally
* speeds site up if site user has the files cached
*/
/* Prevent loading this file directly and/or if the class is already defined */
if ( ! defined( 'ABSPATH' ) )
	return;

if(!class_exists('Clinical_CMS_Core') /* && class_exists( 'TitanFramework' ) */)//only if class doesn't exist and Titan Framework (plugin) is activated
{
    if(!class_exists('Clinical_Appearance')){
        class Clinical_Appearance
        {
            public function __construct() {

                add_action('login_head', array($this, 'custom_login_css') );
                add_filter( 'login_headerurl', array($this, 'my_login_logo_url') );
                //add_filter( 'login_headertitle', array($this, 'my_login_logo_url_title') ); // Deprecated
                add_filter( 'login_headertext', array($this, 'my_login_logo_url_title') );
                add_action( 'login_enqueue_scripts', array($this, 'login_image') );
                add_action( 'avatar_defaults', array($this, 'custom_gravatar') );
            }
            
            /************************************************************************************/
            /*                                                                                  */
            /*                          LOGIN PAGE                                              */
            /*                                                                                  */
            /************************************************************************************/

            /* Add a custom css file to the login page */
            function custom_login_css(){
                //load custom clinical cms login css
                //echo '<link rel="stylesheet" type="text/css" href="'.plugins_url( '../clinical_custom/login.css' , __FILE__ ).'" />';
                echo '<link rel="stylesheet" type="text/css" href="'.plugins_url( '../clinical_custom/login.min.css' , __FILE__ ).'" />';
            }
            
            /* Replace the 'Powered By WordPress' title of Logo on login screen */
            function my_login_logo_url() {
                //return get_bloginfo( 'url' );
                return ('https://codeclinic.de/');
            }

            public static function my_login_logo_url_title() {
                return (__('Powered By ClinicalWP', 'Clinical-CMS-Core'));
            }
            
            function login_image() {
                $titan = TitanFramework::getInstance( 'clinical_cms' );
                $logo_enabled = $titan->getOption( 'clinical_login_logo_image' );
                $imageID = $titan->getOption( 'clinical_login_upload_image' );
                if($logo_enabled  == true  && $imageID !== '') {
                    $imageSrc = $imageID; // For the default value
                    if ( is_numeric( $imageID ) ) {
                        $imageAttachment = wp_get_attachment_image_src( $imageID, 'full' );
                        $imageSrc = $imageAttachment[0];
                    }  ?>
                    <style type="text/css">
                        .login h1 a {
                            background-image: url(<?php echo '\''.esc_url( $imageSrc ).'\'' ?>) !important;
                        }
                    </style>
                <?php }
            }

            //add custom avatar Image
            //All you'll need to customize is the path to your default image.
            function custom_gravatar($avatar_defaults) {
                $titan = TitanFramework::getInstance( 'clinical_cms' );
                $grav = $titan->getOption( 'clinical_admin_profile_gravatar' );
                if($grav == true)
                {
                    $gravImage = $titan->getOption( 'clinical_admin_profile_gravatar_image' );
                    // The value may be a URL to the image (for the default parameter)
                    // or an attachment ID to the selected image.
                    $imageSrc = $gravImage; // For the default value
                    if ( is_numeric( $gravImage ) ) {
                        $imageAttachment = wp_get_attachment_image_src( $gravImage );
                        $imageSrc = $imageAttachment[0];
                    } 
                    $avatar_defaults[esc_url($imageSrc)] = get_bloginfo('name');
                }
                return $avatar_defaults;
            }//END FUNCTION 
        } // END class Clinical_Replace_Core
    } // END if(!class_exists('Clinical_Replace_Core'))
}
if(class_exists('Clinical_Appearance'))
{// instantiate the plugin class
    $clinical_appearance = new Clinical_Appearance();
}

?>