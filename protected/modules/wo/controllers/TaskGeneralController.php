<?php

class TaskGeneralController extends Controller
{
	/**
	 * @return array actions
	 */
   
  public function filters()
{
return array(
'accessControl',
'ajaxOnly'
);
}

  
	public function actions()
	{
           return array(
			'suggestLocations'=>array(
				'class'=>'application.extensions.actions.XSuggestAction',
				'modelName'=>'Locations',
				'methodName'=>'suggest',
			),
               'suggestCeco'=>array(
				'class'=>'application.extensions.actions.XSuggestAction',
				'modelName'=>'Cc',
				'methodName'=>'suggestceco',
			),
               
                   ); 
            
            
        }


  



	
        
        
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('prueba'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('suggestLocations','suggestCeco'),
				//'ips'=>$this->ips,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
}
