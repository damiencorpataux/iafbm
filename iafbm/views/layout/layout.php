<?php

class LayoutLayoutView extends xView {

    function init() {
        $this->meta = xUtil::array_merge($this->meta, array(
            'js' => array(
                xUtil::url('a/js/view/context.js'),
                //xUtil::url('a/js/xfreemwork/lib/core.js'),
                xUtil::url('a/js/ext/bootstrap.js'),
                xUtil::url('a/js/ext-ux/native/form/SearchField.js'),
                xUtil::url('a/js/ext-custom/custom.js')
            ),
            'layout' => array(
                'template' => 'layout.tpl',
                // Possible types: normal, half, full
                // see main.css
                'type' => 'full'
            ),
            'css' => array(
                xUtil::url('a/js/ext/resources/css/ext-all.css'),
                //xUtil::url('a/css/ext.css'),
                xUtil::url('a/css/main.css'),
            )
        ));
    }

    function render() {
        if (@$this->meta['related']['additional']) $this->meta['layout']['type'] = 'normal';
        return $this->apply($this->meta['layout']['template']);
    }
}