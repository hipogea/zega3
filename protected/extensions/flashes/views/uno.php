<?php        foreach($mensajes as $clave=>$mensaje){            echo CHtml::openTag("div",array("class"=>"flash-".$clave)).$mensaje.CHtml::closeTag("div");        }        ?>