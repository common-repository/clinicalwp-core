<?php
add_action( 'wp_enqueue_scripts', 'add_links_script' );
function add_links_script() {
    $titan = TitanFramework::getInstance( 'clinical_cms' );
    $linkExternal = $titan->getOption( 'clinical_external_links_enable' );
    
    if($linkExternal == true){
        wp_enqueue_script(
            'external-links', // name of script so that you can attach other scripts and de-register, etc.
            plugin_dir_url( __FILE__ ) . '../js/external-links.js', // this is the location of the script file
            array('jquery') // this array lists the scripts upon which your script depends
        );
    }
}
?>