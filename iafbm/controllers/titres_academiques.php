<?php

class TitresAcademiquesController extends iaWebController {

    var $model = 'titre_academique';

    function indexAction() {
        $data = array(
            'title' => 'Titres académiques',
            'id' => 'titres-academiques',
            'model' => 'TitreAcademique'
        );
        return xView::load('common/extjs/grid', $data, $this->meta)->render();
    }
}