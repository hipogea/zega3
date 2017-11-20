<?php

class EjemplosController extends Controller
{

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','config','transacciones','parametros','esarchivo','rutas','pio','matrices','moneda'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function mm(){
	return false;

}
	public function actionparametros(){
		if($this->mm()){
			echo "es verdsadero";
		}else
		yii::app()->end();
		Yii::app()->settings->set('General', 'monedadef','PEN', $toDatabase=true);///MONEDA POR DEFAUL, DEBE SE SELECCINADA MEDINATE COMOBO
		Yii::app()->settings->set('General', 'numeromaxbloqueos',5, $toDatabase=true);///CANTIDAD MAXIMA DE DOCUMENTOS ABIERTOS POR UN USUARIO


		Yii::app()->settings->set('Transporte', 'tiempopermitidohastaentrega',24*60*60*1000, $toDatabase=true); //TIEMPO PERMITIDO (MILISEG)  PARA PODER REVERTIR EL DESPACHO DE UNA GUIA DE REMISION,
		Yii::app()->settings->set('Transporte', 'trancheck','1', $toDatabase=true); ///VALIDA LA UBICACAION DE LOS ACTIVOS ANTES DE MOVERLOS

		Yii::app()->settings->set('Inventario', 'periodocontrol',5, $toDatabase=true); ///NUMERO DE DIAS EN LOS QUE DEBE DE REGISTRARSE EL LOGO DE INVENTARIO

		Yii::app()->settings->set('Noticias', 'adminnoticias','admin', $toDatabase=true);//EL USUARIO QUE ADMINISTRA EL TAVBLON POR DEFAULT
		Yii::app()->settings->set('Compras', 'restringircantidades','1', $toDatabase=true);///RESTRINGE LA REGLA DE QUE NO SE PUEDE COMPRAR MAS DE LO QUE LA SOLICITUD INDICA

		Yii::app()->settings->set('Activofijo', 'mascara','/90-3[0-5]{1}00-[0-9]{5}/', $toDatabase=true);
		Yii::app()->settings->set('Documentos', 'mascara','/[1-9]{2}[0-9]{0,20}/', $toDatabase=true);
		Yii::app()->settings->set('Cecos', 'mascara','/90[0-9]{4}/', $toDatabase=true);


		Yii::app()->settings->set('Activofijo', 'rutafotosinventario','recurso/fotosinv/', $toDatabase=true); ///Directorio donde se guardan las fotros del ivnetario
		Yii::app()->settings->set('Directorios', 'rutatemaimagenes','/img/', $toDatabase=true);
		Yii::app()->settings->set('Materiales', 'rutaimagenesmateriales','/materiales/', $toDatabase=true);///directio de fotos de materiales



		Yii::app()->settings->set('Email', 'adminemail','webmaster@neologys.com', $toDatabase=true); //El correo corporativo
		//debe ser una direccion de correo que pueda validarse segun SMTP
		Yii::app()->settings->set('Email', 'usamaildeusuario','1', $toDatabase=true); //Usa la direccion de correo del usuario activo
		//para enviar mensajes
		Yii::app()->settings->set('Email', 'rutaficherosdeplantillas','1', $toDatabase=true); //UDirectorio donde se guarda
		//los archivos CSS y HTML de los mensajes de correo de usuarios
		Yii::app()->settings->set('Email', 'tiempodeespera',10, $toDatabase=true); //TIEMPO DE ESPERA EN SEGUNDOS HASTA ENVIAR OTRO CORREO
		//ESTO PARA EVITAR ENVIAR DOBLE O PRESIONAR VARIAS VECES UN FORM


	}


	public function actionesarchivo(){
  if(is_file(Yii::getPathOfAlias('webroot').'/imgreportes/JULIAN.gif')) echo "si es file<br>";
		ECHO Maestrocompo::subeimagen(Yii::getPathOfAlias('webroot').'/imgreportes/JULIAN.gif','OLMEDO');
		YII::APP()->END();


		$alin=New Alinventario();
		$matrizinv=$alin->getStockValTotal();
		print_r($matrizinv);
		ECHO "<BR><BR><BR>";
		$matrizinv=$alin->getStockValCentro();
		print_r($matrizinv);
		ECHO "<BR><BR><BR>";
		$matrizinv=$alin->getStockValAlmacen();
		print_r($matrizinv);
		ECHO "<BR><BR><BR>";
		$alin=New Alinventario();
		$matrizinv=$alin->getStockMatTotal('18005746');
		print_r($matrizinv);
		ECHO "<BR><BR><BR>";
		$matrizinv=$alin->getStockMatCentro('18005746');
		print_r($matrizinv);
		ECHO "<BR><BR><BR>";
		$matrizinv=$alin->getStockMatAlmacen('18005746');
		print_r($matrizinv);
		ECHO "<BR><BR><BR>";
		yii::app()->end();




echo date('Y-m-d H:i:s');
		var_dump(yii::app()->tipocambio->setcompra('USD',3.69));
	/*	yii::app()->tipocambio->setventa('USD',3.39);
		ECHO "COMRPA DOLAR  ".yii::app()->tipocambio->getcompra('USD');
		echo "<br>";
		ECHO "VENTA  DOLAR  ".yii::app()->tipocambio->getventa('USD');
		echo "<br>";
		echo "moendas vencias ";
		print_r(yii::app()->tipocambio->cambiospasados());*/
		yii::app()->end();



		var_dump( yii::app()->periodo->verificafechas('2015-10-30','2015-10-30'));

		echo " fecha ".strtotime('2015-10-30') ;
		yii::app()->end();
		$compra='21000050';
			$vales=yii::app()->db->createCommand()->
		select('a.numvale')->from('{{almacendocs}} a,{{alkardex}} b, {{alentregas}} c')
			->where("a.id=b.hidvale AND b.id=c.idkardex AND b.numdocref=:nocompra",
				array(":nocompra"=>$compra)
			)->queryColumn();
		//Sacando los numeros de documentos referenciados en dichos vales, que tambien son vales
		$valesreferenciados=yii::app()->db->createCommand()->
		select('a.numdocref')->from('{{almacendocs}} a,{{alkardex}} b, {{alentregas}} c')
			->where("a.id=b.hidvale AND b.id=c.idkardex AND b.numdocref=:nocompra ",
				array(":nocompra"=>$compra)
			)->queryColumn();

		$arraypar=array_combine($vales,$valesreferenciados);
		//$arraypar=array_unique(array_combine($vales,$valesreferenciados));
		$vales=array_unique($vales);
		$valesreferenciados=array_unique($valesreferenciados);

		///Ahora usamos la teoria de conjuntos  $vales INTERESECCION  $valesreferenciados
		///QUIRE DECIR QEU SI HA HABIDO ANULACIONES , DEBE DE HABER UNA INTERSECCION
		$interseccion=array_intersect( $vales,$valesreferenciados);

		print_r($vales);
		echo "<br><br><br>";
		print_r($valesreferenciados);
		echo "<br><br><br>";
		print_r($arraypar);
		echo "<br><br><br>";
		print_r($interseccion);
		echo "<br><br><br>";
		//yii::app()->end();

		IF(COUNT($interseccion)>0){

			foreach($interseccion as $clave=>$valor){
				unset($arraypar[$valor]);
				if( array_search($valor,$arraypar))unset($arraypar[array_search($valor,$arraypar)]);
			}
			$vales=array_keys($arraypar);
		}
        $valores=array();
		$i=0;
		foreach($vales as $clave=>$valor){
			$valores[":ycp".$i]=$valor.'';
			$i=$i+1;
		}



		//bien ya nos aseguramos de eliminar los vales que estan comprometidos con anulaciones
		//ahora si sale limpio:
		$criterio=New CDBCriteria;
		$criterio->addCondition("a.id=b.hidvale AND b.id=c.idkardex AND b.numdocref=:numocompra");
		$criterio->addInCondition('a.numvale',array_keys($valores));
		$valores[":numocompra"]=$compra;
		$criterio->params= $valores;
		print_r($criterio->params);
		echo "<br>vxvx<br><br>";
		$entregas=yii::app()->db->createCommand()->
		select('c.id')->from('{{almacendocs}} a,{{alkardex}} b, {{alentregas}} c')
			->where($criterio->condition,$criterio->params)->queryAll();

       PRINT_R($entregas);
		foreach( $entregas as $filaentrega){
			$detalle=new Tempdetingfactura;
			$detalle->setScenario('basico');
			$detalle->setAttributes(
				array(
					'hidfactura'=>2,
					'hidalentrega'=>$filaentrega->id,

				)
			);
			$detalle->save();
		}





		yii::app()->end();


		echo yii::app()->baseUrl."  /recurso/themes/temita/css/abound.css   <br> ";
	 echo (is_file('/recurso/themes/temita/css/abound.css'))?" Si Es Archivo ":" NO es archivo ";

	}


	public function actionmoneda(){
		Yii::import('ext.EGeoIP');

		$geoIp = new EGeoIP();

		$geoIp->locate(yii::app()->request->userHostAddress); // use your IP

		echo 'Information regarding IP: <b>'.$geoIp->ip.'</b><br/>';
		echo 'City: '.$geoIp->city.'<br>';
		echo 'Region: '.$geoIp->region.'<br>';
		echo 'Area Code: '.$geoIp->areaCode.'<br>';
		echo 'DMA: '.$geoIp->dma.'<br>';
		echo 'Country Code: '.$geoIp->countryCode.'<br>';
		echo 'Country Name: '.$geoIp->countryName.'<br>';
		echo 'Continent Code: '.$geoIp->continentCode.'<br>';
		echo 'Latitude: '.$geoIp->latitude.'<br>';
		echo 'Longitude: '.$geoIp->longitude.'<br>';
		echo 'Currency Symbol: '.$geoIp->currencySymbol.'<br>';
		echo 'Currency Code: '.$geoIp->currencyCode.'<br>';
		echo 'Currency Converter: '.$geoIp->currencyConverter.'<br/>';

		echo 'Converting $10.00 to '.$geoIp->currencyCode.': <b>'.$geoIp->currencyConvert(10).'</b><br/>';
	}


