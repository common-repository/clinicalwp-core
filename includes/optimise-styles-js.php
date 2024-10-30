<?php
/*
Modyfied and updated by Phill Healey @ CodeClinic.de on 01.08.2015
Original Author: Satya Prakash
Original Author URI: http://www.satya-weblog.com/
License: Copyright 2010  Satya Prakash  (email : ws@satya-weblog.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/* Prevent loading this file directly and/or if the class is already defined */
if ( ! defined( 'ABSPATH' ) )
	return;

if(!class_exists('Clinical_Script_Optimiser_Plugin'))
{
    class Clinical_Script_Optimiser_Plugin
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {   
            add_action( 'get_header', array($this, 'orderStyleJS') );
            //add_action( 'wp_head', array($this, 'orderStyleJS') ); 
            //add_action( 'wp_footer', array($this, 'orderStyleJS') );
        }
        
        /*
        * Collect all external js
        */

        public function orderStyleJS($pos) {
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $cs_enable = $titan->getOption( 'clinical_scripts_enable' );
            $cs_inline = $titan->getOption( 'clinical_scripts_defer_inline');
            if($cs_enable==true || $cs_inline==true){
                //enable/disable the script
                static $ct = 0;
                $ct++;

                if ($ct == 1) ob_start(array($this,'outputStyleScriptPlusOtherMeta'));
                //ob_implicit_flush();
                //ob_end_flush();
                ob_flush();

                if ($ct > 1 ) ob_end_flush();
            }
            
        }

        function jsCodeExternal($strJs) {
            //need defer or async?
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $scriptsdefer = $titan->getOption( 'clinical_scripts_defer' );
            
            preg_match_all('/src\s?=\s?([\'|"])(.*)\1/isU',  $strJs, $headerJs2);
            $str = '';
            $tmpDefer = '';
            foreach ($headerJs2[2] as $val)
            {
                if($scriptsdefer == 1 || $scriptsdefer == 2 ){
                    if (is_admin()){
                        $tmpDefer = '';
                    }
                    else if (strpos($val, '/wp-includes/js/jquery/jquery')) {
                        $tmpDefer = '';
                    }
                    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.') !==false) {
                        $tmpDefer = '';
                    }
                    else if($scriptsdefer == 1) {
                        $tmpDefer = 'defer';
                    }
                    else if($scriptsdefer == 2) {
                        $tmpDefer = 'async';
                    }
                }
                else { //return $str; 
                }
                $str .= '<script '.$tmpDefer.' src="'.$val.'" type="text/javascript"></script>' . "\n";
            }

            return $str;
        }

        /*
        * Collect all inline js
        */
        function jsCodeInline($strJs, $cs_inline) {
            
            $inlineJs = '';
            foreach ($strJs as $val)
            {
               if (! empty($val))
               {
                   $inlineJs .= trim($val) . "\n";
               }
            }

            if ($inlineJs != '') {

                $inlineJs = '<script type="text/javascript">' . "\n" . 
                                $inlineJs . "\n" .
                            '</script>';
            }

            return $inlineJs;
        }

        // Grab CSS and JS content and output in order
        function outputStyleScriptPlusOtherMeta($headSection) {
            
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $cs_enable = $titan->getOption( 'clinical_scripts_enable' );
            $cs_inline = $titan->getOption( 'clinical_scripts_defer_inline');
            
                $tmpStr = "";
                $str = "";
            
            if($cs_enable==true){

                // catch external css out for adding later
                preg_match_all('@<link+.*(?=(?:type=[\'|"]text/css[\'|"]))(.*?)(?:/>){1,1}@iU', $headSection, $headCSS);
                $headSection = preg_replace('@<link+.*(?=(?:type=[\'|"]text/css[\'|"]))(.*?)(?:/>){1,1}@iU', '', $headSection);

                // catch Scripts out for adding later
                preg_match_all('/<script(.*)>(.*)<\/script>/isU', $headSection, $headJS);
                $headSection = preg_replace('@<script(.*)>(.*)<\/script>@isU', '', $headSection);

                // remove extra newline
                $headSection = preg_replace('@(\r\n|\r|\n){2,}@im' , "\n", $headSection);

                $headSection = str_replace('<head>' , "<head>%%%HEAD-START%%%", $headSection);
                $headSection = str_replace('</head>' , "%%%HEAD-END%%%</head>", $headSection);

                $cssCode = '';
                foreach ($headCSS[0] as $val)
                {
                   $cssCode .= $val . "\n";
                }

                //$tmpStr .= '<!-- START Order style js plugin -->';

                $tmpStr .= '<br/><!-- START CSS -->';
                $tmpStr .= $cssCode; // output CSS
                $tmpStr .= '<!-- END CSS --></br>';

                //$str .= '<!-- START STUFF -->';
                $str .= $headSection;  // Output Other data minus css and js
                //$str .= '<!-- END STUFF -->';

                $str = str_replace('%%%HEAD-START%%%' , $tmpStr, $str);

                $tmpStr .= '<br/><!-- START EXTERNAL JS -->';
                $tmpStr .= $this->jsCodeExternal(implode("\n", $headJS[1])); // Output: external Js
                $tmpStr .= '<!-- END EXTERNAL JS --><br/>';

                $tmpStr .= '<br/><!-- START INLINE JS -->';
                $tmpStr .= $this->jsCodeInline($headJS[2], $cs_inline); // Output: inline Js
                $tmpStr .= '<!-- END INLINE JS --><br/>';

                $str = str_replace('%%%HEAD-END%%%' , $tmpStr, $str);

                //$str .= '<!-- END Order style js plugin -->';

                return $str;
            }
            if($cs_inline==true){ //this only fires if we want inline defer/async but Scripts & Style optimisation is disabled
                
                $titan = TitanFramework::getInstance( 'clinical_cms' );
                $deferasync = $titan->getOption( 'clinical_scripts_defer' );
                if($deferasync == 1) {
                    $jsload = "defer";
                }
                else if($deferasync == 2) {
                    $jsload = "async";
                }
                $headSection = str_replace('<script type="text/javascript">' , '<script type="text/javascript/' . $jsload . '">', $headSection);
                $headSection = str_replace("<script type='text/javascript'>" , '<script type="text/javascript/' . $jsload . '">', $headSection);
                $headSection = str_replace('<script>' , '<script type="text/javascript/' . $jsload . '">', $headSection);
                $headSection = str_replace('<iframe' , '<iframe ' . $jsload, $headSection);
                
                // remove extra newline
                $headSection = preg_replace('@(\r\n|\r|\n){2,}@im' , "\n", $headSection);
                
                $str .= $headSection;  // Output Other data minus css and js

                return $str;
            }
        }
        
    } // END class Clinical_Script_Optimiser_Plugin
} // END if(!class_exists('Clinical_Script_Optimiser_Plugin'))

if(class_exists('Clinical_Script_Optimiser_Plugin'))
{// instantiate the plugin class
    $clinical_script_optimiser_plugin = new Clinical_Script_Optimiser_Plugin();
}

?>