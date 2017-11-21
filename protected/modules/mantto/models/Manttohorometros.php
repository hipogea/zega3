<?php

class Manttohorometros extends ModeloGeneral implements ImeasurePoints 
{
	/**
	 * @return string the associated database table name
	 */
    CONST COD_DOCUMENTO='146';
    
    public function init(){
        $this->camposfechas=array('fechainicio');
        $this->campossensibles=array('incremental','unidades','lecturaactual','hidpadre','lecturainicio','fechainicio');
         return parent::init();
          }
    
    
    
	public function tableName()
	{
		return '{{manttohorometros}}';
	}
public $fechareemplazo;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                     array('fechafin,activo','safe','on'=>'anular'),
			array('codigo, ubicacion', 'length', 'max'=>10),
                    array('hidequipo,orden,ubicacion,lecturainicio,fechainicio,unidades,incremental','required','on'=>'insert,update'),
                    array('hidpadre,fechainicio,codigo,unidades,incremental,ubicacion','required','on'=>'reemplazo'),
                    array('fechainicio', 'checkfechainicio', 'on'=>'insert,update'),
                    array('hidpadre,fechareemplazo,codigo,lecturainicio,lecturaacumulada,ubicacion','safe','on'=>'reemplazo'),
                     array('lecturainicio,fechainicio','checkReemplazo','on'=>'reemplazo'),
                    array('codigo,orden, hidpadre,hidequipo,ubicacion,hidequipo,lecturaacumulada, fechainicio, activo,lecturaactual,unidades,incremental,fechafin', 'safe', 'on'=>'insert,update'),
			array('hidequipo', 'length', 'max'=>20),
                      //ARRAY('codigo','checkprevio'),
			array('lecturaactual, lecturaacumulada', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codigo, ubicacion, hidequipo, lecturaactual, lecturaacumulada, fechainicio, fechafin', 'safe', 'on'=>'search'),
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
                    'ums' => array(self::BELONGS_TO, 'Ums', 'unidades'),
			'inventario' => array(self::BELONGS_TO, 'Inventario', 'hidequipo'),
                    'manttolecturahorometros' => array(self::HAS_MANY, 'Manttolecturahorometros', 'hidhorometro'),
                      // 'ultimalectura'=>array(self::STAT, 'Manttolecturahorometros', 'hidhorometro','select'=>'MAX(fecha)'),
                        'nhijos' => array(self::STAT, 'Manttohorometros', 'hidpadre'),
                    'padre' => array(self::BELONGS_TO, 'Manttohorometros', 'hidpadre'),
                    'hijo' => array(self::HAS_MANY, 'Manttohorometros', 'hidpadre'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'Code',
			'ubicacion' => 'Location',
			'hidequipo' => 'Hidequipo',
			'lecturaactual' => 'Current value',
			'lecturaacumulada' => 'Accumulated value',
			'fechainicio' => 'Begin Date',
			'fechafin' => 'End Date',
                    'orden' => 'Order',
                    'hidpadre' => 'Has Parent',
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('ubicacion',$this->ubicacion,true);
		$criteria->compare('hidequipo',$this->hidequipo,true);
		$criteria->compare('lecturaactual',$this->lecturaactual,true);
		$criteria->compare('lecturaacumulada',$this->lecturaacumulada,true);
		$criteria->compare('fechainicio',$this->fechainicio,true);
		$criteria->compare('fechafin',$this->fechafin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function search_por_activo($idequipo)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addCondition("hidequipo=:vhidequipo and fechafin is  null");
        $criteria->params=array(":vhidequipo"=>$idequipo);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Manttohorometros the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
      
         public function checkfechainicio($attribute,$params) {
             
               
             
                        
                            
             
            
           }    
           
           //antes de reemplazar hacew ralgunos checkeos
           public function checkReemplazo($attribute,$params) {
                    $point=$this->getParentPoint(); 
             if(!$point->sePuedeReemplazar()){
               $this->adderror('fechainicio',yii::t('errvalid','This measure point already has replaced '));
             return ;}
       
           
            //la fecha de inicio del nuevo punto n debe ser menor al del padre 
            if(strtotime($this->cambiaformatofecha($point->fechainicio,false))>strtotime($this->cambiaformatofecha($this->fechainicio,false))){
               $this->adderror('fechainicio',yii::t('errvalid','Date must be after date of original measure point '));
             return ;}
             //la fecha de inicio del nuevo punto debe ser mayor igual a la fecha
             //de la ultima medidad del padre
             if($point->hasMeasures()) //en caso de haber puntos de medida                  
             if(strtotime ($this->cambiaformatofecha($point->getLastObject()->fecha,false) ) >
                 strtotime ($this->cambiaformatofecha($this->fechainicio,false) )    ){
               $this->adderror('fechainicio',yii::t('errvalid','Date must be after date of last measure point '));
             return ;}                        
              //Si no esta permitido resetear, La lectura de del horometro debe de ser mayor o menor 
              //segun sea incremental o  no
              if(!$this->canReset()){
                  if($point->isIncremental()){
                       if($this->lecturainicio < $point->lecturainicio){
                         $this->adderror('lecturainicio',yii::t('errvalid','This initial measure is less than initial value of original meausre point '));
                            return ;}
                            
                        if($point->hasMeasures()) //en caso de haber puntos de medida
                        if( $this->lecturainicio < $point->getLastObject()->lectura ){///vasrificar la lectura inicio sea mayo que la ultima medida 
                            $this->adderror('lecturainicio',yii::t('errvalid','Initial value for this point is less than last measure'));
                            return ;}      
                            
                            
                  }else{
                     if($this->lecturainicio < $point->lecturainicio) {
                         $this->adderror('lecturainicio',yii::t('errvalid','This initial measure is greater than initial value of original meausre point '));
                            return ;}
                         if($point->hasMeasures()) //en caso de haber puntos de medida
                        if( $this->lecturainicio > $point->getLastObject()->lectura ){///vasrificar la lectura inicio sea mayo que la ultima medida 
                            $this->adderror('lecturainicio',yii::t('errvalid','Initial value for this point is greater than last measure'));
                            return ;}
                  }
                  
                
                  
              }    
            
            
           }    
           
           
           
      
           public function sePuedeReemplazar(){
               //para que sea reemplazable es necesario               
               //es enasrio que no tenga hijos; es decir que no
               //sea un punto de medida ya reemplazado 
               if(!$this->isNewRecord){
                   if($this->nhijos >0){
                     return false;
                         }
                     return true;
                    /*if(strtotime($this->fechafin)>0)
                        return true;*/
               }else{
                   return false;
               }
               
           }
           
  public function beforesave(){
      if($this->getScenario()=='reemplazo'){
        if($this->isNewRecord){
            //anular el horometro anterior
            
            $padre=$this->getParentPoint();
            $this->lecturaacumulada=$padre->getLastObject()->lectura;
            $padre->setScenario('anular');
            $padre->fechafin=$this->cambiaformatofecha($this->fechainicio,false);
           $padre->save();
        }
      }
      return parent::beforeSave();
  }
  
  public function updatePoint($difference){
      $escenario=$this->getScenario();
              $this->setScenario('updatesimple');
      $this->lecturaacumulada=$this->lecturaacumulada+($this->incremental+0)*$difference;
      $this->lecturaactual=$this->lecturaactual+($this->incremental+0)*$difference;
      $this->save();
      $this->setScenario($escenario);
  }
  
   public function getParentPoint(){
      
      if(!($this->hidpadre===null or $this->hidpadre==0)){
                    return $this->find("id=:vhidpadre",array(":vhidpadre"=>$this->hidpadre));
                }else{
                    return null;
                }
      
   }
   
   public function getEquipo(){
      
     if(!$this->isNewRecord){
                 return  Inventario::model()->findByPk($this->hidequipo);
             }else{
                return  $this->inventario;
             }
   }
   
   public function getLastObject(){
       $id=$this->getLastIdLecture();
       if(is_null($id))
           return null;
      return  $this->Modellecturas()->findByPk($id);
   }
   
   private function getCriterio(){
         //$compare=($anterior)?"<":">";
           $criteria=New CDbCriteria();
           $criteria->addCondition("fecha <=:vfecha and"
                   . " hidhorometro=:vhidorometro");
           $criteria->params=array(":vfecha"=>date('Y-m-d H:i:s'),
                                ":vhidorometro"=>$this->id,
                                );
           return $criteria;
   }
   
  private function getLastIdLecture(){
      $valor=yii::app()->db->createCommand()-> 
             select("id")->from("{{manttolecturahorometros}}")->where(
                  $this->getCriterio()->condition,   
                   $this->getCriterio()->params  )-> 
             limit(1)->order("fecha DESC")->queryScalar();
      IF($valor!=false){
          return $valor;
      }ELSE{
          return null;
      }
   }
   
   public function isChild(){
       if($this->hidpadre >0 )
           return true;
       return false;
   }
   public function hasMeasures(){
      return !is_null($this->getLastIdLecture());
   }
   
   public function canReset(){
       $centro=$this->getEquipo()->codpropietario;
       return (Configuracion::valor($this::COD_DOCUMENTO, $centro, '1135')=='1');
   }
   public function isIncremental(){
       return ($this->incremental==1);
   }
   
   //CALULA EL ACUMULADO
   public function getAccumulatedValueFromEquipment(){
       if($this->hasMeasures()){
           $accumulate=$this->getLastObject()->lectura;
       }else{
           $accumulate=0;
       }
           if($this->isChild())
           $accumulate+=$this->getParentPoint()->getAccumulatedValueFromEquipment();
       
       return $accumulate;
   }
   
   public function isMeasureFromThis($id){
       if($this->isNewRecord)
           return false;
       $valor=yii::app()->db->createCommand()-> 
             select("id")->from("{{manttolecturahorometros}}")->where(
                  "hidhorometro=:vid",   
                   array(":vid"=>$id) )-> 
                   queryScalar();
      if($valor!=false)return false;
      return true;
   }
  
   public function getMeasureByDate($date){
       if($this->isNewRecord)
       throw new CHttpException(500,yii::t('errvalid','Call to function getMeasureByDate in New Record'));
       return $this->Modellecturas()->find($this->criteriaByDate($date));
   }
  
   private function criteriaByDate($date){
     $crite=NeW CDbCriteria();
     $crite->addCondition(" fecha=:vfecha and hidhorometro=:vhidhorometro ");
      $crite->params=array(
          ":vhidhorometro"=>$this->id,
          ":vfecha"=>$this->cambiaformatofecha($date, false),
      );
     return $crite;
     
     }
     
     private function Modellecturas(){
        return Manttolecturahorometros::model();
     }
}
