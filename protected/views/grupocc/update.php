<?php
/* @var $this GrupoccController */
/* @var $model Grupocc */

$this->breadcrumbs=array(
	'Grupoccs'=>array('index'),
	$model->codgrupo=>array('view','id'=>$model->codgrupo),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Grupocc', 'url'=>array('index')),
	array('label'=>yii::t('menu','Create'), 'url'=>array('create')),
	//array('label'=>'View Grupocc', 'url'=>array('view', 'id'=>$model->codgrupo)),
	array('label'=>yii::t('titulos','List'), 'url'=>array('admin')),
);
?>

<?php MiFactoria::titulo(yii::t('titulos','Edit Group'),'update'); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>