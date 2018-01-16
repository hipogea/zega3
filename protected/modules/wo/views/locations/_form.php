<?php
/* @var $this LocationsController */
/* @var $model Locations */
/* @var $form CActiveForm */
?>


<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'locations-form',
	/*'enableClientValidation'=>false,
			'clientOptions' => array(
				'validateOnSubmit'=>true,
				'validateOnChange'=>true
			),*/
			'enableAjaxValidation'=>true,
)); ?>

    <?php //echo $form->errorSummary($model); ?>
    
    <div class="row">
		<?php
		$botones = array(
		'save' => array(
		'type' => 'A',
		'ruta' => array(),
		'visiblex' => array('10'),
		),



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
		'visiblex' => array('10'),

		),

			

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
               <?php if(!$model->isNewRecord){?>
		<?php echo $form->labelEx($model,'codeparent'); ?>
		<?php echo $form->textField($model,'codeparent',array('value'=>$model->getCodeParent(),'size'=>60,'maxlength'=>250,'disabled'=>'disabled')); ?>
               <?php  } ?>
        </div>

	<div class="row">
		<?php echo $form->labelEx($model,'codigo'); ?>
                <?php if(!$model->checkcompromisos()){ ?>
                <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$model,
			'attribute'=>'codigo',
                        'source'=>$this->createUrl('TaskGeneral/suggestLocations'),
                        'options'=>array(
				'showAnim'=>'fold',),
                             'htmlOptions'=>array(
        'size'=>60,
    ),
						));
                ?>
                <?php }else{  ?>
		<?php echo $form->textField($model,'codigo',array('size'=>60,'maxlength'=>250,'disabled'=>$model->disabledcampo('codigo'))); ?>
		 <?php }  ?>
                    <?php echo $form->error($model,'codigo'); ?>
	</div>
        

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'colector'); ?>
             <?php if(!$model->checkcompromisos()){ ?>
                <?php  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$model,
			'attribute'=>'colector',
                        'source'=>$this->createUrl('TaskGeneral/suggestCeco'),
                        'options'=>array(
				'showAnim'=>'fold',),
                             'htmlOptions'=>array(
        'size'=>15,
    ),
						));
                ?>
                <?php }else{  ?>
		<?php echo $form->textField($model,'colector',array('size'=>15,'maxlength'=>15,'disabled'=>$model->disabledcampo('colector'))); ?>
		 <?php }  ?>
		<?php echo $form->error($model,'colector'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'codcen'); ?>
		 <?php $datos = CHtml::listData(Centros::model()->findAll(),'codcen','nomcen');                
	echo $form->DropDownList($model,'codcen',$datos, array('empty'=>'--'.yii::t('woModule.menu','Choose a Value',array()).'--')  );
                    ?>
                <?php echo $form->error($model,'codcen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cebe'); ?>
		<?php echo $form->textField($model,'cebe',array('size'=>15,'maxlength'=>15,'disabled'=>$model->disabledcampo('cebe'))); ?>
		<?php echo $form->error($model,'cebe'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'textolargo'); ?>
		 <?php      $this->widget(
                        'application.components.booster.widgets.TbRedactorJs',
                                array(
                                'name' => 'some_text_field',
                                    'model'=> $model,
                                    'height'=>300,
                                    'attribute'=>'textolargo',
                                )
                            );?>
		<?php echo $form->error($model,'textolargo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activa'); ?>
		<?php echo $form->checkBox($model,'activa',array('disabled'=>'disabled ')); ?>
		
	</div>

	
<?php $this->endWidget(); ?>

</div><!-- form -->