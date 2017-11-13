<?php

/**
 * This is the model class for table "areas".
 *
 * The followings are the available columns in table 'areas':
 * @property string $codarea
 * @property string $area
 * @property string $explica
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 */
class Areas extends ModeloGeneral
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Areas the static model class
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
		return 'public_areas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('codarea', 'required'),
			array('codarea', 'length', 'max'=>3),
			array('codarea,codsoc', 'required'),
			array('codarea', 'unique'),
			array('codsoc','exist','allowEmpty' => false, 'attributeName' => 'socio', 'className' => 'Sociedades','message'=>'Esta sociedad no existe'),
			array('codarea', 'match', 'pattern'=>Yii::app()->params['mascaradocs'],'message'=>'El codigo  no es el correcto, El c debe comenzar por 2 DIGITOS  > 0 y los caracteres deben ser numericos'),
			array('area', 'length', 'max'=>25),
			array('area', 'required', 'message'=>'Ingresa la descripcion'),
			array('explica', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codarea, area, codsoc,explica', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codarea' => 'Codarea',
			'area' => 'Area',
			'explica' => 'Explica',

		);
	}
	public $maximovalor;
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									  //
										// $this->creadoel=Yii::app()->user->name;
									   // $this->codarea=Numeromaximo::numero($this->model(),'codarea','maximovalor',3);
										//$this->cod_estado='01';
											//$this->c_salida='1';
									} else
									{
										
										//$this->ultimares=" ".strtoupper(trim($this->usuario=Yii::app()->user->name))." ".date("H:i")." :".$this->ultimares;
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

		$criteria->compare('codarea',$this->codarea,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('explica',$this->explica,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}