<?php
/* @var $this ClasesmaestroController */
/* @var $model Clasesmaestro */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clasesmaestro-form',
	'enableAjaxValidation'=>false,
)); ?>

	

	<div class="row">
		<?php echo $form->labelEx($model,'codclasema'); ?>
		<?php echo $form->textField($model,'codclasema',array('disabled'=>'disabled','size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'codclasema'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nomclase'); ?>
		<?php echo $form->textField($model,'nomclase',array('size'=>35,'maxlength'=>35)); ?>
		<?php echo $form->error($model,'nomclase'); ?>
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->