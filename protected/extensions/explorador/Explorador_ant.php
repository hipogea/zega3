<?php

class Explorador  
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventario the static model class
	 */
	 
	public $codigosap ; //el codigo del archivo a poner correlativo 
	public $rutadearchivos;  //la ruta de la carpera a nalizar
	public $extension; //guarad ala exotension delos archivos 
	public $rutarelativa;
	public function init()
	{
		//$options=$this->options?CJavaScript::encode($this->options):'';
		
	}
	
	public  function devuelvemodelo($campito,$relaciones)
	{
	   		    $mitabla=$this->nombreclase($campito,$relaciones);		
				$cadena="\$estemodelo=  new ".$mitabla."('search');";	
				eval($cadena);
				return $estemodelo;
				
		
	
	
	}
	public  function buscavalor($nombrecampo,$vvalor,$ordencampo,$relaciones)
	{
		
				$mitabla=$this->nombreclase($nombrecampo,$relaciones);		 
				$cadena="\$mimodelo=".$mitabla."::model()->findBypK('".$vvalor."');";
				//echo $cadena;
				
				eval($cadena);
				
				
				if (is_null($mimodelo)) {
					
					
						echo "--";
									} else 		{
													$adel=$mimodelo->attributeNames();
				
				
													$cadena="echo \$mimodelo->".$adel[$ordencampo].";";
												eval($cadena);
										}	
				
				
				
	}
   
	public function nombreclase ($campito,$relaciones) 
	   { foreach ($relaciones as $clave => $valor) {
							foreach ( $relaciones[$clave] as $clave2=>$valor2 ) {
												//echo $valor2."<br>";
											if ($valor2==$campito) {
												$mitabla=  $relaciones[$clave][1];
												$aliastabla=$clave;
											  break;
											}
										
								}
		
						}
				return $mitabla;
	   
	   }
	   
	   
	}