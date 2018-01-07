<?php

/**
 * This is the model class for table "cargamasiva".
 *
 * The followings are the available columns in table 'cargamasiva':
 * @property integer $id
 * @property string $modelo
 * @property integer $iduser
 * @property string $fechacreac
 * @property string $fechaejec
 * @property string $insercion
 * @property string $descripcion
 */
class Cargamasiva extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	 private $_modeloatratar=null;
	 public $ruta;
         public $idcampoadicional=null;
	public function tableName()
	{
		return '{{cargamasiva}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                     
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('modelo', 'length', 'max'=>100),
			array('insercion', 'length', 'max'=>1),
			array('insercion', 'safe'),

			array('id,fechacreac,escenario,iduser,insercion, fechaejec, descripcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, modelo, iduser, fechacreac, fechaejec, insercion, descripcion', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
	
		'detalle'=>array(self::HAS_MANY, 'Cargamasivadet', 'hidcarga', 'order'=>'orden ASC'),
		'numeroerrores'=>array(self::STAT, 'Logcargamasiva', 'hidcarga', 'select'=> 'COUNT(id)', 'condition'=>"level='0' and iduser=".yii::app()->user->id),
			'numeroexitos'=>array(self::STAT, 'Logcargamasiva', 'hidcarga', 'select'=> 'COUNT(id)', 'condition'=>"level='1' and iduser=".yii::app()->user->id),
		'numeroitems'=>array(self::STAT, 'Cargamasivadet', 'hidcarga', 'order'=>'orden ASC'),//el campo foraneo
			'logcarga'=>array(self::HAS_MANY, 'Logcargamasiva', 'hidcarga', 'condition'=>"level='1' and iduser=".yii::app()->user->id),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'modelo' => 'Modelo',
			'iduser' => 'Iduser',
			'fechacreac' => 'Fechacreac',
			'fechaejec' => 'Fechaejec',
			'insercion' => 'Insercion',
			'descripcion' => 'Descripcion',
                    'idcampoadicional' => 'Agregar',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('modelo',$this->modelo,true);
		$criteria->compare('iduser',$this->iduser);
		$criteria->compare('fechacreac',$this->fechacreac,true);
		$criteria->compare('fechaejec',$this->fechaejec,true);
		$criteria->compare('insercion',$this->insercion,true);
		$criteria->compare('descripcion',$this->descripcion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cargamasiva the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
		public function afterSave() {				
		if ($this->isNewRecord) {
                    $this->iduser=yii::app()->user->id;
					}else{
					    if($this->numeroitems==0) 
                                            $this->addChilds();	
						 /* if($this->numeroitems==0) 
						  {
							  $cadena="\$modeloatratar=new ".$this->modelo."('".$this->escenario."');";
							  eval($cadena);
							 $campos= $modeloatratar->getMetaData();
							  $claves=$campos->tableSchema->primaryKey; //los campos claves
							  if(!is_array($claves)){
								  $camposclave[]=$claves;
							  }else{
								  $camposclave=$claves;
							  }
                                                          $i=1;
							foreach( $campos->columns as $columna)
								{
								if($modeloatratar->isAttributeSafe(trim($columna->name))) {
										      //verificando si no se agregado antes 
                                                                     $registro=$this->getChildRecord(trim($columna->name));
										if(is_null($registro)){
												$registro=new Cargamasivadet;
												$registro->nombrecampo=trim($columna->name);
												if(in_array($registro->nombrecampo,$camposclave)) //Si es campo clave
												{
												$registro->esclave='1';
												$registro->orden=array_search($registro->nombrecampo,$camposclave)+1;

												}else{
													$registro->orden=$i;
												}

												$registro->hidcarga=$this->id;
												$registro->aliascampo=trim($this->getAttributelabel($columna->name));
											if( $modeloatratar->isAttributeRequired($columna->name)) 																	
												$registro->requerida = '1';
												$registro->activa = '1';																		
												$registro->longitud =(is_null( $columna->size) or trim($columna->size.'')=='')?20:$columna->size;																		
												$registro->tipo = $columna->dbType;																	
												$registro->tipo = $columna->dbType;
												$registro->save();
											}	
										   }
                                                                              $i+=1;
								   }
						    }*/
						   
						  
						  

				}
		
		return parent::aftersave();
	}
	
		public function beforeSave() {
				
		if ($this->isNewRecord) {
		       $this->iduser=yii::app()->user->id;

					}else{
						 

				}
		
		return parent::beforeSave();
	}

 //funcionq ue devuievle el criteria para filtrar 
 //el campo particular y ver si existe en el detalle este campo
private function getCriteriaField($namefield){
    $croter=New CDbCriteria(); 
    $croter->addCondition("hidcarga=:vcarga and 
			nombrecampo=:vnombrecampo");
    $croter->params=array(
			 ':vcarga'=>$this->id,
			':vnombrecampo'=>trim($namefield)
			);
    return $croter;
  }
  
 //crterio apra delvolver los registros hijos ordenados 
  //segun campo clave y obligatrios 
  private function getCriteriaOrderChilds(){
    $croter=New CDbCriteria(); 
    $croter->addCondition("hidcarga=:vcarga");
    $croter->params=array(':vcarga'=>$this->id);
    $croter->order="esclave,requerida ASC";
    return $croter;
  }
  
//colcoa el orden segun el campo orden de un registron hijo
private function setOrderChild($registro,$order){
  $escenarioant=$registro->getScenario();
  $registro->setScenario('updateorden');
  $registro->orden=$order;
  $registro->save();
  $registro->setScenario($escenarioant);
  }
  
private function setOrderChilds(){
    $i=1;
  $registros= Cargamasivadet::model()->findAll($this->getCriteriaOrderChilds());
  //var_dump($registros);die();
  foreach($registros as $fila){
      $this->setOrderChild($fila, $i);
      $i=$i+1;
  }
}

 //devuelve el registro hijo segun el nombre de una cmpo
  //si no lo encuentra devuelkve null
private function getChildRecord($nameField){
   return Cargamasivadet::model()->find($this->getCriteriaField(trim($nameField)));
}

///lista de campos que estan en el detalle
private function getChildFields(){
   return Yii::app()->db->createCommand()
		  ->select('nombrecampo')
		  ->from('{{cargamasivadet}}')
		  ->where("hidcarga=:vhidcarga ",
			  array(":vhidcarga"=>$this->id))		  
		  ->queryColumn(); 
}

///saca la diferencia de lso campos 
///del detalle y los campos 'safe'  en el escenario de carga
 public function getFielDifference(){
     return array_values(array_diff($this->getModelToPerform()->getSafeAttributeNames(), $this->getChildFields()));
   }

 private function getModelToPerform(){
     if(is_null($this->_modeloatratar)){
         $this->_modeloatratar=New $this->modelo($this->escenario);
     }
     return $this->_modeloatratar;
      
 }
   
//agrega un registro hijo  siempre y cuamdo fieldC sea una instancia de columna de tabla
public function addChild($fieldC=null){
    if(gettype($fieldC)=='string'){
        $fieldC= $this->getModelToPerform()->getMetaData()->columns[$fieldC];
    }
    if(is_object($fieldC) ){
       if(is_null($this->getChildRecord($fieldC->name))){
           $registro=new Cargamasivadet;
           //var_dump($registro->isAttributeSafe('tipo'));die();
           $registro->setAttributes(array(
                                'nombrecampo'=>trim($fieldC->name),
                                'esclave'=>($fieldC->isPrimaryKey)?'1':'0',
                                'hidcarga'=>$this->id,
                                'aliascampo'=>$this->getModelToPerform()->getAttributelabel($fieldC->name),
                                'requerida'=>($this->getModelToPerform()->isAttributeRequired($fieldC->name))?'1':'0',
                                 'activa'=>'1',
                                 'longitud'=>$fieldC->size.'',
                                  'tipo'=>$fieldC->dbType.'',
                                 
                                ));
          if(get_parent_class($this->getModelToPerform())=='ModeloGeneral')
              if(!is_null($this->getModelToPerform()->getModelParentByField($fieldC->name)))
              $registro->modeloforaneo=get_class($this->getModelToPerform()->getModelParentByField($fieldC->name));
           $registro->save();
		
       }
    }
}

public function addChilds(){
    if(!$this->isNewRecord){
        //var_dump($this->getFielDifference());die();
       foreach($this->getFielDifference() as $clave=>$campofaltante){
            //$campoobj= $this->getModelToPerform()->getMetaData()->columns[$campofaltante];
           //var_dump($campoobj);
            $this->addChild($campofaltante);
       }
       $this->setOrderChilds();
    }
}

Private function deleteChilds(){
    return Yii::app()->db->createCommand()
		  ->delete('{{cargamasivadet}}',"hidcarga=:vhidcarga ",
			  array(":vhidcarga"=>$this->id)); 
}

public function refreshChilds(){
    $this->deleteChilds();
    $this->addChilds();
}

}
