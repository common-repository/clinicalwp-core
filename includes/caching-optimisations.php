<?php
/* Prevent loading this file directly and/or if the class is already defined */
if ( ! defined( 'ABSPATH' ) )
	return;

if(/*class_exists( 'Clinical_CMS_Core_Plugin' ) && */ !class_exists('Clinical_Browser_Cache_Plugin') /* && class_exists( 'TitanFramework' )*/)//only if this class doesn't exist, but Clinical CMS exists and Titan Framework (plugin) is activated
{
    class Clinical_Browser_Cache_Plugin
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {/* hook up actions */
            add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_caching_configure'));
            add_action('init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_gzip_php'), 0);
        }
        
        
        function Clinical_caching_write_file( $file_path ){
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Browser Caching\n");
                    fwrite($fp, "<IfModule mod_expires.c>\n");
                    fwrite($fp, "ExpiresActive On \n");
                    fwrite($fp, "# Add correct content-type for fonts\n"); 
                    fwrite($fp, "AddType application/vnd.ms-fontobject .eot\n");
                    fwrite($fp, "AddType font/ttf .ttf\n");
                    fwrite($fp, "AddType font/otf .otf\n");
                    fwrite($fp, "AddType font/x-woff .woff\n");
                    fwrite($fp, "AddType image/svg+xml .svg\n");
                    fwrite($fp, "# Add a far future Expires header for fonts\n");
                    fwrite($fp, "ExpiresDefault \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType application/vnd.ms-fontobject \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType font/ttf \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType font/otf \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType font/x-woff \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType image/x-icon \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType image/gif \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType image/png \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType image/jpg \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType image/jpeg \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType text/css \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType application/javascript \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType application/x-javascript \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType text/javascript \"access plus 1 month\" \n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "# END Clinical CMS Browser Caching\n");
                    fflush($fp);
                    flock($fp, LOCK_UN, $wouldblock);    //unlock
                } else {
                    $status = false;
                }
                fclose($fp);
                $status = true;
            } else {
                $status = false;
            }
            return $status;
        }
        
        function Clinical_alt_caching_write_file( $file_path ){
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
					$date = new DateTime( date() );
					$date->add(new DateInterval('P1Y0M1DT0H0M0S'));
				    $expires = $date->format('D, M j G:i:s T Y');
                    fwrite($fp, "# START Clinical CMS Alt Caching\n");
                    fwrite($fp, "<FilesMatch \".(ico|jpg|jpeg|png|gif|js|css)$\"> \n");
                    //fwrite($fp, "Header set Expires \"Thu, 31 Dec 2020 23:59:59 GMT\" \n");
				    fwrite($fp, "Header set Expires \"" . $expires . "\" \n");
                    fwrite($fp, "Header set Cache-Control \"max-age=315360000\" \n");
                    fwrite($fp, "Header unset Pragma \n");
                    fwrite($fp, "</FilesMatch> \n");
                    fwrite($fp, "# END Clinical CMS Alt Caching\n");
                    fflush($fp);
                    flock($fp, LOCK_UN, $wouldblock);    //unlock
                } else {
                    $status = false;
                }
                fclose($fp);
                $status = true;
            } else {
                $status = false;
            }
            return $status;
        }
        
        function Clinical_modify_etag_write_file( $file_path ){
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Modify ETag\n");
                    fwrite($fp, "FileETag none \n");
                    fwrite($fp, "# END Clinical CMS Modify ETag\n");
                    fflush($fp);
                    flock($fp, LOCK_UN, $wouldblock);    //unlock
                } else {
                    $status = false;
                }
                fclose($fp);
                $status = true;
            } else {
                $status = false;
            }
            return $status;
        }
        
        function Clinical_modify_etag_alt_write_file( $file_path ){
            //removing the inode component of the ETag, resulting in an ETag that includes the file size and timestamp only
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Modify Alt ETag\n");
                    fwrite($fp, "FileETag MTime Size \n");
                    fwrite($fp, "# END Clinical CMS Modify Alt ETag\n");
                    fflush($fp);
                    flock($fp, LOCK_UN, $wouldblock);    //unlock
                } else {
                    $status = false;
                }
                fclose($fp);
                $status = true;
            } else {
                $status = false;
            }
            return $status;
        }
        
        function Clinical_enable_gzip_write_file( $file_path ){
            //enable gzip via .htaccess
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Enable GZip\n");
                    fwrite($fp, "<IfModule mod_deflate.c> \n");
                    fwrite($fp, "AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css application/javascript application/x-javascript application/x-httpd-php application/rss+xml application/atom_xml \n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "# END Clinical CMS Enable GZip\n");
                    fflush($fp);
                    flock($fp, LOCK_UN, $wouldblock);    //unlock
                } else {
                    $status = false;
                }
                fclose($fp);
                $status = true;
            } else {
                $status = false;
            }
            return $status;
        }
        
        static function Clinical_enable_gzip_php( ){
            //enable gzip via .htaccess
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $gzip = $titan->getOption( 'clinical_gzip_enable' );
            if($gzip == 2 && extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {
                ob_start('ob_gzhandler');
            }
        }
			
				function Clinical_debug_old_apache_write_file( $file_path ){//Apache lower than 2.4
							$status = true;
							$wouldblock = 1;
							if (is_writable($file_path)) {
									$fp = fopen($file_path, "a");
									if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
											fwrite($fp, "# START ClinicalWP Debug.log\n");
											fwrite($fp, "<FilesMatch \"debug.log\"> \n");
											fwrite($fp, "Order allow,deny\n");
											fwrite($fp, "Deny from all\n");
											fwrite($fp, "</FilesMatch> \n");
											fwrite($fp, "# END ClinicalWP Debug.log\n");
											fflush($fp);
											flock($fp, LOCK_UN, $wouldblock);    //unlock
									} else {
											$status = false;
									}
									fclose($fp);
									$status = true;
							} else {
									$status = false;
							}
						error_log("OLD CALLED");
							return $status;
					}
					function Clinical_debug_new_apache_write_file( $file_path ){//Apache 2.4 or greater
								$status = true;
								$wouldblock = 1;
								if (is_writable($file_path)) {
										$fp = fopen($file_path, "a");
										if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
												fwrite($fp, "# START ClinicalWP Debug.log\n");
												fwrite($fp, "<FilesMatch \"debug.log\"> \n");
												fwrite($fp, "Require all denied\n");
												fwrite($fp, "</FilesMatch> \n");
												fwrite($fp, "# END ClinicalWP Debug.log\n");
												fflush($fp);
												flock($fp, LOCK_UN, $wouldblock);    //unlock
										} else {
												$status = false;
										}
										fclose($fp);
										$status = true;
								} else {
										$status = false;
								}
						error_log("NEW CALLED");
								return $status;
						}
        
        static function Clinical_caching_configure() {
            //get options
            $titan = TitanFramework::getInstance( 'clinical_cms' );
            $browsercaching = $titan->getOption( 'clinical_browser_caching_enable' );
            $etags = $titan->getOption( 'clinical_ETag_enable' );
            $gzip = $titan->getOption( 'clinical_gzip_enable' );
						$debugProtection = $titan->getOption( 'clinical_debug_protection' );
					
						error_log("DEBUG: " . $debugProtection);
            //get htacess
            $tmphtaccess = file_get_contents(ABSPATH . '.htaccess');
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if($browsercaching == 1 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') === false)){
                //is set in option but htaccess values not set
                $backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if(file_exists(ABSPATH . '.htaccess')) {
                    if(!copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                    }
                    else{
                        $cbcp->Clinical_caching_write_file(ABSPATH . '.htaccess');
                    }
                } else {
                    $cbcp->Clinical_caching_write_file(ABSPATH . '.htaccess');
                }
            }
            else if($browsercaching != 1 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') !== false)){
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(1);
                
            }
            
            if($browsercaching == 2 && (strpos($tmphtaccess, 'START Clinical CMS Alt Caching') === false)){
                //is set in option but htaccess values not set
                //$status = true;
                $backup_filename = 'Clinical_alt_caching_install_backup' . time() . '.htaccess';
                if(file_exists(ABSPATH . '.htaccess')) {
                    if(!copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    }
                    else{
                        $cbcp->Clinical_alt_caching_write_file(ABSPATH . '.htaccess');
                    }
                } else {
                    $cbcp->Clinical_alt_caching_write_file(ABSPATH . '.htaccess');
                }
            }
            else if($browsercaching != 2 && (strpos($tmphtaccess, 'START Clinical CMS Alt Caching') !== false)){
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(2);
                
            }
            
            //no caching methods selected so check for artifacts and remove
            if($browsercaching == 3 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') !== false)){
                //is disabled in options so remove method 1
                $cbcp->Clinical_caching_uninstall(1);
            }
            if($browsercaching == 3 && (strpos($tmphtaccess, 'START Clinical CMS Alt Caching') !== false)){
                //is disabled in options so remove method 2
                $cbcp->Clinical_caching_uninstall(2);
            }
            
            //set ETag modification
            if($etags == 1 && (strpos($tmphtaccess, 'START Clinical CMS Modify ETag') === false)){
                //is set in option but htaccess values not set
                $backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if(file_exists(ABSPATH . '.htaccess')) {
                    if(!copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                    }
                    else{
                        $cbcp->Clinical_modify_etag_write_file(ABSPATH . '.htaccess');
                    }
                } else {
                    $cbcp->Clinical_modify_etag_write_file(ABSPATH . '.htaccess');
                }
            }
            else if($etags != 1 && (strpos($tmphtaccess, 'START Clinical CMS Modify ETag') !== false)){
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(3);
                
            }
            
            if($etags == 2 && (strpos($tmphtaccess, 'START Clinical CMS Modify Alt ETag') === false)){
                //is set in option but htaccess values not set
                $backup_filename = 'Clinical_alt_caching_install_backup' . time() . '.htaccess';
                if(file_exists(ABSPATH . '.htaccess')) {
                    if(!copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                    }
                    else{
                        $cbcp->Clinical_modify_etag_alt_write_file(ABSPATH . '.htaccess');
                    }
                } else {
                    $cbcp->Clinical_modify_etag_alt_write_file(ABSPATH . '.htaccess');
                }
            }
            else if($etags != 2 && (strpos($tmphtaccess, 'START Clinical CMS Modify Alt ETag') !== false)){
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(4);
                
            }
            
            //no caching methods selected so check for artifacts and remove
            if($etags == 3 && (strpos($tmphtaccess, 'START Clinical CMS Modify ETag') !== false)){
                //is disabled in options so remove method 1
                $cbcp->Clinical_caching_uninstall(3);
            }
            if($etags == 3 && (strpos($tmphtaccess, 'START Clinical CMS Modify Alt ETag') !== false)){
                //is disabled in options so remove method 2
                $cbcp->Clinical_caching_uninstall(4);
            }
            
            //set gzip compression
            if($gzip == 1 && (strpos($tmphtaccess, '# START Clinical CMS Enable GZip') === false)){
                //is set in option but htaccess values not set
                $backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if(file_exists(ABSPATH . '.htaccess')) {
                    if(!copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                    }
                    else{
                        $cbcp->Clinical_enable_gzip_write_file(ABSPATH . '.htaccess');
                    }
                } else {
                    $cbcp->Clinical_enable_gzip_write_file(ABSPATH . '.htaccess');
                }
            }
            else if($gzip != 1 && (strpos($tmphtaccess, '# START Clinical CMS Enable GZip') !== false)){
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(5);
                
            }
            /*
            if($gzip == 2){
                //$cbcp->Clinical_enable_gzip_php();
                /*** This is taken care of via the construct() add_action *** /
            }
            */
            //no caching methods selected so check for artifacts and remove
            if($gzip == 3 && (strpos($tmphtaccess, '# START Clinical CMS Enable GZip') !== false)){
                //is disabled in options so remove method 1
                $cbcp->Clinical_caching_uninstall(5);
            }
					
						//set Debug.log protection - prevent url based access.
            if($debugProtection == 2 && (strpos($tmphtaccess, 'START ClinicalWP Debug.log') === false)){
                //is set in option but htaccess values not set
                $backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if(file_exists(ABSPATH . '.htaccess')) {
                    if(!copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                    }
                    else{
                        $cbcp->Clinical_debug_old_apache_write_file(ABSPATH . '.htaccess');
                    }
                } else {
                    $cbcp->Clinical_debug_old_apache_write_file(ABSPATH . '.htaccess');
                }
							
						error_log("OLD METHOD");
            }
            else if($debugProtection == 3 && (strpos($tmphtaccess, 'START ClinicalWP Debug.log') === false)){
                //is set in option but htaccess values not set
                $backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if(file_exists(ABSPATH . '.htaccess')) {
                    if(!copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                    }
                    else{
                        $cbcp->Clinical_debug_new_apache_write_file(ABSPATH . '.htaccess');
                    }
                } else {
                    $cbcp->Clinical_debug_new_apache_write_file(ABSPATH . '.htaccess');
                }
						error_log("NEW CALLED");
            }
            else if( ($debugProtection == 1) && (strpos($tmphtaccess, 'START ClinicalWP Debug.log') !== false)){
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(6);
						error_log("UNINSTALL");
            }
            
        }



        public static function Clinical_caching_uninstall($method) {
            $backup_filename = 'Clinical_caching_uninstall_backup' . time() . '.htaccess';
            
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            $status = $cbcp->Clinical_caching_erase_file(true, $backup_filename, $method);
            return $status;
        }

        public static function Clinical_caching_erase_file($backup, $backup_filename, $method){

            $status = false;
            $wouldblock = 1;

            if($backup) {
                if(copy ( ABSPATH . '.htaccess' , ABSPATH . $backup_filename )) {
                    $status = true;
                } else {
                    $status = false;
                }
                if(!$status) {
                    return;
                }
            }
            if($status) {
                $fp = fopen(ABSPATH . '.htaccess', "w");
                $lines = file( ABSPATH . $backup_filename );

                if (flock($fp, LOCK_EX, $wouldblock)) {//lock the file
                    ftruncate($fp, 0); //truncate the file
                    $inLoop = false;
                    foreach($lines as $line) {
                        if($method == 1){
                            if(strpos($line, 'START Clinical CMS Browser Caching') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Browser Caching') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 2){
                            if(strpos($line, 'START Clinical CMS Alt Caching') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Alt Caching') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 3){
                            if(strpos($line, 'START Clinical CMS Modify ETag') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Modify ETag') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 4){
                            if(strpos($line, 'START Clinical CMS Modify Alt ETag') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Modify Alt ETag') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 5){
                            if(strpos($line, 'START Clinical CMS Enable GZip') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable GZip') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//debug.log protection
                        else if($method == 6){
                            if(strpos($line, 'START ClinicalWP Debug.log') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END ClinicalWP Debug.log') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                    }
                    flock($fp, LOCK_UN, $wouldblock); //unlock file
                } else {
                    $status = false;
                }
                fclose($fp);
            }
            return $status;
        }

    }
}

if(class_exists('Clinical_Browser_Cache_Plugin'))
{
    // instantiate the plugin class
    $clinical_browser_cache_plugin = new Clinical_Browser_Cache_Plugin();
}