<?php

class ConfiguracionController extends Controller
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

	public function accessRules()
	{
		Yii::app()->user->loginUrl = array("/cruge/ui/login");
		return array(
			
			array('allow',
                            'actions'=>array('SettingsModules',  'creaparametro','admin','RefreshMenu',   'ajaxEditHidparentMenu',    'ajaxEditAliasMenu',   'ajaxActivate',     'menu',    'editar','index','ver','creaconfig'),
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
		$model=new Settings;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
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

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

private function pasadatos($model){
	foreach($model->getAttributes() as $clave=>$valor){
		$categoria=explode("_",$clave)[0];
		$nombreparametro=$clave;
		$valorparametro=$valor;
		Yii::app()->settings->set($categoria, $nombreparametro,$valorparametro, $toDatabase=true);

	}
	//$this->redirect(yii::app()->getBaseUrl(true));
	
}

	private function sacadatos($model){
		foreach($model->getAttributes() as $clave=>$valor){
			$categoria=explode("_",$clave)[0];
			//$nombreparametro=$clave;
			//$valorparametro=$valor;
			$model->{$clave}=Yii::app()->settings->get($categoria, $clave);

		}


	}

	public function actionIndex()
	{
		//$this->getActionsFromAll();die();
            $model=New Configuraciongeneral();
		
		if(isset($_POST['Configuraciongeneral']))
		{

			//Yii::app()->end();
			$model->attributes=$_POST['Configuraciongeneral'];
			if(!$model->validate())
			{
				$this->pasadatos($model);
                                $this->render("ver",array("model"=>$model));
                                //$this->redirect(array($this->id."/ver"));
                                
			}
		} else {
			$this->sacadatos($model);
			$this->render('configuracion',array(
				'model'=>$model,
			));

		}
	}


public function actionver(){
    $model=New Configuraciongeneral();
    $this->sacadatos($model);
    $this->render("ver",array("model"=>$model));
    /*print_r(Yii::app()->settings->get('email'));
	echo "<br>";
	print_r(Yii::app()->settings->get('af'));
	echo "<br>";
	print_r(Yii::app()->settings->get('materiales'));
	echo "<br>";
	print_r(Yii::app()->settings->get('colectores'));
	echo "<br>";
	print_r(Yii::app()->settings->get('compras'));
	echo "<br>";
	print_r(Yii::app()->settings->get('Inventario'));
	echo "<br>";
	print_r(Yii::app()->settings->get('transporte'));
	echo "<br>";
	print_r(Yii::app()->settings->get('general'));
	echo "<br>";
	print_r(Yii::app()->settings->get('documentos'));
	echo "<br*/
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Configuracion('search');
                //var_dump($model);die();
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Configuracion']))
			$model->attributes=$_GET['Configuracion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Settings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Settings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Settings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='settings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actioncreaparametro(){
            $model = new Configuracion();
        if (isset($_POST['Configuracion'])) {
            $model->attributes = $_POST['Configuracion'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('_form_config', array(
            'model' => $model,
        ));
        
        
        
        }
        
        public function actioneditar($id){
            $id=(integer)  MiFactoria::cleanInput($id);
            
		$model=  Configuracion::model()->findByPk($id);
                if(is_null($model))
                      throw new CHttpException(500,'No se encontro un registro para este Id.');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Configuracion']))
		{
			$model->attributes=$_POST['Configuracion'];
			if($model->save()){
                            MiFactoria::Mensaje('success', 'Se modifico el parametro');
                            $this->redirect(array('view','id'=>$model->id));
                        }
				
		}

		$this->render('edicion',array(
			'model'=>$model,
		));
            
        
             }
       
    //saca todos lsoc opntroladores  del a plaicaion 
      public function enumControllers()
    {
       
            $controladores = array();
            $p = Yii::app()->getControllerPath();
            foreach (scandir($p) as $f) {
                if ($f == '.' || $f == '..') {
                    continue;
                }
                if (strlen($f)) {
                    if ($f[0] == '.') {
                        continue;
                    }
                }
                if ($pos = strpos(strtolower($f), "controller.php")) {
                    
                    $f=strrev(substr(strrev($f),strpos(strrev($f),'.')+1));
                    //$controladores[$f]['name'] =  'application.controllers';
                     $controladores[$f]['pathalias'] =  'application.controllers';
                    $controladores[$f]['path'] =  '';
                    $controladores[$f]['module'] =  'none';
                }
            }
            $reton=array_merge($controladores,$this->getControllesPathsFromModules());
        // VAR_DUMP( $reton);DIE();
         return $reton;
        
    }
    
     public  function getControllesPathsFromModules()
	{
	$controladores=array();	
		
                    $p=Yii::app()->getModulePath();
                   foreach (scandir($p) as $f) 
                       {
                         $ruta=$p.DIRECTORY_SEPARATOR.$f;
                            if ($f == '.' || $f == '..') {
				continue;
				}
			     if (strlen($f)) {
				if ($f[0] == '.') {
						continue;
				}
				}
                         foreach (scandir($ruta) as $f1) {
				if($f1=="controllers"){
                                                    foreach (scandir($ruta.DIRECTORY_SEPARATOR.$f1) as $f2) {
                                                                if ($f2 == '.' || $f2 == '..') {
                                                                    continue;
                                                                    }
                                                                if (strlen($f2)) {
                                                                    if ($f2[0] == '.') {
                                                                    continue;
                                                                                    }
                                                                                }
                                                                                $f2=strrev(substr(strrev($f2),strpos(strrev($f2),'.')+1));
                                                                               // $f2=substr($f2,strpos($f2,'Controller'));
                                                                               // $controladores[$f2] = $f.'.'.$f1;
                                                                                 $controladores[$f2]['pathalias'] = $f.'.'.$f1;;
                                                                                $controladores[$f2]['path'] =DIRECTORY_SEPARATOR.$f.DIRECTORY_SEPARATOR;
                                                                                 $controladores[$f2]['module'] =  $f;
                                                                    }
                                                }
                                    }
                                
                         }
                         return $controladores;
	} 
                
         
   public function enumActions($ruta,$archivo)
    {
        $acciones= array();
        $className = $archivo;
        $rutascalar=$ruta['pathalias'];
        Yii::import($rutascalar.'.'.$archivo, true);  
        //echo $ruta.'.'.$archivo."<br>";die();
        $refx = new ReflectionClass($className);
        foreach ($refx->getMethods() as $method) {
            if ($method->name != 'actions') {
               //$acciones[]
                if (substr($method->name, 0, 6) == "action") {
                    $acciones[]= substr($method->name, 6);
                }
            }
        }
        
       // print_r($accionesT);
        RETURN $acciones;
    }
    
    public function  getActionsFromAll(){
        $acciones=array();
        //print_r(array_keys($this->enumControllers()));die();
        foreach ($this->enumControllers() as $clave=>$valor){
            $acciones[$clave]['actions']=$this->enumActions($valor, $clave);
            $acciones[$clave]['path']=$valor['path'];
             $acciones[$clave]['module']=$valor['module'];
        }
       // print_r($acciones);die();
       return $acciones; 
    }
    
    
    public function refreshTable(){
      // print_r($this->getActionsFromAll());die();
        $this->createRoootsMenu();
        foreach($this->getActionsFromAll() as $clave =>$valor){
            // var_dump($clave);var_dump($valor);die();
            $ruta=$valor['path'];
            $modulo=$valor['module'];
            
            foreach($valor as $clave_ =>$valor_){
               //var_dump($valor_);echo "<br><br>";
               if(is_array($valor_))
             foreach($valor_ as $clave__ =>$valor__){ 
                  
           if(!Menugeneral::existsMenu(str_replace('Controller','',$clave),$valor__)){
                //echo $modulo."<br>";
               $menu= New Menugeneral();
                $menu->setAttributes(
                        array(
                            'activa'=>0,
                            'codaccion'=>$valor__,
                            'ruta'=>$ruta,
                            'controlador'=>str_replace('Controller','',$clave),
                           'modulo'=>$modulo,
                        )
                        );
                        //var_dump($menu);
             if( !$menu->save())
                 print_r($menu->geterrors());
                
            }
             }  
                
            }
            }
        }
    
   
    public function actionMenu(){
     if(!yii::app()->request->isAjaxRequest){   
         $this->refreshTable();
     }
        
        $model=New Menugeneral('search_by_active');
        $model->unsetAttributes();  // clear any default values
		if(isset($_GET['Menugeneral']))
			$model->attributes=$_GET['Menugeneral'];
                //print_r($model->attributes);
        $this->render('tablamenu',array('model'=>$model));
        
    }
    
    /*
    * Esta funcion corrige la ruta de todos los controladoree
    * en caso de que se migre a otras rutas 
    * yii::app()->basPath
    */   
    public function actionRefreshMenu(){
         $this->resetTable();
         $this->refreshTable();    
         MiFactoria::Mensaje('notice', yii::t('menajes','Se reseteo la tabla de Menu'));
        $this->redirect('menu');
        
    }
    
    private function resetTable(){
       yii::app()->db->createCommand()-> 
             delete('{{menugeneral}}');
    }
    
    
    
    
    PUBLIC function actionajaxEditAliasMenu(){
        if(yii::app()->request->isAjaxRequest){ 
            if(isset($_POST['name'])and 
                   isset($_POST['value'])and
                       isset($_POST['pk'])/*and
                     //  isset($_POST['idlectura'])*/
                     ){
                   $value= MiFactoria::cleanInput(trim($_POST['value']));
                   $value=preg_replace("/[\xA0\xC2]/", "",$value);
                    $name= MiFactoria::cleanInput($_POST['name']);
                     $pk= MiFactoria::cleanInput($_POST['pk']);
                     // $idlectura= MiFactoria::cleanInput($_POST['idlectura']);
                 
                
                $registro= Menugeneral::model()->findByPk($pk);  
                if(is_null($registro))      
                    throw new CHttpException(500,'NO se encontro el registro con el id '.$id); 
                //$registro->setScenario('escalias');
                $registro->{$name}=$value;
                if($registro->save()){
                    echo yii::t('ajax','Change success');
                }else{
                    echo yii::t('ajax','Change fails...!');
                }
                
                }         
            }
    }
    
    
    PUBLIC function actionajaxEditHidparentMenu(){
        if(yii::app()->request->isAjaxRequest){ 
            if(isset($_POST['name'])and 
                   isset($_POST['value'])and
                       isset($_POST['pk'])/*and
                     //  isset($_POST['idlectura'])*/
                     ){
                   $value= MiFactoria::cleanInput(trim($_POST['value']));
                   $value=preg_replace("/[\xA0\xC2]/", "",$value);
                    $name= MiFactoria::cleanInput($_POST['name']);
                     $pk= MiFactoria::cleanInput($_POST['pk']);
                     // $idlectura= MiFactoria::cleanInput($_POST['idlectura']);
                 
                
                $registro= Menugeneral::model()->findByPk($pk);  
                if(is_null($registro))      
                    throw new CHttpException(500,'NO se encontro el registro con el id '.$id); 
                //$registro->setScenario('escalias');
                $registro->{$name}=$value;
                if($registro->save()){
                    echo yii::t('ajax','Change success');
                }else{
                    echo yii::t('ajax','Change fails...!');
                }
                
                }         
            }
    }
    PUBLIC function actionajaxActivate(){
        if(yii::app()->request->isAjaxRequest){ 
            if(isset($_GET['id'])  ){                  
                $id= (integer)MiFactoria::cleanInput($_GET['id']); 
                
                $registro= Menugeneral::model()->findByPk($id);  
                if(is_null($registro))      
                    throw new CHttpException(500,'NO se encontro el registro con el id '.$id); 
                $registro->setScenario('status');
                if($registro->activa==1){
                   $registro->activa=0; 
                }else{
                     $registro->activa=1; 
                }
                //$registro->activa=($registro->activa==1)?0:1;
                if($registro->save()){
                    echo yii::t('ajax','Activation success');
                }else{
                    echo yii::t('ajax','Activation fails...!');
                }
                
                }         
            }
    }
     
   private function createRoootsMenu(){
       //creando el menu gneral general el id padre de todos los menus
       $idpadre=Menugeneral::existsMenu( 'root'  ,'root');
                    
       if(!$idpadre){
        $menu= New Menugeneral();
                $menu->setAttributes(
                        array(
                            'activa'=>1,
                            'codaccion'=>'root',
                            'ruta'=>'#',
                            'controlador'=>'root',
                           'modulo'=>'',
                            'alias'=>'General-Root ',
                            'hidpadre'=>0
                        )
                        );
                $menu->save();$menu->refresh();
                $idpadre=$menu->id;
                    }
       for( $i= 0 ; $i <= 30 ; $i++ ){
            if(
                    !Menugeneral::existsMenu( 'noneisroot'.$i  ,'noneisroot'.$i)
                    ){
          
         $menu= New Menugeneral();
                $menu->setAttributes(
                        array(
                            'activa'=>0,
                            'codaccion'=>'noneisroot'.$i,
                            'ruta'=>'#',
                            'controlador'=>'noneisroot'.$i,
                           'modulo'=>'',
                            'alias'=>'Root '.$i,
                            'hidpadre'=>$idpadre,
                        )
                        );
                        //var_dump($menu);
             if( !$menu->save())
                 print_r($menu->geterrors());
             }    
       }
       
   } 
   
 public function actionSettingsModules(){
     $array_parameters=array();
     $modules=yii::app()->getModules();
     foreach($modules as $name=>$values){
         if(isset($values['components']['config'])){
             $component=yii::app()->getModule($name)->getComponent('config');
             if(method_exists($component,'getParamsConfig'))
             $array_parameters[$name]=$component->getParamsConfig();             
         }
     }
    // var_dump($array_parameters);die();
   $this->render('modulesconf',array('aparametros'=>$array_parameters));
 }
    
}
