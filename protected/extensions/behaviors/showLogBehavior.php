<?php

class showLogBehavior extends CActiveRecordBehavior {

   private function getCriteria(){
       $cri=New CDbCriteria();
       $cri->addCondition("idModelReal=:vid2 and model=:vmodel and field=:vfield");
       $cri->params=array(
           ":vid2"=>$this->_identidad,
           ":vmodel"=>get_class($this->owner),
           ":vfield"=>$this->_campo,
       );
      return $cri;
   }
   
  private function getData(){
      
  }
}
