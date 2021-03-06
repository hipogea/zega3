<?php

/**
 * This is the model class for table "{{tempotconsignacion}}".
 *
 * The followings are the available columns in table '{{tempotconsignacion}}':
 * @property string $id
 * @property string $hidetot
 * @property double $cant
 * @property string $um
 * @property string $codart
 * @property string $fecnec
 * @property integer $idusertemp
 * @property string $idtemp
 * @property string $identificador
 * @property string $hidot
 * @property string $descripcion
 * @property string $textolargo
 */
class Tempotconsignacion extends ModeloGeneral
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tempotconsignacion}}';
	}
        
        public function init(){
            $this->campossensibles=array(
                'cant'=>array(),
                'um'=>array(),
                'codart'=>array(),
                'descripcion'=>array(),
                'centro'=>array(),
                'codal'=>array());
	    $this->campoestado='est';
            return parent::init();
        }
        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('idtemp', 'required'),
                    array('est', 'safe','on'=>'estado'),
                    array('id, hidetot, cant, um, codart, fecnec, 
                         idusertemp, idtemp, identificador,
                         hidot, descripcion,idstatus, textolargo,item,est,centro,codal,codcli', 
                        'safe', 'on'=>'buffer'),
		
			array('idusertemp', 'numerical', 'integerOnly'=>true),
			array('cant', 'numerical'),
			array('hidetot, idtemp, identificador, hidot', 'length', 'max'=>20),
			array('um', 'length', 'max'=>3),
			array('codart', 'length', 'max'=>12),
			array('descripcion', 'length', 'max'=>40),
			array('fecnec, textolargo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, hidetot, cant, um, codart, fecnec, idusertemp, idtemp, identificador, hidot, descripcion, textolargo', 'safe', 'on'=>'search'),
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
                   'maestrocompo' => array(self::BELONGS_TO, 'Maestrocompo', 'codart'),
                    'ot' => array(self::BELONGS_TO, 'Ot', 'hidot'),
                     'otconsignacion' => array(self::HAS_ONE, 'Otconsignacion', 'idtemp'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'hidetot' => 'Hidetot',
			'cant' => 'Cant',
			'um' => 'Um',
			'codart' => 'Codart',
			'fecnec' => 'Fecnec',
			'idusertemp' => 'Idusertemp',
			'idtemp' => 'Idtemp',
			'identificador' => 'Identificador',
			'hidot' => 'Hidot',
			'descripcion' => 'Descripcion',
			'textolargo' => 'Textolargo',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('hidetot',$this->hidetot,true);
		$criteria->compare('cant',$this->cant);
		$criteria->compare('um',$this->um,true);
		$criteria->compare('codart',$this->codart,true);
		$criteria->compare('fecnec',$this->fecnec,true);
		$criteria->compare('idusertemp',$this->idusertemp);
		$criteria->compare('idtemp',$this->idtemp,true);
		$criteria->compare('identificador',$this->identificador,true);
		$criteria->compare('hidot',$this->hidot,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('textolargo',$this->textolargo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tempotconsignacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function search_por_ot($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('hidetot',$this->hidetot,true);
		$criteria->addCondition("hidot=".$id);
           $criteria->addCondition("idstatus> -1");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
   
public function beforeSave(){
    
    return parent::beforeSave();
}      
        
}
