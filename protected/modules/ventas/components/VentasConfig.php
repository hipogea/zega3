<?php
class VentasConfig  extends CComponent
{
         private $parameters=array(
                'ventas_locationsLevelRoot'=>3, //indica le nivel de porfundidad de los nodos root de las ubiaciones tecnicas
                'ventas_locationsMask'=>'XXXX-XX-XXX-XXXXXXX-XXXXX-XXXXX',//MASCAR DE INGRESO DE LA SUBICACIONES TECNICAS
                'ventas_delimiterLocations'=>'-',
                 'ventas_locationsMaxLevelRoot'=>5,//numero maximo de niveles 
            );
         
     public function init(){
       
      }
      public function getParamsConfig(){
          return $this->parameters;
      }
}
