<?php
/**
 * Behavior que gestiona la relacion con las tablas sunat 
 * 
 *
 * @author Julian Ramirez neotegnia@gmail.com
 * @version 1.0.0
 * 
 */
class measurePointBehavior extends CActiveRecordBehavior
{
  /*
 * Comportamiento para hacer que los objetos 
 * logren gestionar los putnos de medaid  u horomatros 
 *
 * @author Julian Ramirez neotegnia@gmail.com
 * @version 1.0.0
 * 
 */
   
  
    
    /*
     * Esta funcion permite agregar los errores de lo spuntos mde medida e incporparalois
     * a los erreos del Owner; de este modo l
     */
    /*
     * 
     */   

    
    /* Objeto que hace rrefrencia al punto de medidad manttolecturahorometros */
private $_measure=null ;
    /* NOmbre del campo que apunta al id del objeto measure*/

public $nameField=null;


public $dateOfMeasure=null;

public $idPoint=null;

/*El valor de la medida*/
public $valueMeasure=null;


public function init(){
    //verificando que la medida pertenezca al horoemtro
    
    return parent::init();
}


private function addErrorsToOwner($errors){
  foreach($errors as $error)
   $this->owner->addError($this->nameField, $error[0]);
}


        
private function getMeasurePointObject(){
     //var_dump($this->owner->{$this->nameField});
  if(!is_object($this->_measure))
    if(!$this->isNewMeasure()){
        $this->checkPoint();//verificando consitencia 
        $this->_measure= Manttolecturahorometros::model()-> 
        findByPk($this->owner->{$this->nameField});
    }ELSE{
       $this->_measure= New Manttolecturahorometros;
      
    }
    
}

/*
 *  
 */
public function UpdateAttributtesMeasurePoint(){

    $this->_measure->setAttributes(
               array(
                   'hidhorometro'=>$this->idPoint->id,
                   'fecha'=>$this->dateOfMeasure,
                   'lectura'=>preg_replace("/[\xA0\xC2]/", "",$this->valueMeasure),
               )
               ); 
}


public function putMeasureInPoint(){
    
     $this->getMeasurePointObject();
    $this->UpdateAttributtesMeasurePoint();
     if($this->_measure->save()){
         // echo "que paso "; die();
         $this->_measure->refresh();
        $this->updateFieldIdOwner();//actualiza el campo del owner con el ID del meausre siemrpe y cuando sea unno nuevio
          $this->resetFields(); //importante 
        return true;
    }else{
       // echo "jhola "; die();
       $this->addErrorsToOwner($this->_measure->getErrors()) ;
       return false;
    }
}

public function DeleteMeasureInPoint(){
    if(!is_object($this->_measure))
     $this->getMeasurePointObject();
    if(!$this->_measure->isNewRecord)
    if($this->_measure->delete()){
        return true;
    }else{
       $this->addErrorsToOwner($this->_measure->getErrors()) ;
       return false;
    }
}

private function isNewMeasure(){
    return (!$this->owner->{$this->nameField})>0;
}

private function checkPoint(){
    if(!$this->isNewMeasure()){
      IF($this->_measure->isMeasureFromThis($this->owner->{$this->nameField}))
          RETURN TRUE;
      throw new CHttpException(500,yii::t('errvalid','This Id Measure {medida} don match with Point {punto} ',array('{punto}'=>$this->idPoint,'{medida}'=>$this->owner->{$this->nameField})));
          
    }
    RETURN TRUE;
        
}

public function hola(){
   return "siii"; 
}

private function updateFieldIdOwner(){
    if($this->isNewMeasure()) 
    $this->getMeasurePointObject();
    if($this->_measure->id >0)
    $this->owner->{$this->nameField}=$this->_measure->id;
}

private function resetFields(){
    $this->_measure=null;
    $this->dateOfMeasure=null;
    $this->idPoint=null;
    $this->valueMeasure=null;
    //$this->dateOfMeasure
}
}