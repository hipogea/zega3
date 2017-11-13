<?php

class ListamaterialesController extends Controller
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
				'actions'=>array('create','view','admin','update','Agregamaterial','Ajaxborramaterial'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Listamateriales;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Listamateriales']))
		{
			$model->attributes=$_POST['Listamateriales'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

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

		if(isset($_POST['Listamateriales']))
		{
			$model->attributes=$_POST['Listamateriales'];
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
		$dataProvider=new CActiveDataProvider('Listamateriales');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Listamateriales('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Listamateriales']))
			$model->attributes=$_GET['Listamateriales'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAjaxborramaterial()
	{
		$identidad=(int)$_GET['id'];
		$modeloaborrar=Dlistamaeriales::model()->findByPk($identidad);
		if(!is_null($modeloaborrar)){
			$modeloaborrar->delete();
			ECHO "BORRO";
		} ELSE {
			ECHO "NO ENCONTRO";
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAgregamaterial($idcabeza)
	{
		$idcabeza=(int)$idcabeza;
		$modelocabeza=Listamateriales::model()->findbypk($idcabeza);
		if(is_null($modelocabeza))
			throw new CHttpException(500,'No existe esta lista con este ID');
		$model=new Dlistamaeriales();
		$model->hidlista=$modelocabeza->id;
		if(isset($_POST['Dlistamaeriales']))
		{
			$model->attributes=$_POST['Dlistamaeriales'];
			if($model->save())
				if (!empty($_GET['asDialog']))
				{
					//Close the dialog, reset the iframe and update the grid
					echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');
													                    window.parent.$('#cru-detalle').attr('src','');
																		window.parent.$.fn.yiiGridView.update('detalle-grid');
																		");
					Yii::app()->end();
				}


		}
		// if (!empty($_GET['asDialog']))
		$this->layout = '//layouts/iframe';
		$this->render('_formdetalle',array(
			'model'=>$model, 'idcabeza'=>$idcabeza
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Listamateriales the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Listamateriales::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Listamateriales $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='listamateriales-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
