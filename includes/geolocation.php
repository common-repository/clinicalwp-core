<?php
    function clinical_GeoLocs(){
        //process the Country codes as listed at: https://datahub.io/core/country-list

        //get json & return as array
        $jsonLoc = file_get_contents( WP_PLUGIN_DIR . '/z_clinicalwp-security-pro/json/codes-ISO3166-1-alpha-2.json' );

        $data = json_decode($jsonLoc, true);
        $locs = array_column( $data, 'Name', 'Code' );

        $newdata = array (
             'unknown' => 'Unidentified',
          );
        $new = array_merge($newdata, $locs);
        //return combined array
        return $new;
    }
?>