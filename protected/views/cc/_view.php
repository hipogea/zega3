<?php
/* @var $this CcController */
/* @var $data Cc */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('codc')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->codc), array('view', 'id'=>$data->codc)); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('cc')); ?>:</b>
	<?php echo CHtml::encode($data->cc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('centro')); ?>:</b>
	<?php echo CHtml::encode($data->centro); ?>
	<br />

	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('modificadoel')); ?>:</b>
	<?php echo CHtml::encode($data->modificadoel); ?>
	<br />

	*/ ?>

</div>