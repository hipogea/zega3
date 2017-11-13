<?php

/**
 * This is the model class for table "paraqueva".
 *
 * The followings are the available columns in table 'paraqueva':
 * @property string $cmotivo
 * @property string $motivo
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 */
class Paraqueva extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Paraqueva the static model class
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
		return Yii::app()->params['prefijo'].'paraqueva';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('cmotivo', 'required'),
			array('cmotivo', 'length', 'max'=>2),
			array('motivo', 'length', 'max'=>30),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cmotivo, motivo', 'safe', 'on'=>'search'),
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
			'cmotivo' => 'Cmotivo',
			'motivo' => 'Motivo',

		);
	}
public $maximovalor;
	//public $conservarvalor=0; //Opcionpa reaverificar si se quedan lo valores predfindos en sesiones 
	public function beforeSave() {
							if ($this->isNewRecord) {
									
									  //
										// $this->creadoel=Yii::app()->user->name;
									    $this->cmotivo=Numeromaximo::numero($this->model(),'cmotivo','maximovalor',2);
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

		$criteria->compare('cmotivo',$this->cmotivo,true);
		$criteria->compare('motivo',$this->motivo,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}