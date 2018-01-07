<h1>Actualizacin masiva de inventario</h1>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	<div class="row"> 
<div class="row">
		<?php echo $form->labelEx($model,'centro'); ?>
		<?php   $datos = CHtml::listData(Centros::model()->findAll(array('order'=>'nomcen')),'codcen','nomcen');
		  echo $form->DropDownList($model,'centro',$datos, array(  'ajax' => array('type' => 'POST', 
										  ),
									  'empty'=>'--Seleccione un centro--',) ) ;
		?>
		<?php echo $form->error($model,'centro'); ?>
	</div>
	




	  
		
		<?php echo $form->labelEx($model,'almacen'); ?>
		<?php
		     $datos = CHtml::listData(Almacenes::model()->findAll(array('order'=>'nomal')),'codalm','nomal');
echo $form->DropDownList($model,'almacen',$datos, array('empty'=>'--Llene el almacen--'));

		?>
		<?php echo $form->error($model,'almacen'); ?>
	</div>

	
	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Actualizar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

