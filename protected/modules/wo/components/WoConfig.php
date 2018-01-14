<?php
class WoConfig  extends CComponent
{
         private $parameters=array(
                'wo_locationsLevelRoot'=>3, //indica le nivel de porfundidad de los nodos root de las ubiaciones tecnicas
                'wo_locationsMask'=>'XXXX-XX-XXX-XXXXXXX-XXXXX-XXXXX',//MASCAR DE INGRESO DE LA SUBICACIONES TECNICAS
                'wo_delimiterLocations'=>'-',
                 'wo_locationsMaxLevelRoot'=>5,//numero maximo de niveles 
            );
         
     public function init(){
       
      }
      public function getParamsConfig(){
          return $this->parameters;
      }
}
