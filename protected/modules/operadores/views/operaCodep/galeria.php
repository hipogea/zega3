<?php
$fotos=Inventario::getPicturesFromAssets($codep);
foreach($fotos as $clave=>$ruta){
     echo Chtml::openTag("div",array("class"=>"marco"));
     echo Chtml::link(Chtml::image($ruta,array("class"=>"imgRedonda100")),yii::app()->createUrl());
    
}
 ?>
