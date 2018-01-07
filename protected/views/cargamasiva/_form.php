<?php
/* @var $this CargamasivaController */
/* @var $model Cargamasiva */
/* @var $form CActiveForm */
?>


<div class="division">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cargamasiva-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	

	<?php echo $form->errorSummary($model); ?>
    
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

			

			'pack1'=>array(
				'type'=>'C',
				'ruta'=>array('cargamasiva/import',array(
					'id'=>10,
					'asDialog'=>1)

							),
				'dialog'=>'cru-dialogdetalle',
				'frame'=>'cru-detalle',
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

	<div class="row">
		<?php echo $form->labelEx($model,'modelo'); ?>
		<?php //echo $form->textField($model,'modelo',array('size'=>60,'maxlength'=>100)); ?>
		<?php
		     $datos = $model->enumModels();
			 $valores=array();
			 foreach ($datos  as $clave => $valor) {
				  $valores[$valor]=$valor;
			 }
				echo $form->DropDownList
				(	$model,'modelo',$valores, 
						array(
							'empty'=>'--Escoja el modelo--',
							'disabled'=>($model->isNewRecord)?'':'disabled',
							'ajax' => array(
												'type' => 'POST',  
												'url' => CController::createUrl('Cargamasiva/cargaescenario'), //  la acci贸n que va a cargar el segundo div 
												'update' => '#Cargamasiva_escenario' // el div que se va a actualizar
											),
						     )
				);

		?>
		<?php echo $form->error($model,'modelo'); ?>
	</div>
	
	
	
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'escenario'); ?>
		<?php //echo $form->textField($model,'modelo',array('size'=>60,'maxlength'=>100)); ?>
		<?php
		    if($model->isNewRecord){

			 $valoresx=array();

				echo $form->DropDownList($model,'escenario',$valoresx, array('empty'=>'--Escoja el escenario--', 'disabled'=>($model->isNewRecord)?'':'disabled'));
			}else {
				echo $form->hiddenField($model,'id');
				echo Chtml::textField("SKJKSFS",$model->escenario,array('disabled'=>'disabled'));
			}
		
		
		
		?>
		<?php echo $form->error($model,'escenario'); ?>
	</div>
	
	

	<div class="row">
		<?php echo $form->labelEx($model,'iduser'); ?>
		<?php echo ($model->isNewRecord)?'':Chtml::textField('iduser',strtoupper(Yii::app()->user->um->loadUserById($model->iduser,false)->username)); ?>
	
	</div>
	
	
	

	<div class="row">
		<?php echo $form->labelEx($model,'fechacreac'); ?>
		<?php echo ($model->isNewRecord)?'':Chtml::textField('fechacreac',$model->fechacreac); ?>
	
	
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'insercion'); ?>
		<?php IF(!$model->insercion=='1') {?>
		<?php echo $form->checkBox($model,'insercion',array('disabled'=>($model->isNewRecord)?'':'disabled')); ?>
		<?php }else {?>
			<?php echo $form->hiddenField($model,'insercion',array('value'=>'1')); ?>
			<?php echo CHTml::checkBox('chcbosinsercion',array('value'=>'1','disabled'=>'disabled')); ?>
		<?php } ?>

		<?php echo $form->error($model,'insercion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>40)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>
	
		<div class="row">
		<?php if(!$model->isNewRecord) { ?>
		<?php echo CHtml::label('Archivo de carga','Archivo de carga'); ?>
		<?php echo CHtml::link('Cargar datos ...',Yii::app()->createUrl('/cargamasiva/import',array('id'=>$model->id))); ?>
		<?php } ?>
		
		
	</div>
	
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detalle-grid',
	'dataProvider'=>Cargamasivadet::model()->search_por_carga($model->id),
	'cssFile' => Yii::app()->getTheme()->baseUrl.'/css/grilla_naranja.css',
	//'filter'=>$model,
    'itemsCssClass'=>'table table-striped table-bordered table-hover',
	
	'columns'=>array(	
        array(
			'htmlOptions'=>array('width'=>15),
			'class'=>'CButtonColumn',
			 'buttons'=>array(
			 
			 
                        'update'=>
                            array(
                            	   'visible'=>'true',
                                    'url'=>'$this->grid->controller->createUrl("/Cargamasiva/Modificadetalle/",
										    array("id"=>$data->id,
                                                                                         "asDialog"=>1,
											"gridId"=>$this->grid->id,
											)
									    )',
                                    'click'=>('function(){ 
							    $("#cru-detalle").attr("src",$(this).attr("href")); 
							    $("#cru-dialogdetalle").dialog("open");  
							     return false;
							 }'),
								'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'page_white_edit.png',
								'label'=>'Actualizar Item', 
                                ),


								'delete'=>

                             array(
                             	    'visible'=>'true',
                                    'url'=>'$this->grid->controller->createUrl("/Cargamasiva/borrafilacampo", array("id"=>$data->id))',
							 'options' => array( 'ajax' => array('type' => 'GET','data'=>'Se borro el registro', 'success'=>'js:function() { $.fn.yiiGridView.update("detalle-grid");}' ,'url'=>'js:$(this).attr("href")'),
							 
							 ) ,
						    'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'borrador.png',
								'label'=>'Borrar',
                                ),	
							

                            


                               'view'=>
                            array(
                            	   'visible'=>'false',
                                    'url'=>'$this->grid->controller->createUrl("/solpe/Reservaitem/",
										    array("id"=>$data->id,
                                                                                         "asDialog"=>1,
											"gridId"=>$this->grid->id,
											"ed"=>"no",

											)
									    )',
                                    'click'=>('function(){ 
							    $("#cru-detalle").attr("src",$(this).attr("href")); 
							    $("#cru-dialogdetalle").dialog("open");  
							     return false;
							 }'),
								'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'box.png',
								'label'=>'Reservar', 
                                ),

                            ),
	               ),	
		//'id',
		'aliascampo',
		array('name'=>'nombrecampo','header'=>'Campo','type'=>'raw','value'=>'($data->getclave()!="0")?CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."key_".$data->getclave().".png")." - ".$data->nombrecampo:"".$data->nombrecampo'),
		ARRAY('name'=>'explicacion','value'=>'substr($data->explicacion,0,40)."..."'),
		'requerida',
		'longitud',
		'tipo',
		'orden',
		'activa',
              'modeloforaneo',
		/*
		'descripcion',
		*/
	
	
	
	
	
	
	
	
	),
)); ?>

