<?php

/**
 * This is the model class for table "{{grupocc}}".
 *
 * The followings are the available columns in table '{{grupocc}}':
 * @property string $codgrupo
 * @property string $desgrupo
 */
class Grupocc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{grupocc}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codgrupo, desgrupo', 'required'),
			array('codgrupo', 'unique', 'message'=>'Este codigo ya está en uso'),

			array('codgrupo', 'match', 'pattern'=>Yii::app()->params['mascaracodigo'],'message'=>'El codigo  no es el correcto, Debe comenzar con digitos < > 0 y los caracteres deben ser numericos'),

			array('codgrupo', 'length', 'max'=>4),
			array('desgrupo', 'length', 'max'=>40),
			array('codgrupo,codclase, desgrupo','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('codgrupo,codclase, desgrupo', 'safe', 'on'=>'search'),
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
			'clase' => array(self::BELONGS_TO, 'Clasecc', 'codclase'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codgrupo' => yii::t('labels','Cod group'),
			'desgrupo' => yii::t('labels','Group'),
                    'codclase' => yii::t('labels','cod Class'),
			//'desgrupo' => 'Desgrupo',
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

		$criteria->compare('codgrupo',$this->codgrupo,true);
		$criteria->compare('desgrupo',$this->desgrupo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pagesize'=>50),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Grupocc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
