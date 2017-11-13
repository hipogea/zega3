<?php
/* @var $this ChoferesController */
/* @var $model Choferes */

$this->breadcrumbs=array(
	'Choferes'=>array('index'),
	'Manage',
);

$this->menu=array(

	array('label'=>'Crear', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('choferes-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Conductores</h1>



<?php echo CHtml::link('Filtrar','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'choferes-grid',
	'itemsCssClass'=>'table table-striped table-bordered table-hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'brevete',
		'creadopor',
		'creadoel',
		'modificadopor',
		'modificadoel',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{view}',
		),
	),
)); ?>
