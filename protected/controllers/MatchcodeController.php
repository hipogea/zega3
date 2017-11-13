<?php

class MatchcodeController extends Controller
{
	

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('Visualiza','muestrasesiones','recibevalorsimple','Excel','defaulte','eliminasesiones','pide','pintamaterial','pintaactivo','pintaequipo','recibevalor1','creadetalle','relaciona1','Relaciona','Recibevalor','Recibevalores','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionRelaciona()
	{
	$vvalore=$this->cleanInput($_POST['valor']);
         $ordencampo=$this->cleanInput($_POST['ordencampo']);   
         $campito=$this->cleanInput($_POST['campo']);
	 $cremoto=$this->cleanInput($_POST['camporemoto']);
	 $clasi=$this->cleanInput($_POST['clasesita']);
                
              
		if($cremoto==""){
			$rr= $clasi::model()->findByPk($vvalore);
			//var_dump($rr);
			if(!is_null($rr)){
                          //   var_dump($rr->attributes);
				//echo $rr->{$rr->attributeNames()[$ordencampo]};
                            $valor=$rr->{$rr->attributeNames()[$ordencampo]};
			}else{
				$valor=null;
			}
		}else{
			$mokix =new $clasi;
			$func = function($valor) {
				if (gettype($valor)=='string')
					return strtolower($valor);
			};
			$columnas=array_map($func,$mokix->getTableSchema()->getColumnNames());
			if(!in_array(strtolower($cremoto),$columnas) )
				throw new CHttpException(500,__CLASS__.'   '.__FUNCTION__.'  '.__LINE__.' No se encontro ninguna columna remota con el nombre :  '.$cremoto.', por favor revise la propiedad ');
			$moki=$clasi::model()->find("".$cremoto."='".trim($vvalore)."'");
			//var_dump($clasi);var_dump($cremoto);var_dump($vvalore);
                        if(!is_null($moki)){
                           //yii::app()->session[$campito]=$moki->{$moki->attributeNames()[$ordencampo]};	
					$valor=$moki->{$moki->attributeNames()[$ordencampo]};
				}else{
                                    // yii::app()->session[$campito]=$moki->{$moki->attributeNames()[$ordencampo]};	
			
					$valor=null;
				} 
                                
		}
                MatchCode::pintatexto(is_null($valor)?"--No encontrado ":$valor);
               yii::app()->session[$campito]=$vvalore;	
			 
                

	}

public function actionRelaciona1()
	{


  /* print_r($_GET);
		yii::app()->end();*/
		$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];
			$campolargo=$_GET['campolargo'];
			$vvalore=$_POST[$_GET['contr']][$campito];	
			$clasi=$_GET['clasesita'];


			//$form=$_GET['form'];	
			$contr=$_GET['contr'];
			// echo CHtml::textField($contr.'_'.$campito,Yii::app()->explorador->buscavalor($campito,$vvalore,$ordencampo,$clasi),
			 	//array('id'=>$contr.'_'.$campito));
			 //Fotos::buscavalor($campito,$vvalore,$ordencampo,$relaciones);
			//echo " type=text name='[".$contr."]".$campito."'   id='".$contr."_".$campito."'  size='40' value='".$vvalue."'  ";
			//echo "<input type=text name='[".$contr."]".$campito."'   id='".$contr."_".$campito."'  size='40' value='".Yii::app()->explorador->buscavalor1($campito,$vvalore,$ordencampo,$clasi)."' >";
		/*	echo "vvvalore=".$vvalore."<br>";
			echo "contr=".$contr."<br>";
			echo "ordencampo=".$ordencampo."<br>";
			echo "campito=".$campito."<br>";
			echo "clasi=".$clasi."<br>";*/
		//echo $clasi::model()->findByPK($vvalore)->{$clasi::model()->attributeNames()[$ordencampo]};



		if (isset($_GET['campoex'])){ //SIS SE DIO COMO DATO UN CAMPO QUE ON ES LA CLAVE PRINCIPAL DE LA LLAVE FORANEA USAR FIND
			$campoex=$_GET['campoex'];
			if(gettype($vvalore)=='string')
				$vvalore="'".$vvalore."'";
			$condicion="".$campoex."=".$vvalore;
			$modelin=$clasi::model()->find($condicion);

		}else { //SI NO SE HA DADO NADA SE ASUME QUE ES LA CLAVE PRINCIPAL

			$modelin=$clasi::model()->findByPk($vvalore);

		}


		   if(!is_null($modelin)){
			 $contenido= $modelin->{$clasi::model()->attributeNames()[$ordencampo]};
		   } else {
			  $contenido="--No hay resultados ";
			  // $contenido=$condicion;
		   }
		//$aponer= $clasi::model()->find("brevete='".trim($vvalore)."'")->{$clasi::model()->attributeNames()[$ordencampo]};
		Unset($modelin);
		//echo $contenido;
		echo "<input type=text name='".$contr."[".$campolargo."]'   id='".$contr."_".$campolargo."'  size='40' value='".$contenido."' >";

		//var_dump( );
		//var_dump($vvalore);
		//Yii::app()->explorador->buscavalor1($campolargo,$contr,$vvalore,$ordencampo,$clasi) ;
		//echo "<input type=text name='".$contr."[".$campito."]'   id='".$contr."_".$campito."'  size='40' value='".$aponer."' >";



	}


