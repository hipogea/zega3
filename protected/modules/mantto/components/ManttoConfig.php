<?php
class ManttoConfig  extends CComponent
{
    //const MODULE_MANTTO='mantto';
    const DOCU_DAILYWORK='146';
        
         private static $parameters=array(
                 );
         
     public function init(){
       
      }
      
      //coloca el prefijo del modulo en cada parametro
      public function getParamsConfig(){
          $newKeys=array();
         foreach(array_keys($this::$parameters) as $indice=>$clave){
           $newKeys[]= self::getModuleName().$clave;
         }          
          return array_combine( $newKeys, array_values($this::$parameters));
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
                 //var_dump(self::$parameters);die();
          if(in_array($name,array_keys(self::$parameters)))
                  //return self::parameters[$name];
                  echo "";
           else
               return null;
          return  yii::app()->settings->get(self::getModuleName(),self::getModuleName().$name);
      }
      
       public static function setParam($name,$value){
          return yii::app()->settings->set(self::getModuleName(),self::getModuleName().$name,$value);
      }
      
      
      //chekea si tiene valores por defecto en lso dailyworks
      /**/
     public static function checkDeafultValues(){
         return (VwOpcionesdocumentos::tienevalorpordefecto('DailyWork', 'hidturno') &&
          VwOpcionesdocumentos::tienevalorpordefecto('DailyWork', 'codproyecto')&&
           VwOpcionesdocumentos::tienevalorpordefecto('DailyWork', 'codresponsable'));
                 
     }
     public static function countMachinesWorking($idproject){
         $valor= Yii::app()->db->createCommand()
			->select('count(id)')
			->from('{{machineswork}}')
			->where("hidot=:vhidot",array(":vhidot"=>$idproject))->queryScalar();
            if($valor===false)
                return 0;
            else
                return $valor;
     }
      
      
}
