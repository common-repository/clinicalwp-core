<?php
/* Prevent loading this file directly and/or if the class is already defined */
if (!defined('ABSPATH'))
    return;

if (/*class_exists( 'Clinical_CMS_Core_Plugin' ) && */ !class_exists('Clinical_Browser_Cache_Plugin') /* && class_exists( 'TitanFramework' )*/ )//only if this class doesn't exist, but Clinical CMS exists and Titan Framework (plugin) is activated
{
    class Clinical_Browser_Cache_Plugin
    { 
        /**
         * Construct the plugin object
         */
        public function __construct()
        {/* hook up actions */
            //performs the full activation after the activation
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_caching_configure'));
            //adds the notice(s) to admin
            //add_action('admin_notices', array('Clinical_Browser_Cache_Plugin', 'my_plugin_admin_notices'));
            add_action('init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_gzip_php'), 0);
            //do the optimisations in 'housekeeping' section
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_WP_POST_REVISIONS'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_WP_MEMORY_LIMIT'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_WP_MAX_MEMORY_LIMIT'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_EMPTY_TRASH_DAYS'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_DISALLOW_FILE_EDIT'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_DISALLOW_FILE_MODS'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_AUTOSAVE_INTERVAL'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_IMAGE_EDITOR'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_AUTO_UPDATES'), 0);
            //add_action('admin_init', array('Clinical_Browser_Cache_Plugin', 'Clinical_enable_SSL_ADMIN'), 0);
        }


        function Clinical_caching_write_file($file_path)
        {
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Browser Caching\n");
                    fwrite($fp, "<IfModule mod_expires.c>\n");
                    fwrite($fp, "ExpiresActive On \n");
                    #fwrite($fp, "# Add correct content-type for fonts\n"); 
                    fwrite($fp, "AddType application/vnd.ms-fontobject .eot\n");
                    fwrite($fp, "AddType font/ttf .ttf\n");
                    fwrite($fp, "AddType font/otf .otf\n");
                    fwrite($fp, "AddType font/x-woff .woff\n");
                    fwrite($fp, "AddType image/svg+xml .svg\n");
                    //fwrite($fp, "# Add Proper MIME-Type for Favicon\"\n");
                    fwrite($fp, "AddType image/x-icon .ico\n");
                    //fwrite($fp, # Add the expires declarations\n");
                    fwrite($fp, "ExpiresDefault \"access plus 1 week\" \n");
                    #fwrite($fp, "# Add a far future Expires header for fonts\n");
                    fwrite($fp, "ExpiresByType application/vnd.ms-fontobject \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType font/ttf \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType font/otf \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType font/x-woff \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType application/font-woff \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType application/x-font-ttf \"access plus 1 month\"\n");
                    fwrite($fp, "ExpiresByType font/opentype \"access plus 1 month\"\n");
                    #fwrite($fp, "# Images\" \n");
                    fwrite($fp, "ExpiresByType image/gif \"access plus 1 year\" \n");
                    fwrite($fp, "ExpiresByType image/png \"access plus 1 year\" \n");
                    fwrite($fp, "ExpiresByType image/jpg \"access plus 1 year\" \n");
                    fwrite($fp, "ExpiresByType image/jpeg \"access plus 1 year\" \n");
                    fwrite($fp, "ExpiresByType image/webp \"access plus 1 year\" \n");
                    fwrite($fp, "ExpiresByType image/svg+xml \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType image/x-icon \"access plus 1 year\" \n");
                    //fwrite($fp, "ExpiresByType image/ico \"access plus 1 month\" \n");
                    #fwrite($fp, "# Html JS CSS\" \n");
                    fwrite($fp, "ExpiresByType text/html \"access plus 1 minute\" \n");
                    fwrite($fp, "ExpiresByType text/css \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType text/plain \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType application/javascript \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType application/x-javascript \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType text/javascript \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType text/x-javascript \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType text/x-component \"access plus 1 month\" \n");
                    #fwrite($fp, "# Others\" \n");
                    fwrite($fp, "ExpiresByType application/x-shockwave-flash \"access 1 month\" \n");
                    fwrite($fp, "ExpiresByType application/pdf \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType application/json \"access plus 0 seconds\" \n");
                    fwrite($fp, "ExpiresByType application/ld+json \"access plus 0 seconds\" \n");
                    fwrite($fp, "ExpiresByType application/xml \"access plus 0 seconds\" \n");
                    fwrite($fp, "ExpiresByType text/xml \"access plus 0 seconds\" \n");
                    fwrite($fp, "ExpiresByType application/atom+xml \"access plus 1 hour\" \n");
                    fwrite($fp, "ExpiresByType application/rss+xml \"access plus 1 hour\" \n");
                    #fwrite($fp, "# Manifest\" \n");
                    fwrite($fp, "ExpiresByType application/x-web-app-manifest+json \"access plus 0 seconds\" \n");
                    fwrite($fp, "ExpiresByType text/cache-manifest \"access plus 0 seconds\" \n");
                    #fwrite($fp, "# Audio\" \n");
                    fwrite($fp, "ExpiresByType audio/ogg \"access plus 1 month\" \n");
                    #fwrite($fp, "# Video\" \n");
                    fwrite($fp, "ExpiresByType video/mp4 \"access plus 1 year\" \n");
                    fwrite($fp, "ExpiresByType video/mpeg \"access plus 1 year\" \n");
                    fwrite($fp, "ExpiresByType video/ogg \"access plus 1 month\" \n");
                    fwrite($fp, "ExpiresByType video/webm \"access plus 1 month\" \n");
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

        function Clinical_alt_caching_write_file($file_path)
        {
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
					#$date = new DateTime( date() );
					#$date->add(new DateInterval('P0Y1M1DT0H0M0S'));
					#$month = $date->format('D, d M Y H:i:s CET');
					#$date->add(new DateInterval('P0Y11M1DT0H0M0S'));
					#$year = $date->format('D, d M Y H:i:s CET');

                    fwrite($fp, "# START Clinical CMS Alt Caching\n");
                    fwrite($fp, "<IfModule mod_headers.c>\n");
                    #fwrite($fp, "# One month for css and js\n");
                    fwrite($fp, "<filesMatch \".(css|js|pdf|flv|swf|html|htm|txt)$\">\n");
                    fwrite($fp, "Header set Cache-Control \"max-age=2628000, public\" \n");
                    fwrite($fp, "</filesMatch>\n");
                    #fwrite($fp, "# One year for image files\n");
                    fwrite($fp, "<FilesMatch \".(ico|jpg|jpeg|png|gif)$\"> \n");
                    #fwrite($fp, "Header set Expires \"Thu, 31 Dec 2020 23:59:59 GMT\" \n");
                    #fwrite($fp, "Header set Expires \"" . $year . "\" \n");
                    fwrite($fp, "Header set Cache-Control \"max-age=31536000, public\" \n");
                    ##fwrite($fp, "Header unset Pragma \n");
                    fwrite($fp, "</FilesMatch> \n");
                    fwrite($fp, "</IfModule> \n");
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

        function Clinical_modify_etag_write_file($file_path)
        {
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Modify ETag\n");
                    fwrite($fp, "<IfModule mod_expires.c>\n");
                    fwrite($fp, "<IfModule mod_headers.c>\n");
                    fwrite($fp, "Header unset Etag \n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "FileETag none \n");
                    fwrite($fp, "</IfModule> \n");
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

        function Clinical_modify_etag_alt_write_file($file_path)
        {
            //removing the inode component of the ETag, resulting in an ETag that includes the file size and timestamp only
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Modify Alt ETag\n");
                    fwrite($fp, "<IfModule mod_headers.c>\n");
                    fwrite($fp, "FileETag MTime Size \n");
                    fwrite($fp, "</IfModule> \n");
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

        function Clinical_enable_gzip_write_file($file_path)
        {
            //enable gzip via .htaccess
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START Clinical CMS Enable GZip\n");
                    fwrite($fp, "<IfModule mod_deflate.c> \n");
                    fwrite($fp, "AddOutputFilterByType DEFLATE text/plain text/javascript text/html text/xml text/css text/vtt text/x-component application/xml application/xhtml+xml application/rss+xml  application/js application/javascript application/x-javascript application/x-httpd-php application/x-httpd-fastphp application/atom+xml application/json application/ld+json application/vnd.ms-fontobject application/x-font-ttf application/x-web-app-manifest+json font/opentype image/svg+xml image/x-icon \n");
                    #fwrite($fp, "# Exception: Images \n");
                    fwrite($fp, "SetEnvIfNoCase REQUEST_URI \.(?:gif|jpg|jpeg|png)$ no-gzip dont-vary \n");
                    #fwrite($fp, "# Drop problematic browsers \n");
                    fwrite($fp, "BrowserMatch ^Mozilla/4 gzip-only-text/html \n");
                    fwrite($fp, "BrowserMatch ^Mozilla/4\.0[678] no-gzip \n");
                    fwrite($fp, "BrowserMatch \bMSI[E] !no-gzip !gzip-only-text/html \n");
                    #fwrite($fp, "# Make sure proxies don't deliver the wrong content \n");
                    fwrite($fp, "<IfModule mod_headers.c> \n");
                    fwrite($fp, "Header append Vary User-Agent env=!dont-vary \n");
                    fwrite($fp, "</IfModule> \n");
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

        /* static */ function Clinical_enable_gzip_php()
        {
            //enable gzip via .htaccess
            $titan = TitanFramework::getInstance('clinical_cms');
            $gzip = $titan->getOption('clinical_gzip_enable');
            if ($gzip == 2 && extension_loaded("zlib") && (ini_get("output_handler") != "ob_gzhandler")) {
                ob_start('ob_gzhandler');
            }
        }

        function Clinical_enable_maintenance_write_file($file_path)
        {
            //enable maintenance mode in wp-config
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "\n# START Clinical CMS Enable Maintenance\n");
                    fwrite($fp, "define('WP_ALLOW_REPAIR', true); \n");
                    fwrite($fp, "# END Clinical CMS Enable Maintenance\n");
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

        function Clinical_debug_apache_write_file($file_path)
        {//Apache 2.4 or greater
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP Debug.log\n");
                    fwrite($fp, "<FilesMatch \"debug.log\"> \n");
                    fwrite($fp, "# APACHE 2.2 \n");
                    fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                    fwrite($fp, "Order allow,deny\n");
                    fwrite($fp, "Deny from all\n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "# APACHE 2.4 \n");
                    fwrite($fp, "<IfModule mod_authz_core.c> \n");
                    fwrite($fp, "Require all denied\n");
                    fwrite($fp, "</IfModule> \n");
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
            return $status;
        }

        function Clinical_security_XMLRPC_write_file($file_path)
        {//Apache
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP XMLRPC\n");
                    fwrite($fp, "<Files xmlrpc.php>\n");
                    fwrite($fp, "# APACHE 2.2 \n");
                    fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                    fwrite($fp, "Order allow,deny\n");
                    fwrite($fp, "Deny from all\n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "# APACHE 2.4 \n");
                    fwrite($fp, "<IfModule mod_authz_core.c> \n");
                    fwrite($fp, "Require all denied\n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "</Files> \n");
                    fwrite($fp, "# END ClinicalWP XMLRPC\n");
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

        function Clinical_keep_alive_write_file($file_path)
        {//keep alive command
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP KeepAlive\n");
                    fwrite($fp, "<IfModule mod_headers.c>\n");
                    fwrite($fp, "Header set Connection keep-alive\n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "# END ClinicalWP KeepAlive\n");
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

        function Clinical_disable_readme_write_file($file_path)
        {//Apache - hide readme
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP Readme\n");
                    fwrite($fp, "<Files readme.html>\n");
                    fwrite($fp, "# APACHE 2.2 \n");
                    fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                    fwrite($fp, "Order allow,deny\n");
                    fwrite($fp, "Deny from all\n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "# APACHE 2.4 \n");
                    fwrite($fp, "<IfModule mod_authz_core.c> \n");
                    fwrite($fp, "Require all denied\n");
                    fwrite($fp, "</IfModule> \n");
                    fwrite($fp, "</Files> \n");
                    fwrite($fp, "# END ClinicalWP Readme\n");
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

        function Clinical_disable_indexes_write_file($file_path)
        {//Apache - hide directory indexes
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP Indexes\n");
                    fwrite($fp, "Options -Indexes\n");
                    fwrite($fp, "# END ClinicalWP Indexes\n");
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

        function Clinical_disable_includes_write_file($file_path)
        {//Apache - hide wp-includes directory
            $status = true;
            $wouldblock = 1;
            //if (is_writable($file_path)) {
            $fp = fopen($file_path, "a");
            if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                fwrite($fp, "# START ClinicalWP Includes\n");
                fwrite($fp, "<FilesMatch \"\.(?i:php)$\">\n");
                fwrite($fp, "# APACHE 2.2 \n");
                fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                fwrite($fp, "Order allow,deny\n");
                fwrite($fp, "Deny from all\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "# APACHE 2.4 \n");
                fwrite($fp, "<IfModule mod_authz_core.c> \n");
                fwrite($fp, "Require all denied\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "</FilesMatch> \n");
                fwrite($fp, "<Files wp-tinymce.php>\n");
                fwrite($fp, "# APACHE 2.2 \n");
                fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                fwrite($fp, "Allow from all\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "# APACHE 2.4 \n");
                fwrite($fp, "<IfModule mod_authz_core.c> \n");
                fwrite($fp, "Require all granted\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "</Files> \n");
                fwrite($fp, "<Files ms-files.php>\n");
                fwrite($fp, "# APACHE 2.2 \n");
                fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                fwrite($fp, "Allow from all\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "# APACHE 2.4 \n");
                fwrite($fp, "<IfModule mod_authz_core.c> \n");
                fwrite($fp, "Require all granted\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "</Files> \n");
                fwrite($fp, "# END ClinicalWP Includes\n");
                fflush($fp);
                flock($fp, LOCK_UN, $wouldblock);    //unlock
            } else {
                $status = false;
            }
            fclose($fp);
            $status = true;
            //} else {
            //   $status = false;
            //}
            return $status;
        }

        function Clinical_disable_content_write_file($file_path)
        {//Apache - hide wp-includes directory
            $status = true;
            $wouldblock = 1;
            //if (is_writable($file_path)) {
            $fp = fopen($file_path, "a");
            if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                fwrite($fp, "# START ClinicalWP Content\n");
                fwrite($fp, "<FilesMatch \"\.(?i:php)$\">\n");
                fwrite($fp, "# APACHE 2.2 \n");
                fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                fwrite($fp, "Order allow,deny\n");
                fwrite($fp, "Deny from all\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "# APACHE 2.4 \n");
                fwrite($fp, "<IfModule mod_authz_core.c> \n");
                fwrite($fp, "Require all denied\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "</FilesMatch> \n");
                fwrite($fp, "# END ClinicalWP Content\n");
                fflush($fp);
                flock($fp, LOCK_UN, $wouldblock);    //unlock
            } else {
                $status = false;
            }
            fclose($fp);
            $status = true;
            //} else {
            //   $status = false;
            //}
            return $status;
        }

        function Clinical_disable_uploads_write_file($file_path)
        {//Apache - hide wp-includes directory
            $status = true;
            $wouldblock = 1;
            //if (is_writable($file_path)) {
            $fp = fopen($file_path, "a");
            if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                fwrite($fp, "# START ClinicalWP Uploads\n");
                fwrite($fp, "<FilesMatch \"\.(?i:php)$\">\n");
                fwrite($fp, "# APACHE 2.2 \n");
                fwrite($fp, "<IfModule !mod_authz_core.c> \n");
                fwrite($fp, "Order allow,deny\n");
                fwrite($fp, "Deny from all\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "# APACHE 2.4 \n");
                fwrite($fp, "<IfModule mod_authz_core.c> \n");
                fwrite($fp, "Require all denied\n");
                fwrite($fp, "</IfModule> \n");
                fwrite($fp, "</FilesMatch> \n");
                fwrite($fp, "# END ClinicalWP Uploads\n");
                fflush($fp);
                flock($fp, LOCK_UN, $wouldblock);    //unlock
            } else {
                $status = false;
            }
            fclose($fp);
            $status = true;
            //} else {
            //   $status = false;
            //}
            return $status;
        }

        function Clinical_disable_jacking_write_file($file_path)
        {//Apache - prevent click jacking
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP Jacking\n");
                    fwrite($fp, "<IfModule mod_headers.c>\n");
                    fwrite($fp, "Header always append X-Frame-Options SAMEORIGIN\n");
                    fwrite($fp, "</IfModule>\n");
                    fwrite($fp, "# END ClinicalWP Jacking\n");
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

        function Clinical_disable_xss_write_file($file_path)
        {//Apache - prevent XSS
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP XSS\n");
                    fwrite($fp, "<IfModule mod_headers.c>\n");
                    fwrite($fp, "Header set X-XSS-Protection \"1; mode=block\"\n");
                    fwrite($fp, "</IfModule>\n");
                    fwrite($fp, "# END ClinicalWP XSS\n");
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

        function Clinical_disable_trace_write_file($file_path)
        {//Apache - prevent trace
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP Trace\n");
                    fwrite($fp, "<IfModule mod_rewrite.c>\n");
                    fwrite($fp, "RewriteEngine On\n");
                    fwrite($fp, "RewriteCond %{REQUEST_METHOD} ^TRACE\n");
                    fwrite($fp, "RewriteRule .* - [F]\n");
                    fwrite($fp, "</IfModule>\n");
                    fwrite($fp, "# END ClinicalWP Trace\n");
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

        function Clinical_disable_sniff_write_file($file_path)
        {//Apache - prevent trace
            $status = true;
            $wouldblock = 1;
            if (is_writable($file_path)) {
                $fp = fopen($file_path, "a");
                if (flock($fp, LOCK_EX, $wouldblock)) {  //get file lock
                    fwrite($fp, "# START ClinicalWP NoSniff\n");
                    fwrite($fp, "<IfModule mod_headers.c>\n");
                    fwrite($fp, "Header set X-Content-Type-Options nosniff\n");
                    fwrite($fp, "</IfModule>\n");
                    fwrite($fp, "# END ClinicalWP NoSniff\n");
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

        /* static */ function Clinical_enable_WP_POST_REVISIONS()
        {
            //enable WP_POST_REVISIONS in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $revisions = $titan->getOption('clinical_revision_limit');
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            //echo 'CLIN REVS: ' . $revisions . ' / WP REVS: ' . WP_POST_REVISIONS;
            $tmpWP_POST_REVS;
            if (WP_POST_REVISIONS === true) {
                $tmpWP_POST_REVS = 'true';
            } else if (WP_POST_REVISIONS === false) {
                $tmpWP_POST_REVS = 'false';
            } else {
                $tmpWP_POST_REVS = WP_POST_REVISIONS;
            }

            if ($tmpWP_POST_REVS != $revisions) {
                $cbcp->removeWPConfigs("# START Clinical CMS WP_POST_REVISIONS\n", "# END Clinical CMS WP_POST_REVISIONS\n", "define('WP_POST_REVISIONS', " . $tmpWP_POST_REVS . ");\n");
                //add new revisions value
                $cbcp->addWPConfigs("# START Clinical CMS WP_POST_REVISIONS\n", "define('WP_POST_REVISIONS', " . $revisions . ");\n", "# END Clinical CMS WP_POST_REVISIONS\n");
                
                //echo 'CONFIG WRITE: revisions1 <br/>';
            }
            /*
            else if(WP_POST_REVISIONS == false || WP_POST_REVISIONS == true ){
                $cbcp->removeWPConfigs("# START Clinical CMS WP_POST_REVISIONS\n", "# END Clinical CMS WP_POST_REVISIONS\n", "define('WP_POST_REVISIONS', " . WP_POST_REVISIONS . ");\n");
                
                //add new revisions value
                $cbcp->addWPConfigs("# START Clinical CMS WP_POST_REVISIONS\n", "define('WP_POST_REVISIONS', " . $revisions . ");\n", "# END Clinical CMS WP_POST_REVISIONS\n");

                echo 'CONFIG WRITE: revisions2 <br/>';
            }
             */
            //echo 'CLIN REVS: ' . $revisions . ' / WP REVS: ' . WP_POST_REVISIONS;
        }

        function Clinical_enable_WP_MEMORY_LIMIT()
        {
            //enable WP_MEMORY_LIMIT in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $memory = $titan->getOption('clinical_memory_limit');
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if (/*defined('WP_MEMORY_LIMIT') && */ WP_MEMORY_LIMIT != $memory . "M") {
                $cbcp->removeWPConfigs("# START Clinical CMS WP_MEMORY_LIMIT\n", "# END Clinical CMS WP_MEMORY_LIMIT\n", "define('WP_MEMORY_LIMIT', '" . WP_MEMORY_LIMIT . "');\n");
                $cbcp->addWPConfigs("# START Clinical CMS WP_MEMORY_LIMIT\n", "define('WP_MEMORY_LIMIT', '" . $memory . "M');\n", "# END Clinical CMS WP_MEMORY_LIMIT\n");

                //echo 'CONFIG WRITE: mem_limit <br/>';
            }
            /*
            if(!defined('WP_MEMORY_LIMIT')){
                echo '<br/>MEMORY: ' . WP_MEMORY_LIMIT;
                $cbcp->addWPConfigs("# START Clinical CMS WP_MEMORY_LIMIT\n", "define('WP_MEMORY_LIMIT', " . $memory . "); \n", "# END Clinical CMS WP_MEMORY_LIMIT\n");
            }
             */
        }

        /* static */ function Clinical_enable_WP_MAX_MEMORY_LIMIT()
        {
            //enable WP_MAX_MEMORY_LIMIT in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $maxMemory = $titan->getOption('clinical_admin_memory_limit');
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if (WP_MAX_MEMORY_LIMIT != $maxMemory . "M") {
                $cbcp->removeWPConfigs("# START Clinical CMS WP_MAX_MEMORY_LIMIT\n", "# END Clinical CMS WP_MAX_MEMORY_LIMIT\n", "define('WP_MAX_MEMORY_LIMIT', '" . WP_MAX_MEMORY_LIMIT . "');\n");
                //add new max memory limit
                $cbcp->addWPConfigs("# START Clinical CMS WP_MAX_MEMORY_LIMIT\n", "define('WP_MAX_MEMORY_LIMIT', '" . $maxMemory . "M');\n", "# END Clinical CMS WP_MAX_MEMORY_LIMIT\n");

                //echo 'CONFIG WRITE: max_mem_limit <br/>';
            }
        }

        /* static */ function Clinical_enable_EMPTY_TRASH_DAYS()
        {
            //enable EMPTY_TRASH_DAYS in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $trash = $titan->getOption('clinical_trash_days');
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if (EMPTY_TRASH_DAYS != $trash) {
                $cbcp->removeWPConfigs("# START Clinical CMS EMPTY_TRASH_DAYS\n", "# END Clinical CMS EMPTY_TRASH_DAYS\n", "define('EMPTY_TRASH_DAYS', " . EMPTY_TRASH_DAYS . "); \n");
                //add new trash days
                $cbcp->addWPConfigs("# START Clinical CMS EMPTY_TRASH_DAYS\n", "define('EMPTY_TRASH_DAYS', " . $trash . "); \n", "# END Clinical CMS EMPTY_TRASH_DAYS\n");

                //echo 'CONFIG WRITE: empty_trash_days <br/>';
            }
        }

        /* static */ function Clinical_enable_DISALLOW_FILE_EDIT()
        {
            //enable DISALLOW_FILE_EDIT in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $disallowFileEdit = $titan->getOption('clinical_filesplugins_editor');
            $tmp = '';
            //get instance of class
            if ($disallowFileEdit == true) {
                $tmp = 'true';
            } else {
                $disallowFileEdit = 0;
                $tmp = 'false';
            }
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if (defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT != $disallowFileEdit) {
                $status = DISALLOW_FILE_EDIT ? "true" : "false";
                $cbcp->removeWPConfigs("# START Clinical CMS DISALLOW_FILE_EDIT\n", "# END Clinical CMS DISALLOW_FILE_EDIT\n", "define('DISALLOW_FILE_EDIT', " . $status . ");\n");
                //add new value
                $cbcp->addWPConfigs("# START Clinical CMS DISALLOW_FILE_EDIT\n", "define('DISALLOW_FILE_EDIT', " . $tmp . ");\n", "# END Clinical CMS DISALLOW_FILE_EDIT\n");

                //echo 'CONFIG WRITE: file_edits <br/>';
            }
            if (!defined('DISALLOW_FILE_EDIT')) {
                $cbcp->addWPConfigs("# START Clinical CMS DISALLOW_FILE_EDIT\n", "define('DISALLOW_FILE_EDIT', " . $tmp . ");\n", "# END Clinical CMS DISALLOW_FILE_EDIT\n");

                //echo 'CONFIG WRITE: file_edits <br/>';
            }
            //$cbcp->addWPConfigs("/* FILEEDITS: ", DISALLOW_FILE_EDIT . " / " . $disallowFileEdit. " / " . $tmp . " */              ");
        }

        /* static */ function Clinical_enable_DISALLOW_FILE_MODS()
        {
            //enable DISALLOW_FILE_MODS in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $disallowFileMods = $titan->getOption('clinical_theme_editor');
            $tmp = '';
            //get instance of class
            if ($disallowFileMods == true) {
                $tmp = 'true';
            } else {
                $disallowFileMods = 0;
                $tmp = 'false';
            }
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if (defined('DISALLOW_FILE_MODS') && DISALLOW_FILE_MODS != $disallowFileMods) {
                $status = DISALLOW_FILE_MODS ? "true" : "false";
                $cbcp->removeWPConfigs("# START Clinical CMS DISALLOW_FILE_MODS\n", "# END Clinical CMS DISALLOW_FILE_MODS\n", "define('DISALLOW_FILE_MODS', " . $status . ");\n");
                //add new value
                $cbcp->addWPConfigs("# START Clinical CMS DISALLOW_FILE_MODS\n", "define('DISALLOW_FILE_MODS', " . $tmp . ");\n", "# END Clinical CMS DISALLOW_FILE_MODS\n");

                //echo 'CONFIG WRITE: file_mods <br/>';
            }
            if (!defined('DISALLOW_FILE_MODS')) {
                $cbcp->addWPConfigs("# START Clinical CMS DISALLOW_FILE_MODS\n", "define('DISALLOW_FILE_MODS', " . $tmp . ");\n", "# END Clinical CMS DISALLOW_FILE_MODS\n");

                //echo 'CONFIG WRITE: file_mods <br/>';
            }
            //$cbcp->addWPConfigs("/* FIELMODS: ", DISALLOW_FILE_MODS . " / " . $disallowFileMods. " / " . $tmp . " */\n");
        }

        /* static */ function Clinical_enable_IMAGE_EDITOR()
        {
            //enable DISALLOW_FILE_MODS in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $limitImageEditor = $titan->getOption('clinical_limit_image_editor');
            $tmp = '';
            //get instance of class
            if ($limitImageEditor == true) {
                $tmp = 'true';
            } else {
                $limitImageEditor = 0;
                $tmp = 'false';
            }
            $cbcp = new Clinical_Browser_Cache_Plugin();

            $status = $limitImageEditor ? "true" : "false";
            if (defined('IMAGE_EDIT_OVERWRITE') && IMAGE_EDIT_OVERWRITE != $limitImageEditor) {
                $cbcp->removeWPConfigs("# START Clinical CMS IMAGE_EDIT_OVERWRITE\n", "# END Clinical CMS IMAGE_EDIT_OVERWRITE\n", "define('IMAGE_EDIT_OVERWRITE', " . $status . ");\n");
                //add new value
                $cbcp->addWPConfigs("# START Clinical CMS IMAGE_EDIT_OVERWRITE\n", "define('IMAGE_EDIT_OVERWRITE', " . $tmp . ");\n", "# END Clinical CMS IMAGE_EDIT_OVERWRITE\n");

                //echo 'CONFIG WRITE: image_editor <br/>';
            }
            if (!defined('IMAGE_EDIT_OVERWRITE')) {
                $cbcp->addWPConfigs("# START Clinical CMS IMAGE_EDIT_OVERWRITE\n", "define('IMAGE_EDIT_OVERWRITE', " . $tmp . ");\n", "# END Clinical CMS IMAGE_EDIT_OVERWRITE\n");

                //echo 'CONFIG WRITE: image_editor <br/>';
            }
        }

        /* static */ function Clinical_enable_AUTOSAVE_INTERVAL()
        {
            //enable AUTOSAVE_INTERVAL in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $autosave = $titan->getOption('clinical_autosave_interval');
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if (AUTOSAVE_INTERVAL != $autosave) {
                $cbcp->removeWPConfigs("# START Clinical CMS AUTOSAVE_INTERVAL\n", "# END Clinical CMS AUTOSAVE_INTERVAL\n", "define('AUTOSAVE_INTERVAL', " . AUTOSAVE_INTERVAL . ");");
                $cbcp->addWPConfigs("# START Clinical CMS AUTOSAVE_INTERVAL\n", "define('AUTOSAVE_INTERVAL', " . $autosave . ");\n", "# END Clinical CMS AUTOSAVE_INTERVAL\n");

                //echo 'CONFIG WRITE: autosave_interval <br/>';
            }
        }

        /* static */ function Clinical_enable_AUTO_UPDATES()
        {
            //enable AUTOSAVE_INTERVAL in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $autoupdate = $titan->getOption('clinical_advanced_automated');
            
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            //$cbcp->addWPConfigs("", "/* WP_AUTO_UPDATE_CORE: " . WP_AUTO_UPDATE_CORE . " */\n", "");
            $core = WP_AUTO_UPDATE_CORE;
            settype($core, "string");
            $autotmp = '';
            
            /* it should be safe to remove this if else but need to test */
            if ($core == "minor") {
                $core = "minor";
            } else if ($core == true) {
                $core = "true";
            } else {
                $core = "false";
            }


            switch ($autoupdate) {
                case "1":
                    $autotmp = "false";
                    break;
                case "2":
                    $autotmp = "minor";
                    break;
                case "3":
                    $autotmp = "true";
                    break;
            }

            if (defined('WP_AUTO_UPDATE_CORE') && $core !== $autotmp) {
                if ($autotmp == "minor") {
                    $autotmp = "'minor'";
                }
                if ($core == "minor") {
                    $core = "'minor'";
                }
                $cbcp->removeWPConfigs("# START Clinical CMS WP_AUTO_UPDATE_CORE\n", "# END Clinical CMS WP_AUTO_UPDATE_CORE\n", "define('WP_AUTO_UPDATE_CORE', " . $core . ");\n");
                $cbcp->removeWPConfigs("", "", "define('WP_AUTO_UPDATE_CORE', 'minor');\n");
                $cbcp->addWPConfigs("# START Clinical CMS WP_AUTO_UPDATE_CORE\n", "define('WP_AUTO_UPDATE_CORE', " . $autotmp . ");\n", "# END Clinical CMS WP_AUTO_UPDATE_CORE\n");
                
                //$cbcp->addWPConfigs("/* TEST 1: ", "define('WP_AUTO_UPDATE_CORE', " . $autotmp . ");", " CORE: ".$core." / AUTO: " . $autotmp . "*/\n");

                //echo 'CONFIG WRITE: auto_update_core <br/>';
            }
            if (!defined('WP_AUTO_UPDATE_CORE')) {
                if ($autotmp == "minor") {
                    $autotmp = "'minor'";
                }
                if ($core == "minor") {
                    $core = "'minor'";
                }
                $cbcp->addWPConfigs("# START Clinical CMS WP_AUTO_UPDATE_CORE\n", "define('WP_AUTO_UPDATE_CORE', " . $core . ");\n", "# END Clinical CMS WP_AUTO_UPDATE_CORE\n");
                
                //$cbcp->addWPConfigs("/* TEST 2: ", "define('WP_AUTO_UPDATE_CORE', " . $autotmp . ");", " CORE: ".$core." / AUTO: " . $autotmp . "*/\n");

                //echo 'CONFIG WRITE: auto_update_Core <br/>';
            }
                
                //$cbcp->addWPConfigs("/* TEST 3: ", "define('WP_AUTO_UPDATE_CORE', " . $autotmp . ");", " CORE: ".$core." / AUTO: " . $autotmp . "*/\n");

        }

        /* static */ function Clinical_enable_SSL_ADMIN()
        {
            //enable forced SSL in wp-config
            $titan = TitanFramework::getInstance('clinical_cms');
            $adminssl = $titan->getOption('clinical_enable_ssl_admin');
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            if (FORCE_SSL_ADMIN != $adminssl) {
                $cbcp->removeWPConfigs("# START Clinical CMS FORCE_SSL_ADMIN\n", "define('FORCE_SSL_ADMIN', " . FORCE_SSL_ADMIN . ");\nif (strpos(\$_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)\n\$_SERVER['HTTPS']='on';", "# END Clinical CMS FORCE_SSL_ADMIN\n");

                $cbcp->addWPConfigs("# START Clinical CMS FORCE_SSL_ADMIN\n", "define('FORCE_SSL_ADMIN', $adminssl);\nif (strpos(\$_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)\n\$_SERVER['HTTPS']='on';", "# END Clinical CMS FORCE_SSL_ADMIN\n");
            }
        }

        public /* static */ function Clinical_caching_configure()
        {
            //get options
            $titan = TitanFramework::getInstance('clinical_cms');
            $browsercaching = $titan->getOption('clinical_browser_caching_enable');
            $etags = $titan->getOption('clinical_ETag_enable');
            $gzip = $titan->getOption('clinical_gzip_enable');
            $maintenance = $titan->getOption('clinical_maintenance_enable');
            $debugProtection = $titan->getOption('clinical_debug_protection');
            $xmlrpcProtection = $titan->getOption('clinical_disable_xmlrpc');
            $keepAlive = $titan->getOption('clinical_keep_alive_enable');

            //$disableVersion = $titan->getOption('clinical_disable_wpversion'); <-- See security pro extension
            $disableReadme = $titan->getOption('clinical_disable_readme');
            $disableIndexes = $titan->getOption('clinical_disable_indexes');

            $disableIncludes = $titan->getOption('clinical_disable_includes');
            $disableContent = $titan->getOption('clinical_disable_content');
            $disableUploads = $titan->getOption('clinical_disable_uploads');

            $disableSniff = $titan->getOption('clinical_disable_sniffing');
            $disableJacking = $titan->getOption('clinical_click_jacking');
            $disableXSS = $titan->getOption('clinical_xss_protection');
            $disableTrace = $titan->getOption('clinical_trace_method');
            
            //get htacess
            $tmphtaccess = file_get_contents(ABSPATH . '.htaccess');
            //if($maintenance == true){
                //get wp-config
            $tmpwpconfig = file_get_contents(ABSPATH . 'wp-config.php');
            //}
            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            //check .htaccess exists
            $htexists = file_exists(ABSPATH . '.htaccess');
            //make backup
            $backup_filename = 'ClinicalWP_backup' . date("Ymd") . '.htaccess';
            $canCopy = copy(ABSPATH . '.htaccess', ABSPATH . $backup_filename);

            if ($browsercaching == 1 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_caching_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_caching_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
                //$backup_filename = 'Clinical_caching_uninstall_backup' . time() . '.htaccess';
                //$cbcp->Clinical_caching_erase_file(false, $backup_filename, 1);
            }/*
            else if($browsercaching == 1 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') !== false)){
                //is enabled in options & value has already been written
                //do nothing
                //echo 'Borwser Caching already enabled';
            }
            else if($browsercaching != 1 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') === false)){
                //is disabled in options and htaccess values removed or never set
                //do nothing
                //echo 'Borwser Caching already disabled';
            }*/
            else if ($browsercaching != 1 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(1, $backup_filename);

            }

            if ($browsercaching == 2 && (strpos($tmphtaccess, 'START Clinical CMS Alt Caching') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_alt_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_alt_caching_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_alt_caching_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($browsercaching != 2 && (strpos($tmphtaccess, 'START Clinical CMS Alt Caching') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(2, $backup_filename);

            }
            
            //no caching methods selected so check for artifacts and remove
            if ($browsercaching == 3 && (strpos($tmphtaccess, 'START Clinical CMS Browser Caching') !== false)) {
                //is disabled in options so remove method 1
                $cbcp->Clinical_caching_uninstall(1, $backup_filename);
            }
            if ($browsercaching == 3 && (strpos($tmphtaccess, 'START Clinical CMS Alt Caching') !== false)) {
                //is disabled in options so remove method 2
                $cbcp->Clinical_caching_uninstall(2, $backup_filename);
            }
            
            //set ETag modification
            if ($etags == 1 && (strpos($tmphtaccess, 'START Clinical CMS Modify ETag') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_modify_etag_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_modify_etag_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
                //$backup_filename = 'Clinical_caching_uninstall_backup' . time() . '.htaccess';
                //$cbcp->Clinical_caching_erase_file(false, $backup_filename, 1);
            } else if ($etags != 1 && (strpos($tmphtaccess, 'START Clinical CMS Modify ETag') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(3, $backup_filename);
            }

            if ($etags == 2 && (strpos($tmphtaccess, 'START Clinical CMS Modify Alt ETag') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_alt_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_modify_etag_alt_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_modify_etag_alt_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
                //$backup_filename = 'Clinical_alt_caching_uninstall_backup' . time() . '.htaccess';
                //$cbcp->Clinical_caching_erase_file(false, $backup_filename, 2);
            } else if ($etags != 2 && (strpos($tmphtaccess, 'START Clinical CMS Modify Alt ETag') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(4, $backup_filename);

            }
            
            //no caching methods selected so check for artifacts and remove
            if ($etags == 3 && (strpos($tmphtaccess, 'START Clinical CMS Modify ETag') !== false)) {
                //is disabled in options so remove method 1
                $cbcp->Clinical_caching_uninstall(3, $backup_filename);
            }
            if ($etags == 3 && (strpos($tmphtaccess, 'START Clinical CMS Modify Alt ETag') !== false)) {
                //is disabled in options so remove method 2
                $cbcp->Clinical_caching_uninstall(4, $backup_filename);
            }
            
            //set gzip compression
            if ($gzip == 1 && (strpos($tmphtaccess, '# START Clinical CMS Enable GZip') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_enable_gzip_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_enable_gzip_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
                //$backup_filename = 'Clinical_caching_uninstall_backup' . time() . '.htaccess';
                //$cbcp->Clinical_caching_erase_file(false, $backup_filename, 1);
            } else if ($gzip != 1 && (strpos($tmphtaccess, '# START Clinical CMS Enable GZip') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(5, $backup_filename);

            }
            /*
            if($gzip == 2){
                //$status = true;
                //$cbcp->Clinical_enable_gzip_php();
                /*** This is taken care of via the construct() add_action *** /
            }
             */
            //no caching methods selected so check for artifacts and remove
            if ($gzip == 3 && (strpos($tmphtaccess, '# START Clinical CMS Enable GZip') !== false)) {
                //is disabled in options so remove method 1
                $cbcp->Clinical_caching_uninstall(5, $backup_filename);
            }
            
            /*
            //set maintenance mode
            if($maintenance == true && (strpos($tmpwpconfig, '# START Clinical CMS Enable Maintenance') === false)){
                //is set in option but htaccess values not set
                //$status = true;
                $backup_filename = 'Clinical_caching_install_backup' . time() . 'wp-config.php';
                if(file_exists(ABSPATH . 'wp-config.php')) {
                    if(!copy ( ABSPATH . 'wp-config.php' , ABSPATH . $backup_filename )) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    }
                    else{
                        $status = $cbcp->Clinical_enable_maintenance_write_file(ABSPATH . 'wp-config.php');
                    }
                } else {
                    $status = $cbcp->Clinical_enable_maintenance_write_file(ABSPATH . 'wp-config.php');
                }
            }
            else if($maintenance !== true && (strpos($tmpwpconfig, '# START Clinical CMS Enable Maintenance') !== false)){
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(6);
            }
             */
			//set Debug.log protection - prevent url based access.
            if ($debugProtection == '1' /*&& (strpos($tmphtaccess, 'START ClinicalWP Debug.log') === false)*/ ) {
                //is set in option but htaccess values not set
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                    } else {
						//remove any existing entry
                        $cbcp->Clinical_debug_apache_write_file(ABSPATH . '.htaccess');
                    }
                } else {
					//remove any existing entry
                    $cbcp->Clinical_debug_apache_write_file(ABSPATH . '.htaccess');
                }
            } else if (($debugProtection != '1') && (strpos($tmphtaccess, '# START ClinicalWP Debug.log') !== false)) {
                //remove any existing entry
                $cbcp->Clinical_caching_uninstall(14, $backup_filename);
            }
		    //set xmlrpc protection
            if ($xmlrpcProtection === true && (strpos($tmphtaccess, '# START ClinicalWP XMLRPC') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_security_XMLRPC_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_security_XMLRPC_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($xmlrpcProtection !== true && (strpos($tmphtaccess, '# START ClinicalWP XMLRPC') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(15, $backup_filename);
            }
            
            //set keep-alive
            if ($keepAlive === true && (strpos($tmphtaccess, '# START ClinicalWP KeepAlive') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_keep_alive_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_keep_alive_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($keepAlive !== true && (strpos($tmphtaccess, '# START ClinicalWP KeepAlive') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(16, $backup_filename);
            }

        //hide readme
            if ($disableReadme === true && (strpos($tmphtaccess, '# START ClinicalWP Readme') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_disable_readme_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_disable_readme_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($disableReadme !== true && (strpos($tmphtaccess, '# START ClinicalWP Readme') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(18, $backup_filename);
            }

            //disable directory indexes
            if ($disableIndexes === true && (strpos($tmphtaccess, '# START ClinicalWP Indexes') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_disable_indexes_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_disable_indexes_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($disableIndexes !== true && (strpos($tmphtaccess, '# START ClinicalWP Indexes') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(19, $backup_filename);
            }

            //disable direct wp-includes access
            $tmpIncludes = file_get_contents(ABSPATH . 'wp-includes/.htaccess');
            if ($disableIncludes === true && (strpos($tmpIncludes, '# START ClinicalWP Includes') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                //if ($htexists) {
                //    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                //    } else {
                $status = $cbcp->Clinical_disable_includes_write_file(ABSPATH . 'wp-includes/.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                //    }
                //} else {
                //    $status = $cbcp->Clinical_disable_includes_write_file(ABSPATH . 'wp-includes/.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                //}
            } else if ($disableIncludes !== true && (strpos($tmpIncludes, '# START ClinicalWP Includes') !== false)) {
                //is disabled in options and htaccess values still need removing
                //make backup
                $backup_filename = "wp-includes/" . 'ClinicalWP_backup' . date("Ymd") . '.htaccess';
                copy(ABSPATH . 'wp-includes/.htaccess', ABSPATH . $backup_filename);
                $cbcp->Clinical_caching_uninstall(20, $backup_filename);
            }
            
            //disable direct wp-content access
            $tmpContent = file_get_contents(ABSPATH . 'wp-content/.htaccess');
            if ($disableContent === true && (strpos($tmpContent, '# START ClinicalWP Content') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                //if ($htexists) {
                //    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                //    } else {
                //        $status = $cbcp->Clinical_disable_content_write_file(ABSPATH . 'wp-content/.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                //    }
                //} else {
                $status = $cbcp->Clinical_disable_content_write_file(ABSPATH . 'wp-content/.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                //}
            } else if ($disableContent !== true && (strpos($tmpContent, '# START ClinicalWP Content') !== false)) {
                //is disabled in options and htaccess values still need removing
                //make backup
                $backup_filename = "wp-content/" . 'ClinicalWP_backup' . date("Ymd") . '.htaccess';
                copy(ABSPATH . 'wp-content/.htaccess', ABSPATH . $backup_filename);
                $cbcp->Clinical_caching_uninstall(21, $backup_filename);
            }
            
            //disable direct wp-uploads access
            $tmpUploads = file_get_contents(ABSPATH . 'wp-content/uploads/.htaccess');
            if ($disableUploads === true && (strpos($tmpUploads, '# START ClinicalWP Uploads') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                //if ($htexists) {
                //    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                //    } else {
                //        $status = $cbcp->Clinical_disable_uploads_write_file(ABSPATH . 'wp-content/uploads/.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                //    }
                //} else {
                $status = $cbcp->Clinical_disable_uploads_write_file(ABSPATH . 'wp-content/uploads/.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                //}
            } else if ($disableUploads !== true && (strpos($tmpUploads, '# START ClinicalWP Uploads') !== false)) {
                //is disabled in options and htaccess values still need removing
                //make backup
                $backup_filename = "wp-content/uploads/" . 'ClinicalWP_backup' . date("Ymd") . '.htaccess';
                copy(ABSPATH . 'wp-content/uploads/.htaccess', ABSPATH . $backup_filename);
                $cbcp->Clinical_caching_uninstall(22, $backup_filename);
            }

            //disable link jacking
            if ($disableJacking === true && (strpos($tmphtaccess, '# START ClinicalWP Jacking') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_disable_jacking_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_disable_jacking_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($disableJacking !== true && (strpos($tmphtaccess, '# START ClinicalWP Jacking') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(23, $backup_filename);
            }
            
            //disable XSS
            if ($disableXSS === true && (strpos($tmphtaccess, '# START ClinicalWP XSS') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_disable_xss_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_disable_xss_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($disableXSS !== true && (strpos($tmphtaccess, '# START ClinicalWP XSS') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(24, $backup_filename);
            }
            
            //disable trace
            if ($disableTrace === true && (strpos($tmphtaccess, '# START ClinicalWP Trace') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_disable_trace_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_disable_trace_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($disableTrace !== true && (strpos($tmphtaccess, '# START ClinicalWP Trace') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(25, $backup_filename);
            }
            
            //disable Sniffing
            if ($disableSniff === true && (strpos($tmphtaccess, '# START ClinicalWP NoSniff') === false)) {
                //is set in option but htaccess values not set
                //$status = true;
                //$backup_filename = 'Clinical_caching_install_backup' . time() . '.htaccess';
                if ($htexists) {
                    if (!$canCopy) {
                        //$status = false;
                        //echo 'Can not create backup file. So Browser Caching was halted';
                    } else {
                        $status = $cbcp->Clinical_disable_sniff_write_file(ABSPATH . '.htaccess');
                        //$status = true;
                        //echo 'Created backup file.';
                    }
                } else {
                    $status = $cbcp->Clinical_disable_sniff_write_file(ABSPATH . '.htaccess');
                    //$status = true;
                    //echo 'Created htaccess file.';
                }
            } else if ($disableSniff !== true && (strpos($tmphtaccess, '# START ClinicalWP NoSniff') !== false)) {
                //is disabled in options and htaccess values still need removing
                $cbcp->Clinical_caching_uninstall(26, $backup_filename);
            }
        }


        public /* static */ function Clinical_caching_uninstall($method, $backup_filename = '')
        {
            /*
            if($method != 6){
                $backup_filename = 'Clinical_caching_uninstall_backup' . time() . '.htaccess';
            }
            else{
                $backup_filename = 'Clinical_caching_uninstall_backup' . time() . 'wp-config.php';
            }
             */

            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            $status = $cbcp->Clinical_caching_erase_file(false, $backup_filename, $method);
            return $status;
        }

        public /* static */ function Clinical_caching_erase_file($backup, $backup_filename = '', $method = '')
        {
            $status = true;
            $wouldblock = 1;

            if ($backup) {
                if ($method == 20) { ///includes
                    if(copy(ABSPATH . 'wp-includes/.htaccess', ABSPATH . $backup_filename)){
                        $status = true;
                    }
                    else { $status = false; }
                }
                else if ($method == 21){ //wp-content
                    if(copy(ABSPATH . 'wp-content/.htaccess', ABSPATH . $backup_filename)){
                        $status = true;
                    }
                    else { $status = false; }
                }
                else if (method == 22){ //wp-content/uploads
                    if(copy(ABSPATH . 'wp-content/uploads/.htaccess', ABSPATH . $backup_filename)){
                        $status = true;
                    }
                    else { $status = false; }
                }
                else if ($method != 6) {
                    if(copy(ABSPATH . '.htaccess', ABSPATH . $backup_filename)){
                        $status = true;
                    }
                    else { $status = false; }
                } else if ($method == 6) {
                    if (copy(ABSPATH . 'wp-config.php', ABSPATH . $backup_filename)) {  
                        $status = true;
                    }
                    else { $status = false; }
                } else {
                    $status = false;
                }
                if (!$status) {
                    return;
                }
            }
            if ($status) {
                if ($method == 20) {
                    $fp = fopen(ABSPATH . 'wp-includes/.htaccess', "w");
                } else if ($method == 21) {
                    $fp = fopen(ABSPATH . 'wp-content/.htaccess', "w");
                } else if ($method == 22) {
                    $fp = fopen(ABSPATH . 'wp-content/uploads/.htaccess', "w");
                } else if ($method == 6) {
                    $fp = fopen(ABSPATH . 'wp-config.php', "w");
                } else {
                    $fp = fopen(ABSPATH . '.htaccess', "w");
                }
                $lines = file(ABSPATH . $backup_filename);

                if (flock($fp, LOCK_EX, $wouldblock)) {//lock the file
                    ftruncate($fp, 0); //truncate the file
                    $inLoop = false;
                    foreach ($lines as $line) {
                        if ($method == 1) {
                            if (strpos($line, 'START Clinical CMS Browser Caching') !== false) {
                                $inLoop = true;
                            }
                            if (strpos($line, 'END Clinical CMS Browser Caching') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        } else if ($method == 2) {
                            if (strpos($line, 'START Clinical CMS Alt Caching') !== false) {
                                $inLoop = true;
                            }
                            if (strpos($line, 'END Clinical CMS Alt Caching') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        } else if ($method == 3) {
                            if (strpos($line, 'START Clinical CMS Modify ETag') !== false) {
                                $inLoop = true;
                            }
                            if (strpos($line, 'END Clinical CMS Modify ETag') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        } else if ($method == 4) {
                            if (strpos($line, 'START Clinical CMS Modify Alt ETag') !== false) {
                                $inLoop = true;
                            }
                            if (strpos($line, 'END Clinical CMS Modify Alt ETag') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        } else if ($method == 5) {
                            if (strpos($line, 'START Clinical CMS Enable GZip') !== false) {
                                $inLoop = true;
                            }
                            if (strpos($line, 'END Clinical CMS Enable GZip') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//debug.log protection
                        else if ($method == 14) {
                            if (strpos($line, 'START ClinicalWP Debug.log') !== false) {
                                $inLoop = true;
                            }
                            if (strpos($line, 'END ClinicalWP Debug.log') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//XML-RPC Disable
                        else if ($method == 15) {
                            if (strpos($line, 'START ClinicalWP XMLRPC') !== false) {
                                $inLoop = true;
                            }
                            if (strpos($line, 'END ClinicalWP XMLRPC') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//KeepAlive
                        else if ($method == 16) {
                            if (strpos($line, 'START ClinicalWP KeepAlive') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP KeepAlive') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Secure Readme file
                        else if ($method == 18) {
                            if (strpos($line, 'START ClinicalWP Readme') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP Readme') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Secure Indexes
                        else if ($method == 19) {
                            if (strpos($line, 'START ClinicalWP Indexes') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP Indexes') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Secure Includes
                        else if ($method == 20) {
                            if (strpos($line, 'START ClinicalWP Includes') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP Includes') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Secure WP-Content
                        else if ($method == 21) {
                            if (strpos($line, 'START ClinicalWP Content') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP Content') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Secure Uploads folder
                        else if ($method == 22) {
                            if (strpos($line, 'START ClinicalWP Uploads') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP Uploads') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Prevent Browser Jacking
                        else if ($method == 23) {
                            if (strpos($line, 'START ClinicalWP Jacking') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP Jacking') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Prevent XSS
                        else if ($method == 24) {
                            if (strpos($line, 'START ClinicalWP XSS') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP XSS') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Prevent Traces
                        else if ($method == 25) {
                            if (strpos($line, 'START ClinicalWP Trace') !== false) {
                                $inLoop = true;
                                //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP Trace') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }//Prevent Sniffing
                        else if ($method == 26) {
                            if (strpos($line, 'START ClinicalWP NoSniff') !== false) {
                                $inLoop = true;
                               //error_log('LOOP START');
                            }
                            if (strpos($line, 'END ClinicalWP NoSniff') !== false) {
                                $inLoop = false;
                                //error_log('LOOP STOP');
                                continue;
                            }
                            if (!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        /*
                        else if($method == 6){
                            if(strpos($line, 'START Clinical CMS Enable Maintenance') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable Maintenance') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 7){
                            if(strpos($line, 'START Clinical CMS Enable WP_POST_REVISIONS') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable WP_POST_REVISIONS') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 8){
                            if(strpos($line, 'START Clinical CMS Enable WP_MEMORY_LIMIT') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable WP_MEMORY_LIMIT') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 9){
                            if(strpos($line, 'START Clinical CMS Enable WP_MAX_MEMORY_LIMIT') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable WP_MAX_MEMORY_LIMIT') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 10){
                            if(strpos($line, 'START Clinical CMS Enable EMPTY_TRASH_DAYS') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable EMPTY_TRASH_DAYS') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 11){
                            if(strpos($line, 'START Clinical CMS Enable DISALLOW_FILE_EDIT') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable DISALLOW_FILE_EDIT') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 12){
                            if(strpos($line, 'START Clinical CMS Enable DISALLOW_FILE_MODS') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable DISALLOW_FILE_MODS') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                        else if($method == 13){
                            if(strpos($line, 'START Clinical CMS Enable AUTOSAVE_INTERVAL') !== false) {
                                $inLoop = true;
                            }
                            if(strpos($line, 'END Clinical CMS Enable AUTOSAVE_INTERVAL') !== false) {
                                $inLoop = false;
                                continue;
                            }
                            if(!$inLoop) {
                                fwrite($fp, $line);
                                fflush($fp);
                            }
                        }
                         */
                    }
                    flock($fp, LOCK_UN, $wouldblock); //unlock file
                } else {
                    $status = false;
                }
                fclose($fp);
            }
            return $status;
        }

        /* static */ function removeWPConfigs($sOne, $sTwo, $sThree)
        {
            //read the entire string
            $file_path = ABSPATH . 'wp-config.php';
                //echo "FILE PATH: " + $file_path;
            $str = file_get_contents($file_path);

            //replace something in the file string
            $str = str_replace($sOne, "", $str);
            $str = str_replace($sTwo, "", $str);
            $str = str_replace($sThree, "", $str);
            $str = str_replace("   ", "", $str);

            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            //backup and write wp-config
            $cbcp->configSafety($file_path, $str);
        }

        /* static */ function addWPConfigs($sOne, $sTwo, $sThree)
        {
            //string to find and insert before
            $findMe = "/* That's all, stop editing! Happy blogging. */";
            //read the entire string
            $file_path = ABSPATH . 'wp-config.php';
            $str = file_get_contents($file_path);

            //replace something in the file string
            $str = str_replace($findMe, $sOne . ' ' . $sTwo . ' ' . $sThree . ' ' . $findMe, $str);

            //get instance of class
            $cbcp = new Clinical_Browser_Cache_Plugin();
            //backup and write wp-config
            $cbcp->configSafety($file_path, $str);
        }

        /* static */ function configSafety($file_path, $str)
        {
            //get orig wp content
            $orig = file_get_contents($file_path);
            //make a backup
            $backup = ABSPATH . 'wp-config-backup.php';
            file_put_contents($backup, $orig, LOCK_EX);
            
            //check new wp contents contain essentials
            if (strpos($str, '$table_prefix') !== false && strpos($str, "define('DB_NAME'") !== false && strpos($str, "define('DB_USER'") !== false && strpos($str, "define('DB_PASSWORD'") !== false && strpos($str, "define('DB_HOST'") !== false && strpos($str, "require_once(ABSPATH . 'wp-settings.php');") !== false) {
                //string contains essentials so safe to overwrite wp-config
                
                //write the entire string
                file_put_contents($file_path, $str, LOCK_EX);
            }

        }

    }
}

if (class_exists('Clinical_Browser_Cache_Plugin')) {
    // instantiate the plugin class
    $clinical_browser_cache_plugin = new Clinical_Browser_Cache_Plugin();
}