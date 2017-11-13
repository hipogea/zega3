<?php

/**
 * This is the model class for table "centros".
 *
 * The followings are the available columns in table 'centros':
 * @property string $codcen
 * @property string $codsoc
 * @property string $nomcen
 * @property string $descricen
 * @property string $creadopor
 * @property string $creadoel
 * @property string $modificadopor
 * @property string $modificadoel
 * @property string $n_dir
 * @property integer $c_planta
 *
 * The followings are the available model relations:
 * @property Usuarios[] $usuarioses
 * @property Almacenes[] $almacenes
 */
class Centros extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Centros the static model class
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
		return 'public_centros';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codcen, nomcen,codsoc', 'required'),
//			array('codcen', 'required'),
			array('codcen', 'unique'),
			array('codcen', 'match', 'pattern'=>Yii::app()->params['mascaradocs'],'message'=>'El codigo  no es el correcto, El c debe comenzar por 2 DIGITOS  > 0 y los caracteres deben ser numericos'),

			//array('c_planta', 'numerical', 'integerOnly'=>true),
			array('codcen', 'length', 'max'=>4),
			array('codsoc', 'length', 'max'=>1),
			array('nomcen', 'length', 'max'=>35),
			//array('creadopor, modificadopor', 'length', 'max'=>25),
			//array('creadoel, modificadoel', 'length', 'max'=>20),
			array('descricen, n_dir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('codcen, codsoc, nomcen, descricen', 'safe', 'on'=>'search'),
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
			'sociedades'=>array(self::BELONGS_TO, 'Sociedades', 'codsoc'),
			
                    'usuarioses' => array(self::HAS_MANY, 'Usuarios', 'centrodefault'),
			'almacenes' => array(self::HAS_MANY, 'Almacenes', 'codcen'),
			'almacenes_agrega_auto' => array(self::STAT, 'Almacenes', 'codcen','condition'=>'agregarauto="1"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'codcen' => 'Codigo',
			'codsoc' => 'Sociedad',
			'nomcen' => 'Nombre descriptivo',
			'descricen' => 'Detalles',
			/*'creadopor' => 'Creadopor',
			'creadoel' => 'Creadoel',
			'modificadopor' => 'Modificadopor',
			'modificadoel' => 'Modificadoel',
			'n_dir' => 'N Dir',
			'c_planta' => 'C Planta',*/
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

		$criteria->compare('codcen',$this->codcen,true);
		$criteria->compare('codsoc',$this->codsoc,true);
		$criteria->compare('nomcen',$this->nomcen,true);
		$criteria->compare('descricen',$this->descricen,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}