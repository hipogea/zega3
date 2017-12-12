<?php

/**
 * This is the model class for table "{{menugeneral}}".
 *
 * The followings are the available columns in table '{{menugeneral}}':
 * @property integer $id
 * @property integer $activa
 * @property string $codaccion
 * @property string $ruta
 * @property string $controlador
 * @property string $modulo
 * @property integer $hidpadre
 */
class Menugeneral extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menugeneral}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('activa, hidpadre', 'numerical', 'integerOnly'=>true),
			array('codaccion', 'length', 'max'=>100),
			array('controlador, modulo', 'length', 'max'=>50),
			array('ruta', 'safe'),
                    array('estado', 'safe','on'=>'status'),
                     array('alias', 'safe','on'=>'escalias'),
                      array('alias', 'safe','on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,activa,alias,codaccion,ruta,controlador,modulo,hidpadre', 'safe', 'on'=>'search_by_active,insert,search'),
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
			'id' => 'ID',
			'activa' => '1 : activo  , otro valor  inactivo',
			'codaccion' => 'Codaccion',
			'ruta' => 'Ruta',
			'controlador' => 'Controlador',
			'modulo' => 'Modulo',
			'hidpadre' => 'Hidpadre',
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
		$criteria->compare('activa',$this->activa);
		$criteria->compare('codaccion',$this->codaccion,true);
		$criteria->compare('ruta',$this->ruta,true);
		$criteria->compare('controlador',$this->controlador,true);
		$criteria->compare('modulo',$this->modulo,true);
		$criteria->compare('hidpadre',$this->hidpadre);
                $criteria->compare('alias',$this->alias);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menugeneral the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function existsMenu($controllerName,$actionName){
            //var_dump($controllerName);var_dump($actionName);die();
            if(is_array($actionName) or is_array($controllerName)){
                echo $controllerName."<br>";
                echo $actionName."<br>";
                var_dump($controllerName);var_dump($actionName);die();
            }
           $res=yii::app()->db->createCommand()->
             select('id')->from('{{menugeneral}}')-> 
             where("controlador=:vcontrolador and codaccion=:vcodaccion ",
                    array(
                       ":vcodaccion"=> $actionName,
                        ":vcontrolador"=>$controllerName
                    ))->limit(1)->queryScalar();
            if($res!=false)
                return $res;
            return false;
            }
            
    public function search_by_active()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
$criteria->compare('codaccion',$this->codaccion,true);
		$criteria->compare('ruta',$this->ruta,true);
                $criteria->compare('id',$this->id);
		$criteria->compare('controlador',$this->controlador,true);
		$criteria->compare('modulo',$this->modulo,true);
		$criteria->compare('activa',$this->activa);
                $criteria->compare('alias',$this->alias,true);
                  $criteria->compare('hidpadre',$this->hidpadre);
		//$criteria->addCondition("activa='1'");
               // $criteria->condition=array(":vcontrolador"=>$controlador);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
/*saca todas las opciens de la tablsa*/
public static function getArrayFromTableMenu(){
  $opciones=yii::app()->db->
    createCommand()->  
   select('id,codaccion,ruta,controlador,modulo,alias,hidpadre')->from('{{menugeneral}}')->  
      where("activa=1")->order("id asc")->queryAll();
 return $opciones; 
}