	public function actionRelacionas()
	{
			$ordencampo=$_POST['ordencampo'];
			$campito=$_POST['campo'];

			/*$ordencampo=$_GET['ordencampo'];
			$campito=$_GET['campo'];*/
			$vvalore=$_POST[$_GET['contr']][$campito];	
			/*$clasi=$_GET['clasesita'];	*/


			
			//$vvalore=$_POST[$_POST['contr']][$campito];						
			$clasi=$_POST['clasesita'];	

			ECHO "CONTROLADOR:  ".$_POST['contr']."<br>";
			
			ECHO "ORDEN CAMPO  :  ".$ordencampo."<br>";
			ECHO "CAMPITO :  ".$campito."<br>";

			ECHO "VALOR  :  ".$_POST[$_POST['contr']][$campito]."<br>";
			ECHO "CLASE  :  ".$clasi."<br>";
			//echo "hola";
			//echo gettype($_POST['clasesita']);
			  //Yii::app()->explorador->buscavalor($campito,$vvalore,$ordencampo,$clasi);
			 //Fotos::buscavalor($campito,$vvalore,$ordencampo,$relaciones);
	}

	public function actionRecibevalorSimple()
	{

		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
		{
			$autoIdAll = $_GET['checkselected']; ///The records selecteds
		};
		if(count($autoIdAll)>0)
		{
			echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');
																		var valoresclave= new Array();
																		var controles=new Array();
																		var cadenita='{$autoIdAll[0]}';
																		var valoresclave=cadenita.split('_');
																		var controles=caja.split('@');
																		window.parent.$('#'+controles[0]+'').val(valoresclave[0]);
																		window.parent.$('#'+controles[1]+'').html(valoresclave[1]);
																		");
			//window.parent.$('#'+controles[1]+'').html(valoresclave[0]);
			//window.parent.$('#'+controles[0]+'').attr('value',valoresclave[0]);
			//
			Yii::app()->end();
		} else{

			//$relaciones=$_GET['relaciones'];
			//$modeliz=new Guia;
			//$relaciones=$modeliz->relations();
			$nombreclase=$_GET['clasesita'];
			//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
			//$model=Yii::app()->explorador->devuelvemodelo($campo,$nombreclase);
			$model=new $nombreclase;
			$model->unsetAttributes();
			if(isset($_GET[$nombreclase]))
				$model->attributes=$_GET[$nombreclase];
			$this->layout='//layouts/iframe' ;
			$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
			//$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));

		}

	}