public function actionconfig ()
{

	print_r(Yii::app()->settings->get('email'));
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
	echo "<br>";

}

 public function actionRutas(){

 /*
	 $registro=Maestrocompo::model()->findByPk('18008823');
	 print_r($registro->explota());
	 yii::app()->end();
	// echo Contactos::getListMailContacto ( 33 , '421' ) ;
	 $cadena=yii::app()->correo->correo_simple (
		 'neotegnia@gmail.com' ,
		 'neotegnia@gmail.com' ,
		 'SOLICITUD DE COTIZACION' ,
		 " favor de cotizar los siguiente s mateiale   "
	 );
	 var_dump($cadena);
	 yii::app()->end();



	 $modelokardex=Alkardex::model()->findByPk(2408);
	// $transacc=Yii::app()->db->beginTransaction();
	 $nuevo=new Alkardex();
	 $nuevo->attributes=$modelokardex->attributes;
	 $nuevo->numdocref='PICHOx';
	 $nuevo->save();
	 print_r($nuevo->attributes);
	 yii::app()->end();

	 $model=new Desolpe();
	 $model->save();
	 yii::app()->mensajes->clear();
	 yii::app()->mensajes->setmessageitem('350',456,"eSTE ES MI PRIMER MEJSAE ",'notice');
	 yii::app()->mensajes->setmessageitem('350',455,"eSTE ES MI segundo MEJSAE ",'notice');
	 yii::app()->mensajes->setmessageitem('350',455,yii::app()->mensajes->getErroresItem($model->geterrors()),'error');
	 yii::app()->mensajes->setmessageitem('350',455,"eSTE ES MI tercer MEJSAE ",'notice');
	 //print_r(yii::app()->session['errores']);
	 $matriz=yii::app()->mensajes->getMessages('350');
	 print_r($matriz); yii::app()->end();
	 var_dump(Ocompra::puedeautorizar());

	var_dump(Montoinventario::datosgrafo('mes',6,null));

$mo=New Alinventario();
	 print_r($mo->getStockValAlmacen());

	$data=Ocompra::historicoprecios('18005720');
	 print_r($data->getData());

*/

	 echo " Yii::getPathOfAlias('webroot') :  ".Yii::getPathOfAlias('webroot')."<br>";
	 //echo "yii::app()->params['webRoot']     :     ".yii::app()->params['webRoot']."<br> ";
	 echo "yii::app()->baseUrl     :     ".yii::app()->baseUrl ."<br> ";
	 echo "yii::app()->getBaseUrl(true)     :     ".yii::app()->getBaseUrl(true) ."<br> ";
	 echo "yii::app()->getBaseUrl(false)     :     ".yii::app()->getBaseUrl(false) ."<br> ";
	 echo "yii::app()->basePath      :     ".yii::app()->basePath ."<br> ";
	 echo "yii::app()->baseUrl     :     ".yii::app()->baseUrl ."<br> ";
	 echo "Yii::app()->getTheme()->baseUrl    :    ".Yii::app()->getTheme()->baseUrl."<br> ";
	 echo "Yii::app()->getTheme()->basePath    :    ".Yii::app()->getTheme()->basePath."<br> ";
	 echo "Yii::app()->getTheme()->systemViewPath    :    ".Yii::app()->getTheme()->systemViewPath."<br> ";
	 echo "Yii::app()->getTheme()->viewPath    :    ".Yii::app()->getTheme()->viewPath."<br> ";
	 echo "Yii::app()->getHomeUrl()            :    ".Yii::app()->getHomeUrl() ."  <br>";
	 echo "Yii::app()->runtimePath             :  ".Yii::app()->runtimePath ."<br> ";
	 echo "yii::app()->request->getServerName()     :     ".yii::app()->request->getServerName() ."<br> ";
	 echo "yii::app()->request->hostInfo     :     ".yii::app()->request->hostInfo ."<br> ";
	 echo "yii::app()->request->pathInfo     :     ".yii::app()->request->pathInfo ."<br> ";
	 echo "yii::app()->request->serverName     :     ".yii::app()->request->serverName ."<br> ";
	 echo "yii::app()->request->url     :     ".yii::app()->request->url ."<br> ";
	 echo "yii::app()->request->userHostAddress     :     ".yii::app()->request->userHostAddress ."<br> ";

   echo "<br><br><br>";
   
   echo "Comprobar el directorio con la funcio is_dir()    :     is_dir(".Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.")  <br> ";
   var_dump( is_dir(Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR));
   echo "<br><br><br>";
   echo " microtime() : <br> ";
   var_dump(microtime(true));
   var_dump(date("Y-m-d H:i:s",microtime(true)));
   echo "<br><br><br>";
   
   echo "Comprobar el directorio con la funcio is_dir()    :     is_dir(".Yii::getPathOfAlias('webroot').")  <br> ";
   var_dump( is_dir(Yii::getPathOfAlias('webroot')));
	 echo "<br><br><br>";
	 echo "Archivos del directorio ". Yii::app()->getTheme()->basePath."  <br>";
	 $archivos=CFileHelper::findFiles(		Yii::app()->getTheme()->basePath.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'reportes',
		   									array(
			   									'fileTypes'=>array('css'),
												'exclude'=>array(),
												'level'=>-1,
												'absolutePaths'=>false
		  									 )
	 									);
	 print_r($archivos);


         
         
         
 }


	public function actiontransacciones(){
	 /* $modelo1=new Canales;
		$modelo2=new Oficios;
		$modelo1->codcanal='893';
		$modelo1->canal='CANAL 893';
		$modelo2->codof='781';
		$modelo2->oficio='EL CHUPE1';*/
		$transaccion=Yii::app()->db->beginTransaction();
		$karde=Alkardex::model()->findByPk(2178);

		$ofi=Oficios::model()->findByPk('312');
		$cana=Canales::model()->findByPk('893');
		$cana->canal='CANAL bb';
		$ofi->oficio='ESTIBADOR bb';
		$karde->cant=-8.888;

		$cana->save();
		$ofi->save();
		$karde->save();

		//sleep(20);
		$transaccion->rollback();

		/*$transaccion->connection->autoCommit=true;
		$modelo2->save();
		var_dump($transaccion->active);
		$modelo1->save();*/

}

