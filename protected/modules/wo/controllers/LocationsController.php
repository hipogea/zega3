<?php

class LocationsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array('accessControl',array('CrugeAccessControlFilter'));
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		Yii::app()->user->loginUrl = array("/cruge/ui/login");
		
		return array(
			
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('fillLocations',  'createmaster', 'index',  'createroot','admin','view',  'create','update'),
				'users'=>array('@'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

        public function actions(){
            $pathClass='application.modules.wo.actions.createAction';
            return array(
                        'create'=>array(
                        'class'=>$pathClass,
                        'model'=> ucfirst($this->id),
                         'scenario'=>'insert', 
                            ),
                
                     'createmaster'=>array(  //para crear aquelloos que son nodos padres pricipales
                         'class'=>$pathClass,
                       'model'=> ucfirst($this->id),
                         'scenario'=>'master', 
                            ),
                                    
                          'createroot'=>array(//crear el nodo root
                         'class'=>$pathClass,
                       'model'=> ucfirst($this->id),
                         'scenario'=>'root', 
                            ),
                
                'fillLocations'=>array(
                'class'=>'ext.actions.XFillTreeAction',
                'modelName'=>'Locations',
	//'rootId'=>1,
	            'showRoot'=>true

                    ),
                
                
                
                                    );
            
            
            
                        }
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate()
               
	{
            var_dump(WoConfig::getPattern());DIE();
            var_dump($this->getModule()->getComponent('config'));die();
            
		$model=new Locations;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Locations']))
		{
			$model->attributes=$_POST['Locations'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Locations']))
		{
			$model->attributes=$_POST['Locations'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Locations');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Locations('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Locations']))
			$model->attributes=$_GET['Locations'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Locations the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Locations::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Locations $model the model to be validated
	 */
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='locations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
