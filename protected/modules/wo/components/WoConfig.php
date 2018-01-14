<?php
class WoConfig  extends CComponent
{
    
        
         private $parameters=array(
                '_locationsLevelRoot'=>array(
                                'value'=>'3',
                                'size'=>2,
                                'label'=>'Level Roots Locations' ,
                                    ), //indica le nivel de porfundidad de los nodos root de las ubiaciones tecnicas
                '_locationsMask'=>array(
                                'value'=>'XXXX-XX-XXX-XXXXXXX-XXXXX-XXXXX',
                                'size'=>80,
                                'label'=>'Mask for Locations'
                                    ),//MASCAR DE INGRESO DE LA SUBICACIONES TECNICAS
                '_delimiterLocations'=>array(
                                'value'=>'-',
                                'size'=>1,
                                'label'=>'Character delimiter'
                                    ),
                 '_locationsMaxLevelRoot'=>array(
                                'value'=>5,
                                'size'=>2,
                                'label'=>'Max levels to Locations'
                                    ),//numero maximo de niveles 
            );
         
     public function init(){
       
      }
      
      //coloca el prefijo del modulo en cada parametro
      public function getParamsConfig(){
          $newKeys=array();
         foreach(array_keys($this->parameters) as $indice=>$clave){
           $newKeys[]= self::getModuleName().$clave;
         }          
          return array_combine( $newKeys, array_values($this->parameters));
      }
      
      public static function getModuleName(){
         if(isset(explode(DIRECTORY_SEPARATOR,strrev(__FILE__))[2]))
         return  strrev(explode(DIRECTORY_SEPARATOR,strrev(__FILE__))[2]);
         return null;
      }
      /*primero se fija si ya esta registrado en la base de dartos 
       * Si no saca de la propiedad de este componente no mas
       */
      public static function getParam($name){
         if(yii::app()->settings->get(self::getModuleName(),$name)=='')
          if(in_array($name,$this->parameters))
                  return $this->parameters[$name];
           else
               return null;
          return  yii::app()->settings->get($type,$name);
      }
      
       public static function setParam($name,$value){
          return yii::app()->settings->set(self::getModuleName(),$name,$value);
      }
      
      /*obierne el aepxresion regualra para codificar las ubiacones tecnicas*/
      public static function getPattern(){
          $regexpression=array();
          $smallString="";
          $delimiter=self::getParam('_delimiterLocations');
          //var_dump($delimiter);die();
          $patron=self::getParam('_locationsMask');
          foreach( explode($delimiter,$patron) as $clave=>$fragment  ){
              $lenght=strlen($fragment);
              $smallString.="/^[A-Z0-9]{".$lenght."}\\z/".$delimiter;
              $regexpression[]=substr($smallString,0,strlen($smallString)-1);
          }
          return $regexpression;
      }
}