<div class="row">
		<?php  ?>
		<?php //echo $form->textField($model,'modelo',array('size'=>60,'maxlength'=>100)); ?>
		<?php
		    if(!$model->isNewRecord and count($model->getFielDifference())>0 ){
                          echo $form->labelEx($model,'idcampoadicional');
			$datos= array_combine(array_values($model->getFielDifference()),array_values($model->getFielDifference()));

				echo $form->DropDownList(
                                        $model,
                                        'idcampoadicional',
                                        $datos, 
                                        array(
                                            'ajax' => array(
							'type' => 'POST', 
                                                       // 'data'=>array();
							'url' => CController::createUrl($this->id.'/AjaxAddChild'), //  la acción que va a cargar el segundo div 
							'success'=>"function(data) {
							   $.fn.yiiGridView.update('detalle-grid'); 
                                                                $.notify(data, 'info');  
                                                                return false;
                                                            }",// el div que se va a actualizar
							),
						'prompt' => '--Seleccione campo--' // Valor por defecto 
						)
                                                        );
                    }
		
		
		
		?>
		<?php echo $form->error($model,'escenario'); ?>
	</div>
    
    <?php $this->endWidget(); ?>
</div>
</div><!-- form -->





<?php
	//--------------------- begin new code --------------------------
	// add the (closed) dialog for the iframe
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'cru-dialogdetalle',
		'options'=>array(
			'title'=>'Favorito',
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>500,
			'height'=>400,
			'show'=>'Transform',
		),
	));
	?>
<iframe id="cru-detalle" frameborder="0"  width="100%" height="100%" ></iframe>
<?php
 
$this->endWidget();
//--------------------- end new code --------------------------
?>
<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('detalle-grid');
	alert(data);
}
</script>