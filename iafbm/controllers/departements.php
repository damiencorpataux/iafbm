<?php

class DepartementsController extends iaWebController {

    var $model = 'departement';

    function indexAction() {
        $data = array(
            'title' => 'Départements',
            'id' => 'departements',
            'model' => 'Departement'
        );
        return xView::load('common/extjs/grid', $data, $this->meta)->render();
    }
}