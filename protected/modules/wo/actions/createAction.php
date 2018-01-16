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
       // echo "hola"; die();
       // $model->save();
      if ($model->save()){
       MiFactoria::mensaje('success',yii::t('woModule.messages','Location has been created '));
        $controller->redirect('admin');
      }else{
          print_r($model->geterrors());die();
      }
    }
     $controller->render('create_'.$this->scenario, array(
        'model' => $model,
    ));    
    }
    
  
}