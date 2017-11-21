<?php
/**
*/
interface IDocumentsDaily
{  
    /*Esta funcion prepara los campos donde almacenara
     * la referencia aun registro Manttolecturahorometros
     *  em un documento 
     *  de tal  forma 
     * $meausreFields=array(
     *                    1=>array('nombrecampo1','nombrecampo2',...)  
     *                    2=array('nombrecampox','nombrecampoy') 
     *                      );
     * donde los keys son los numeros de orden del horometro o punto de 
     * medida 
     ***/
    public function initFields();
    
    
     
    
}