/*saca LOS HIJOS RECURSICAMENTE */
public static function getChildsMenu($id=null){
 
 
  $childs=array();
 // var_dump(self::getArrayFromTableMenu());die();
  $filas=self::getArrayFromTableMenu();
     if(!is_null($id)){
         $id=(integer)$id; 
     }else{
         if(count($filas)>0)
             $id=$filas[0]['id']+0;
         
     }
      
  foreach ($filas as $clave=>$valor){
     if($valor['hidpadre']==$id){
       //$childs[$valor['id']]=$valor;  
      $acceso=yii::app()->user->checkAccess('action_'.$valor['controlador'].'_'.$valor['codaccion']);
        if($valor['ruta']=='#' or $acceso ){
      $childs[$valor['id']]['label']=$valor['alias'];
      if(strlen(yii::app()->baseUrl)>0)$valor['ruta']=yii::app()->baseUrl.DIRECTORY_SEPARATOR.$valor['ruta'];
        if(!in_array(substr($valor['ruta'],0,1),array('/','\\'))) $valor['ruta']=DIRECTORY_SEPARATOR.$valor['ruta'];
       $childs[$valor['id']]['url']=$valor['ruta'].$valor['controlador'].DIRECTORY_SEPARATOR.$valor['codaccion'];  
      $childs[$valor['id']]['items']=self::getChildsMenu($valor['id']);  
        /* $childs=[$valor['id']];  
         $childs['items']['label']=$valor['alias'];*/
        }
         
     }      
  }
  $childs=array_values($childs);
  return $childs;
}
/*prepara el array para RENDERIZAR CON LA CLASE  CMENU */
public static function getArrayMenu($id){
    //primero los roots 
   // $opciones=self::getArrayFromTableMenu();
    //FOREACH($opciones as $clave=>$valor)
    $hijas=self::getChildsMenu($id);
   foreach($hijas as $clave=>$valor){
       
   }    
}

        
}
/*
Array (
    [7] => Array ( 
        [id] => 7 
        [codaccion] => noneisroot6 
        [ruta] => '#'
        [controlador] => noneisroot6 
        [modulo] => 
        [alias] => Corporativos 
        [hidpadre] => 2 
        [items] => Array ( 
                   [252] => Array ( 
                                [id] => 252
                               [codaccion] => Create 
                               [ruta] => /dev/ 
                               [controlador] => Centros 
                                [modulo] => none 
                                [alias] => Crear Centro
                               [hidpadre] => 7
                                [items] => Array ( )
                                 ) 
                    [256] => Array ( 
                                 [id] => 256 
                                 [codaccion] => Admin 
                                 [ruta] => /dev/ 
                                    [controlador] => Centros
                                  [modulo] => none
                                [alias] => Listado-Centros
                                 [hidpadre] => 7 
                                    [items] => Array ( ) 
                                 ) 
                   [270] => Array ( 
                                [id] => 270 
                               [codaccion] => Create
                               [ruta] => /dev/
                               [controlador] => Clipro 
                               [modulo] => none 
                              [alias] => Crear Proveedor 
                              [hidpadre] => 7 
                               [items] => Array ( 
                                                [12] => Array ( 
                                                          [id] => 12 
                                                    [codaccion] => Edita 
                                                    [ruta] => /dev/ 
                                                    [controlador] => Adjuntos 
                                                    [modulo] => none 
                                                    [alias] => hijio3 
                                                    [hidpadre] => 270 [items] => Array (
                                                                                        [15] => Array (
                                                                                                    [id] => 15 
                                                                                                    [codaccion] => View 
                                                                                                    [ruta] => /dev/ 
                                                                                                    [controlador] => Alconversiones 
                                                                                                    [modulo] => none 
                                                                                                    [alias] => nieto 
                                                                                                    [hidpadre] => 12 
                                                                                                    [items] => Array ( ) 
                                                                                                    ) 
                                                                                        ) 
                                                              ) 
                                                [13] => Array ( 
                                                       [id] => 13 
                                                        [codaccion] => Borra 
                                                         [ruta] => /dev/ 
                                                          [controlador] => Adjuntos 
                                                          [modulo] => none 
                                                           [alias] => hijo 
                                                    [hidpadre] => 270 
                                                    [items] => Array ( ) 
                                                             ) 
                                         )
                       
                                     ) 
                 [282] => Array ( 
                     [id] => 282 
                     [codaccion] => Admin 
                     [ruta] => /dev/ 
                     [controlador] => Clipro 
                     [modulo] => none 
                     [alias] => Listado Proveedores 
                     [hidpadre] => 7 
                     [items] => Array ( ) 
                              ) 
                  [1179] => Array ( 
                      [id] => 1179 
                       [codaccion] => Create 
                      [ruta] => /dev/ 
                      [controlador] => Sociedades 
                      [modulo] => none 
                      [alias] => Crear Sociedad 
                      [hidpadre] => 7 
                      [items] => Array ( ) 
                                    ) 
                  [1183] => Array ( 
                      [id] => 1183 
                      [codaccion] => Admin 
                      [ruta] => /dev/ 
                      [controlador] => Sociedades 
                      [modulo] => none 
                      [alias] => Listado-Sociedades 
                      [hidpadre] => 7 
                      [items] => Array ( ) 
                                   ) 
                ) 
        
        ) //fin del array 7
    
    )*/


