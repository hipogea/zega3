
<?php
$this->menu=array(
	array('label'=>'Listado de cargas ', 'url'=>array('admin')),
	array('label'=>'Crear Carga', 'url'=>array('create')),
);
?>

<h1> Listado de errores de carga  <?php echo $model->descripcion; ?> </h1> 

  Numero de errores :   <?php echo $model->numeroerrores; ?> 
  <DIV CLASS="FORM">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'logerrores-grid',
	'dataProvider'=>Logcargamasiva::model()->search_carga($model->id),
	'cssFile' => Yii::app()->getTheme()->baseUrl.'/css/grilla_celeste.css',


	//'filter'=>$model,
	'columns'=>array(
		//'id',
		'numerolinea',
		array('name'=>'level', 'type'=>'raw','header'=>'.','value'=>'($data->level=="1")?
						CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."arrow_up.png","hola","",array("width"=>"5","height"=>5))
						:
						CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."rojo.png","hola","",array("width"=>5,"height"=>5))'
						),
		
		'hidcarga',
		array('name'=>'campo', 'type'=>'raw','header'=>'Campo','value'=>'($data->level=="1")?
						$data->campo	
						:
						$data->campo'
						),
		'mensaje',
		array('name'=>'iduser', 'value'=>'Yii::app()->user->um->loadUserById($data->iduser ,false)->username'),
						
		//'level',
		/*
		'descripcion',
		*/
		
	),
)); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cargamasiva-form',
	'action'=>Yii::app()->createUrl($this->id.'/cargar',array('id'=>$model->id)),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	

<?php 

echo $form->hiddenField($model,'id'); ?>
		<?php  //echo $form->hiddenField($model,'ruta',array('value'=>$ruta)); ?>
		


	<div class="row buttons">
                <?PHP    
                $ajaxOptions=array(
                    'type'=>'POST',
                    'data'=>array("id"=>$model->id,"ruta"=>$ruta),
                    'success'=>'js:function(data){$.notify(data,"info");$("#valik").hide();}',
                    'error'=>'js:function(data){$.notify(data,"error");}',
                    'url'=>yii::app()->createUrl($this->id."/cargar")
                );
                echo ($model->numeroerrores ==0)?CHtml::ajaxSubmitButton('Efect carga',yii::app()->createUrl($this->id."/cargar"), $ajaxOptions,array("id"=>"valik")):""; ?>
		<?php //echo ($model->numeroerrores ==0)?CHtml::submitButton('Efectuar carga'):""; ?>
	</div>

<?php $this->endWidget(); ?>

      </DIV>

 <?php //echo $model->ruta; ?> 