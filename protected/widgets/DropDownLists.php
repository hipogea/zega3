<?php
class DropDownLists extends CWidget
{
  public $namemodels=array('Centros','Almacenes');
  public $namemodel=null;
  
  public function init(){
      if(!(in_array($this->namemodel,$this->namemodels)))
           throw new CHttpException(500,yii::t('errors',"The model {model} isn't in model lists the Widget",array('{model}'=>$this->namemodel)));
         
  }
  
  

	public function run()
	{
                $name=$this->namemodel;
                $datos = CHtml::listData($name::model()->findAll(),$fields[0],$fields[1]);
                
	echo $form->DropDownList($model,'codocu',$datos, array('empty'=>'--Seleccione un clase --')  )
	
	}
        
   
   

}
