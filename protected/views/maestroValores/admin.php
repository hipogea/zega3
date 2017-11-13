<?php
/* @var $this MaestroValoresController */
/* @var $model MaestroValores */

$this->breadcrumbs=array(
	'Maestro Valores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MaestroValores', 'url'=>array('index')),
	array('label'=>'Create MaestroValores', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#maestro-valores-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Maestro Valores</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'maestro-valores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombrevalor',
		'hidat',
		'abreviatura',
		'texto',
		'respaldo1',
		/*
		'respaldo2',
		'respaldo3',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
