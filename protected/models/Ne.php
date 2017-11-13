<?php

class Ne extends ModeloGeneral
{
	const CODIGO_DOC='500';
    const ESTADO_DETALLE_ANULADO='40';
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Guia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{guia}}';
	}




	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_rsguia', 'required','message'=>'Llene la sociedad'),
			array('c_coclig', 'required','message'=>'El remitente es un dato obligatorio'),
			array('c_coclig,c_codtra','exist','allowEmpty' => false, 'attributeName' => 'codpro', 'className' => 'Clipro','message'=>'Esta empresa no existe'),
			array('c_codtra', 'required','message'=>'Indique la empresa que transporta'),
			array('n_direc', 'required','message'=>'Llene  el punto de emision?'),
			array('n_dirsoc', 'required','message'=>'Llene el punto de llegada?'),
			array('n_direc,n_dirsoc','exist','allowEmpty' => false, 'attributeName' => 'n_direc', 'className' => 'Direcciones','message'=>'Esta dirección no existe'),
			array('c_trans', 'required','message'=>'Falta indicar el nombre del conductor'),
			array('d_fecgui', 'required','message'=>'Llene la fecha del documento'),
			array('d_fectra', 'required','message'=>'Llene la fecha del ingreso'),
			array('d_fectra', 'checkfechas'),
                    array('c_codtra', 'checkvalores'),
                        array('c_coclig', 'checkvalores'),
                        array('c_rsguia', 'checkvalores'),
			array('n_direc,n_dirsoc','checkdirecciones'),
			array('n_direc, n_direcformaldes, n_directran, n_dirsoc, n_agencia', 'numerical', 'integerOnly'=>true),
			array('c_coclig, c_codtra', 'length', 'max'=>6),
			array('c_estgui', 'length', 'max'=>2),
			array('c_rsguia, c_dirsoc, c_estado, c_salida', 'length', 'max'=>1),
			array('c_trans', 'match','pattern'=>'/[A-Z ][a-z ]/','message'=>'Nombre incorrecto'),
			array('c_motivo, c_serie, codcentro, codobjeto, codocu', 'length', 'max'=>3),
			array('cod_cen', 'required', 'message'=>'Llena el centro receptor'),
			array('d_fecgui, d_fectra, n_direcformaldes,n_directran,codcentro,c_desgui, c_texto,  d_fecentrega', 'safe'),
			array('c_estgui','safe', 'on'=>'cambiaestado'),
			array('c_numgui, c_coclig, d_fecgui, c_estgui, c_rsguia, c_codtra,'
                            . ' c_trans, c_motivo, c_placa, c_licon, d_fectra, c_desgui,'
                            . ' n_direc, c_texto, c_dirsoc, c_serie, n_direcformaldes,'
                            . ' n_directran, c_creado,  c_estado, n_dirsoc, c_modificado, '
                            . 'n_agencia, creadopor, creadoel, modificadopor, modificadoel, '
                            . 'codcentro, codobjeto, d_fecentrega, c_salida, codocu,'
                            . ' cod_cen', 'safe', 'on'=>'search'),
		);
	}

	/* ESTA FIUNCION VERIFICA SI EL ACTIVO SE PUEDE MOVER O NO DE ACUERDO AL PUNTO DE PARTIDA
	Y DESTINO DEL MODELO DE LA GUIA, ES RESTRICITIVO SIEMPRE Y CUANMDO EN LA CONFIGIURACION
	SE ESPECIFIQUE CASO CONTRARIO ES UN TRANSPORTE LIBRE */

	Public function canMove($codigoaf){
		IF(Yii::app()->params['trancheck']=='1'){
			$isthere=false;
			//verificando el lugar del AF
			$recInventario=Inventario::recordByPlate($codigoaf);
			if(!is_null($recInventario)){
				$placeofasset=$recInventario->codlugar;
				$places=$this->direccionespartida->lugares;
				foreach ($places as $fila){
					if($fila->codlugar==$placeofasset){
						$isthere=true;
						break;
					}
				}

				return $isthere;

			} else{
				Return false;
			}





		} else {

			return true;
		}
	}

