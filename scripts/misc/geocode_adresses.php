<?php

require_once(dirname(__file__).'/../Script.php');

class iafbmGeocodeAdresses extends iafbmScript {

    function run() {
        // Ensures 'adresse' geo-fields exist
        $this->log("Checking 'adresses' geo-fields");
        if (!$this->fields_exist()) {
            $this->log("Fields do not exist, creating...", 1);
            $this->create_fields();
        } else {
            $this->log("Fields do exist", 1);
        }
        // Geocodes adresses
        $this->geocode_adresses();
    }


    /**
     * Geocodes all ungeocodes adresses (eg. geo_x || geo_y is null)
     */
    function geocode_adresses() {
        $this->log('Geocoding');
        $this->log('Retrieving adresses to geocode', 1);
        $items = xModel::load('adresse', array(
            'geo_x' => null,
            'geo_y' => null
        ))->get();
        $count = count($items);
        print "* Processing {$count} items";
        foreach ($items as $item) {
            // POSTS unmodified record to trigger geocoding (see AdresseModel::post())
            xModel::load('adresse', $item)->post();
            print '.';
        }
    }

    function fields_exist() {
        $fields = array('geo_x', 'geo_y');
        $r = xModel::q('DESCRIBE adresses');
        while ($row = mysql_fetch_assoc($r)) {
            $result[] = $row['Field'];
        }
        return !!array_intersect($result, $fields);
    }

    /**
     * Adds fields to table 'candidats'
     */
    function create_fields() {
        $t = new xTransaction();
        $t->start();
        $t->execute_sql('ALTER TABLE adresses ADD COLUMN geo_y FLOAT DEFAULT NULL AFTER pays_id');
        $t->execute_sql('ALTER TABLE adresses ADD COLUMN geo_x FLOAT DEFAULT NULL AFTER pays_id');
        $t->end();
    }


}

new iafbmGeocodeAdresses();