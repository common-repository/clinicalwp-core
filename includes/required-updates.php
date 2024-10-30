<?php
/**
 * Check available updates
 */
function CCK_available_updates()
{
    return( check_core() . check_plugins() . check_themes() );
}

function check_core()
{
        //do_action( "wp_version_check" ); //check for core updates
    $update_core = get_site_transient("update_core"); // get information of updates
    if ('upgrade' == $update_core->updates[0]->response) { // is WP core update available?
        $new_core_ver = $update_core->updates[0]->current; // The new WP core version
            //$old_core_ver = $wp_version; // the old WP core version
        return  "<strong>" . sprintf( __("WP core can be upgraded to version: %s, ", "Clinical-CMS-Core") , $new_core_ver ) . "</strong>";
    } else {
        return  "<strong>" . __("No core updates") . "</strong>, ";
    }
}

function check_plugins()
{
        //do_action( "wp_update_plugins" ); //check plugins for updates
    $update_plugins = get_site_transient('update_plugins'); //get info on updates
    if (!empty($update_plugins->response)) { //any updates?
        $plugins_need_update = $update_plugins->response; //plugins for updating
            /*
            if ( count( $plugins_need_update ) >= 1 ) { //check have at least 1

            }
         */
    }
    return "<strong>" . count($plugins_need_update) . " " . __("plugin ", "Clinical-CMS-Core") . "</strong>";
}

function check_themes()
{
        //do_action( "wp_update_themes" ); //check for theme updates
    $update_themes = get_site_transient('update_themes'); //get info on updates
    if (!empty($update_themes->response)) { //any updates?
        $themes_need_update = $update_themes->response; //themes that need updating
            /*
            if ( count( $themes_need_update ) >= 1 ) {//check have at least 1
                //do something
            }
         */
    }
    return  __("and", "Clinical-CMS-Core"). " <strong>" . count($themes_need_update) . " " . __("theme")  . "</strong> " . __("updates available.", "Clinical-CMS-Core");
}
?>