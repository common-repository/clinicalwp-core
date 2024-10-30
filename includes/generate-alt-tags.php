<?php
/* Create alt tags on post/page update for images added to WP */
if ( ! defined( 'ABSPATH' ) )
	return;

if(/*class_exists( 'Clinical_CMS_Core_Plugin' ) && */ !class_exists('Clinical_Generate_Alts_Plugin') /* && class_exists( 'TitanFramework' )*/)//only if this class doesn't exist, but Clinical CMS exists and Titan Framework (plugin) is activated
{
    class Clinical_Generate_Alts_Plugin
    {
        /**
         * Construct the plugin object
         */
        public function __construct(){
            add_filter( 'wp_insert_post_data', array($this,'register_clinical_alt_scripts'), '99', 2 );
        }
        
        function register_clinical_alt_scripts( $data , $postarr ) {
            //print_r($data);
            
            //var_dump($data);
            
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $clinical_alt_enable = $titan->getOption( 'clinical_alt_enable' );

            if($clinical_alt_enable == true){
                $clinical_alt_tags = $titan->getOption( 'clinical_alt_tags' );
                
            
            if($data['post_content']){
                $doc=new DOMDocument();
                $doc->loadHTML($data['post_content']);
                $xml=simplexml_import_dom($doc); // just to make xpath more simple
                if($xml){

                    $images=$xml->xpath('//img');
                    
                    if( $images != false ){
                        $tmpData = $data['post_content'];

                        $imgAlts = array();
                        $i = 0;
                        foreach ($images as $img) {
                            $imgAlts[$i] = $img['alt'];
                            $i++;
                        } 

                            $result='';
                            foreach ($clinical_alt_tags as $option) {
                                switch ($option) {
                                    //case 'current'://existing alt tags
                                        //break;
                                    case 'post_title':
                                        $result .= $data['post_title'].'_';
                                        break;
                                    case 'site_title':
                                        $result .= get_bloginfo().'_';
                                        break;
                                    case 'category':
                                        $postCats = get_the_category( $postarr['ID'] );
                                        foreach ($postCats as $key) {
                                            $result .= $key->slug.'_';
                                        }
                                        break;
                                    case 'number':
                                        $result .= '%%%RANDOM%%%';
                                        break;
                                }   
                            }
                            foreach($imgAlts as $alt){
                                $tmpData = str_replace($alt, '"'.$result.'"', $tmpData);
                                $tmpData = str_replace('%%%RANDOM%%%', substr(md5(rand()), 0, 7).'_', $tmpData);
                            }
                            $data['post_content'] = $tmpData;
                        }
                    }
                }
            }
            return $data;
        }
    }
}
if(class_exists('Clinical_Generate_Alts_Plugin'))
{// instantiate the plugin class
    $clinical_generate_alts_plugin = new Clinical_Generate_Alts_Plugin();
}
?>