<?php

/**
 * This is the model class for table "maestro_valores".
 *
 * The followings are the available columns in table 'maestro_valores':
 * @property integer $id
 * @property string $nombrevalor
 * @property string $hidat
 * @property string $abreviatura
 * @property string $texto
 * @property string $respaldo1
 * @property string $respaldo2
 * @property string $respaldo3
 */
class MaestroValores extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaestroValores the static model class
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
		return 'public_maestro_valores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombrevalor', 'length', 'max'=>40),
			array('abreviatura', 'length', 'max'=>5),
			array('respaldo1, respaldo2, respaldo3', 'length', 'max'=>40),
			array('hidat, texto', 'safe'),
			array('resultado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, resultado,nombrevalor, hidat, abreviatura, texto, respaldo1, respaldo2, respaldo3', 'safe', 'on'=>'search'),
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
		'atributos' => array(self::BELONGS_TO, 'MaestroAtributos', 'hidat'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombrevalor' => 'Nombrevalor',
			'hidat' => 'Hidat',
			'abreviatura' => 'Abreviatura',
			'texto' => 'Texto',
			'respaldo1' => 'Respaldo1',
			'respaldo2' => 'Respaldo2',
			'respaldo3' => 'Respaldo3',
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nombrevalor',$this->nombrevalor,true);
		$criteria->compare('hidat',$this->hidat,true);
		$criteria->compare('abreviatura',$this->abreviatura,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('respaldo1',$this->respaldo1,true);
		$criteria->compare('respaldo2',$this->respaldo2,true);
		$criteria->compare('respaldo3',$this->respaldo3,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}