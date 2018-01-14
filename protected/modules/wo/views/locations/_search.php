<?php
/* @var $this LocationsController */
/* @var $model Locations */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hidpadre'); ?>
		<?php echo $form->textField($model,'hidpadre'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'colector'); ?>
		<?php echo $form->textField($model,'colector',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codcen'); ?>
		<?php echo $form->textField($model,'codcen',array('size'=>4,'maxlength'=>4)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cebe'); ?>
		<?php echo $form->textField($model,'cebe',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'textolargo'); ?>
		<?php echo $form->textArea($model,'textolargo',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'activa'); ?>
		<?php echo $form->textField($model,'activa',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->