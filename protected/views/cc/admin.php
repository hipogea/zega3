<?php
/* @var $this CcController */
/* @var $model Cc */

$this->breadcrumbs=array(
       // 'classes'=>array(''),
	yii::t('menu','Groups')=>array('grupocc/admin'),
	'List',
);

$this->menu=array(
	//array('label'=>'Listado', 'url'=>array('index')),
	array('label'=>yii::t('menu','create'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cc-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php MiFactoria::titulo(yii::t('titulos','Colectors'), 'money'); ?>



<?php echo CHtml::link(yii::t('app','search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.groupgridview.GroupGridView', array(
	'id'=>'cc-grid',
	'mergeColumns' => array('codgrupo','vale','cc'),
	'itemsCssClass'=>'table table-striped table-bordered table-hover',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('header'=>yii::t('labels','Cod Class'),'value'=>'$data->grupo->clase->codclasecolector'),
		array('name'=>'cc','header'=>yii::t('labels','Class'),'value'=>'$data->grupo->clase->desclasecolector'),
		'codgrupo',
		array('name'=>'vale','header'=>yii::t('labels','Group'),'value'=>'$data->grupo->desgrupo'),
		
		'codc',
		//'cc',
		//'centro',
		'desceco',
		/*
		'modificadopor',
		'modificadoel',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
