<?php

class CommissionFinalisationModel extends iaModelMysql {

    var $table = 'commissions_finalisations';

    var $mapping = array(
        'id' => 'id',
        'actif' => 'actif',
        'commission_id' => 'commission_id',
        'candidat_id' => 'candidat_id',
        'termine' => 'termine',
        'reception_contrat_date' => 'reception_contrat_date',
        'reception_contrat_etat' => 'reception_contrat_etat',
        'reception_contrat_commentaire' => 'reception_contrat_commentaire',
        'debut_activite' => 'debut_activite',
        'commentaire' => 'commentaire'
    );

    var $primary = array('id');

    var $validation = array(
        'commission_id' => 'mandatory'
    );

    var $archive_foreign_models = array(
        'candidat' => array('candidat_id' => 'id')
    );
}
