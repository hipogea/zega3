<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	'Manage',
);




if($model->existsCodeRoot())
 $this->menu=array(array('label'=>'Create Root', 'url'=>array('createroot')));
else
$this->menu=array(
	array('label'=>'List Locations', 'url'=>array('index')),
	array('label'=>'Create Locations', 'url'=>array('create')),
        array('label'=>'Create Master Root', 'url'=>array('createmaster')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#locations-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php MiFactoria::titulo(yii::t('woModule.titulos','List of locations '),'list'); ?>
<?php  //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'locations-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'codigo',
		'descripcion',
		'parent_id',
		'colector',
		'codcen',
		/*
		'cebe',
		'textolargo',
		'activa',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php 
$this->renderpartial('tree_locations');


?>