	public function actionRecibevalor()
	{
		
		$autoIdAll=array();
               
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
				{
				$autoIdAll = $_GET['checkselected']; ///The records selecteds 
				};
				if(count($autoIdAll)>0)
										{
												echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');													                    
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');
																		var valoresclave= new Array();
																		var controles=new Array();
																		var cadenita='{$autoIdAll[0]}';
																		var valoresclave=cadenita.split('_');	
																		var controles=caja.split('@');
																		window.parent.$('#'+controles[0]+'').val(valoresclave[0]);
																		window.parent.$('#'+controles[1]+'').html(valoresclave[1]);
																		");
											//window.parent.$('#'+controles[1]+'').html(valoresclave[0]);
											//window.parent.$('#'+controles[0]+'').attr('value',valoresclave[0]);
											//
														Yii::app()->end();
										} else{
												//$campo=$_GET['campo'];
												//$relaciones=$_GET['relaciones'];
												//$modeliz=new Guia;
												//$relaciones=$modeliz->relations();
												$nombreclase=$_GET['clasesita'];
												//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
												//$model=Yii::app()->explorador->devuelvemodelo($campo,$nombreclase);
												$model=new $nombreclase;
												$model->unsetAttributes(); 
												if(isset($_GET[$nombreclase]))
												$model->attributes=$_GET[$nombreclase];                                                                                              
                                                                                              
												$this->layout='//layouts/iframe' ;
												$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
												 //$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												
												}
										
	}
	
	public function actionRecibevalor1()
	{
		// VAR_DUMP(COUNT($_GET['checkselected']));
		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
				{
				$autoIdAll = $_GET['checkselected']; ///The records selecteds 
				};
				if(count($autoIdAll)>0)
					{ ECHO "YA ESTA ";
                                           echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');													                    
							window.parent.$('#cru-frame3').attr('src','');
							var caja=window.parent.$('#cru-dialog3').data('hilo');	
							var valoresclave= new Array();
							var controles=new Array();
							var cadenita='".CJavaScript::quote($autoIdAll[0])."';
                                        		var valoresclave=cadenita.split('_');	
							var controles=caja.split('@');	
							window.parent.$('#'+controles[0]+'').val(valoresclave[0]);
							window.parent.$('#'+controles[1]+'').attr('value',valoresclave[1]);
								window.parent.$('#pio').attr('src','".Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes']."filter.png');
							");
                                                        
                                                        ECHO "EJECUTO EL SCRIPT";
							Yii::app()->end();
										} else{
												$campo=$_GET['campo'];
												//$relaciones=$_GET['relaciones'];
												//$modeliz=new Guia;
												//$relaciones=$modeliz->relations();
												$nombreclase=$_GET['clasesita'];
												//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));
												$model=Yii::app()->explorador->devuelvemodelo($campo,$nombreclase);												
												$model->unsetAttributes(); 
												if(isset($_GET[$nombreclase]))
												$model->attributes=$_GET[$nombreclase];
												$this->layout='//layouts/iframe' ;
												$this->render("ext.explorador.views.vw_".$nombreclase,array('model'=>$model));
												 //$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												
												}
										
	}
	

