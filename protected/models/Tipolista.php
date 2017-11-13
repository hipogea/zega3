<?php

/**
 * This is the model class for table "{{tipolista}}".
 *
 * The followings are the available columns in table '{{tipolista}}':
 * @property string $codtipo
 * @property string $destipo
 * @property integer $iduser
 *
 * The followings are the available model relations:
 * @property Listamateriales[] $listamateriales
 */
class Tipolista extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{tipolista}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codtipo', 'required'),
			array('iduser', 'numerical', 'integerOnly'=>true),
			array('codtipo', 'length', 'max'=>3),
			array('destipo', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codtipo, destipo, iduser', 'safe', 'on'=>'search'),
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
			'listamateriales' => array(self::HAS_MANY, 'Listamateriales', 'codtipo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codtipo' => 'Codtipo',
			'destipo' => 'Destipo',
			'iduser' => 'Iduser',
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

		$criteria->compare('codtipo',$this->codtipo,true);
		$criteria->compare('destipo',$this->destipo,true);
		$criteria->compare('iduser',$this->iduser);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tipolista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
