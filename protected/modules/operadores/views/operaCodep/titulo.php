
<div class="panelizquierdo btn btn-success">
    <div class="bolaexcentrica"> <?php
                    $registrofoto=Adjuntos::findByDocu('346', Trabajadores::getCodigoFromUsuario());
                    //var_dump($registrofoto);die();
                    if(!is_null($registrofoto)){
                        echo  CHtml::image($registrofoto->rutacorta($registrofoto->enlace),'#',array('class'=>'imgRedonda100'));
                    }
                     
                    ?> </div>
    <DIV CLASS='btn btn-warning'><?PHP echo Embarcaciones::model()->findByPk(OperaCodep::getEp()['barco'])->nomep; ?></DIV>
    <?php  echo Trabajadores::getNombresFromIdUsuario(yii::app()->user->id); ?> 
</div>
