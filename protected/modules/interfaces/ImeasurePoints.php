<?php
/**
*/
interface ImeasurePoints
{  
    /*recupera lecturas de un punto de medida segun fecha*/
    public function getMeasureByDate($date);
    
    
     public function  updatePoint($difference);

     
     public function  getEquipo();
    /*
        @returns Boolean true=login aceptado false=error de conexion.
    */
 
    
}
