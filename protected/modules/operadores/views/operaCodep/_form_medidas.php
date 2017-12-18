<?php MiFactoria::titulo( (($model->isNewRecord)?'Crear':'Actualizar').' Medida', 'gear');  ?>
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
     
           <div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>28,'maxlength'=>28)); ?>
		<?php echo $form->error($model,'numero'); ?>
            <?php //echo $model->ot->textocorto; ?>
	</div>
        
         <div class="row">
             <?php echo $form->labelEx($model,'um'); ?>
		<?php $datos=CHtml::listData(Ums::model()->findAll(), 'um','desum');  ?>
			<?php echo $form->DropDownList($model,'um',$datos ,array( 'disabled'=>($model->escampohabilitado('um'))?'':'disabled' ,  'empty'=>'--Seleccione una medida--')); ?>
			<?php echo $form->error($model,'hidturno');  ?>
            <?php //echo $model->ot->textocorto; ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'requireid'); ?>
           <?php echo $form->checkBox($model,'requireid'); ?>
		
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'obligatorio'); ?>
           <?php echo $form->checkBox($model,'obligatorio'); ?>
		
	</div>
       

<?php $this->endWidget(); ?>
</div>
    


