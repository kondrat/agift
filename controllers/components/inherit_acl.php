<?php
/*
* small component the reset the parent Aco in case of inheritance
*
*/
class InheritAclComponent extends Object {
    var $controller = null;

    function startup(&$controller) {
        $this->controller = $controller;
    }

    function checkAroParent($modelname, $id, $parentModel, $parentId) {
        // find the current aro for the model

        $aro = $this->controller->Acl->Aro->node( array('model' => $modelname, 'foreign_key' => $id) );

        if( empty($aro) ) {
            trigger_error("checkAroParent, no Aro found for model: {$modelname}, id : {$id}", E_USER_WARNING);
            return false;
        }

        $aronode = $aro[0]['Aro'];

        // if parent did not change, perfect

        if($aronode['parent_id'] == $parentId)
            return true;

        // we find the Aro for the parent model

        $aroparent = $this->controller->Acl->Aro->node(array('model' => $parentModel, 'foreign_key' => $parentId));

        if(empty($aroparent)) {
            trigger_error("checkAroParent, no Aro found for parent model: {$parentModel}, id : {$parentId}", E_USER_WARNING);
            return false;
        }

        // we get the aro id of the parent

        $newid = $aroparent[0]['Aro']['id'];

        // save aro with new parent id

        $aronode['parent_id'] = $newid;
        $this->controller->Acl->Aro->save($aronode);
        return true;
    }
}
?>