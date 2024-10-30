<?php
/* Loads core scripts from wordpress.com rather than locally
* speeds site up if site user has the files cached
*/
/* Prevent loading this file directly and/or if the class is already defined */
if ( ! defined( 'ABSPATH' ) )
	return;

if(class_exists('Clinical_CMS_Core'))//only if class doesn't exist and Titan Framework (plugin) is activated
{
    if(!class_exists('Clinical_Replace_Core')){
        class Clinical_Replace_Core
        {
            public function __construct() {
                add_filter( 'script_loader_src', array( $this, 'rewrite_core_files' ), 999, 2 );
                add_filter( 'style_loader_src', array( $this, 'rewrite_core_files' ), 999, 2 );
            }

            function rewrite_core_files( $src, $handle ) {
                $titan = TitanFramework::getInstance( 'clinical_cms' );
                $clinical_script_replace = $titan->getOption( 'clinical_swap_enable' );
								$extras = $titan->getOption( 'clinical_CDNJS_extra' );
                
                if( strpos( $src, 'wp-includes' ) && $clinical_script_replace == 2 ) {
                    //replace all WP Core scripts & styles
                    $src = str_replace( site_url(), 'https://s0.wp.com', $src );
                }
/*
				else if( (strpos( $src, 'wp-includes' ) && $handle == 'jquery-core') && $clinical_script_replace == 3 ) {
									//just load JQuery from Google CDN

									$jquery_version = wp_scripts()->registered['jquery']->ver;
									$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

									/*
									if($this->URL_exists('https://ajax.googleapis.com/ajax/libs/jquery/' . $jquery_version . '/jquery' . $suffix . '.js'))
									{
											//replace full JQuery URI with Google CDN version if exists
											$src = str_replace( $src, 'https://ajax.googleapis.com/ajax/libs/jquery/' . $jquery_version . '/jquery' . $suffix . '.js', $src );
									}
									* /

									if( get_option( 'clinical_cms_jquery_cdn' ) && !is_admin() ){
									//JQuery is available on CDN so load
										$tmp = 'https://ajax.googleapis.com/ajax/libs/jquery/' . $jquery_version . '/jquery' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, 'https://ajax.googleapis.com/ajax/libs/jquery/' . $jquery_version . '/jquery' . $suffix . '.js', $src );
										}
									}
              	}
								else if( strpos( $src, 'wp-includes' ) && !is_admin() && $clinical_script_replace == 4){
									//Test if debug mode
									$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
									
									if( $handle == 'jquery-core' ){
										//JQuery is available on CDNJS / cloudflare so load
										$jquery_version = wp_scripts()->registered['jquery']->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/' . $jquery_version . '/jquery' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
									else if( $handle == 'jquery-migrate' ){
										//JQuery is available on CDNJS / cloudflare so load
										$jquery_migrate = wp_scripts()->registered['jquery-migrate']->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/' . $jquery_migrate . '/jquery-migrate' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
									else if( $handle == 'jquery-ui' ){
										//JQuery is available on CDNJS / cloudflare so load
										$jqueryui = wp_scripts()->registered['jquery-ui']->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/' . $jqueryui . '/jquery-ui' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
								}
							else if( $extras && !is_admin() && $clinical_script_replace == 4){//convert additional scripts to CDNJS cloudflare
									if( $handle == 'tweenmax' ){
										//JQuery is available on CDNJS / cloudflare so load
										$tweenmax = wp_scripts()->registered['tweenmax']->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/gsap/' . $tweenmax . '/TweenMax' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
									else if( $handle == 'snap-svg' || $handle == 'snap.svg' || $handle == 'snapsvg' ){
										//JQuery is available on CDNJS / cloudflare so load
										$snap = wp_scripts()->registered[$handle]->ver;
										if ($suffix == '.min') {$suffix = '-min';}
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/snap.svg/' . $snap . '/snap.svg' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
									else if( $handle == 'isotope' || $handle == 'jquery-isotope' || $handle == 'jquery.isotope' || $handle == 'jqueryisotope' || $handle == 'lvca-isotope'){
										//JQuery is available on CDNJS / cloudflare so load
										$isotope = wp_scripts()->registered[$handle]->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/' . $isotope . '/isotope.pkgd' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
									else if( $handle == 'imagesloaded' || $handle == 'lvca-imagesloaded' ){
										//JQuery is available on CDNJS / cloudflare so load
										$imagesloaded = wp_scripts()->registered['imagesloaded']->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/' . $imagesloaded . '/imagesloaded' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
									else if( $handle == 'jquery-json' || $handle == 'jquery.json' || $handle == 'jqueryjson' ){
										//JQuery is available on CDNJS / cloudflare so load
										$jqueryjson = wp_scripts()->registered[$handle]->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-json/' . $jqueryjson . '/jquery.json' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
									else if( $handle == 'jquery-cookie' || $handle == 'jquery.cookie' || $handle == 'jquerycookie' ){
										//JQuery is available on CDNJS / cloudflare so load
										$jquerycookie = wp_scripts()->registered[$handle]->ver;
										$tmp = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/' . $jqueryjson . '/jquery.cookie' . $suffix . '.js';
										if($this->URL_exists($tmp)){
											$src = str_replace( $src, $tmp, $src );
										}
									}
				}
*/
                return $src;
            }
            
            public function URL_exists($url){
                $headers=get_headers($url);
                return stripos($headers[0],"200 OK")?true:false;
            }

        } // END class Clinical_Replace_Core
    } // END if(!class_exists('Clinical_Replace_Core'))
}
if(class_exists('Clinical_Replace_Core'))
{// instantiate the plugin class
    $clinical_replace_core = new Clinical_Replace_Core();
}

?>