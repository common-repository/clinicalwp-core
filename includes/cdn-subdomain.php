<?php
/* Loads static resources from CDN or subdomain
*/
/* Prevent loading this file directly and/or if the class is already defined */
if ( ! defined( 'ABSPATH' ) )
	return;

if(!class_exists('Clinical_CDN_Replace') && class_exists( 'TitanFramework' ) )//only if class doesn't exist and Titan Framework (plugin) is activated
{
    if(!class_exists('Clinical_CDN_Replace')){
        class Clinical_CDN_Replace
        {
            public function __construct() {
                // add rewrite filters for plugin & theme assets
                add_filter( 'theme_root_uri', array( $this, 'replaceCDN' ), 99, 1 );
                add_filter( 'plugins_url', array( $this, 'replaceCDN' ), 99, 1 );
                // add rewrite filters for misc scripts and styles
                add_filter( 'script_loader_src', array( $this, 'replaceCDN' ), 99, 1 );
                add_filter( 'style_loader_src', array( $this, 'replaceCDN' ), 99, 1 );
            }

            public function replaceCDN( $url ) {
                $titan = TitanFramework::getInstance( 'clinical_cms' );
                $clinical_CDN_enable = $titan->getOption( 'clinical_CDN_enable' );
                $clinical_CDN_uri = trim($titan->getOption( 'clinical_CDN_uri' ));
                $ignores = $titan->getOption( 'clinical_CDN_ignores' );
                if($clinical_CDN_enable && is_array($ignores) && $clinical_CDN_uri !== '' && !is_admin()){
                    //echo 'ARRAY DUMP: '.var_dump($ignores) . '<br/>';
                    //check items to ignore
                    $tmpIgnoreVals = "";
                    while (list($vars, $vals) = each($ignores)) {
                        $tmpIgnoreVals .= ",".$vals.",";
                    }
                        if(strpos($tmpIgnoreVals, ",1,")!== false && 'theme_root_uri' === current_filter()){
                            //do replacements
                            //$url = str_replace( get_site_url(), $clinical_CDN_uri, $url );
                        }
                        else if (strpos($tmpIgnoreVals, ",2,")!== false && 'plugins_url' === current_filter()){
                            //do replacements
                            //$url = str_replace( get_site_url(), $clinical_CDN_uri, $url );
                        }
                        else if (strpos($tmpIgnoreVals, ",3,")!== false && 'script_loader_src' === current_filter()){
                            //do replacements
                           //$url = str_replace( get_site_url(), $clinical_CDN_uri, $url );
                        }
                        else if (strpos($tmpIgnoreVals, ",4,")!== false && 'style_loader_src' === current_filter()){
                            //do replacements
                            //$url = str_replace( get_site_url(), $clinical_CDN_uri, $url );
                        }
                        else{
                            //do replacements
                            $url = str_replace( get_site_url(), $clinical_CDN_uri, $url );
                        }
                }
                
                return $url;
            }
        } // END class Clinical_Replace_Core
    } // END if(!class_exists('Clinical_Replace_Core'))
}
if(class_exists('Clinical_CDN_Replace'))
{// instantiate the plugin class
    $clinical_CDN_replace = new Clinical_CDN_Replace();
}

?>