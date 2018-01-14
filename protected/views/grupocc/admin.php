<?php
/* @var $this GrupoccController */
/* @var $model Grupocc */


$this->breadcrumbs=array(
       // 'classes'=>array(''),
	yii::t('menu','Colectors')=>array('Cc/admin'),
	'List',
);

$this->menu=array(
	//array('label'=>'List Grupocc', 'url'=>array('index')),
	array('label'=>yii::t('menu','Create Group'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#grupocc-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php MiFactoria::titulo(yii::t('titulos','Group Colectors'),'package'); ?>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grupocc-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'codgrupo',
		'codclase',
		'desgrupo',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
