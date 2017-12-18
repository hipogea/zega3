<div class="form">
    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dailywork-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
 <div class="row">
                <?php
                
                    $botones = array( 
                        'save' => array(
                            'type' => 'A',
                            'ruta' => array(),
                            'visiblex' => array('10'),
                        ),
                          
                        
                        'print' => array(
                            'type' => 'B',
                            'ruta' => array('coordocs/hacereporte', array('id' => $model->id, 'idfiltrodocu' => $model->id, 'file' => 0)),
                            'visiblex' => array('10'),
                        ),
                    
                    );
                $this->widget('ext.toolbar.Barra',
                    array(
                        //'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
                        'botones'=>$botones,
                        'size'=>24,
                        'extension'=>'png',
                        'status'=>'10',
                    )
                );
                ?>
            

            </div>
	
	<?php echo $form->errorSummary($model); ?>
            <?php  echo $form->hiddenField($model,'hidparte',array('value'=>$idpadre)); ?>
          
     <div class="row">
		<?php $datos=CHtml::listData(Inventario::equipmentsForShip($codep),'idinventario' ,'descripcion' )  ?>
			<?php echo $form->DropDownList($model,'hidequipo',$datos ,array( 'empty'=>'--Seleccione equipo--')); ?>
			<?php echo $form->error($model,'hidequipo');  ?>
            
            <?php //echo $model->ot->textocorto; ?>
	</div>
    
    <div class="row">
      <?php  /*$this->widget(
    'booster.widgets.TbSwitch',
    array(
        'form'=>$form,
        'name' => 'codcriticidad',
        'options' => array(
            'size' => 'normal', //null, 'mini', 'small', 'normal', 'large
            'onColor' => 'success', // 'primary', 'info', 'success', 'warning', 'danger', 'default'
            'offColor' => 'danger',  // 'primary', 'info', 'success', 'warning', 'danger', 'default'
        ),
    )
); */
       echo $form->labelEx($model,'parada'); ?>
		<?php echo $form->checkBox($model,'parada',array('onClick'=>"js:$('#Dailyevents_parada').notify('AL ACTIVAR ESTO REGISTRARA UNA  PARADA', 'info')" )); ?>
		<?php echo $form->error($model,'parada'); ?>
      
      
    </div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>28,'maxlength'=>28)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
            <?php //echo $model->ot->textocorto; ?>
	</div>
        
         <div class="row">
             <?php echo $form->labelEx($model,'codcriticidad'); ?>
		<?php $datos=array('A'=>'Emergente','B'=>'Critico','C'=>'Normal');  ?>
			<?php echo $form->DropDownList($model,'codcriticidad',$datos ,array( 'empty'=>'--Seleccione una medida--')); ?>
			<?php echo $form->error($model,'codcriticidad');  ?>
            <?php //echo $model->ot->textocorto; ?>
	</div>
    
    
    <div class="row">
		<?php echo $form->labelEx($model,'detalle'); ?>
           <?php echo $form->textArea($model,'detalle'); ?>
		
	</div>
       
<?php
$fotos=Inventario::getPicturesFromAssets($codep);
foreach($fotos as $clave=>$ruta){
     echo Chtml::openTag("div",array("class"=>"imgRedonda100"));
     echo Chtml::link(Chtml::image($ruta,'',array("style"=>"imgRedonda100")),yii::app()->createUrl("/OPERA/"));
    echo Chtml::closeTag("div");
}
 ?>
<?php $this->endWidget(); ?>
</div>
    


