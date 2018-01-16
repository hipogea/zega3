<?php
/* @var $this LocationsController */
/* @var $model Locations */
/* @var $form CActiveForm */
?>


<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'locations-form',
	'enableClientValidation'=>false,
			'clientOptions' => array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>true
			),
			'enableAjaxValidation'=>true,
)); ?>

    <?php //echo $form->errorSummary($model); ?>
    
    <div class="row">
		<?php
                echo $model->getScenario();
		$botones = array(
		'save' => array(
		'type' => 'A',
		'ruta' => array(),
		'visiblex' => array('10'),
		),


/*
		'refresh' => array(
		'type' => 'D', //AJAX LINK
		'ruta' => array($this->id.'/AjaxRefreshChildFields', array('id' => $model->id)),
		'opajax' => array(
		'type' => 'GET',
		'ruta' => array($this->id.'/AjaxRefreshChildFields', array('id' => $model->id)),
		'complete' => 'function(){
		     $.fn.yiiGridView.update("detalle-grid");
		}'
		),
		/*'success'=>'function(data) {
		$("#myDivision").html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut("slow");
		}'
		),*/
		/*'visiblex' => array('10'),*

		),
*/
			

			'checklist'=>array(
				'type'=>'B',
				'ruta'=>array($this->id.'/generacsv',array(
					'id'=>$model->id)

							),
				'visiblex'=>array('10'),

			),

			

		);

		/*VAR_DUMP($model->{$this->campoestado});
		YII::APP()->END();*/
		$this->widget('ext.toolbar.Barra',
		array(
		//'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
		'botones'=>$botones,
		'size'=>24,
		'extension'=>'png',
		'status'=>'10',

		)
		);
		// var_dump($model->{$this->campoestado}); var_dump(ESTADO_CREADO);var_dump($model->numeroitems+0);die();

		?>
	</div> 
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	

	<div class="row">
		<?php echo $form->labelEx($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('size'=>25,'disabled'=>$model->disabledcampo('codigo'))); ?>
		<?php echo $form->error($model,'codigo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion'); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'essuperior'); ?>
		<?php echo $form->checkBox($model,'essuperior'); ?>
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activa'); ?>
		<?php echo $form->checkbox($model,'activa'); ?>
		
	</div>

	
<?php $this->endWidget(); ?>

</div><!-- form -->