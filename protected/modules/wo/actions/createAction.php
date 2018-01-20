<?php

class createAction extends CAction
{
    public $model;
    public $scenario;
   public function run() {
    
 $controller=$this->getController();
    // get the Model Name
    $model_class = $this->model; 
    // create the Model
    $model = new $model_class($this->scenario); 
    // Uncomment the following line if AJAX validation is needed
     $controller->performAjaxValidation($model);
    if (isset($_POST[$model_class])) {
        $model->attributes = $_POST[$model_class]; 
       //echo "hola"; die();
       //VAR_DUMP($model->save());DIE();
         
      if ($model->save()){
          //ECHO "ERROR ERE";DIE();
       MiFactoria::mensaje('success',yii::t('woModule.messages','Location {location} has been created ',array('{location}'=>$model->codigo)));
        $controller->redirect('admin');
      }else{
         // ECHO "ERROR";DIE();
          print_r($model->geterrors());die();
      }
    }
     $controller->render('create_'.$this->scenario, array(
        'model' => $model,
    ));    
    }
    
  
}