//Mueve el activo dejando el LOG de registro para historial
	public function Move($id,$iddetgui){


	}




	public function checkdirecciones($attribute,$params) {
		if ($this->n_direc==$this->n_dirsoc )
                    
			$this->adderror('n_direc','El punto de emision no puede ser igual al punto de recepcion');

		//luego verificamos que el puno de recepcion tenga le flag de esrecepcion
         if(!$this->direccionesllegada->tienereceptor=='1')
			 $this->adderror('n_direc','Este punto de llegada no admite recepciones, modifique los datos maestros para esta dirección ');


	}





	public function checkfechas($attribute,$params) {
		$tiempoguia =  strtotime($this->d_fecgui);
		$tiempotran =  strtotime($this->d_fectra);
		//$tiempoparte=strtotime($this->fecha);	//$tiempoarribo =  $this->fechaarribo;
		//$tiempozarpe =   strtotime($this->fechazarpe);
		$tiempotranscurrido =( $tiempotran-$tiempoguia);

		if ( $tiempotranscurrido < 0) {
			$this->adderror('d_fectra','La fecha de traslado no puede ser menor a la del documento');
		}


	}





	public function checkvalores($attribute,$params) {
		//verificando que se a el unico
		//Comporbando si existen valores en los matchcodes

		//En el modelo transportista
		$modeloprueba=Clipro::model()->find("codpro=:micodpro",array(":micodpro"=>is_null($this->c_codtra)?'':$this->c_codtra)) ;
		if (is_null($modeloprueba )) {
			$this->adderror('c_codtra','Esta empresa de transportes no existe');
		}else{
			//verficando que tenga una direccion fiscal por lo menos
			$modeloprueba7=Direcciones::model()->find("c_hcod=:micodpro",array(":micodpro"=>$this->c_codtra));
			if (is_null($modeloprueba7 ))
			{$this->adderror('c_codtra','Este transportista no cuenta con direccion fiscal');}
			else {$this->n_directran=$modeloprueba7->n_direc;}

			//En el modelo destinatario
			$modeloprueba1=Clipro::model()->find("codpro=:micodpro",array(":micodpro"=>is_null($this->c_coclig)?'':$this->c_coclig)) ;
			if (is_null($modeloprueba1)) {
				$this->adderror('c_coclig','Este emisor no existe');
			}else{
				//verficando que tenga una direccion fiscal por lo menos
				$modeloprueba17=Direcciones::model()->find("c_hcod=:micodpro",array(":micodpro"=>$this->c_coclig));
				if (is_null($modeloprueba17 ))
				{$this->adderror('c_coclig','Este emisor no cuenta con direccion fiscal');}
				else{$this->n_direcformaldes=$modeloprueba17->n_direc; }
			}
			//En el modelo direcciones
			$modeloprueba11=Direcciones::model()->find("n_direc=:micodpro",array(":micodpro"=>empty($this->n_direc)?0:$this->n_direc+0)) ;
			if (is_null($modeloprueba11 )) {
				$this->adderror('n_direc','Esta direccion no existe');
			} else {



			}
			//En el modelo direcciones desl socio
			$modeloprueba111=Direcciones::model()->find("n_direc=:micodpro",array(":micodpro"=>is_null($this->n_dirsoc)?0:$this->n_dirsoc+0)) ;
			if (is_null($modeloprueba111 ))
				$this->adderror('n_dirsoc','Este punto de ingreso no existe');







		}
	}





	public $direccionesllegada_c_direc;
	public $direccionestransportista_c_direc;
	public $transportistas_despro;
	public $destinatarios_despro;
	public $dirsoc_c_direc;

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                     'estado' => array(self::BELONGS_TO, 'Estado', array('c_estgui'=>'codestado','codocu'=>'codocu')),

			'detalle' => array(self::HAS_MANY, 'Detgui', 'n_hguia'),
			'tempdetalle' => array(self::HAS_MANY, 'Tempdetgui', 'n_hguia'),
                        'numeroitemsvalidos'=>array(self::STAT, 'Tempdetgui', 'n_hguia','condition'=>" c_estado not in ('".self::ESTADO_DETALLE_ANULADO."')  and idusertemp =".yii::app()->user->id." "),//el campo foraneo
		
			'direccionespartida' => array(self::BELONGS_TO, 'Direcciones', 'n_dirsoc'),
			'direccionesllegada' => array(self::BELONGS_TO, 'Direcciones', 'n_direc'),
			'transportistas' => array(self::BELONGS_TO, 'Clipro', 'c_codtra'),
			'direccionestransportista' => array(self::BELONGS_TO, 'Direcciones', 'n_directran'),
			'destinatario'=>array(self::BELONGS_TO, 'Clipro', 'c_coclig'),
			'dirsoc' => array(self::BELONGS_TO, 'Direcciones', 'n_dirsoc'),
			'testado' => array(self::BELONGS_TO, 'Estado', 'c_estgui'),
			'choferes' => array(self::BELONGS_TO, 'Choferes', 'c_licon'),
			//'codocu0' => array(self::BELONGS_TO, 'Estado', 'codocu'),
			//'cCoclig' => array(self::BELONGS_TO, 'ObjetosCliente', 'c_coclig'),
			//'codobjeto0' => array(self::BELONGS_TO, 'ObjetosCliente', 'codobjeto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'c_numgui' => 'Numero',
			'c_coclig' => 'Emisor',
			'd_fecgui' => 'Fecha',
			'c_estgui' => 'Estado',
			'c_rsguia' => 'Recepcionista',
			'c_codtra' => 'Transportista',
			'c_trans' => 'Conductor',
			'c_motivo' => 'Motivo',
			'c_placa' => 'Placa',
			'c_licon' => 'Licencia',
			'd_fectra' => 'F. transp.',
			'c_desgui' => 'Descripcion',
			'n_direc' => 'Pto llegada',
			'c_texto' => 'Detalle',
			'c_dirsoc' => 'C Dirsoc',
			'c_serie' => 'Serie',
			'n_direcformaldes' => 'Dir Emisor',
			'n_directran' => 'Dir Transp',
			'c_creado' => 'Creado',
			//'n_guia' => 'N Guia',
			'c_estado' => 'Estado',
			'n_dirsoc' => 'Pto inic',
			'c_modificado' => 'Modificado',
			//n_agencia' => 'N Agencia',
			'creadopor' => 'Creado por',
			'creadoel' => 'Creado el',
			'modificadopor' => 'Modificado por',
			'modificadoel' => 'Modificado el',
			//'codcentro' => 'Codcentro',
			'codobjeto' => 'Referencia',
			'd_fecentrega' => 'F. entrega',
			//'c_salida' => 'C Salida',
			//'codocu' => 'Codocu',
			'cod_cen' => 'Centro Recep',
		);
	}




	/*funciok npara consultrar si la direccion destinoi
	es un purnto d emabrque */
	public function esembarcable(){
		return ($this->direccionesllegada->esembarque=='1')?true:false;

	}




	public function refrescacampos(){
		/*$this->direccionesllegada_c_direc=$this->;
        $direccionestransportista_c_direc;
        $transportistas_despro;
        $destinatarios_despro;*/
	}
	public function beforeSave() {
		if ($this->isNewRecord) {
			 $this->sacadireccion();
			$this->c_salida='0';
			$this->codobjeto='001';
			$this->codocu='500';
			$this->c_estgui='99';

		} else
		{
                    IF ($this->c_estgui=='99') {//SI SE TRATA DE UNA GUIA NUEVA COLOCARLE 'PREVIO'
				$this->c_estgui='10';

			}
			if(is_null($this->c_numgui)){
				$this->c_serie=substr($this->cod_cen,0,3);
				$criterio=New CDBcriteria();
				$criterio->addcondition("cod_cen=:vcodcentro and c_salida='0' ");
				$criterio->params=array(":vcodcentro"=>$this->cod_cen);
				/*var_dump( $criterio->condition);
				echo "<br>";*/
				$this->c_numgui=$this->correlativo('c_numgui',$criterio,"");

			}

			//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
		}
		$criteria=new CDbCriteria;
		$criteria->addCondition(" c_hcod='".$this->c_coclig."' ");
		$row=Direcciones::model()->findall($criteria);
		if (!is_null($row[0])) {
			$this->n_direcformaldes=$row[0]->n_direc;

		}

		$criteria=new CDbCriteria;
		$criteria->addCondition(" c_hcod='".$this->c_codtra."' ");
		$row=Direcciones::model()->findall($criteria);
		if (!is_null($row[0])) {
			$this->n_directran=$row[0]->n_direc;

		}
		/*********VERIFICANDO LOS CHOFERES****************/
		$mij=Choferes::model()->find("brevete=:vbrevete", array(":vbrevete"=>trim($this->c_licon)));
		if (is_null($mij)) { //si el brevete no esta registrado pues insertar en nla tabla choferes

			$nuevomodelo=New Choferes;
			$nuevomodelo->nombre=$this->c_trans;
			$nuevomodelo->brevete=$this->c_licon;
			$nuevomodelo->save();

		}
		return parent::beforeSave();
	}







	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('c_numgui',$this->c_numgui,true);
		$criteria->compare('c_coclig',$this->c_coclig,true);
		$criteria->compare('d_fecgui',$this->d_fecgui,true);
		$criteria->compare('c_estgui',$this->c_estgui,true);
		$criteria->compare('c_rsguia',$this->c_rsguia,true);
		$criteria->compare('c_codtra',$this->c_codtra,true);
		$criteria->compare('c_trans',$this->c_trans,true);
		$criteria->compare('c_motivo',$this->c_motivo,true);
		$criteria->compare('c_placa',$this->c_placa,true);
		$criteria->compare('c_licon',$this->c_licon,true);
		$criteria->compare('d_fectra',$this->d_fectra,true);
		$criteria->compare('c_desgui',$this->c_desgui,true);
		$criteria->compare('n_direc',$this->n_direc);
		$criteria->compare('c_texto',$this->c_texto,true);
		$criteria->compare('c_dirsoc',$this->c_dirsoc,true);
		$criteria->compare('c_serie',$this->c_serie,true);
		$criteria->compare('n_direcformaldes',$this->n_direcformaldes);
		$criteria->compare('n_directran',$this->n_directran);
		$criteria->compare('c_creado',$this->c_creado,true);
		$criteria->compare('n_guia',$this->n_guia,true);
		$criteria->compare('c_estado',$this->c_estado,true);
		$criteria->compare('n_dirsoc',$this->n_dirsoc);
		$criteria->compare('c_modificado',$this->c_modificado,true);
		$criteria->compare('n_agencia',$this->n_agencia);




		$criteria->compare('codcentro',$this->codcentro,true);
		$criteria->compare('codobjeto',$this->codobjeto,true);
		$criteria->compare('d_fecentrega',$this->d_fecentrega,true);
		$criteria->compare('c_salida',$this->c_salida,true);
		$criteria->compare('codocu',$this->codocu,true);
		$criteria->compare('cod_cen',$this->cod_cen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
      public function sacadireccion(){
		$criteria=new CDbCriteria;
		$criteria->addCondition(" c_hcod='".$this->c_coclig."' ");
		$row=Direcciones::model()->findall($criteria);
		/*VAR_DUMP($this->c_coclig);
		ECHO "<BR>";
		VAR_DUMP($row[0]->n_direc);
		YII::APP()->END();*/
		//if (!is_null($row[0])) {
			$this->n_direcformaldes=$row[0]->n_direc;
		$criteria=new CDbCriteria;
		$criteria->addCondition(" c_hcod='".$this->c_codtra."' ");
		$row=Direcciones::model()->findall($criteria);
		$this->n_directran=$row[0]->n_direc;


		//}
	}  
     public function arreglaOrdenItems($estadoanulado){
            $contador=1;
            foreach($this->tempdetalle as $detalle){
                 $detalle->setScenario('cambioitems');
                if(!($detalle->c_estado==$estadoanulado)){
                   
                    $detalle->c_itguia=str_pad($contador,3,"0",STR_PAD_LEFT); 
                     $contador+=1;
                }else{
                     $detalle->c_itguia='000'; 
                }
                 $detalle->save();
                   
                
            }
        }
        
        public function getNextItem(){
            return str_pad($this->numeroitemsvalidos+1,3,"0",STR_PAD_LEFT); 
        }    
       
        
    public static function findByNumero($serie,$numero){
       // var_dump($numero);var_dump($serie);die();
        $criter=New CDbCriteria();
        $criter->addCondition("c_numgui=:vnumero and c_serie=:vserie and c_salida <> '1' ");
        $criter->params=array(":vnumero"=>$numero,":vserie"=>$serie );
        return self::model()->find($criter);
        
    } 
    
    public function listaitems(){
        $cri=New CDbCriteria();
        $cri->addCondition("n_hguia=:vid ");
        $cri->params=array(":vid"=>$this->id);
        $cri->addNotInCondition("c_estado",Estado::estadosnocalculablesdetalle(self::CODIGO_DOC));
          return yii::app()->db->createCommand()->
                  select('t.c_itguia')->
                  from('{{detgui}} t')-> 
                  where($cri->condition,$cri->params)-> 
                  queryColumn();
    }
}