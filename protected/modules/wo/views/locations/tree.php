<?php
/* @var $this LocationsController */
/* @var $model Locations */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	'Manage',
);





$this->menu=array(
	array('label'=>'List Locations', 'url'=>array('admin')),
	array('label'=>'Create Locations', 'url'=>array('create')),
        array('label'=>'Create Master Root', 'url'=>array('createmaster')),
);
?>
<?php MiFactoria::titulo(yii::t('woModule.titulos','List of locations '),'list'); ?>

<?php 
$this->renderpartial('tree_locations');

?>
