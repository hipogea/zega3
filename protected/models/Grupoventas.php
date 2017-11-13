<?php

/**
 * This is the model class for table "grupoventas".
 *
 * The followings are the available columns in table 'grupoventas':
 * @property string $codgrupo
 * @property string $codalm
 * @property string $nomgru
 * @property string $desgru
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $codsociedad
 */
class Grupoventas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Grupoventas the static model class
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
		return Yii::app()->params['prefijo'].'grupoventas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codgrupo', 'required'),
			array('codgrupo, codalm', 'length', 'max'=>3),
			array('desgru', 'length', 'max'=>20),
			//array('creadopor, modificadopor', 'length', 'max'=>25),
			array('codsociedad', 'length', 'max'=>1),
			array('desgru', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codgrupo, codalm, nomgru, desgru, codsociedad', 'safe', 'on'=>'search'),
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
			'codgrupo' => 'Codgrupo',
			'codalm' => 'Codalm',
			'nomgru' => 'Nomgru',
			'desgru' => 'Desgru',
			'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'codsociedad' => 'Codsociedad',
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

		$criteria->compare('codgrupo',$this->codgrupo,true);
		$criteria->compare('codalm',$this->codalm,true);
		$criteria->compare('nomgru',$this->nomgru,true);
		$criteria->compare('desgru',$this->desgru,true);




		$criteria->compare('codsociedad',$this->codsociedad,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}