public $layout='//layouts/column2';
	public function actionPio() {
             yii::import('application.modules.mantto.behaviors.measurePointBehavior');
            
            $partes= Dailywork::model()->findAll("id>28");
            $op=array('I','E');
            
            foreach($partes as $parte){
                foreach($parte->dailydet as $detalle){
                    
                    $detalle->refrescacampos();
                    $hola=$detalle->attachbehavior('auditoriaBehavior',
                           new measurePointBehavior(
                                   array(
                                       
                                       )));
                   
                   $horometro1=$detalle->getMeasurePointByOrder(1);
                   $horometro2=$detalle->getMeasurePointByOrder(2);
                   
                    //para el campo hidlectura2
                   $detalle->nameField='hidlectura1';
                   $detalle->idPoint=$horometro1->id;
                   $detalle->dateOfMeasure=$detalle->getDateInitial();
                   $detalle->valueMeasure=$detalle->getValueMeasurePointFromId($detalle->previous()->hidlectura2);
                   $detalle->putMeasureInPoint();
                   
                   //para el campo hidlectura2
                   $detalle->refrescacampos();
                   $detalle->nameField='hidlectura2';
                   $detalle->idPoint=$horometro1->id;
                   $detalle->dateOfMeasure=$detalle->getDateFinal();
                   $detalle->valueMeasure=$detalle->getValueMeasurePointFromId($detalle->hidlectura1)+$detalle->hd;
                   $detalle->putMeasureInPoint();
                  
                  // echo "el id asgnado es  lctura 2 es ".$detalle->hidlectura2."  ya esta  av  <br>";
                   echo "grab campos1 <br>";
                   if($detalle->save()){ print_r($detalle->attributes);
                   echo "<br>";echo $detalle->id."ok<br>";}else{
                        print_r($detalle->attributes);echo "<br>";
                       echo $detalle->id."<br>";
                       print_r($detalle->geterrors());
                       echo "no<br>";
                       
                   }
                   if($detalle->inventario->tienecarter=='1'){
                   $detalle->refrescacampos();
                   
                    //para el campo hidlectura2
                   $detalle->nameField='hidlectura3';
                   $detalle->idPoint=$horometro2->id;
                   $detalle->dateOfMeasure=$detalle->getDateInitial();
                   $detalle->valueMeasure=$detalle->getValueMeasurePointFromId($detalle->previous()->hidlectura4);
                   $detalle->putMeasureInPoint();
                   echo "saliendo el  primer id ".$detalle->hidlectura3."<br>";
                   //para el campo hidlectura2
                   $detalle->refrescacampos();
                   $detalle->nameField='hidlectura4';
                   $detalle->idPoint=$horometro2->id;
                   $detalle->dateOfMeasure=$detalle->getDateFinal();
                   $detalle->valueMeasure=$detalle->getValueMeasurePointFromId($detalle->hidlectura3)+$detalle->hd;
                   $detalle->putMeasureInPoint();
                    echo "saliendo el  segundo  id ".$detalle->hidlectura3."<br>";
                   
                   
                   
                   
                    echo "grab campos [] ID  lectura4 previa ".$detalle->previous()->hidlectura4." lectua 3 actual   ".$detalle->hidlectura3."  deben ser iguales . ANTES ".$detalle->getValueMeasurePointFromId($detalle->hidlectura3)."  AHORA VALOR  => ".$detalle->valueMeasure." diferencia ".$detalle->hd."<br>";
                   if($detalle->save()){echo $detalle->id."ok<br>";
                   print_r($detalle->attributes);echo "<br>";
                   }else{
                       print_r($detalle->attributes);echo "<br>";
                       echo $detalle->id."<br>";
                       print_r($detalle->geterrors());
                       echo "no<br>";
                       
                   }
                   
                   }
                    
                    /*$detalle->addCheckDaily();
                    $r=new Dailyevents;
                    $r->setAttributes(
                    array(
                        'hidet'=>$detalle->id,
                        'descripcion'=>yii::t('errvalid',' Any event for  ',array('{equipo}'=>$detalle->inventario->codigoaf)),
                         'codresponsable'=>$detalle->dailywork->codresponsable,
                        'tipmanoobra'=>$op[rand(0,1)],
                        'hinicio'=>date('H:i',strtotime($detalle->dailywork->regimen->hinicio)+50*rand(1,2)*60),
                        'hfinal'=>date('H:i',strtotime($detalle->dailywork->regimen->hinicio)+50*60+rand(1,3)*3600),
                        )
                    );
                    $r->save();*/
                }
            }
            
            die();
            
            
            
            
            
            
                   
                   die();
            
            
            
            $reg=New Manttolecturahorometros();
            $reg->hidhorometro=34;
            $reg->fecha='2017-10-01 19:40';
            $reg->lectura=32;
            if($reg->save()){
                echo "ok";
            }else{
                print_r($reg->geterrors());
            }
            die();
            phpinfo();die();
           // var_dump(preg_match('/[0-9,.]/'," 10"));die();
  $registro=Manttolecturahorometros::model()->findByPk(126);         
           /*$registro=New Manttolecturahorometros;
      $registro->fecha='12/10/2017 06:12:00';
      $registro->hidhorometro=23;
      $registro->lectura=4035;*/
echo "id vecino anterior  "; var_dump($registro->getIdVecino(true));echo "<br>";
 echo "is first() "; var_dump($registro->isFirst());echo "<br>";
echo "id vecino siguiente  "; var_dump($registro->getIdVecino(false));echo "<br>";
 echo "is last() "; var_dump($registro->isLast());echo "<br>";
echo "previous()  "; var_dump($registro->previous());echo "<br>";
echo "next()  "; var_dump($registro->next());echo "<br>";
echo "differenceTimeBack()  "; var_dump($registro->differenceTimeBack());echo "<br>";
echo "differenceTimeForward()  "; var_dump($registro->differenceTimeForward());echo "<br>"; 
echo "differenceVlauesBack()  "; var_dump($registro->differenceValuesBack($registro->manttohorometros->ums->escala+0));echo "<br>";
echo "differenceVlauesForward()  "; var_dump($registro->differenceValuesForward($registro->manttohorometros->ums->escala+0));echo "<br>"; 
echo "cuantos por atras  "; var_dump(count($registro->getBack()));echo "<br>";
echo "cuantos por delante  "; var_dump(count($registro->getForward()));echo "<br>";
echo " lectura sguietne  "; var_dump($registro->next()->lectura);echo "<br>";
echo " lectura anteriori  "; var_dump($registro->previous()->lectura);echo "<br>";
//var_dump($registro->getIdVecino(false));
die();   
            
            
            
            $registro= Manttolecturahorometros::model()->findByPk(114);
            $otro=" 10";
            $previo=$registro->previous();
            echo " el original: ";var_dump(trim($previo->lectura));echo "<br>";
            echo " LA SUAM DE L ORIGINAL : ";var_dump($previo->lectura +0);echo "<br>";
            echo " El otro : ";var_dump($otro);echo "<br>";
            echo " LA suma del otro : ";var_dump($otro +0);echo "<br>";
            die();
            echo $previo->lectura+0 ;die();
            var_dump($previo->lectura());die();
            $registro->lectura=4;
            if($registro->validate(null, false)){
                echo "todo ok";
            }else{
                var_dump($registro->geterrors());
            }
            die();
            var_dump();die();
            var_dump($registro->getValueMeasurePointFromId($registro->hidlectura1));die();
            var_dump(is_numeric(1));
            $r=Inventario::model()->findByPk(19)->getPoint(1);
            var_dump($r);
            die();
            $modelant= Manttohorometros::model()->findByPk(23); 
            $nombremodelo='Manttohorometros';
            $model=new $nombremodelo('reemplazo');             
               // $model->valorespordefecto();
                 $model->ubicacion=$modelant->ubicacion;
                 $model->hidpadre=$modelant->id;
                 $model->hidequipo=$modelant->hidequipo;
                 $model->unidades=$modelant->unidades;
                 $model->incremental=$modelant->incremental;
                 //var_dump($modelant->hasMeasures());
                 IF($modelant->hasMeasures()){
                     $model->setAttributes(array(
                         'fechainicio'=>$modelant->getLastObject()->fecha,                         
                         'lecturainicio'=>(!$modelant->canReset())?$modelant->getLastObject()->lectura:0,
                     ));
                     //MiFactoria::Mensaje('notice', 'Some values have been taken from the last measure ');
                 }
            
            var_dump($model->getParentPoint()->getLastObject());die();
           
            
            $diff=strtotime('2017-11-15 18:13:00')-strtotime('2017-11-16 10:08:00');
            $horas=$diff/(3600);
            echo $horas;
            die();
            //$registro= Manttolecturahorometros::model()->findByPk(59);             
           // var_dump($registro->difference());die();
      



$registro->getBack();
$registro->getForward();


die();
            var_dump($registro->fechainicio);
            $registro->conviertefechas(true);
             var_dump($registro->fechainicio);
             $registro->conviertefechas(false);
             var_dump($registro->fechainicio);die();
            //echo "de"; die();
            $REGISTRO= Solpe::model()->findByPk(21);
            echo "de"; die();
            $REGISTRO->numero='004545';
            $REGISTRO->save();die();
            var_dump(Dailydet::model()->search_por_parte(21)->getdata());
            die();
              var_dump(yii::app()->periodo->toISO('18/11/2017 12:41').'');
            var_dump(yii::app()->periodo->fechaParaBd('18/11/2017 12:41:34'));
            die();
            var_dump(yii::app()->periodo->validaformatos('18/11/2017 12:41'));
            
            
            $model=New Dailydet('update');
            $model->hidequipo=19;$model->hidparte=32;
            //$model->codproyecto='490000000031';
            $model->validate(null,false);
            var_dump($model->geterrors());die();
                   //var_dump($idparte);die();
                   $model->hidparte=26;
                   $model->hidequipo=19;
                   $horometro=$model->getHorometroAnterior('hmf');
                   $horometrop=$model->getHorometroAnterior('hpf');
                    var_dump($horometro);var_dump($horometrop);die();
            
            $reg=Dailydet::model()->findByPk(79);
            var_dump($reg->getHorometroSiguiente('hmf'));die();
            /*$b=new Dailyturnos();
            $registros=$b->search_por_ot('490000000031');*/
           var_dump(Dailyturnos::getSecuencia('490000000031'));die();
           
            VAR_DUMP(yii::app()->periodo->verificaFechas($fecha1,$fecha2));
             VAR_DUMP(yii::app()->periodo->verificaFechas($fecha2,$fecha3));
            VAR_DUMP(yii::app()->periodo->toISO('2017-10-01 10:35:00'));DIE();
            $maximo=yii::app()->db->createCommand()->select('hmi')
              ->from('vw_parteopdetalle')->where("id=-4")
            ->queryScalar();
            var_dump($maximo);die();
            
            
        $registro=Dailydet::model()->findByPk(229);
            //var_dump(property_exists($registro, 'hmi'));
           $vela= $registro->getHorometroAnterior('hmi');
           var_dump($vela);
            die();
            var_dump(yii::app()->periodo->semanas(10,'17'));die();
            
            
            $model=New VwParteopdetalle();
             $model->fecha1='2017-10-27';
               $model->fecha='2017-01-01';
               $model->periodo='mes';
                $model->grupo='codtipo';
                $model->_level=$model->periodo;
               $model->_campopivote=$model->grupo;
                            //print_r($model->attributes);die();
              echo $model->buildSqlFechas($model->fecha, $model->fecha1);
               $proveedor=$model->proveedor(NULL);   
           // print_r($proveedor->getData());
            Yii::import('application.helpers.CArray');
            $nuevoarr=CArray::rotate($proveedor->getData());
            print_r($nuevoarr);
            die();
            
            $datos=array(array('uno'=>'dos',));
            var_dump(yii::app()->periodo->explotaFechas('2017-03-15','2017-09-23'));die();
            var_dump(VwParteopdetalle::camposprofundidad()); die();
            $regi=New VwParteopdetalle;
            $regi->_campopivote='codtipo';
            $regi->_level='semana';
              $parametros=array('anno'=>'17','mes'=>'10');
           echo $regi->buildSql($parametros);die();
            
            
            
           $dife=strtotime("01:30")-strtotime(date('Y-m-d'));
           var_dump($dife/3600);die();
            $horaac=(Integer)(microtime(true)*10000);
            echo "hora a actual copn microtime <br>";
            var_dump($horaac);
            $horaacx=time();
            echo "hora a actual copn time <br>";
            var_dump($horaacx);
            echo "<br>";
             echo "fecha con  dato  microtime<br>";
            $fechaactual=date("Y-m-d H:i:s",$horaac/10000);
            var_dump($fechaactual);
            echo "<br>";
             echo "fecha con  dato  time<br>";
            $fechaactual=date("Y-m-d H:i:s",$horaacx);
             var_dump($fechaactual);
             echo "<br>";
             echo "HORA ACTUAL + 10 HORAS CON TIME <BR>";
             //$horaactual=date('H:i:s');
             $hfinal=date('Y-m-d H:i:s',time()+10*60*60);
             $registro=Regimen::model()->findByPk(2);
             $horainicio=$registro->hinicio;
             $horafinal=$registro->horafin();
             $limitesup=$registro->getLimiteSuperior('2017-10-29');
              $limiteinf=$registro->getLimiteInferior('2017-10-29');
              var_dump($limitesup);var_dump($limiteinf);
            die();
             
            
           // date_default_timezone_set('Africa/lusaka');
            echo date('Y-m-d H:i:s');die();
            $comportamiento=new TomaFotosBehavior();
        $comportamiento->_codocu='390';
         $comportamiento->_ruta=yii::app()->settings->get('general','general_directorioimg');
         $comportamiento->_numerofotosporcarpeta=yii::app()->settings->get('general','general_nregistrosporcarpeta')+0;
          $comportamiento->_extensionatrabajar='jpg';
           $comportamiento->_id=10; 
          
           $registro=Inventario::model()->findByPk(10);
           $registro->attachbehavior('adjuntador',$comportamiento ); 
           
           var_dump($registro->getCarrusel(10,'390'));die();
            
            
            $registro= New Adjuntos('insert');//$registro->setAttributes($values)
            
       $registro->setAttributes(array(
               "codocu"=>'891',
                "hiddocu"=>23,                        
                "enlace"=>'hola', 
           "extension"=>'jpg', 
           "iduser"=>yii::app()->user->id,
           "subido"=>date('Y-m-d H:i:s'),
                ));
       if(!$registro->save()){
           echo print_r($registro->geterrors());
       }else{
            echo "ok";
       }die();
            $registro=new Templibrodiario('basico');
              $registro->setAttributes(ARRAY
                     (
                 'codcuenta'=>'6000000001',
                 'tipo'=>'D','codocu'=>'760',
                 'idkey'=>'59c12450ca986',
                     ));
              echo $registro->save();die();
            echo uniqid();die();
             VAR_DUMP(yii::app()->tipocambio->registroactual('USD'));DIE();
            VAR_DUMP(yii::app()->settings->get('general','general_dni'));
            $VALOR="12345678";
             VAR_DUMP($VALOR);
           var_dump(preg_match(yii::app()->settings->get('general','general_dni'),$VALOR));
            DIE();
            var_dump(yii::app()->periodo->getperiodo());die();
          
            var_dump(yii::app()->periodo->diferenciahoras("08:00","18:32"));die();
           var_dump(is_file("/home/neotegni/public_html/recurso/recurso/carpeta/390/jpg/2/8_0_15014402750000_1.jpg"));die();
            $regin=  Alinventario::model()->findByPk(281);
            var_dump(Solpe::solpeautomatica($regin));die();
            
            
            echo yii::app()->periodo->diferenciahoras("16:30","08:00"); die();
            $registro= Ne::model()->findByPk(30);
            var_dump($registro->numeroitemsvalidos);die();
            $fecha='04/02/20176886';
           if(yii::app()->periodo->validaformatos($fecha)){  
               echo "si e s valido";
               
           }else{ echo "no es  valido";
               
           };die();
            if(preg_match('/[0-3]{1}[0-9]{1}\/[0-1]{1}[0-9]{1}\/[1-2]{1}[0|9]{1}[0-9]{2}$/', $fecha)){//FORMATO  12/04/1989
               $retazos=explode("/",$fecha);//print_r($retazos);
              echo "primer". $retazos[2]."-".$retazos[1]."-".$retazos[0];
          } 
     elseif(preg_match ('/[0-3]{1}[0-9]{1}\-[0-1]{1}[0-9]{1}\-[1-2]{1}[0|9]{1}[0-9]{2}$/', $fecha)){//FORMATO  12-04-1989
        $retazos=explode("-",$fecha);
         echo "segundo". $retazos[2]."-".$retazos[1]."-".$retazos[0];
     }elseif(preg_match ('/[1-2]{1}[0|9]{1}[0-9]{2}\/[0-1]{1}[0-9]{1}\/[0-3]{1}[0-9]{1}$/', $fecha)){ //FORMATO 1989/04/02
         echo "tercerp".  preg_replace('/\//', "-", $fecha);
     }elseif(preg_match ('/[1-2]{1}[0|9]{1}[0-9]{2}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}$/',$fecha)){//FORMATO 1989-04-02
       echo "la fecha ".  $fecha; 
     }else{
         echo "fallo";
     } 
            die();
            
           yii::app()->periodo->toISO('17/02/201455');
           // VAR_DUMP($registro->checkcompromisos(get_class($registro)));DIE();
            
            
            
           /* echo "2015-12-03 23:45:12    :  ". yii::app()->periodo->toISO("2015-12-03 83:45:12"). "    <BR>"; 
            echo "2015/12/03 23:45:12    :  ". yii::app()->periodo->toISO("2015/12/03 23:45:12 "). "    <BR>"; 
            Echo "12-03-2015    :  ". yii::app()->periodo->toISO("12-03-2015"). "    <BR>"; 
             Echo "12/03/2015    :  ". yii::app()->periodo->toISO("12/03/2015"). "    <BR>"; DIE();
            
              echo "2015-12-03 23:45:12    :  ". yii::app()->periodo->toISO("2015-12-03 83:45:12"). "    <BR>"; 
            echo "2015/12/03 23:45:12    :  ". yii::app()->periodo->toISO("2015/12/03 23:45:12 "). "    <BR>"; 
            Echo "12-03-2015    :  ". yii::app()->periodo->toISO("12-03-2015"). "    <BR>"; */
             Echo "12/03/2015 08:23:15   :  ". yii::app()->periodo->fechaparaMostrar("12-03-2015 08:23:15"). "    <BR>"; DIE();
            
             
             
             echo  preg_replace('/\//', "-", "2005/12/03");die();
            
           var_dump(!yii::app()->periodo->verificaFechas('2017-09-02' ,date('Y-m-d')));die();
            die();
            clearstatcache();
            $ruta = 'recurso/';
      $archivo='nino.pdf';
if (is_dir($ruta))
{
   header('Content-Type: application/force-download');
   header('Content-Disposition: attachment; filename='.$archivo);
   header('Content-Transfer-Encoding: binary');
   header('Content-Length: '.filesize($ruta));

   readfile($ruta); 
}else{
    echo $ruta."   No es un archivo";
}
   die();
            
            
            
            
           var_dump(Alinventario::getrotacion('125'));die();
            
            echo yii::app()->periodo->diasentre('2016-04-12','2016-04-16');die();
            
            var_dump(yii::app()->db->createCommand()->
                select('codobjeto')->
           from('{{objetos_cliente}}')->limit(1)->queryScalar());die();
         var_dump(Contactos::getListMailEmpresa('107031', '145')); die();
            
            
            
            var_dump(yii::app()->correo->ValidateAddress('address'));die();
            
            
            
            
            var_dump(yii::app()->tipocambio->vacanciastotales('2017-01-01','2017-02-15')); 
            die();
            
            
            
            
            
            
            
          PRINT_R(yii::app()->tipocambio->vacancias('USD','2015-12-14','2016-02-05'));DIE();
        $fechas=yii::app()->db->createCommand()->
                select('fecha')->
           from('{{logtipocambio}}')->
           where("fecha <= :fechitasup ",
           array(":fechitasup"=>date('Y-m-d'))
                   )->order("fecha desc")->queryColumn() ; 
        var_dump($fechas);
        die();   
            
            
         echo date('Y-m-d H:i:s');die();
date_default_timezone_set('Europe/London');

if (date_default_timezone_get()) {
    echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
}

if (ini_get('date.timezone')) {
    echo 'date.timezone: ' . ini_get('date.timezone');
}

die();
            
            
            
           VAR_DUMP( yii::app()->tipocambio->getVenta('USD','2016-02-16'));DIE();
            echo date("w",time());die();
            $clase= New Tempdesolpe();
            print_r($clase->enumModels());die();
           $p=yii::app()->basePath.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR;
           $modulosp=array();
            $modelosp=array();
           foreach (scandir($p) as $f) {
               
              // var_dump($f); echo "<br><br><br>";
				if ($f == '.' || $f == '..') {
					continue;
				}
				if (strlen($f)) {
					if ($f[0] == '.') {
						continue;
					}
				}
                                    if(is_dir($p.$f.DIRECTORY_SEPARATOR.'models')){
                                        foreach(scandir($p.$f.DIRECTORY_SEPARATOR.'models') as $archivo)
                                                {
                                                        if ($archivo == '.' || $archivo == '..') {
                                                            continue;
                                                            }
                                                            if (strlen($archivo)) {
                                                            if ($archivo[0] == '.') {
                                                                    continue;
                                                                    }
                                                            }
                                                        if(is_file($p.$f.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$archivo)                   
                                                                )  {
                                                            $modelosp[]=substr($archivo,0,strpos($archivo,'.php'));
                                                        }  
                                                    }
                                    }
				//$modulosp[]=$p.$f.DIRECTORY_SEPARATOR.'models';

			}
                   print_r($modelosp);
           die();
            
            
            
            
            
            $client = Yii::createComponent
                    (array(
                    'class' => 'ext.GWebService.GSoapClient',
                    'wsdlUrl' => 'http://ws.insite.pe/sunat/ruc.php?wsdl'
                        )   );
 
// remote method parameters are passed as an array
     VAR_DUMP($client->call('consultaRUC', array('ruc'=>'20600279832')));
             die();
            
            
            
            
            
            
            
            
            
            
            
            
            
             var_dump(date("w",time())) ;die();
           $citer=New CDBCriteria;
        $citer->addCondition("codmondef=:monedadef AND codmon1=:monedaacomprar");
        $citer->params=array(":monedadef"=>'PEN' ,":monedaacomprar"=>'USD' );
        $ultima= yii::app()->db->createCommand()->select('id,compra,venta,dia,ultima,iduser')->
        from('{{tipocambio}}')->
        where($citer->condition,$citer->params)->queryAll();
        //var_dump($moneda);yii::app()->end();
        //if(!$ultima!=false)
          // throw new CHttpException(500,__CLASS__.' '.__FUNCTION__.'  '.__LINE__.'  No se ha registrado tipo de cambio compra para la moneda '.$moneda);
        var_dump($ultima);die(); 
            
            
            
            
            $client = Yii::createComponent
                    (array(
                    'class' => 'ext.GWebService.GSoapClient',
                    'wsdlUrl' => 'http://www.webservicex.net/CurrencyConvertor.asmx?WSDL'
                        )   );
 
// remote method parameters are passed as an array
     VAR_DUMP($client->call('ConversionRate', array('FromCurrency'=>'USD','ToCurrency'=>'PEN')));
             die();
            //var_dump(Docingresados::model()->findByPk(344)->procesosdocusinanular);die();
            $dar=date("H:i:s");
           // var_dump(strtotime($dar));
           // var_dump($dar);die();
            $dia="2016-12-14";
            $hoy=date("Y-m-d");
            $tiempopasado=time()-strtotime($hoy);
            var_dump(date("Y-m-d H:i:s",strtotime($dia)+$tiempopasado));die();
            
                        VwDoci::kpiprovdocuhoras('145','100');die();
            //Yii::app()->user->um->getFieldValue(5,'codtra');die();
            echo Trabajadores::getNombresFromIdUsuario(5); echo "<br>";
            echo Trabajadores::getNombresFromIdUsuario(2);echo "<br>";
              echo Trabajadores::getNombresFromIdUsuario(3);echo "<br>";
               echo Trabajadores::getNombresFromIdUsuario(4);echo "<br>";
                echo Trabajadores::getNombresFromIdUsuario(5);echo "<br>";
                DIE();
                
            
            var_dump(Docingresados::clipro_from_ids(array(702,703,704,705,706)));die();
            var_dump(Configuracion::valor('280',
                    '1203', 
                    '1238',
                        '6'));die();
            
            print_r(Docingresados::model()->findBypK(67)->recuperaarchivos(true));
             print_r(Docingresados::model()->findBypK(67)->recuperaarchivos(false));
            die();
            echo "erer";
            print_r(Tenencias::model()->findByPk('400')->tenenciaprocauto);die();
             echo   Procesosdocu::model()->findByPk(276)->tiempopasado(); die();
            echo MiFactoria::tiempopasado('2016-11-30 00:00:00'); die();
            
            VAR_dump(Configuracion::valor(
                                    '280',
                                     '1203', 
                                    '1012' ));die();
                                    
            echo   Procesosdocu::model()->findByPk(276)->tiempopasado(); die();
            
            
           $this->layout='//layouts/column2';
           echo  CHtml::openTag("span",array("class"=>"icon icon-man"),true);die();
            
            
            
            $registro=New VwDocuIngresados;
            $datos=$registro->datosParaLineaTiempo(19);
            $cuantos=count($datos);
            print_r($registro->datosParaLineaTiempo(19)[0]);
            echo "<br>";
             print_r($registro->datosParaLineaTiempo(19)[$cuantos-1]);die();
            
            
            echo MiFactoria::tiempopasado('2016-11-22 18:34:42'); die();
            $cifrax= base64_encode($cifra);
           echo "encriptado  ". var_dump($cifrax)."<br>";
            $cifran= base64_decode($cifrax);
            var_dump($cifran); die();
            var_dump((integer)microtime(true)*10000);die();
            
                                    echo "/public_html/recurso/carpeta/280/pdf/6/26_0_1.47976117335E+13_1.pdf";
           var_dump(rename(
                   '/home/neotegni/public_html/recurso/carpeta/280/pdf/6/26_0_1.47976435572E+13_1.pdf' ,
                   '/home/neotegni/public_html/recurso/carpeta/280/pdf/6/26_ORDEN_DE_COMPRA_4500078027_1.47976435572E+13_1.pdf' )); die();
            
           ECHO  CHtml::encode(utf8_encode(" PERNO  1/2 ' <> &&& "));DIE();
      $this->layout='//layouts/column2';
       
        
        $this->widget('CTreeView',array(
    'id'=>'unit-treeview',
    'url'=>array('request/fillTree'),
    'htmlOptions'=>array(
        'class'=>'treeview-red'
    )
));
        
  
            die();
          
           var_dump($registro);die();
           var_dump($proceso->tenenciastraba);die();
        
       // ->eventos->descripcion
           
           
            $this->render('//site/mensajes');die();
           
            
            
              echo "Comprobar el directorio con la funcio is_dir()    :     is_dir(".Yii::getPathOfAlias('webroot').")  <br> ";
   var_dump( is_dir(Yii::getPathOfAlias('webroot')));
	 echo "<br><br><br>";
	 echo "Archivos del directorio ". Yii::app()->getTheme()->basePath."  <br>";
	 $archivos=CFileHelper::findFiles(		Yii::app()->getTheme()->basePath.DIRECTORY_SEPARATOR,
		   									array(
			   									'fileTypes'=>array('css','php'),
												'exclude'=>array(),
												'level'=>-1,
												'absolutePaths'=>true
		  									 )
	 									);
	 print_r($archivos);DIE();

            
            
            
            $model =new Almacendocs;
            $registro= Desolpe::model()->findAll("id=268");
            var_dump($registro[0]->punitreal);die();
            echo "<br>";
            $registro->setScenario('buffer');
            var_dump($registro->save()); echo "<br>";
            print_r($registro->attributes);die();
            $registro=$model->find("numvale=:vnumvale",array(":vnumvale"=>'507000000008'));
           var_dump($registro);  die();          
            VAR_DUMP(Almacendocs::valepornumero('507000000008'));die();
            $registro= Tempdesolpe::model()->findByPk(244);
            //$var_dump($registro);
            var_dump($registro->numeroitem);die();
         echo '/home/neotegni/public_html/recurso/carpeta'; 
         var_dump(is_writable('/home/neotegni/public_html/recurso/carpeta'));
         
         echo "<br>";
            echo '/carpeta'; 
         var_dump(is_writable('/carpeta'));
         die();
         //($_SERVER['HTTP_USER_AGENT']);
            $reg=new Tempdetot();
            $reg->colocaarchivox('/home/neotegni/public_html/recurso');
       
            die();
            $archivo="/recurso/images/210/jpg/3/14_14744927089492_1.jpg";
            $pare=  pathinfo($archivo);
            echo $archivo; echo "<br>";
            var_dump($pare);die();
            //$foto=New Directoriofotos('100',572,5,'/images','.jpg');
            $foto=  Tempdetot::model()->findByPk(187);
            var_dump($foto);die();
        //  var_dump($foto->creacarpeta());die();
            //echo "carpeta destino :<br>";
            //var_dump($foto->_carpetadestino);die();
            echo "<br>";
            $archivo="C:/xampp/htdocs/recurso/webcam.jpg";
          // var_dump($foto->colocaarchivo($archivo));
            var_dump($foto->getauditoria());
            die();
            
            
                $ot=Ot::model()->findByPk(14);
               var_dump( $ot->tienesolpeabierta('S')->attributes);die();
            
            
            
            
		$reg=Desolpe::model()->findByPk(143);
		var_dump($reg);die();

		$reg=new Ot;
		$reg=Ot::model()->findByPk(8);
		var_dump($reg->desolpe);die();


		var_dump(microtime(true));
		var_dump(microtime());die();

		$mane=array('uno','dos','tres','cuatro','cinco','seis','siete','ocho');
		$mane2=array('uno','seis','siete','ocho');

		var_dump(array_diff($mane2,$mane));die();
		$criteria=New CDbCriteria();
		$criteria->addCondition("codal='850'");
		$registros=New CActiveDataProvider('Desolpe', array(
    'criteria'=>$criteria,
  ));
		//var_dump($registros->model);
		var_dump($registros->modelClass);
		var_dump($registros->keyAttribute);
		var_dump($registros->keys);
		var_dump($registros->getdata());
		var_dump($registros->itemCount);
		var_dump($registros->id);
		var_dump($registros->totalItemCount);






		$inventario=Alinventario::model()->findByPk(71);

		//$regis=Solpe::solpeautomatica($inventario);
		var_dump($inventario->refrescapreciolote());die();




		VAR_DUMP(yii::app()->tipocambio->getcambio(
			'PEN',
			'PEN'
		)); DIE();
		$valores=Yii::app()->db->createCommand()
			->select(' * ')
			->from('{{alinventario}} a')
			->where(" a.codalm= '140' and cantlibre >0  ")
			//->group('a.codalm,  a.codcen')
			->queryAll();
		var_dump($valores);die();


		var_dump(yii::app()->periodo->estadentroperiodo('2016-07-01',false));die();
		$cad=array("dedalo_eotoeote","amidatdes_eo945894594","cox_35893583jjj");
		$ade=array_map("substr(,'_',1)",$cad);



		var_dump( yii::app()->tipocambio->getcambio('USD','PEN'));DIE();
		//echo " el ". $registro->tienekardex();die();
		$reg=Alkardex::model()->findByPk(343);
		echo "monoto base   ". Alkardex::model()->findByPk(343)->montobase()."<br>";
		echo "preciounitario base base ( ".$reg->codmoneda." )  con parametro  :  ".$reg->preciounitariobase($reg->codmoneda)."<br>";
		echo "punit base   ". Alkardex::model()->findByPk(343)->punitbase()."<br>";
		echo "cantidad  base   ". Alkardex::model()->findByPk(343)->cantidadbase()."<br>";
		echo "monot movido    ". Alkardex::model()->findByPk(343)->getmonto()."<br>";
		die();
		$CLAV=array("12000001", "1203", "140");
		$modelo=Maestrodetalle::model()->findbYpK($CLAV);
		VAR_DUMP($modelo);DIE();
		$modeloatratar=New Maestrodetalle;
		$campos= $modeloatratar->getMetaData();
		$clave=$campos->tableSchema->primaryKey;
		var_dump($campos);
		var_dump($clave);
		die();
		$registro=Alinventario::model()->findByPk(46);
		echo "getStockValTotal()    ";var_dump($registro->getStockValTotal()); echo "<br><br>";
		echo "getStockValCentro() ";var_dump($registro->getStockValCentro()); echo "<br><br>";
		echo "getStockValAlmacen() ";var_dump($registro->getStockValAlmacen()); echo "<br><br>";
		echo "getStockMatTotal('12000012') ";var_dump($registro->getStockMatTotal('12000012')); echo "<br><br>";
		echo "getStockMatCentro('12000012') ";var_dump($registro->getStockMatCentro('12000012')); echo "<br><br>";
		echo "getStockMatAlmacen('12000012') ";var_dump($registro->getStockMatAlmacen('12000012')); echo "<br><br>";
		echo "getStockTotalAlmacen('125') ";var_dump($registro->getStockTotalAlmacen('450',null)); echo "<br><br>";
		die();


		//var_dump($registro->getStockValAlmacen());die();
		var_dump($registro->getStockTotalAlmacen('125',0));
			Maestrodetalle::model()->findByPk(array('codart'=>'12000012','codcentro'=>'1203','codal'=>'450'));
		VAR_DUMP($registro->tienekardex);
		echo " el ". $registro->tienekardex();die();
		echo "monoto base   ". Alkardex::model()->findByPk(333)->montobase()."<br>";
		echo "punit base   ". Alkardex::model()->findByPk(333)->punitbase()."<br>";
		echo "cantidad  base   ". Alkardex::model()->findByPk(333)->cantidadbase()."<br>";
		echo "monot movido    ". Alkardex::model()->findByPk(333)->getmonto()."<br>";
		die();
		echo 3* Alconversiones::convierte('12000012', '100');die();

		/*$KARDEX=Alkardex::model()->findByPk(229);;
		$KARDEX->insertaCCgastos($KARDEX->colector); die();*/

		$cantidad=$_GET['canti'];
		$inventario=Alinventario::model()->findByPk(73);
		echo "costea  ".$inventario->costealote($cantidad,'F')."<br>";
		//echo "descargalote   ".$inventario->descargalote($cantidad,'F')."<br>";
		echo "PRECIO FINAL DE INVENTARIO   ".$inventario->refrescapreciolote();die();



		$daed= array(true,'30',null,'09');$estado="30";
		var_dump(in_array($estado,$daed,true));	yii::app()->end();
		$compra=Ocompra::model()->findByPk(166);
		var_dump($compra->detallefirme[0]);
		yii::app()->end();
		foreach($compra->relations() as $clave=>$valor){
			var_dump($compra->{$clave});
			yii::app()->end();
		}
		yii::app()->end();
		$inventario=new Alinventario();
		var_dump($inventario->getStockMatCentro('18000005'));
		yii::app()->end();

		$valores=array(805=>'Desolpe',806=>'Desolpe',807=>'Desolpe');
		yii::app()->maletin->ponervalores($valores);
		var_dump(yii::app()->maletin->getvalues('Desolpe'));yii::app()->end();





		var_dump(yii::app()->user);
		echo "<br>";
		echo "<br>";
		echo "<br>";
		$elusuario=Yii::app()->user->um->LoadUserById(yii::app()->user->id);
		var_dump($elusuario);
		$sesion_activa=Yii::app()->user->um->findSession($elusuario);
		echo "<br>";
		ECHO " LA DURACION MAXIMA DE LA SESION ".Yii::app()->user->um->getDefaultSystem()->getn('sessionmaxdurationmins')."   Minutos";
		echo "<br>";
		ECHO " la sesion expira  ".date("Y-m-d H:i:s",$sesion_activa->expire);
		echo "<br>";
		ECHO " la sesion inicio en ".date(" H:i:s",$sesion_activa->created);
		echo "<br>";
		ECHO " Ultimo uso  ".date("H:i:s",$sesion_activa->lastusage);
		echo "<br>";
		ECHO " la hora actual  ".date("H:i:s");
		echo "<br>";
		ECHO " El id  de l sesion ".$sesion_activa->idsession."   <br>";
		echo "<br>";
		ECHO " El id  de l sesion directamente yii::app()->user->idsession ".yii."   <br>";
		echo "<br>";
		ECHO " Han pasado :   " .((time()-$sesion_activa->created)/(60))."   minutos       con  ";
		echo "<br>";
		echo "  Sesion expirada? :
		        ->             ".var_dump($sesion_activa->isSessionExpired());
		echo "<br>";
		echo "  Sesion name  : ".$sesion_activa->getSessionName();
		echo "<br>";
		echo"  Sesion valida : ".$sesion_activa->validateSession();

		//	$sesion_activa->getSessionFilter();
		echo "<br>";
		//print_r($sesion_activa);
		yii::app()->end();






		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{14000035.*}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
		print_r($images);
		yii::app()->end();


		echo "  falta copmpraer ".Desolpe::model()->findByPk(730)->cuantofaltacomprar();
		yii::app()->end();


		ECHO  "  del material azufre <br>";
		echo "   una caja   vale :  ".Alconversiones::convierte('18004728','190')."     unidades <br>";
		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123')."     unidades <br>";
		echo "   unA caja  vale :  ".Alconversiones::convierte('18004728','190','120')."     unidades <br>";
		echo "   unA UNIDAD  vale :  ".Alconversiones::convierte('18004728','120','190')."    CAJAS <br>";
		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123','120')."     unidades <br>";
		echo "   unA UNIDAD  vale :  ".Alconversiones::convierte('18004728','120','123')."    KILOGRAMOS <br>";


		echo "   un KG  vale :  ".Alconversiones::convierte('18004728','123','190')."    CAJAS <br>";
		echo "   unA CAJA  vale :  ".Alconversiones::convierte('18004728','190','123')."    KILOGRAMOS <br>";
		yii::app()->end();
             $model=new Noticias();

		var_dump(get_class($model));
		yii::app()->end();


		var_dump(count(Peticion::model()->search()->getdata()));
		yii::app()->end();


		ini_set ( 'soap.wsdl_cache_enable' , 0 ); ini_set ( 'soap.wsdl_cache_ttl' , 0 );
		$wsdlURL='https://www.sunat.gob.pe/ol-ti-itcpgem-beta/billService?wsdl';
		$client=new SoapClient($wsdlURL);
		var_dump($client->__getFunctions());
		ECHO "<BR>";
		ECHO "<BR>";
		var_dump($client->__getTypes());
		//var_dump($client);
		yii::app()->end();
		//$result=$client->giveTimestamp();
		//echo $result;












		echo yii::getPathOfAlias('webroot.materiales');
		//echo yii::app()->baseUrl;
		YII::APP()->END();
		/*var_dump(yii::app()->request);
		echo "<br>";
		print_r(yii::app()->request->baseUrl);*/
		echo yii::app()->getBaseUrl(true);
		echo "<br>";
		var_dump( is_dir(yii::app()->getBaseUrl(true)));

		YII::APP()->END();


		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
		print_r($images);
		yii::app()->end();



	var_dump( is_dir("/public_html/recurso/materiales/"));

        YII::APP()->END();


		var_dump(yii::app()->estadisticas->linear_regression(array(2,3,3.5,5), array(2,3,4,6)));



		$this->render('//alinventario/vw_loginventario',array());

		yii::app()->end();


  $modelinv=Alinventario::model()->findByPk(343569);
		$modelinv->actualiza_stock('77',1,null);
		yii::app()->end();



		echo Yii::app()->baseUrl;
		yii::app()->end();



		$criterio=new CDbcriteria;
		$criterio->addcondition("hidsolpe=:vid");
		$criterio->params=array(":vid"=>387);
		$objeto= new Miproveedor('Desolpe',array('criteria'=>$criterio));
		//var_dump($objeto->getdata());
		$objeto->camposasumar=array("TOTAL CANTIDAD"=>'cant','SUBTOTAL PLANEADO'=>"punitplan",'SUBTOTAL REAL'=>"punitreal");
		$subtotales=$objeto->Total();
		var_dump($subtotales);
		yii::app()->end();



		$nuevoarray=array();
		$nuevoarray['uno']=1;
		$nuevoarray['dos']=2;
		var_dump($nuevoarray);
		yii::app()->end();


		$criterio=new CDbcriteria;
		$objeto= new CActiveDataProvider('Impuestos');
// $dataProvider->getData() will return a list of Post objects
         var_dump($objeto->getdata());
		yii::app()->end();







		//echo Almacendocs::model()->findByPk(709)->almacendocs_almacenmovimientos->eventos->estadofinal;
		var_dump(Almacendocs::model()->findByPk(709)->almacendocs_almacenmovimientos);
		yii::app()->end();


		$criterio=New CDbCriteria();
		$criterio->addCondition("hidguia=:xdet");
		$criterio->params=array(':xdet'=>59);
		//var_dump($criterio->condition);
		print_r(MiFactoria::arrayColumnaSQL(Docompra::model()->tableName(),'id',$criterio));
      yii::app()->end();



		$images = glob(yii::getPathOfAlias('webroot.materiales').DIRECTORY_SEPARATOR."{*.JPG,*.PNG,*.JPEG,*.GIF,*.BMP}",GLOB_BRACE);
		//echo yii::getPathOfAlias('webroot.materiales.gallery').DIRECTORY_SEPARATOR;
		//echo "<br>";
//imprime el nombre de cada archivo
		foreach($images as $image)
		{
			echo $image . '<br />';
		}
          print_r($images);
       yii::app()->end();

		$modelito=new Ocompra();
		$modelito->codocu=$this->documento;
		echo $modelito->correlativo('numcot');
		yii::app()->end();

		echo dirname(__FILE__).'/css/estilogrid.css';
		var_dump(is_file($_SERVER['SCRIPT_NAME'].'/css/estilogrid.css'));
		//ECHO "..//".(strlen(dirname($_SERVER['SCRIPT_NAME']))>1 ? dirname($_SERVER['SCRIPT_NAME']) : '' ) . '/css/estilogrid.css';
		yii::app()->end();

		// una ffraccion de la forma   1/2 , 3/4 , 45/3, 1 /2 , 7./3 , 1/ 3, 234/567,  4/.5 ,
		$cadena1="PERNO  11/45 INOXIDABLE  7/8 HF   1/2 x 3/4  1/12 * 5/16 ";
		$cadena2="PERNO   12./. 56  3 1/2 INOXIDABLE  17/8 HF ";
		$cadena3="PERNO  45/ 34 INOXIDABLE  7./ 8 HF ";
		$cadena4="PERNO  1/2 4 5/34 INOXIDABLE  7 /8  HF ";
		$cadena5=" PERNO   4/.63 INOXIDABLE  756/458 HF ";
		$cadena6="3/4 PERNO  1 / 3 INOXIDABLE  17/8*1 HF ";
		$cadena7="PERNO INOXIDABLE  3*41 25/16 1781 HF ";

		$patron="/^(\s)[0-9]{1,}[\.|\s]?[\/]{1}[\.|\s]?[0-9]{1,}(\s)$/";
		$patron2='/[1-9]{0,}+[\s|*|x|X]{1}[0-9]{1,}[\.|\s]{0,1}[\/]{1}[\.|\s]{0,1}[0-9]{1,}[\s|*|x|X]{1}/';
		echo $cadena1. "    ". preg_match_all($patron2,$cadena1,$resultado1) ."<br>";
		print_r($resultado1);
		echo "<br>";
		echo "<br>";
		echo $cadena2. "    ". preg_match_all($patron2,$cadena2,$resultado2) ."<br>";
		print_r($resultado2);
		echo "<br>";
		echo "<br>";
		echo $cadena3. "    ". preg_match_all($patron2,$cadena3,$resultado3) ."<br>";
		print_r($resultado3);
		echo "<br>";echo "<br>";
		echo $cadena4. "    ". preg_match_all($patron2,$cadena4,$resultado4) ."<br>";
		print_r($resultado4);
		echo "<br>";echo "<br>";
		echo $cadena5. "    ". preg_match_all($patron2,$cadena5,$resultado5) ."<br>";
		print_r($resultado5);
		echo "<br>";echo "<br>";
		echo $cadena6. "    ". preg_match_all($patron2,$cadena6,$resultado6) ."<br>";
		print_r($resultado6);
		echo "<br>";echo "<br>";
		echo $cadena7. "    ". preg_match_all($patron2,$cadena7,$resultado7) ."<br>";
		print_r($resultado7);
		echo "<br>";echo "<br>";
		//echo $cadena8. "    ". preg_match('/^(\s)[0-9]{1,}[\.|\s]?[\/]{1}[\.|\s]?[0-9]{1,}(\s)$/',$cadena1) ."<br>";


		yii::app()->end();

		print_r(Yii::app()->user->rbac->getMenu());
		yii::app()->end();
		//$model=new Impuestos;
		yii::app()->crugemailer->mail_con_archivo ('neotegnia@gmail.com','hipogea@hotmail.com','hi','130165');
	//	var_dump(mail('neotegnia@gmail.com','holas','holas'));
		yii::app()->end();
		echo Valorimpuestos::getimpuesto ( '200');

		$model->codocumento='1';
		ECHO Valorimpuestos::model()->getimpuesto('100');
		yii::app()->end();
		$model->codocumento='130';
		echo $model->Correlativo('numero');
		yii::app()->end();
		$modelin=CactiveRecord::model('Alkardex');
		print_r($modelin->getTableSchema());
		yii::app()->end();


		echo get_include_path();
		yii::app()->end();


		ECHO " la sesion expira  ".date("Y-m-d,H-i:s");
		yii::app()->end();


		echo MiFactoria::decimal(47/3);
		yii::app()->end();


		print_r(MiFactoria::opcionestoolbar(345,'130','20'));
		yii::app()->end();
		$model=new Inventario();
		$objeto=$model->getMetaData();
		foreach($objeto->columns as $columna)
		{
			echo "campo  ".$columna->name."    ancho ".$columna->size."  el tipo  : ".$columna->dbType."<br>";

		}
		print_r($objeto->columns);

		//$model->rucpro='121212121212121';
		//$model->save();
		//print_r($model->getMetaData());
		yii::app()->end();




		$movimientoauxiliar='45';
		$filakardexoriginal=Alkardex::model()->findByPk(1691);
		$filakardexoriginal->alkardex_alinventario->actualiza_stock($movimientoauxiliar,abs(3),null);
		yii::app()->end();




		$modeloreserva=Alreserva::model()->findByPk(255);
		var_dump($modeloreserva->alreserva_cantidadatendida);
		yii::app()->end();
		var_dump($kardex=Alkardex::model()->findByPk(1514)->alkardex_despacho);
		yii::app()->end();
		//tag(string $tag, array $htmlOptions=array ( ), mixed $content=false, boolean $closeTag=true)
		$arrayes=Almacendocs::model()->findAll("numvale=:nimi",array("nimi"=>trim('130200000129')));
		echo count($arrayes);
		yii::app()->end();


		if(is_dir('assets'))
			echo " si es un directrio";
		yii::app()->end();

		Yii::app()->crugemailer->prueba();

		//echo CHtml::tag("div",array("style"=>"font:23px;fotn-size:445;"),"AQUI",true);
		$calse=new Cc();
		ECHO $calse::BELONGS_TO;
	//	var_dump($calse);

		//phpinfo(INFO_MODULES);
		yii::app()->end();
		//tag(string $tag, array $htmlOptions=array ( ), mixed $content=false, boolean $closeTag=true)
		$arrayes=Almacendocs::model()->findAll("numvale=:nimi",array("nimi"=>trim('130200000129')));
       echo count($arrayes);
		yii::app()->end();

		echo strpos("manicomo","c");

		Yii::app()->user->setFlash('error', "MENSAJE ERRO1");
		Yii::app()->user->setFlash('error2', "MENSAJE ERR2");
		Yii::app()->user->setFlash('error3', "MENSAJE ERR3");
		Yii::app()->user->setFlash('notice', "MENSAJE NORICE1");
		Yii::app()->user->setFlash('notice2', "MENSAJE NOTICE2");
		Yii::app()->user->setFlash('notice3', "MENSAJE NOTICE3");
		Yii::app()->user->setFlash('success', "SUCCESS ERRO1");
		Yii::app()->user->setFlash('success2', "SUCCESS ERR2");
		Yii::app()->user->setFlash('success3', "SUCCESS ERR3");

     // PRINT_R(Yii::app()->user->getFlashes());



		yii::app()->end();
		//$this->ConfirmaBuffer($id);

		$kardexhijos=MiFactoria::DevuelveKardexHijos($id);

		echo count($kardexhijos);
		/*foreach ( $kardexhijos as $filakardex ) {
			//$filakardex->preciounit=$filakardex->getMonto();
			//$filakardex->VerificaCantAtenReservas();
			//$filakardex->InsertaAtencionReserva($filakardex->id);
			echo "   id del kardex ".$filakardex->id."<br>";
			//$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmov,abs($filakardex->cantidadbase()),null);

			//$filakardex->InsertaCcGastos();
		}
	*/
		yii::app()->end();




		$id=160;
		$modeloreserva=Alreserva::model()->findByPk($id);
		$modeloreserva->anular();
		PRINT_R(Yii::app()->user->getFlashes());
		yii::app()->end();




		$id=490;
			$kardexhijos=MiFactoria::DevuelveKardexHijos($id);
		//var_dump($kardexhijos);

			foreach ( $kardexhijos as $filakardex ) {

				//calculando el precio unitario
				$filakardex->preciounit=$filakardex->getMonto();
				IF($filakardex->VerificaCantAtenReservas())
					PRINT_R($filakardex->mensajes);

				//ECHO " GRABA  ".$filakardex->InsertaAtencionReserva($filakardex->id);

				$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmov,abs($filakardex->cantidadbase()),null);
                print_r($filakardex->alkardex_alinventario->mensajes);
				//verificandso si hay errrores recoger los mensajes
				/*if(!$filakardex->VerificaCantAtenReservas() or
                    !$filakardex->InsertaAtencionReserva() or
                    !$filakardex->alkardex_alinventario->actualiza_stock($filakardex->codmovimiento,$filakardex->cant,null)
                   )
                 $this->mensajes=array_merge($this->mensajes,$filakardex->mensajes,$filakardex->alkardex_alinventario->mensajes);
          */

				$filakardex->InsertaCcGastos();

			}

		yii::app()->end();




		//$nuevo=new MiFactoria();
		//Mifactoria::InsertaAtencionReserva(1357);


		$row=Alkardex::model()->findByPk(NULL);
		$matrix= Alreserva::model()->findAll("hidesolpe=:vhidsolpe AND codocu='450' ",array(":vhidsolpe"=>$row->idref));
		$model=new Atencionreserva();
		$model->cant=$row->cant;
		$model->hidkardex=$row->id;
		$model->hidreserva=$matrix[0]['id'];
		$model->estadoatencion=Atencionreserva::ESTADO_CREADO;
		if(!$model->save())
			throw new CHttpException(500,"NO se Pudo insertar el registro de atenciones reservas ");
		unset($model);unset($matrix);unset($row);
		yii::app()->end();



           $mimo=new ModeloGeneral();
		   $mimo->insertamensaje('success','primermamesaje');
		$mimo->insertamensaje('success1','segundo mensaje');
		$mimo->insertamensaje('error','tercer mensaje');
		$mimox=new ModeloGeneral();
		$mimox->insertamensaje('successx','primermamesaje');
		$mimox->insertamensaje('success1x','segundo mensaje');
		$mimox->insertamensaje('errorx','tercer mensaje');
		/*$gg= new Alinventario();*/
		print_r($mimo->mensajes);
		echo "<br><br>";
		print_r($mimox->mensajes);
		$mensaj=array();
		$mensaj=array_merge($mensaj,$mimo->mensajes);
		$mensaj=array_merge($mensaj,$mimox->mensajes);
		//array_merge($mensaj,$mimox->mensajes);
		//$mensaj[]=$mimo->mensajes;
		//$mensaj[]=$mimox->mensajes+$mimo->mensajes;
		//array_push($mensaj,$mimox->mensajes);
		echo "<br><br>";
		print_r($mensaj);

		yii::app()->end();


		var_dump(Almacenmovimientos::model()->findByPk('10')->signo);
		//echo "total   ".Alinventario::getStockTotal('11000004');
		yii::app()->end();
		/*if(Yii::app()->periodo->getModel()->HoyDentroPeriodo()){
			echo "ESTAMOS DENTRO DEL PERIODO";
		} else {
			echo "no  ESTAMOS DENTRO DEL PERIODO";
		}

		yii::app()->end();*/

		if(Yii::app()->periodo->verificaFechas('2015-03-5','2015-03-4')){
			echo "ESTAMOS DENTRO DEL PERIODO";
		} else {
			echo "no ESTAMOS DENTRO DEL PERIODO";
		}

		yii::app()->end();


