<?php
/* @var $this LocationsController */
/* @var $data Locations */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codigo')); ?>:</b>
	<?php echo CHtml::encode($data->codigo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hidpadre')); ?>:</b>
	<?php echo CHtml::encode($data->hidpadre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('colector')); ?>:</b>
	<?php echo CHtml::encode($data->colector); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codcen')); ?>:</b>
	<?php echo CHtml::encode($data->codcen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cebe')); ?>:</b>
	<?php echo CHtml::encode($data->cebe); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('textolargo')); ?>:</b>
	<?php echo CHtml::encode($data->textolargo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activa')); ?>:</b>
	<?php echo CHtml::encode($data->activa); ?>
	<br />

	*/ ?>

</div>