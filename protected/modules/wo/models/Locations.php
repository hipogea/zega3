<?php
class Locations extends ModeloGeneral
{
    
        public $_parent=null; ///modelo parent 
        const DELIMITER_CODE="-";
        
        /*mejorar este codigo 
         * esta proiedad debe de ser ingresad en 
         * la configuracion del modulo o apllicaicon */         
        public $_patterncode=array(
                '/^[A-Z0-9]{4}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}-[A-Z0-9]{5}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}-[A-Z0-9]{5}-[A-Z0-9]{5}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}-[A-Z0-9]{5}-[A-Z0-9]{5}-[A-Z0-9]{5}\\z/'
            );
        private $_format_pattern='XXXX-XX-XXX-XXXXX-XXXXX-XXXXX';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{locations}}';
	}

        
        public $campossensibles=array('colector','cebe','codcen','activa');
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                     array('codigo,descripcion', 'required','on'=>'root'),
                    array('codcen,colector', 'required','on'=>'insert,update'),
                     array('codigo,descripcion', 'safe','on'=>'superior'),
                    array('codigo,descripcion,codcen,colector', 'safe','on'=>'insert,update'),
                    array('codigo,descripcion','required'),
			//array('id', 'required'),
			array(' hidpadre', 'numerical', 'integerOnly'=>true),
			array('codigo', 'length', 'max'=>300),
			array('colector, cebe', 'length', 'max'=>15),
			array('codcen', 'length', 'max'=>4),
			array('activa', 'length', 'max'=>1),
			array('essuperior,textolargo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codigo, descripcion, hidpadre, colector, codcen, cebe, textolargo, activa', 'safe', 'on'=>'search'),
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
			'cc' => array(self::BELONGS_TO, 'Cc', 'colector'),
			'cebe' => array(self::BELONGS_TO, 'Cc', 'cebe'),
			'centros' => array(self::BELONGS_TO, 'Centros', 'codcen'),
                         'padre' => array(self::BELONGS_TO, 'Locations', 'hidparent'),
			'children' => array(self::HAS_MANY, 'Locations', 'hidparent'),
                        'childequi' => array(self::HAS_MANY, 'Inventario', 'idinventario'),
			'childCount' => array(self::STAT, 'Pruebaarbol', 'hidparent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => yii::t('woModule.labels','Code'),
			'descripcion' => yii::t('woModule.labels','Description'),
			'hidpadre' => yii::t('woModule.labels','Parent Id'),
			'colector' => yii::t('woModule.labels','Colector Cost'),
			'codcen' => yii::t('woModule.labels','Center'),
			'cebe' => yii::t('woModule.labels','Colector Benef'),
			'textolargo' => yii::t('woModule.labels','Long Description'),
			'activa' => yii::t('woModule.labels','On Activity'),
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
		$criteria->compare('descripcion',$this->descripcion);
		$criteria->compare('hidpadre',$this->hidpadre);
		$criteria->compare('colector',$this->colector,true);
		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('cebe',$this->cebe,true);
		$criteria->compare('textolargo',$this->textolargo,true);
		$criteria->compare('activa',$this->activa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Locations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /*
         * Esta funcion deveulve el codigo de la ubicacion del parent
         */
        
        public function getCodParent(){
            if(is_null($this->getParent())){
                $cad= strrev($this->codigo);
                $lon=strpos(self::DELIMITER_CODE,$cad);
               return  strrev(substr($cad,$lon+1));
            }else{
                return $this->CodParent()->codigo;
            }
        }
       
        /*
         * Devuelve el objeto parent; pero se validan algunos casos
         * que nos pueden traer erroes al ejecutar el codigo 
         * por ejemplo invocar a un registro nuevo o no haber llenado el campo hidparent
         * Almacena este obejeto en la popiedad _parent, para evitar sobrecarga de
         * memoria
         * @force: Indica si se refresca nuevamednjte l opbjeto
         */
        private function getParent($force=false){
           if(!$this->isNewRecord or $this->hidparent===null)
            return null;
          if($force or is_null($this->_parent)){
              $this->_parent=$this->padre;
          }
           return $this->_parent;
        }
       
       
        
        
        /*
         * Esta funcion propaga los cambios aguas abajo
         * de cualquier campo sensible en la ubicacion actual
         * por ejemplo sis e actualiza un ceciontro de costo 
         * el cambio debe de propagarse por todos los hijos 
         */
      public function spreadChangesToChilds($fieldName){
          if($fieldName=='hidpadre')
              throw new CHttpException(500,yii::t('errors','Can \'t change  field {hidpadre}',array('{hidpadre}'=>$fieldName)));
          if(in_array($fieldName,$this->campossensibles))
          //if($this->cambiocampo($fieldName)){
              foreach($this->children as $children){
                  $children->setScenario('change_field_'.$fieldName);
                  $children->{$fieldName}=$this->{$fieldName};
                  $children->save();
             // }
          }
          return true;
      }
      
      /*
       * Fucnionq ue valida el codigo de la ubicacion
       * se vale de la propeiedad _patterncode
       * retirna el nivel de profundidad 
       */
    
      private function getLevelCode(){
          $valor=0;
          if(strlen($this->codigo)>0)
         foreach($this->_patterncode as $fragmetPattern){
             if(preg_match($fragmetPattern,$this->codigo)>0){
                 exit;
             }
             $valor+=1;
           }
          return $valor;
      }
      
      
      
      
      /*
       * Fucnionq ue valida el codigo de la ubicacion
       * desde las ubicaciones ya creadas 
       */
    
      private function validateCodeFromDb(){
          $level=$this->getLevelCode();          
          if($level==0)
              return false;
          elseif($level==1)
            return true;
          else
              return  $this->existsCode();
      }
      
    
      
      public function existsCode(){
         $reg=$this->find("codigo=:mycode",array($this->codigo));
         $retorno=(!is_null($reg))?true:false;
         unset($reg);
         return $retorno;
      }
      
      private function existsCodeRoot(){
          
      }
      
      public function checkCodeInf($attribute,$params) {
	 if($this->getLevelCode()== 0)
             $this->addError ('codigo', yii::t('woModule.errors','Code is not Match With {pattern}',array('{pattern}'=>$this->_format_pattern)));
	if( $this->existsCode() )
             $this->addError ('codigo', yii::t('woModule.errors','This {attribute} already exists',array('{attribute}'=>yii::t('woModule.labels','Code'))));								
	} 
}
