<?php
/* 
* add some dashboard stats
*/
/* Prevent loading this file directly and/or if the class is already defined */
if ( ! defined( 'ABSPATH' ) )
	return;

//if(!class_exists('Clinical_CMS_Core') && class_exists( 'TitanFramework' ))//only if class doesn't exist and Titan Framework (plugin) is activated
//{
    //if(!class_exists('Clinical_Stats')){
        class Clinical_Stats
        {
            public function __construct() {
                //add_action('admin_head-index.php', array( $this, 'cc_add_JQuery_Script' ));
            }

            function cc_add_JQuery_Script(){
                wp_enqueue_script( 'CC-graphs', plugin_dir_url( __FILE__ ) . '../js/peity/jquery.peity.min.js', array('jquery'), '1.0.0', true );
                wp_enqueue_script( 'CC-graphsSet', plugin_dir_url( __FILE__ ) . '../js/drawGraphs.js', array('CC-graphs'), '1.0.0', true );
            }
            
            function cc_get_cmsVersion() {
                //$cmsData;
                /*
                switch(CC_Plan){
                    case "Premium+":
                        $cmsData['mods'] = "Premium+";
                        //$cmsData['disk'] = 10000;
                        break;
                    case "Pro":
                        $cmsData['mods'] = "Pro";
                        //$cmsData['disk'] = 2000;
                        break;
                    case "Basics":
                        $cmsData['mods'] = "Basics";
                        //$cmsData['disk'] = 1000;
                        break;
                    default:
                        //$cmsData['mods'] = "FREE";
                        $cmsData['mods'] = "Premium+";
                        //$cmsData['disk'] = 10000;
                        break;
                }
                */
                $cmsData['mods'] = "Pro";
                $cmsData['diskTotal'] = disk_total_space('/home');
                $cmsData['diskFree'] = disk_free_space('/home');
                return $cmsData;
            }
            
            /* Get User Quota Information
             *
             * Prepare and array with the user's account disk space information
             * by ascertaining the amount of space available on its quota,
             * the used space from that quota and free space remaining.
             *
             * @param string $user The system user name
             *
             * @return array
             */
            function getUserQuotaInfo($user) {
              $quota = exec("quota -u ".$user);            // query server
              $quota = preg_replace("/[\s-]+/", ' ', $quota); // clear spaces
              $arr = explode(' ', $quota);

              $freeSpace = $arr[3] - $arr[2];

              return array(
                "total" => $arr[3],
                "used"  => $arr[2],
                "free"  => $freeSpace
              );
            }
            
            function cc_get_memory() {
                $memory['memory_limit'] = ini_get( 'memory_limit' );
                $memory['memory_usage'] = function_exists( 'memory_get_usage' ) ? round( memory_get_usage(), 2 ) : 0;

                //memory percentage
                if ( !empty( $memory[ 'memory_usage' ] ) && !empty( $memory[ 'memory_limit' ] ) ) {
                    $memory['memory_percentage'] = round (( ( str_replace('MB','',$this->format_size( $memory[ 'memory_usage' ] ) ) / str_replace('M','',$memory[ 'memory_limit' ]) )) * 100, 0 );
                }
                $memory['memory_limit'] = str_replace('M','',$memory[ 'memory_limit' ]);
                $memory['memory_usage'] = str_replace('MB','',$this->format_size( $memory[ 'memory_usage' ] ) );
                $memory['memory_usage'] = str_replace(' ','',$memory['memory_usage']);
                return $memory;
            }

            // Create the function to output the contents of our Dashboard Widget
            function cc_get_dbsize(){

                global $wpdb;
                $dbname = $wpdb->dbname;

                // Get Database Size
                $result = $wpdb->get_results( 'SHOW TABLE STATUS', ARRAY_A );
                $rows = count( $result );
                $dbsize = 0;

                if ( $wpdb->num_rows > 0 ) {
                    foreach ( $result as $row ) {
                        $dbsize += $row[ "Data_length" ] + $row[ "Index_length" ];
                    }
                }

                return str_replace(' MB','',format_size( $dbsize ));
            }
            function cc_get_PHP(){
                $phpversion['OSBit'] = ( PHP_INT_SIZE * 8 );
                $phpversion['OS'] = php_uname('s');
                $phpversion['version'] = PHP_VERSION;
                return $phpversion;
            }

            function cc_get_fileSize(){

                // Setup Home Path for Later Usage
                if ( get_home_path() === "/" )
                    $homepath = ABSPATH;
                else
                    $homepath = get_home_path();

                $subfolder = strrpos( get_site_url(), '/', 8 ); // Starts after http:// or https:// to find the last slash

                // Determines if site is using a subfolder, such as /wp
                if ( isset( $subfolder ) && $subfolder != "" ) {
                    $remove = substr( get_site_url(), strrpos( get_site_url(), '/' ), strlen( get_site_url() ) );
                    $home = str_replace ( $remove, '', $homepath ); // Strips out subfolder to avoid duplicate folder in path
                } else {
                    $home = $homepath;
                }

                // Upload Directory
                $uploads = wp_upload_dir();

                $content = parse_url( content_url() );
                $content = $home . $content[ 'path' ];
                $plugins = str_replace( plugin_basename( __FILE__ ), '', __FILE__ );
                
                $total = disk_free_space("/");
                
                // WP Content and selected subfolders
                $contents = array(
                    "total" => $this->format_size($total / 100),
                    "wp-content" => $content,
                    "plugins" => $plugins,
                    "themes" => get_theme_root(),
                    "uploads" => $uploads[ 'basedir' ],
                );

                /*
                foreach ($contents as $name => $value) {

                    $name = __( $name, 'my-simple-space' ); // Make translatable
                    echo '<span class="spacedark">' . $name . '</span>: ' . format_size( foldersize( $value ) ) . '<br />';

                }
                */

                return $contents;
            }

            // Get Folder size function
            function foldersize( $path ) {

            // Check if size is cached
            //$total_size = wp_cache_get( $path );

            // Get size if not cached
            //if ( false === $total_size ) {

                if ( false === ( $total_size = get_transient( $path ) ) ) {

                $total_size = 0;
                $files = scandir( $path );
                $cleanPath = rtrim( $path, '/' ). '/';

                    foreach( $files as $t)  {
                        if ( $t<>"." && $t<>".." ) {
                            $currentFile = $cleanPath . $t;
                            $owner = fileowner($currentFile);
                            if ( $owner != 0 ) {
                                if ( is_dir( $currentFile ) ) {
                                    $size = foldersize( $currentFile );
                                    $total_size += $size;
                                }
                                else {
                                    $size = filesize( $currentFile );
                                    $total_size += $size;
                                }
                            }
                        }   
                    }

                //store value in transients
                set_transient( $path, $total_size, 1 * HOUR_IN_SECONDS );
                }

                return $total_size;
            }

            // Formatting the size function
            function format_size( $size ) {
                global $units;

                $units = explode( ' ', 'B KB MB GB TB PB' );
                $mod = 1024;

                for ( $i = 0; $size > $mod; $i++ ) {
                    $size /= $mod;
                }

                $endIndex = strpos( $size, "." ) + 3;
                $formattedSize = substr( $size, 0, $endIndex ) .' '. $units[$i];

                return $formattedSize;
            } 
            
            function formatBytes($bytes, $precision = 2) { 
                $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

                $bytes = max($bytes, 0); 
                $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
                $pow = min($pow, count($units) - 1); 

                // Uncomment one of the following alternatives
                 $bytes /= pow(1024, $pow);
                // $bytes /= (1 << (10 * $pow)); 

                return round($bytes, $precision) . ' ' . $units[$pow]; 
            } 
            
            function ConvertBytes($number)
            {
                $len = strlen($number);
                if($len < 4)
                {
                    return sprintf("%d b", $number);
                }
                if($len >= 4 && $len <=6)
                {
                    return sprintf("%0.2f Kb", $number/1024);
                }
                if($len >= 7 && $len <=9)
                {
                    return sprintf("%0.2f Mb", $number/1024/1024);
                }

                return sprintf("%0.2f Gb", $number/1024/1024/1024);

            }
        } // END class 
    //} // END
//}
/*
if(class_exists('Clinical_Stats'))
{// instantiate the plugin class
    $clinical_stats = new Clinical_Stats();
}
*/
?>
