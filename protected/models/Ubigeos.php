<?php

/**
 * This is the model class for table "{{ubigeos}}".
 *
 * The followings are the available columns in table '{{ubigeos}}':
 * @property string $coddep
 * @property string $codprov
 * @property string $coddist
 * @property string $departamento
 * @property string $provincia
 * @property string $distrito
 * @property integer $id
 */
class Ubigeos extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ubigeos the static model class
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
		return '{{ubigeos}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('coddep, codprov, coddist, departamento, provincia, distrito', 'required'),
			array('coddep, codprov, coddist', 'length', 'max'=>2),
			array('departamento, provincia, distrito', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('coddep, codprov, coddist, departamento, provincia, distrito, id', 'safe', 'on'=>'search'),
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
			'coddep' => 'Coddep',
			'codprov' => 'Codprov',
			'coddist' => 'Coddist',
			'departamento' => 'Departamento',
			'provincia' => 'Provincia',
			'distrito' => 'Distrito',
			'id' => 'ID',
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

		$criteria->compare('coddep',$this->coddep,true);
		$criteria->compare('codprov',$this->codprov,true);
		$criteria->compare('coddist',$this->coddist,true);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('provincia',$this->provincia,true);
		$criteria->compare('distrito',$this->distrito,true);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function buscaporcodigos($codepa,$codprov,$coddist){
        $codepa=MiFactoria::cleanInput($codepa);
        $codprov=MiFactoria::cleanInput($codprov);
        $coddist=MiFactoria::cleanInput($coddist);
       return self::model()->find("coddep=:vcoddep and codprov=:vcodprov and coddist=:vcoddist  ",array(":vcoddep"=>$codepa,":vcodprov"=>$codprov,":vcoddist"=>$coddist));


     }
}