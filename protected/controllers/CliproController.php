<?php

class CliproController extends Controller
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
				'actions'=>array('view','Excel','muestraofertas','Actualizamateriales','actualizaobjeto','admin','cargaums','creamaterial','creaobjeto','agenda','actualizadirecciones','creacontacto','creadireccion','create','update'),
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
		$model=$this->loadModel($id);
		//$filtro1=$model->attributes['razondestinatario'];
		$modelodirecciones = new Direcciones;
		$modelocontactos =new Contactos;
		$modeloobjetos=new ObjetosCliente;
		$criteriazo=new CDbCriteria;
		$criteriazo->condition = "c_hcod ='".$model->codpro."'";
		//$criteria->compare('razondestinatario', 'SOLTE',true);
		//$criteria->compare('descripcion', 'ADE',true);
		//echo $model->attributes['descripcion'];
		$proveedor = new CActiveDataProvider($modelodirecciones, array(
			'criteria'=>$criteriazo,
		));
		//$this->render('busca',array('model'=>$model,'proveedor'=>$proveedor));
		//$modelodirecciones=Direcciones::find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro));
		//$modelocontactos =Contactos::model()->find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro));
		$proveedor2= new  CActiveDataProvider($modelocontactos, array(
			'criteria'=>$criteriazo,
		));
		$criteriazo1=new CDbCriteria;
		$criteriazo1->condition = "codpro ='".$model->codpro."'";
		$proveedor3= new  CActiveDataProvider($modeloobjetos, array(
			'criteria'=>$criteriazo1,
		));

		$this->render('view',array('model'=>$model,'proveedor'=>$proveedor,'proveedor2'=>$proveedor2,'proveedor3'=>$proveedor3));



	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		$model=new Clipro;
		$model->codestado='99'; //creado

		if(isset($_POST['Clipro']))
		{
			$model->attributes=$_POST['Clipro'];
			$ruc=$model->rucpro;
			if($model->save()) {
			    //$criteria = new CDbCriteria;  
				//$criteria->condition = "rucpro=':rucpro'";
				//$criteria->params = array(':rucpro' => $ruc);
				if($model->nobjetos==0){
					$modeloobjeto=new ObjetosCliente();
					$modeloobjeto->nombreobjeto='OBEJTO1';
					$model->refresh();
					$modeloobjeto->codpro=$model->codpro;
					$modeloobjeto->save();
					//yii::app()->end();
				}
				if($model->ndirecciones==0 ){
					$modelodireccion=new Direcciones();
					$modelodireccion->c_direc=$model->direcciontemp;
					$model->refresh();
					$modelodireccion->c_hcod=$model->codpro;
					$modelodireccion->coddepa='01';
					$modelodireccion->codprov='01';
					$modelodireccion->coddist='01';
					$modelodireccion->cospostal='51';
					$modelodireccion->save();
					//yii::app()->end();
				}
			   $model2=$model->find('rucpro=:rukis', array(':rukis'=>$ruc));
				//Yii::app()->user->setFlash('success','Se ha creado el proveedor  '.$model2->despro);
				MiFactoria::mensaje('success','Se ha creado el proveedor, complete los datos si lo desea');
                           $this->redirect(array('view','id'=>$model2->codpro));
                           yii::app()->end();
				//return true;
				}
			//$this->refresh();
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	
	
public function ActionExcel()
	{
	$d = new CActiveDataProvider('Inventario');
	$data=$d->getData();
	// count($data);
	 $this->render('ju',array('data'=>$data));
	 
//Yii::import('application.extensions.phpexcel.JPhpExcel');
//$xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
//$xls->addArray($data);
//$xls->generateXML('my-test');
	
	 }
	 
	 
	 
	public function actionCreacontacto()
	{
		$model=new Contactos;
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		if(isset($_POST['Contactos']))
		{
				$model->attributes=$_POST['Contactos'];
				if($model->save()) {
										if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog2').dialog('close');window.parent.$('#cru-frame2').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
								}else {
								}
		}
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_contactos',array('model'=>$model,'codpro'=>$_GET['codpro']));
		
	}
	
	public function actionCreamaterial()
	{
		$model=new Maestroclipro;
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		if(isset($_POST['Maestroclipro']))
		{
				$model->attributes=$_POST['Maestroclipro'];
				if ($model->validate()) {
				$model->save();
										if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog4').dialog('close');window.parent.$('#cru-frame4').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}

					}
		}
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_materiales',array('model'=>$model,'codpro'=>$_GET['codpro']));
		
	}
	

	public function actioncargaums()
	{
		$valor=$_POST['Maestroclipro']['codart'];
		$valores=Alconversiones::model()->findall("codart='".$valor."'");
		$values = array();
		$otro="";
			foreach($valores as $registro) {$values[] = $registro['um2']; $otro=$registro['um1'];}
			array_push($values,$otro );

		$criteria = new CDbCriteria();
		$criteria->addInCondition('um',$values);
		
		$data=CHtml::listData(	Ums::model()->findAll( $criteria),
		  //$data=CHtml::listData(	Direcciones::model()->findAll(),
												"um",
												"desum"
											
												); 
			echo CHtml::tag('option', array('value'=>null),CHtml::encode('Escoja una uM'),true);
			foreach($data as $value=>$name) { 
			    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			   } 
	}


	
	public function actionCreaobjeto()
	{
		$model=new ObjetosCliente;
		// Uncomment the following line if AJAX validation is needed
		$codpro=MiFactoria::cleanInput($_GET['codpro']);
		$modelclipro=$this->loadModel($codpro);
		$model->codpro=$codpro;
		 $this->performAjaxValidation($model);
		if(isset($_POST['ObjetosCliente']))
		{
				$model->attributes=$_POST['ObjetosCliente'];
				if($model->save()) {
										if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog5').dialog('close');window.parent.$('#cru-frame5').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
								}else {
								//Yii::app()->end();
								//echo CHtml::script("window.parent.$('#cru-dialog5').dialog('close');window.parent.$('#cru-frame5').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
									print_r($model->getErrors());
					Yii::app()->end();
								}
		}
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_objetos',array('model'=>$model,'codpro'=>$_GET['codpro']));
		
	}

    public function actionActualizaobjeto($id)
    {
        $model=ObjetosCliente::model()->findByPk($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if(isset($_POST['ObjetosCliente']))
        {
            $model->attributes=$_POST['ObjetosCliente'];
            if($model->save()) {
                if (!empty($_GET['asDialog']))
                {
                    //Close the dialog, reset the iframe and update the grid
                    echo CHtml::script("window.parent.$('#cru-dialog5').dialog('close');window.parent.$('#cru-frame5').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
                    Yii::app()->end();
                }

            }
        }
        if (!empty($_GET['asDialog']))
            $this->layout = '//layouts/iframe';
            $this->render('_form_objetos',array('model'=>$model,'codpro'=>$_GET['codpro']));

    }
	
	
	
	
	public function actionCreadireccion()
	{
		$model=new Direcciones;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
			

		if(isset($_POST['Direcciones']))
		{
				$model->attributes=$_POST['Direcciones'];
				if($model->save()) {
										if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
			  
										
				
								}else {
								}
		
		
		//----- begin new code --------------------
				//if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
    //----- end new code --------------------
		
		
		
		}
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_direcciones',array('model'=>$model,'codpro'=>$_GET['codpro']));
		
	}
	
	
	
	public function actionActualizadirecciones($id)
	{
		$model=Direcciones::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
			

		if(isset($_POST['Direcciones']))
		{
				$model->attributes=$_POST['Direcciones'];
				if($model->save()) {
										if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
			  
										
				
								}else {
								}
		
		
		//----- begin new code --------------------
				//if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
    //----- end new code --------------------
		
		
		
		}
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_direcciones',array('model'=>$model,'codpro'=>$model->c_hcod));
		
	}

	public function actionActualizamateriales($id)
	{
		$model=Maestroclipro::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
			

		if(isset($_POST['Maestroclipro']))
		{
				$model->attributes=$_POST['Maestroclipro'];
				if($model->save()) {
										if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog4').dialog('close');window.parent.$('#cru-frame4').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}
			  
										
				
								}else {
								}
		
		
		//----- begin new code --------------------
				//if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
    //----- end new code --------------------
		
		
		
		}
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
		$this->render('_form_materiales',array('model'=>$model,'codpro'=>$model->codpro));
		
	}
	
	 /* If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Clipro']))
		{
					$model->attributes=$_POST['Clipro'];
				if($model->save()) {
										/*if (!empty($_GET['asDialog']))
												{
													//Close the dialog, reset the iframe and update the grid
													echo CHtml::script("window.parent.$('#cru-dialog').dialog('close');window.parent.$('#cru-frame').attr('src','');window.parent.$.fn.yiiGridView.update('{$_GET['gridId']}');");
														Yii::app()->end();
												}*/
										//ASUSTANDO AL USUARP APRA QUE LLEN LAS DIRECIONES
					Yii::app()->user->setFlash('success','Se ha actualizado los datos del  proveedor  '.$model->despro);

					Direcciones::model()->find("c_hcod=:codigo", array(":codigo"=>$model->codpro));
										 if (is_null(Direcciones::model()->find("c_hcod=:codigo", array(":codigo"=>$model->codpro)))) 
										  {
										    $this->redirect(array('update','id'=>$model->codpro));
										  }else {
											$this->redirect(array('view','id'=>$model->codpro));							  
										   }


				}
		
		if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
    //----- end new code --------------------
		
	//	$this->render('update',array('model'=>$model,'proveedor'=>$proveedor,'proveedor2'=>$proveedor2));
		
		
		}
		
		
						//$filtro1=$model->attributes['razondestinatario'];
					$modelodirecciones = new Direcciones;
					$modelocontactos =new Contactos;
					$modeloobjetos=new ObjetosCliente;
						$criteriazo=new CDbCriteria;
						$criteriazo->condition = "c_hcod ='".$model->codpro."'";
							//$criteria->compare('razondestinatario', 'SOLTE',true);
							//$criteria->compare('descripcion', 'ADE',true);
								//echo $model->attributes['descripcion'];
								$proveedor = new CActiveDataProvider($modelodirecciones, array(
									'criteria'=>$criteriazo,
									));	
								//$this->render('busca',array('model'=>$model,'proveedor'=>$proveedor));
							//$modelodirecciones=Direcciones::find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro));
							//$modelocontactos =Contactos::model()->find('c_hcod=:c_hcod', array(':c_hcod'=>$model->codpro));
						$proveedor2= new  CActiveDataProvider($modelocontactos, array(
									'criteria'=>$criteriazo,
									));
									$criteriazo1=new CDbCriteria;
						$criteriazo1->condition = "codpro ='".$model->codpro."'";
						$proveedor3= new  CActiveDataProvider($modeloobjetos, array(
									'criteria'=>$criteriazo1,
									));			
									
									
		 //----- begin new code --------------------
				if (!empty($_GET['asDialog']))
					$this->layout = '//layouts/iframe';
    //----- end new code --------------------
		
		$this->render('update',array('model'=>$model,'proveedor'=>$proveedor,'proveedor2'=>$proveedor2,'proveedor3'=>$proveedor3));
		
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
		$dataProvider=new CActiveDataProvider('Clipro');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		
		$model=new Clipro('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Clipro']))
			$model->attributes=$_GET['Clipro'];
			if (isset($_GET['espe'])) {
			         // $this->render('ju',array('data'=>$model->search()->getdata()));
					$modelito=new Clipro('search_');
					$modelito->unsetAttributes();  // clear any default values
					if(isset($_GET['Clipro']))
						$modelito->attributes=$_GET['Clipro'];
						$data=$modelito->search_()->getdata();
						Yii::import('application.extensions.phpexcel.JPhpExcel');
						$xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
						$xls->addArray($data);
						$xls->generateXML('my-test');
							Yii::app()->end();
			           } 
		$this->render('admin',array(
			'model'=>$model,
		));
		
		
	}


	/**
	 * Manages all models.
	 */
	public function actionAgenda()
	{
		
		$model=new VwContactos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VwContactos']))
			$model->attributes=$_GET['VwContactos'];
			
		$this->render('contactos',array(
			'model'=>$model,
		));
		
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Clipro::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'El enlace o direccion solicitado no existe');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='clipro-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function  actionMuestraofertas(){
		$this->layout='//layouts/columnclipro';

			$externo=yii::app()->user->um->getFieldValue(yii::app()->user->id,'externo');
			$codigoprov=yii::app()->user->um->getFieldValue(yii::app()->user->id,'codpro');
	   if($externo=='1'){
		   $this->render('vw_materialesoferta',array('codpro'=>$codigoprov));
	   }else{

	   }
	}
}
