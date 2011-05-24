<?php

class CommissionFonctionModel extends xModelMysql {

    var $table = 'commissions_fonctions';

    var $mapping = array(
        'id' => 'id',
        'actif' => 'actif',
        'created' => 'created',
        'modified' => 'modified',
        'nom' => 'nom',
        'description' => 'description'
    );

    var $primary = array('id');

    var $validation = array(
        'nom' => array(
            'mandatory'
        )
    );
}
