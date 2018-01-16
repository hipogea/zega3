<?php
class Locations extends ModeloGeneral
{
    
        public $_parent=null; ///modelo parent 
        const LEVEL_ROOT=1;
        public $campossensibles=array('codigo','colector','codcen','cebe');
        public $codeparent; //solo para mosmtrar valores, no tiene utulidad 
        /*mejorar este codigo 
         * esta proiedad debe de ser ingresad en 
         * la configuracion del modulo o apllicaicon */         
       /* public $_patterncode=array(
                '/^[A-Z0-9]{4}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}-[A-Z0-9]{5}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}-[A-Z0-9]{5}-[A-Z0-9]{5}\\z/',
                '/^[A-Z0-9]{4}-[A-Z0-9]{2}-[A-Z0-9]{3}-[A-Z0-9]{5}-[A-Z0-9]{5}-[A-Z0-9]{5}\\z/'
            );*/
        
       // private $_format_pattern='XXXX-XX-XXX-XXXXX-XXXXX-XXXXX';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{locations}}';                
	}

        
         public function behaviors()
    {
        return array(
            'TreeBehavior' => array(
                'class' => 'ext.behaviors.XTreeBehavior',
                'treeLabelMethod'=> 'getTreeLabel',
                'menuUrlMethod'=> 'getMenuUrl',
            ),
        );
    }
        
       // public $campossensibles=array('colector','cebe','codcen','activa');
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                   array('codigo', 'checkMaster','on'=>'master'),
                    array('codigo', 'checkInsert','on'=>'insert'),
                     array('codigo,descripcion', 'required','on'=>'master,root,insert'),
                    array('activa,essuperior,textolargo,codigo,descripcion', 'safe','on'=>'root,insert,master'),
                    array('codigo', 'checkRoot','on'=>'root'),
                   array('colector','exist','allowEmpty' => false, 'attributeName' => 'codc', 'className' => 'Cc','message'=>yii::t('woModule.errors',"Cost Colector {colector} doesn't exists", array('{colector}'=>$this->colector)),'on'=>'insert,update'),
                   array('codcen','exist','allowEmpty' => false, 'attributeName' => 'codcen', 'className' => 'Centros','message'=>yii::t('woModule.errors',"Cod Center {colector} doesn't exists", array('{colector}'=>$this->codcen)),'on'=>'insert,update'),
            
	
                    
                    array('codcen,colector', 'required','on'=>'insert,update'),
                     array('codigo,descripcion', 'safe','on'=>'superior'),
                    array('codigo,descripcion,codcen,colector', 'safe','on'=>'insert,update'),
                    array('codigo,descripcion','required'),
			//array('id', 'required'),
			array(' parent_id', 'numerical', 'integerOnly'=>true),
			array('codigo', 'length', 'max'=>300),
			array('colector, cebe', 'length', 'max'=>15),
			array('codcen', 'length', 'max'=>4),
			array('activa', 'length', 'max'=>1),
			array('essuperior,textolargo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, codigo, descripcion, parent_id, colector, codcen, cebe, textolargo, activa', 'safe', 'on'=>'search'),
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
                         'padre' => array(self::BELONGS_TO, 'Locations', 'parent_id'),
			'children' => array(self::HAS_MANY, 'Locations', 'parent_id'),
                        'childequi' => array(self::HAS_MANY, 'Inventario', 'idinventario'),
			'childCount' => array(self::STAT, 'Locations', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
                    'codeparent'=>'Cod Parent',
			'codigo' => yii::t('woModule.labels','Code'),
			'descripcion' => yii::t('woModule.labels','Description'),
			'parent_id' => yii::t('woModule.labels','Parent Id'),
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
		$criteria->compare('parent_id',$this->parent_id);
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
        
        public function getCodeParent(){
            IF(strlen(trim($this->codigo))==0)
                return '';
            if(is_null($this->getParent())){
                $cad= strrev($this->codigo);
                $lon=stripos($cad,$this->delimiter());
                /*echo $this->delimiter();echo "<br>";
                ECHO $cad; echo "<br>";var_dump($lon);die();*/
               if($lon===false)return $this->codigo;
               else
               return  strrev(substr($cad,$lon+1));
            }else{
                return $this->getParent()->codigo;
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
            if($this->iamRoot()) //es el root
                return null;
           if($this->isNewRecord ){
                return null;
           }else{
              if($force or is_null($this->_parent)){
                            $this->_parent=$this->padre;
                    }
                    return $this->_parent; 
           }
           
        }
       
       
        
        
        /*
         * Esta funcion propaga los cambios aguas abajo
         * de cualquier campo sensible en la ubicacion actual
         * por ejemplo sis e actualiza un ceciontro de costo 
         * el cambio debe de propagarse por todos los hijos 
         */
      public function spreadChangesToChilds($fieldName){
          if($fieldName=='parent_id')
              throw new CHttpException(500,yii::t('errors','Can \'t change  field {parent_id}',array('{parent_id}'=>$fieldName)));
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
          //$valor=0;$retazo="";
          if(strlen($this->codigo)>0)
          {
              $cad=$this->codigo;
              if(substr(strrev($cad),0,1)==$this->delimiter())
                $cad= substr($cad,0,strlen($cad)-1);
              if(substr(0,1)==$this->delimiter())
                $cad= substr($cad,1);
                 
            return count(explode($this->delimiter(),$cad));  
          }
              
          return 0;
         /*foreach(explode($this->delimiter(),$this->codigo) as $fragment){
              $retazo.=$fragment.$this->delimiter();
             // var_dump(WoConfig::getPattern()[$valor]);
              //var_dump(substr($retazo,0,strlen($retazo)-1));
              if(!preg_match(WoConfig::getPattern()[$valor],substr($retazo,0,strlen($retazo)-1))>0){
                $valor=$valor+1;
                  BREAK;
             }
             $valor=$valor+1;
           }*/
           //die();
         // return $valor;
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
         $reg=$this->find("codigo=:mycode",array(":mycode"=>$this->codigo));
         $retorno=(!is_null($reg))?true:false;
         unset($reg);
         return $retorno;
      }
      
      public function existsCodeRoot(){
          return ($this->existsCode() or 
                  ($this->parent_id==0 
                  and !$this->isNewRecord))?true:false;
      }
      
      public function checkCodeInf($attribute,$params) {
	 if($this->getLevelCode()== 0)
             $this->addError ('codigo', yii::t('woModule.errors','Code is not Match With {pattern}',array('{pattern}'=> $this->getMaskForLevel())));
	if( $this->existsCode() )
             $this->addError ('codigo', yii::t('woModule.errors','This {attribute} already exists',array('{attribute}'=>yii::t('woModule.labels','Code'))));								
	} 
        
        public function checkRoot($attribute,$params) {
            if(!$this->match(self::LEVEL_ROOT))
             $this->addError ('codigo', yii::t('woModule.errors','Code is not Match With {pattern}',array('{pattern}'=> $this->getMaskForLevel())));
            if($this->existsCodeRoot())
                 $this->addError ('codigo', yii::t('woModule.errors','Node root already exists '));
            
	} 
        
        public function checkMaster($attribute,$params) {
            //VAR_DUMP($this->getLevelCode());DIE();
            if(!$this->match())
              $this->putMessageError('Code is not Match With {pattern}  level {level}',array('{level}'=>$this->getLevelCode() ,'{pattern}'=> $this->getMaskForLevel()));
            if($this->existsCode())
                 $this->putMessageError('This code already exists ');
            if(is_null($this->getCodeParentFromDb()))
                $this->putMessageError("The code Parent {codeparent} don't exists yet ",array('{codeparent}'=>$this->getCodeParent()));
            if(!($this->iamRootMaster())) //Si se trata de niveles Master
              $this->putMessageError("By Settings; System allows create Master locations until {level} level {MYLEVEL} deepth ",array('{MYLEVEL}'=>$this->getLevelCode() ,'{level}'=>WoConfig::getParam('_locationsLevelRoot')));
             
        } 
        
        
         public function checkInsert($attribute,$params) {
            //VAR_DUMP($this->getLevelCode());DIE();
            if(!$this->match())
              $this->putMessageError('Code is not Match With {pattern}  level {level}',array('{level}'=>$this->getLevelCode() ,'{pattern}'=> $this->getMaskForLevel()));
        
            if($this->existsCode())
                 $this->putMessageError('This code already exists ',ARRAY());
            if(is_null($this->getCodeParentFromDb()))
                $this->putMessageError("The code Parent {codeparent} don't exists yet ",array('{codeparent}'=>$this->getCodeParent()));
            if(($this->iamRootMaster())) //Si se trata de niveles Master
              $this->putMessageError("By Settings; System allows create Master locations until {level} level {MYLEVEL} deepth ",array('{MYLEVEL}'=>$this->getLevelCode() ,'{level}'=>WoConfig::getParam('_locationsLevelRoot')));
             
            
            
        } 
        
        private function putMessageError($message,$aerror){
            $this->addError ('codigo', yii::t('woModule.errors',$message,$aerror));
               }
        
        private function Match($level=null){
          if(is_null($level))
           $level=$this->getLevelCode();
          IF($level==0)
              RETURN FALSE;
          if(preg_match($this->getPatternForLevel(),$this->codigo)>0)
            return true;
          return false;
        }
        
        public function iamRootMaster(){
             return ($this->getLevelCode()+0 > 1 and 
                $this->getLevelCode()+0 <=
                  WoConfig::getParam('_locationsLevelRoot')+0)
            ?true:false;
        }
        
        private function getPatternForLevel($level=null){
            if(is_null($level))
           $level=$this->getLevelCode();
            IF($level==0) RETURN '';
            if(WoConfig::getPattern()[$level-1])
            return WoConfig::getPattern()[$level-1]; 
            return '';
             
        }
         private function getMaskForLevel($level=null){   
             if(is_null($level))
           $level=$this->getLevelCode();
             $smallMask='';
            IF($level==0) return '';
              $mask=WoConfig::getParam('_locationsMask');
              foreach(explode($this->delimiter(),$mask) as $key=>$fragment){
                $smallMask.=$fragment.$this->delimiter();
                if($key==$level-1)
                 break;
              }
              return substr($smallMask,0,strlen($smallMask)-1);
        }
        
        private function delimiter(){
            return WoConfig::getParam('_delimiterLocations');
        }
        
        public function getCodeRoot(){
            if($this->isNewRecord or empty($this->codigo)){
               return $this->getCodeRootFromDb();
            }else{
               return explode($this->delimiter(),$this->codigo)[0]; 
            }
            
        }
        
        private function getCodeRootFromDb(){
            $reg=$this->find("hidparent=0");
         $retorno=(!is_null($reg))?$reg->codigo:null;
         unset($reg);
         return $retorno;
        }
        
        private function getCodeParentFromDb(){
            //echo "este el codigo   *  ".$this->getCodeParent();die();
            $reg=$this->find("codigo=:vcodigo",array(":vcodigo"=>$this->getCodeParent()));
         $retorno=(!is_null($reg))?$reg->codigo:null;
         unset($reg);
         return $retorno;
        }
        
        private function getParentFromParentCode(){
            //echo "este el codigo   *  ".$this->getCodeParent();die();
            $reg=$this->find("codigo=:vcodigo",array(":vcodigo"=>$this->getCodeParent()));
            //var_dump($reg);DIE();
            RETURN $reg;
        }
        
     private function getHidParent(){
         
     }
     
     
     PUBLIC function iamRoot(){
         IF($this->isNewRecord){
           return ($this->getLevelCode()==self::LEVEL_ROOT)?true:false;                 
         }else{
           return($this->codigo==$this->getCodeRoot())?true:false;
         }
     }
     
     private function checkColectorsInRoots(){
         if($this->iamRootMaster() and $this->isNewRecord){
                  $this->setAttributes(array(
                      'colector'=>'000000',//ensure this code: String format '0000' Must be validate with other models 
                      'codcen'=>'0000',
                      'cebe'=>'00000'
                  ));
              }
     }
     
     
     public function beforeSave(){
          //ECHO "UNO";DIE();
        // VAR_DUMP($this->getParentFromParentCode());DIE();
         if($this->isNewRecord){
            // ECHO "UNO";DIE();
             $this->checkColectorsInRoots(); //ECHO "DOS";DIE();
              if(!$this->iamRoot())
               $this->parent_id=$this->getParentFromParentCode()->id;
               
         }
          
         return parent::beforeSave();
         
     }
     
     
    public function getTreeLabel()
    {
        
        return ucwords(strtolower ($this->descripcion));
        return $this->descripcion."   ".$this->childCount;
       
// return CHtml::openTag("span",array("style"=>"background-color:".$this->color.";  font-weight:bold;font-size:16px; color:white;border-radius:13px;padding:4px;")).$data->tipodoc.CHTml::closeTag("span").str_pad($this->titulo,($this->nivel==2)?60:0,'.',STR_PAD_RIGHT).':' . $this->childCount;
    }
    /**
     * @return array menu url
     */
    public function getMenuUrl()
    {
        return 0;
    }
    /**
     * Retrieves a list of child models
     * @param integer the id of the parent model
     * @return CActiveDataProvider the data provider
     */
    public function getDataProvider($id=null)
    {
        if($id===null)
            $id=$this->TreeBehavior->getRootId();
        $criteria=new CDbCriteria(array(
            'condition'=>'parent_id=:id',
            'params'=>array(':id'=>$id),
            'order'=>'label',
            'with'=>'childCount',
        ));
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }
    
    public function suggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'codigo LIKE :keyword',
			'order'=>'codigo',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"$keyword%")
		));
		$suggest=array();
		//$suggest=array(JSON_ENCODE($models[0]),'KFSHFKSIY');
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->codigo,  // label for dropdown list
				'value'=>$model->codigo,  // value for input field
				//'id'=>$model->id,       // return values from autocomplete
				//'code'=>$model->code,
				//'call_code'=>$model->call_code,
			);
		}
		
		return $suggest;
	}

}