$gg=new Alkardex();
		//$gg=Alkardex::model()->findByPk(1236);
		//var_dump($gg->oldAttributes);
		ECHO "<BR><BR> ESCENARIO :".$gg->getScenario()."<BR>";
		$gg->save();
		var_dump($gg->errors);


		$ggt=new Tempalkardex();
		//$gg=Alkardex::model()->findByPk(1236);
		//var_dump($gg->oldAttributes);
		ECHO "<BR><BR> ESCENARIO :".$ggt->getScenario()."<BR>";
		$ggt->save();
		var_dump($ggt->errors);
		yii::app()->end();
		$matriz=$gg->relations();
		$nuevoarr=array();
		//print_r($matriz);
		foreach($matriz as $clave=>$matricita)
		{
				     if($matricita[0]=='CHasManyRelation')
					   $nuevoarr[$matricita[2]]=$matricita[1];
			        }
		print_r($nuevoarr);
		//$hallo=array_search('CHasManyRelation',$matriz);
    // echo var_dump($hallo);
		yii::app()->end();
		$arreglo=array();
		/*$arreglo1=array('uno'=>1);
		$arreglo2=array('dos'=>2);
		$arreglo3=array('tres'=>3);*/
		$arreglo['uno']=1;
		$arreglo['dos']=2;


		print_r($arreglo);
		yii::app()->end();

		/***********************************************
		 * Prueba de la propieda mensajes ARRAY() de
		 * la clase MODELOGENERAL
		 *
		 * *******************       */
		$modelo=new ModeloGeneral();
		$modelo->insertamensaje('error','MENSAJE 1');
		$modelo->insertamensaje('error','MENSAJE 2');
		$modelo->insertamensaje('error','MENSAJE 3');
		$modelo->insertamensaje('notice','notice 1');
		$modelo->insertamensaje('notice','notice 2');
		$modelo->insertamensaje('success','succes 3');
         echo $modelo->parsemensajes('error');
		echo $modelo->parsemensajes('notice');
		echo $modelo->parsemensajes('success');
		//PRINT_R($modelo->mensajes);
		yii::app()->end();
		foreach($arreglo as $registro) {
			echo $registro->cant;
			echo " <br><br>";
		}
		//var_dump($modelo->desolpe_alreserva);
		yii::app()->end();
		/***********************************************************
		 *
		 */



		/***********************************************
		 * Prueba de que los registros hijos pueden ser
		 * llmados desde la relacion
		*  HAS:MANY                                   */
		$modelo=Desolpe::model()->findByPk(168);
		$arreglo=$modelo->desolpe_alreserva; ///LLAMA A LA RELACION Y RETORNA OBJETOS HIJOS
		   PRINT_R($arreglo);
		foreach($arreglo as $registro) {
			  echo $registro->cant;
			  echo " <br><br>";
		  }
		//var_dump($modelo->desolpe_alreserva);
		yii::app()->end();
		/***********************************************************
		 *
		 */



		echo Alconversiones::convierte('18005239','120');
           yii::app()->end();
		$petri=new Peticion();
		print_r($petri->behaviors());
		if(array_key_exists('ActiveRecordLogableBehavior',$petri->behaviors()))echo "salio";
		yii::app()->end();


		/*print_r(MiFactoria::ExisteRegistroTemporal('Tempdpeticion',127));
		yii::app()->end();*/
		/*print_r(Peticion::relations());
		$campoenlace=Peticion::getFieldLink(Peticion::relations(),'Peticion','Tempdpeticion');
		echo "<br>";
		echo "campo enl ace   :   ".$campoenlace;
		yii::app()->end();*/
		$id=127;
		$con=$this->IniciaBuffer($id);
		foreach($con as $grupo)
		{
			echo "<br>";
			foreach($grupo as $objeto){
				echo "<br>";
				   foreach( $objeto as $row){
							echo "======================================================<br>";
								print_r($row);
								echo "======================================================<br>";
					  		 echo "<br>";
				   }
			}
			echo "<br>";
		}

		$nombremodelocabecera='Peticion';
		foreach($con as $registroshijos)
		{

			// foreach ($grupo as $registroshijos)
			//{
			// $campoenlace=$nombremodelocabecera::getFieldLink($nombremodelocabecera::relations(), $nombremodelocabecera,$nombremodelohijo);
			// $registroshijos=MiFactoria::getRegistrosHijos($nombremodelohijo,$campoenlace,$id);
			foreach  ($registroshijos as $row)
			{

				if(is_null(MiFactoria::ExisteRegistro('Tempdpeticion',$id))){

					if($row->save()){
					echo " <br>";
					 echo " *********************************";
				echo " <br>";
				   echo "grabo     ".$row->getTableAlias();
				echo " <br>";
				echo " *********************************";
				  echo " <br>";
						}
				}

			  }
		}

		yii::app()->end();
		 print_r($con);
		yii::app()->end();

	//	$lalo=null;
		$modeloant=Solpe::model()->findByPk(239);
		$matriz=$modeloant->relations();
		$palo=$this->recorro($matriz);
		//echo Solpe::HAS_MANY;
		print_r($palo);
		yii::app()->end();

		$modeloant=Solpe::model()->findByPk(239);
		print_r($modeloant->relations());
		//echo $modeloant->codart;
		yii::app()->end();

		$modelo="Dpeticion";
		$s=new $modelo;
		print_r($s);
		yii::app()->end();

		$clasetemporal="Alinventario";
		$valor=$clasetemporal::model()->hasAttribute('codart');
		echo "   gfgfgf ".$valor;
		yii::app()->end();



		$registroshijos=$modelo::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=54 ");

		print_r($registroshijos);
		yii::app()->end();


		$inv='Alinventario';

		$arraymodelos=array();
		$modelo=$inv::model()->findByPk(343563);
		$modelo2=$inv::model()->findByPk(343564);
		array_push($arraymodelos,$modelo);
		array_push($arraymodelos,$modelo2);
		//$nuevomod=Bloqueos::prueba();
		echo $arraymodelos[0]->codart;
		//print_r($modelo);
		yii::app()->end();
         // $modelo=new ModInventario();
		$modelo=ModInventario::loadModel(343563);
		$modeloant=ModInventario::loadModel(343563);
		//echo " hola  ".gettype($modelo->codart);
		//$modelo->actualizaprecio($cantmov,1.23,$this->CAMPO_STOCK_LIBRE);
		$nuevoprecio=500;
		$cantmov=100;
		if($modelo->actualizaprecio($cantmov,$nuevoprecio,ModInventario::CAMPO_STOCK_LIBRE)) {
			echo "ok se relaizo el proceso :<br>";
			echo "cant libre :  ".$modelo->cantlibre."                 anterior : ".$modeloant->cantlibre."<br>";
			echo "cant reserva :  ".$modelo->cantres."                  anterior : ".$modeloant->cantres."<br>";
			echo "cant reserva :  ".$modelo->canttran."                    anterior : ".$modeloant->canttran."<br>";
			echo "Precio unitario :".$modelo->punit."                      anterior : ".round($modeloant->punit,3)."<br>";
			echo "dif de precio unitario :  ".$modelo->punitdif."                 anterior : ".$modeloant->punitdif."<br>";
			echo "cant stock afectado por el ambio de precio  :  ".$modelo->getStockCamposAfectadosPrecio()."<br>";
			echo "cant movida  :   ".$cantmov."<br>";
			echo "precio unitario nuevo  :   ".$nuevoprecio."<br>";
			echo "-------<br><br>";
		} else {
			$matriz=$modelo->getMensajes();
             echo " HAY  ".COUNT($matriz)."     Elementos";
			print_r($matriz);
         foreach( $matriz as $arreglo){
			// echo   "  ".$arregloclave."  :   ".$valor."<br>";
		 }
			echo "hu,,-------<br><r>";
		}

		yii::app()->end();

		$am = new MyCrugeAuthManager;
		$am->init();
		foreach($am->autoDetect() as $itemName)
			printf("%s\n",$itemName);
		echo "  la direccion IP:  ".CrugeUtil::hash("julian");


		echo " es una instancia de ". gettype(Yii::app()->crugemailer);
		/*if (Yii::app()->CrugeMailer instanceof CrugeMailer) {
			echo 'Crugemailer';
		} else  {
			echo "que carajo sera";
		}*/
		yii::app()->end();
        $id=54;
		$difiere=false; ///Asumismos que no ha variado
		$registrosactuales =Tempdpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."tempdpeticion
  																 where
  																 hidpeticion=".$id." and idusertemp = ".Yii::app()->user->id." ");
		$registrosviejos =Dpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=".$id." ");
		foreach ($registrosactuales as $row)
		{   $newattributes = $row->getAttributes(); ///Los valores de este instante
			foreach ($registrosviejos as $rowviejo){
				$oldattributes=$rowviejo->getAttributes();
				echo " Emparewjando : ".$oldattributes['id']."  con  ".$newattributes['id']." <br>";
				if($oldattributes['id']==$newattributes['id'] )  //compaRlo s
				{
					echo " En la fila ".$oldattributes['id']."  : <br>";
					foreach($oldattributes as $clave=>$valor) {
						echo "Comparando  :<br>";
						echo " original  :  ".$clave."                               original=".$valor."   actual=".$newattributes[$clave]."<br>";
						if($valor<>$newattributes[$clave] and $clave<>'idtemp' and $clave<>'idusertemp' ) {
							echo " DIFERENTE <br><br> ";
							$difiere=true;
							break;
						}

					}
					echo "  <br><br><br><br>";
				}

				/* print_r($newattributes );
                    echo "<br>";
                     print_r($atributos);
                   echo "<br><br><br>";*/
				if($difiere)
					break;
			}

			/*print_r($this->bufferdetalle);
			echo "<br>";
			        if($difiere)
				   break;*/
			if($difiere)
				break;
		}

		echo "<br><br>   total    ".$difiere;
		yii::app()->end();




























		$registrostemporalesdpeticion=array();
		$datosdebuffer=array(); ///Estos datos
		$datosbufferdefila=array();
		$registroshijos =Dpeticion::model()->findAllBySql(" select *from
  																".Yii::app()->params['prefijo']."dpeticion
  																 where
  																 hidpeticion=".$hidpeticion."  ");
		foreach  ($registroshijos as $row) {
			///Evitamos levantar items duplicados
			$existeregistro= Tempdpeticion::model()->find("id= ".$row->id." AND idusertemp=".Yii::app()->user->id." ");
			if(is_null($existeregistro)) {  ///Solo si no existe
				$modelotempdpeticion=new Tempdpeticion;
				$modelotempdpeticion->attributes=$row->attributes;
				$modelotempdpeticion->idusertemp=Yii::app()->user->id;
				array_push($registrostemporalesdpeticion,$modelotempdpeticion);

				$datosbufferdefila=$row->attributes;
				//array_push($datosbufferdefila,array('micalve'=>$row->id));
				array_push($datosdebuffer,$datosbufferdefila);
			}
		}
		//print_r($datosdebuffer);

		foreach ($datosdebuffer as $clave=>$atributos){
			 print_r($atributos);
			echo "<br><br>";

		}
		//$this->bufferdetalle=$registrostemporalesdpeticion; ///Guarda el bu¡ffer de datos
		//return $registrostemporalesdpeticion;
		yii::app()->end();










		$arreglo=array();
		$arreglo1=array('uno'=>1);
		$arreglo2=array('dos'=>2);
		$arreglo3=array('tres'=>3);

		array_push($arreglo,array('uno'=>1));
		array_push($arreglo,array('dos'=>2));

		print_r($arreglo);
		yii::app()->end();

    $id=34;
		if($id)
			echo "dsdsdsds eco ";
		yii::app()->end();

		$me=Yii::app()->user->id;
		$cadena= " select distinct idusertemp from ".Yii::app()->params['prefijo']."temppeticion WHERE id=".$id." and idusertemp <> ".$me." ";
		$quien=Yii::app()->db->createCommand($cadena)->queryScalar();
		echo $cadena;
		echo " El tipo de quien ".gettype($quien)."    -----    ".$quien;
		//yii::app()->end();
		if($quien) { /// Quiere decir que hay otros que estan ediotnado el documento
			///PARA VER SIS ES CIERTO DEEBMOS VERIFICAR Q ESTE USUARIO NO HA DEJADO LA VENTANA ABANDONADA CON E DOMCUENTO EN EDICION
			$elusuario=Yii::app()->user->um->LoadUserById($quien);
			///hallando la sesion activa de este usuario
			$sesion_activa=Yii::app()->user->um->findSession($elusuario);
			if(is_null($sesion_activa)) {
				echo "  NO esta cupado man ";  //No esta ocupado por que estaba editando pero ya temrino sus sesion, alo mejor dejo la ventana abierta
			}  else {
				echo "  Estaa cupado por el usuario ".$elusuario->username;  ///Si esta ocupado por que el usuario tiene sesion activa, y eszta editando
			}

		} else {
			echo "  NO esta cupado , estas solo mano  ";
		}

		yii::app()->end();







		$usuariojesus=Yii::app()->user->um->loadUser('admin',false);
		print_r($usuariojesus);

		echo "<br><br><br><br>";
		$modelo=Yii::app()->user->um->findSession($usuariojesus);
       echo  " el tipo retoranado es ".gettype($modelo);
		print_r($modelo);


		echo "<br><br><br><br>El  modelo de sesion de Jesus";
		$modelo=Yii::app()->user->um->findSession(Yii::app()->user->um->loadUser('jesus',false));
		echo  " el tipo retoranado es ".gettype($modelo);
		print_r($modelo);




		yii::app()->end();

		$modelo->isSessionExpired();
		if($expiro){
			echo "   Ya expiro ";
		}  else {
			echo "   Todavia esta vignte la sesion  ";
		}


		yii::app()->end();




		$this->layout = '//layouts/iframe';
		$this->render('carachita');
		yii::app()->end();
        // $modelosolpe=Desolpe::model()->findByPk(79);
		$modelokardex=Alkardex::model()->findByPk(1236);
		$clonado=$modelokardex->clonaregistro();
		//echo $clonado->cant;
		print_r($clonado);
		yii::app()->end();
		echo " numeor reservar compras ". $modelosolpe->numero_reservascompras;
		echo " modelo cant ".$modelosolpe->cant;
		yii::app()->end();
		if(($cantidadatendidaacumulada+$modelokardex->cant)== $modeloreserva->cant)
		{$modeloreserva->estadoreserva='20';///Completo...!
			///Veriifcar primero si DESOLPE tiene partido RESERVA +RESERVA PARA COMPRA
			IF($modelodesolpe->numero_reservascompras == 0 ) ///Si no tiene solicitudes de compra
				$modelodesolpe->est=='40';///Completo...!
		}



		$kardex=Alkardex::model()->findByPk(1125);
		echo "  la sumatoria de las cantidades :  ".$kardex->alkardex_alkardextraslado_emisor_cant;
		echo "  la cantidad  :  ".$kardex->cant;
		yii::app()->end();

		$modelo=New Alkardex;
		$centro=$modelo->alkardex_alinventario->cantlibre;
		echo "  el cento es  ".$centro;
		yii::app()->end();
		$modelo=Desolpe::model()->findByPk(74)->desolpe_alinventario;
		$modelo->cantlibre=1234;
		$modelo->setScenario('modificacantidad');
		$modelo->save();
		echo "  ES ".$modelo->codart;
		yii::app()->end();
		//$modelo->Actualizar($movimiento,$cantidad,$unidad,$punitario=null);
		$mensaje=$modelo->Actualizar('80',0.03,'140',null);

		//echo " El almacen : ".$modelo->desolpe_alinventario->codalm."  \n";
		 if(strlen($mensaje)== 0){
			 echo " cantidad  libre : ".$modelo->cantlibre."  \n";
			 echo " cantidad  libre : ".$modelo->cantlibre."  \n";
			 echo " cantidad reservada : ".$modelo->cantres."  \n";
			 echo " cantidad  transito : ".$modelo->canttran."  \n";
			 echo " precio unitario : ".$modelo->punit."  \n";
			 echo " cantidad  movida : ".$modelo->cantidadmovida."  \n";
			 echo " monto movido : ".$modelo->montomovido."  \n";
			// echo " La conversion  : ".Alconversiones::model()->convierte($modelo->codart,$modelo->um)."  \n";
			 //echo " catidad reservada  : ".$modelo->desolpe_alinventario->cantres."  \n";

		 } else {
			 echo "  ".$mensaje;
		 }
		yii::app()->end();
	   }


}