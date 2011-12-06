<?php

class CommissionMembreModel extends iaModelMysql {

    var $table = 'commissions_membres';

    var $mapping = array(
        'id' => 'id',
        'personne_id' => 'personne_id',
        'commission_id' => 'commission_id',
        'commission_fonction_id' => 'commission_fonction_id',
        'titre_academique_id' => 'titre_academique_id',
        'departement_id' => 'departement_id',
        'actif' => 'actif',
        'created' => 'created',
        'modified' => 'modified'
    );

    var $primary = array('id');

    var $joins = array(
        'personne' => 'LEFT JOIN personnes ON (commissions_membres.personne_id = personnes.id)',
        'commission' => 'LEFT JOIN commissions ON (commissions_membres.commission_id = commissions.id)',
        'commission_type' => 'LEFT JOIN commissions_types ON (commissions.commission_type_id = commissions_types.id)',
        'commission_fonction' => 'LEFT JOIN commissions_fonctions ON (commissions_membres.commission_fonction_id = commissions_fonctions.id)',
        'commission_etat' => 'LEFT JOIN commissions_etats ON (commissions.commission_etat_id = commissions_etats.id)',
        'section' => 'LEFT JOIN sections ON (commissions.section_id = sections.id)',
        'titre_academique' => 'LEFT JOIN titres_academiques ON (commissions_membres.titre_academique_id = titres_academiques.id)',
        'departement' => 'LEFT JOIN departements ON (commissions_membres.departement_id = departements.id)'
    );

    var $join = array('personne', 'commission', 'commission_fonction', 'titre_academique', 'departement');

    var $wheres = array(
        'query' => "{{personne_id}} = {personne_id} AND {{actif}} = 1 AND (1=0 [OR {{*}} LIKE {*}])"
    );

    var $validation = array();
}
