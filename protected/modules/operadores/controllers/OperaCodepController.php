<?php

class OperaCodepController extends Controller
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
				'actions'=>array('confirmMaterials',   'MyMaterials',   'MyConsole',    'createEvent',    'PickDate',   'updateMeasure','createMeasure',    'Measures',   'updateDailyReport',   'admin','create','update','createDailyReport'),
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
		$model=new OperaCodep;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OperaCodep']))
		{
			$model->attributes=$_POST['OperaCodep'];
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

		if(isset($_POST['OperaCodep']))
		{
			$model->attributes=$_POST['OperaCodep'];
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
		$dataProvider=new CActiveDataProvider('OperaCodep');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OperaCodep('search');
               // var_dump($model->fotoprimera());die();
               $model->unsetAttributes();  // clear any default values
		if(isset($_GET['OperaCodep']))
			$model->attributes=$_GET['OperaCodep'];   
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OperaCodep the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OperaCodep::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OperaCodep $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='opera-codep-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
      
     public function actioncreateDailyReport(){
         $this->isOwner();
         $this->filterfecha();
         
            $model=new Dailywork('parte');
                 //$model->valorespordefecto();
                 $model->fecha=$_GET['fecha'];
                 //$model->codestado=$model::ESTADO_PREVIO;
                 $model->codep=$_GET['codep'];
                 //$model->codproyecto=ot::
                 $turnoid= Dailywork::getIdShift();
               //  $turnoid=1;
                 if($turnoid <0)
                  throw new CHttpException(500,'Registre turnos  ');
	//var_dump($turnoid);die();
                 $model->hidturno=$turnoid;
                 $model->codresponsable= Trabajadores::getCodigoFromUsuario(yii::app()->user->id);
		
			if($model->save()){                            
                            $model->refresh();
                            //$this->isOwnerParte($model->id,$model->codep);                           
                            $this->creaeventos($model->id,$model->codep);
                            
                             MiFactoria::Mensaje('success', 'Daily woksheet, created. Please Now, fill detail data');
		             $this->redirect(array('updateDailyReport','id'=>$model->id));                           
                                        }
				
                  $criterio=new CDbCriteria();
                                
                if(is_null($model->codproyecto)){
                    $criterio->addCondition("1=1");
                }else{
                     $criterio->addCondition("codproyecto=:vcodproyecto");
                      $criterio->params=array(":vcodproyecto"=>$model->codproyecto);
                }
		$this->render('create_parte',array(
			'model'=>$model,
                         'criterio'=>$criterio,
                        		));
     }   
     
     
     public function actionupdateDailyReport($id){
         
         $id= MiFactoria::cleanInput($id);
         $model=$this->loadParte($id);
         //var_dump($model);die();
         $this->isOwnerParte($id,$model->codep);
         if(!($model->neventos > 0))
         $this->creaeventos($id,$model->codep);
         $this->render('create_parte',array(
			'model'=>$model,
                         //'criterio'=>$criterio,
                        		));
         
     }
     
     private function loadParte($id){
        $registro= Dailywork::model()->findByPk($id);
        if(is_null($registro))
            throw new CHttpException(404,'no existe el registro ');
        return $registro;
     }
     
     
     public function isOwner(){
         if(!(isset($_GET['codep']) and isset($_GET['codof'])))
            throw new CHttpException(404,'Especifique parametros');
	  
         $codep= MiFactoria::cleanInput($_GET['codep']);
         $codof= MiFactoria::cleanInput($_GET['codof']);
         $valores=OperaCodep::getEp();
       if(is_null($valores)){
           throw new CHttpException(500,'NO se encuentra registrado en esta instancia ');
		
       }else{
          if($valores['barco'] ==$codep and $valores['ofic']==$codof){
              return true;
         
              
          }else{
              throw new CHttpException(500,'Intenta ingresa a una instancia que no es suya');
	 
          }
       }
          
     }
     
     //crewa los evnetows minimos para el parte diario 
     private function creaeventos($id,$codep){
         $filas=Operamedidas::model()->findAll();
         foreach($filas as $fila){
            // var_dump($fila);die();
             
             if($fila->obligatorio=='1'){
                 //echo "die();";die();
                 $regevento=new Dailyevents('medida');
                            $regevento->setAttributes(
                                ARRAY(
                                        'codcriticidad'=>'C',
                                        'hidparte'=>$id,
                                       // 'hidequipo'=>$equipo->idinventario,
                                        'descripcion'=>$fila->descripcion,
                                         'hidmedida'=>$fila->id,
                                            )
                                            );
                             if(!$regevento->save()){print_r($regevento->geterrors());die();}
                 //unset($regevento);
                 continue;
             }
             if($fila->requireid=='1'){
                // echo "salio ";die();
                 //si requiere un equipo 
                // var_dump($codep);die();
                 $equipos= Inventario::equipmentsForShip($codep);
                 foreach($equipos as $equipo){
                    
                     if($equipo->hasPoints()){ //si el equipo tiene horometros u otro punto de meidad 
                        //echo "salio ";die();
                         $regevento=new Dailyevents('medida');
                            $regevento->setAttributes(
                                ARRAY(
                                        'codcriticidad'=>'C',
                                        'hidparte'=>$id,
                                        'hidequipo'=>$equipo->idinventario,
                                        'descripcion'=>$fila->descripcion,
                                         'hidmedida'=>$fila->id,
                                            )
                                            );
                             $regevento->save();
                     }
                     
                 }
             }
             
         }
         
     }
     
     
     private function isOwnerParte($id,$codep){
         $valores= OperaCodep::getEp();
          if(is_null($valores)){
           throw new CHttpException(500,'NO se encuentra registrado en esta instancia ');
		
       }else{
           //var_dump($valores['barco']);var_dump($codep);die();
          if($valores['barco'] ==$codep ){
             $parte=$this->loadParte($id);
             
              if($parte->codep==$valores['barco']){
                  
              }else{
                 throw new CHttpException(500,'Intenta modificar un parte de otra instancia ');
	  
              }
         
              
          }else{
              throw new CHttpException(500,'Intenta ingresa a una instancia que no es suya');
	 
          }
       }
     }
     
     
    public function actionMeasures(){
       $model=new Operamedidas ('search');
               // var_dump($model->fotoprimera());die();
               $model->unsetAttributes();  // clear any default values
		if(isset($_GET['Operamedidas']))
			$model->attributes=$_GET['Operamedidas'];   
		$this->render('admin_medidas',array(
			'model'=>$model,
		));
    } 
     
     public function actioncreateMeasure(){
       $model=new Operamedidas ('insert');
               // var_dump($model->fotoprimera());die();
               //$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Operamedidas'])){
                    $model->attributes=$_POST['Operamedidas']; 
                    $model->save();
                    MiFactoria::Mensaje('success', 'Se creo la medida');
                    $this->redirect(array('measures'));
                }
			  
		$this->render('_form_medidas',array(
			'model'=>$model,
		));
    }
    public function actionupdateMeasure($id){
       $model= Operamedidas::model()->findByPk($id);
       if(is_null($model))
         throw new CHttpException(500,'No existe esta medida');
	    
               // var_dump($model->fotoprimera());die();
               //$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Operamedidas'])){
                    $model->attributes=$_POST['Operamedidas']; 
                    $model->save();
                    MiFactoria::Mensaje('success', 'Se Modifico la medida');
                    $this->redirect(array('measures'));
                }
			  
		$this->render('_form_medidas',array(
			'model'=>$model,
		));
    }
    
    public function actionPickDate(){
        $valores= OperaCodep::getEp();
        if($valores){
            $this->render('calendario',array('barco'=>$valores['barco'],'oficio'=>$valores['ofic']));
        }else{
            throw new CHttpException(500,'Intenta ingresa a una instancia que no es suya');
	  
        }
        
    }
    private function filterfecha(){
        if(isset($_GET['fecha'])){
            $fecha=$_GET['fecha'];
           if(!preg_match ('/[0-3]{1}[0-9]{1}\-[0-1]{1}[0-9]{1}\-[1-2]{1}[0|9]{1}[0-9]{2}$/', $fecha))
            if(!preg_match ('/[1-2]{1}[0|9]{1}[0-9]{2}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}$/',$fecha))
                   throw new CHttpException(500,'El formato de fecha no es valido');      
        }
    }
    private function isMotorista(){
        $valores= OperaCodep::getEp();
          if($valores===false){
              
          }else{
              return $valores;
          }
           	
    }
    
  public function actionCreateEvent(){
       $id=$_GET['id'];
       $padre=$this->loadParte($id);
       //$padre=Dailywork::model()->findByPk(MiFactoria::cleanInput($id));
              // $cata= Dailywork::model()->findByPk(MiFactoria::cleanInput($id));
          $cata=New Dailyevents('parte'); 
         
               if(isset($_POST[get_class($cata)])){
                   $cata->attributes=$_POST[get_class($cata)];
			if($cata->save()){
                          echo CHtml::script("window.parent.$('#cru-dialog4').dialog('close');
									window.parent.$('#cru-frame4').attr('src','');
									window.parent.$.fn.yiiGridView.update('cuentas-grid');
					");
					Yii::app()->user->setFlash('success', " Se grabaron los datos  ");
					yii::app()->end();  
                        }else{
                            echo yii::app()->mensajes->getErroresItem($cata->geterrors());
                        
                            die();
                        }
                            	
                            
			
               }
               if(isset($_GET['asDialog']))
               $this->layout = '//layouts/iframe';
               $this->render('_form_evento',array(
                   'idpadre'=>$padre->id,'codep'=>$padre->codep,
                'model'=>$cata      ));
             
  }
  
  //Panel de control del motorista 
  public function actionMyConsole(){
     $this->render('consola'); 
  }
  
  public function actionMyMaterials(){
       $valores= OperaCodep::getEp();
          if(is_null($valores))
           throw new CHttpException(500,'NO se encuentra registrado en esta instancia ');
     $modelo=New VwGuia('search_opera');
          $proveedor= $modelo->search_opera($valores['barco'],
              $modelo::ESTADO_DETALLE_CREADA);
          //$pr=$proveedor->getdata();
      $this->render('materiales',array('proveedor'=>$proveedor));
  }
  
  public function actionConfirmMaterials($id){
      $id= (integer)MiFactoria::cleanInput($id);
      $registro=Detgui::model()->findByPk($id);
      if(!is_null($registro)){
         if($registro->delete()){
             echo "Se confirmo la recepción del material : ".$registro->c_descri;
         }else{
            echo "Hubo errores :".yii::app()->mensajes->getErroresItem($registro->geterrors()); 
         }
             
      }else{
          echo "No se encontro el registro con el Id ".$id;
      }
      
      
  }
  
  
}