	public function actionRecibevalores()
	{
		
		$autoIdAll=array();
		if(  isset($_GET['checkselected'])   ) //If user had posted the form with records selected
				{
				$autoIdAll = $_GET['checkselected']; ///The records selecteds 
				};
				if(count($autoIdAll)>0)
										{
												echo CHtml::script("window.parent.$('#cru-dialog3').dialog('close');													                    
																		window.parent.$('#cru-frame3').attr('src','');
																		var caja=window.parent.$('#cru-dialog3').data('hilo');	
																		var valoresclave= new Array();
																		var controles=new Array();
																		var primervalor='{$autoIdAll[0]}';																		
																		var controles=caja.split('@');	
																		window.parent.$('#'+controles[0]+'').attr('value',primervalor);
																		window.parent.$('#pio'+controles[0]+'').attr('src','".Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes']."filter.png');
																		window.parent.$('#pio2'+controles[0]+'').attr('src','".Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes']."nofilter.png');
																		window.parent.$('#pio3'+controles[0]+'').attr('src','".Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes']."Column.png');

																		");
														//Creando la sesion 
													  if(!isset($_SESSION['sesion_'.$_GET['nombremodelo']])) {
													  	 $_SESSION['sesion_'.$_GET['nombremodelo']] = array();
                                                         // $_SESSION['sesion_'.$_GET['nombremodelo']]=$autoIdAll;
													  	   }else {

													  	   	// Yii::app()->session['sesion_maestrocompo']=Yii::app()->session['sesion_maestrocompo']+	$autoIdAll;	
													  	   }
                                             $_SESSION['sesion_'.$_GET['nombremodelo']]= array_merge($_SESSION['sesion_'.$_GET['nombremodelo']],$autoIdAll);
													  	   //	 Yii::app()->session['sesion_'.$_GET['nombremodelo']]=$autoIdAll;

                                                       // echo $_SESSION['sesion_'.$_GET['nombremodelo']];

														Yii::app()->end();
										} else{
												$campo=$_GET['campo'];
												//$relaciones=$_GET['relaciones'];
												//$modeliz=new Guia;
												//$relaciones=$modeliz->relations();
												$nombreclase=$_GET['clasesita'];
												//$tipodato=gettype(Yii::app()->explorador->devuelvemodelo($campo,$relaciones));


														$model=Yii::app()->explorador->devuelvemodelo($campo,$_GET['nombremodelo']);

											//$model=Yii::app()->explorador->devuelvemodelo($campo,$nombreclase);
												//$m=$_GET['nombremodelo'];
												$model->unsetAttributes(); 
												if(isset($_GET[$nombreclase])){
                                                                                                    $model->attributes=$_GET[$nombreclase];                                                                                                   
                                                                                                      // var_dump($model->attributes);
                                                                                                     //  echo "<br>";
                                                                                                       //var_dump($_GET[$nombreclase]);
                                                                                                       // echo "<br>";
                                                                                                    // var_dump($nombreclase);
                                                                                                     // var_dump(get_class($model));
                                                                                             }
												
												$this->layout='//layouts/iframe' ;


														$this->render("ext.explorador.views.vw_multi_".$_GET['nombremodelo'],array('model'=>$model));
					//$this->render("ext.explorador.views.vw_multi_".$nombreclase,array('model'=>$model));


					//$this->render("ext.explorador.views.vw_pruebitas1",array('tipodato'=>$tipodato,'tablita'=>$nombreclase,'campo'=>$campo,'relaciones'=>$relaciones));
												
												}
										
	}
	
	public function actioneliminasesiones(){
			unset($_SESSION['sesion_'.$_POST['sesion']]);

	}

	public function actionmuestrasesiones (){
		$this->layout='//layouts/iframe';
		$nmodeo=$this->cleanInput($_GET['nombremodelo']);

		if(!isset($_SESSION['sesion_'.$nmodeo])){
			$arreglo=array();
		}else{
			$arreglo=$_SESSION['sesion_'.$nmodeo];
		}
		$combinado=array();
        foreach($arreglo as $clave=>$valor){
                       // $combinado[]=array('id'=>$valor);
			$combinado[]=array('valor'=>$valor);
		}
                //$rawData=Yii::app()->db->createCommand('SELECT * FROM public_tipoactivos')->queryAll();
               //var_dump($rawData);die();
// print_r($arreglo);echo "<br><br>";print_r($combinado);die();
		$dataProvider = new CArrayDataProvider($combinado,array('id'=>'codtipo','keyField'=>'valor'));
		$this->render("ext.explorador.views.vw_sesiones",array('proveedor'=>$dataProvider));
	}

	public  function cleanInput($input) {

		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Elimina javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
			'@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
		);

		$output = preg_replace($search, '', $input);
		return $output;
	}

}
