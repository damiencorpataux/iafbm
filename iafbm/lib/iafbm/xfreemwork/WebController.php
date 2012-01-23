<?php

/**
 * Project specific xWebController
 */
class iaWebController extends xWebController {

    var $model = null;

    /**
     * Allowed CRUD operations.
     * Possible values: 'get', 'post', 'put', 'delete'
     * @see iaWebController::get()
     * @see iaWebController::post()
     * @see iaWebController::put()
     * @see iaWebController::delete()
     * @var array
     */
    var $allow = array('get', 'post', 'put', 'delete');

    /**
     * Excluded fields for model parameters creation on query.
     * Eg. when the query parameter is provided with a GET method.
     * @see iaWebController::get()
     */
    var $query_fields = array();

    /**
     * @todo
     * Return true if the method is allowed.
     * Checks for:
     * - $this->allow rights
     * - authenticated role
     */
    function is_allowed() {
        throw new xException('Not implemented', 501);
        /* TODO
        if (!in_array($this->http['method'], $this->allow))
            throw new xException('Method not allowed', 403);
        if (false)
            throw new xException('Insufficent privileges', 403);
        */
    }

    /**
     * Returns controller name
     * @return string Controller name
     */
    protected function get_name() {
        return strtolower(substr(get_class($this), 0, -strlen('Controller')));
    }

    /**
     * Manages action redirection
     * according the received params and the available controller actions.
     */
    function defaultAction() {
        if (!isset($this->params['id'])) {
            if (method_exists($this, 'indexAction')) return $this->indexAction();
        } else {
            if (method_exists($this, 'detailAction')) return $this->detailAction();
        }
        throw new xException('Not found', 404);
    }

    /**
     * API Method.
     * Generic get method for API calls.
     * @param mixed Any model fields for filtering, or a query parameter for search
     * @return array An ExtJS compatible resultset structure.
     */
    function get() {
        if (!in_array('get', $this->allow)) throw new xException("Method not allowed", 403);
        // Creates parameter for model instance
        $params = $this->params;
        // Manages query case
        if (strlen(@$params['query']) > 0) {
            $fields = array_merge(
                array_keys(xModel::load($this->model)->mapping),
                array_keys(xModel::load($this->model)->foreign_mapping())
            );
            // Adds (specified if applicable) model fields
            foreach ($fields as $field) {
                // Skips model field if $this->query_field exists but $field not in list
                if ($this->query_fields && !in_array($field, $this->query_fields)) continue;
                // Skips fields existing in params:
                // these are to be used as constraint
                if (in_array($field, array_keys($this->params), true)) continue;
                // Adds model field
                $params[$field] = "%{$this->params['query']}%";
                $params["{$field}_comparator"] = 'LIKE';
                $params["{$field}_operator"] = 'OR';
            }
            // Removes query param
            unset($params['query']);
        }
        // Creates extjs compatible result
        return array(
            'xcount' => xModel::load($this->model, xUtil::filter_keys($params, array('xoffset', 'xlimit'), true))->count(),
            'items' => xModel::load($this->model, $params)->get()
        );
    }

    /**
     * API Method.
     * Generic post method for API calls.
     * @param array items: contains an array of model fields and values.
     * @return array An ExtJS compatible resultset structure.
     */
    function post() {
        // Checks if method is allowed
        if (!in_array('post', $this->allow))
            throw new xException("Method not allowed", 403);
        // Checks provided parameters
        if (!isset($this->params['items']))
            throw new xException('No items provided', 400);
        // Checks for params.id and params.items.id consistency
        // (this test is only for precaution: params.id is not used in anyway)
        if ($this->params['id'] != $this->params['items']['id'])
            throw new xException("Parameters id and items.id do not match", 400);
        // Database action
        $r = xModel::load($this->model, $this->params['items'])->post();
        // Result
        $i = xController::load($this->get_name(), array('id'=>$this->params['items']['id']))->get();
        $r['items'] = array_shift($i['items']);
        return $r;
    }

    /**
     * API Method.
     * Generic put method for API calls.
     * @param array items: contains an array of model fields and values.
     * @return array An ExtJS compatible resultset structure.
     */
    function put() {
        // Checks if method is allowed
        if (!in_array('put', $this->allow)) throw new xException("Method not allowed", 403);
        // Checks provided parameters
        if (!isset($this->params['items'])) throw new xException('No items provided', 400);
        // Database action
        $r = xModel::load($this->model, $this->params['items'])->put();
        // Result
        $i = xController::load($this->get_name(), array('id'=>$r['xinsertid']))->get();
        $r['items'] = array_shift($i['items']);
        return $r;
    }

    /**
     * API Method.
     * Generic delete method for API calls.
     * @param integer id: the id parameter of the record to delete
     * @return array An ExtJS compatible resultset structure.
     */
    function delete() {
        // Checks if method is allowed
        if (!in_array('delete', $this->allow)) throw new xException("Method not allowed", 403);
        // Database action + result
        return xModel::load($this->model, array('id'=>@$this->params['id']))->delete();
    }

    /**
     * API Method.
     * Creates a tag.
     * A tag consists in version generated by the user.
     * @param integer id: the id parameter of the record to tag (version)
     * @return array An ExtJS compatible resultset structure.
     */
    function tag() {
        return xModel::load($this->model, array(
            'id' => @$this->params['id'],
            'commentaire' => @$this->params['commentaire']
        ))->tag();
    }
}