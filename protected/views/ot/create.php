<?php
//echo yii::app()->getLanguage();
					
/* @var $this OtController */
/* @var $model Ot */

$this->breadcrumbs=array(
	'Ots'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Ot', 'url'=>array('index')),
	array('label'=>'Listado', 'url'=>array('admin')),
);
?>

<?php MiFactoria::titulo('Create Project','page_white_gear') ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>