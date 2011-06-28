<?php

class FormationTitreModel extends xModelMysql {

    var $table = 'formations_titres';

    var $mapping = array(
        'id' => 'id',
        'nom' => 'nom'
    );

    var $primary = array('id');

    var $validation = array(
        'nom' => 'mandatory'
    );
}