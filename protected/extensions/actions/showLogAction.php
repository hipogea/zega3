<?php
/**
 * showLogAction action
 *
 * This action returns data for 
 *
 * The following shows how to use XFillTreeAction action
 *
 * First set up the action on RequestController actions() method:

 */
class showLogAction extends CAction
{
   
    public $methodName='showLog';
    private $_nameField=null;
    /**
     * @var int id of the node that is taken as root node.
     */
   
    public function run()
    {
         if(!isset($_GET['root'])||$_GET['root']=='source')
        {
           $rootId=$this->rootId;
            $showRoot=$this->showRoot;
              }
        else
        {
           $rootId=$_GET['root'];
            $showRoot=false;
        }
         $dataShow=$this->getModel()->{$this->methodName}();
        echo CTreeView::saveDataAsJson($dataTree);
    }
    /**
     * @return CActiveRecord
     */
    protected function getModel()
    {
        return CActiveRecord::model($this->modelName);
    }
}