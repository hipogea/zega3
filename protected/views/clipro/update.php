<?php
/* @var $this CliproController */
/* @var $model Clipro */

$this->menu=array(
	//array('label'=>'List Clipro', 'url'=>array('index')),
	array('label'=>'Nuevo', 'url'=>array('create')),
	//array('label'=>'Actualizar', 'url'=>array('update', 'id'=>$model->codpro)),
	//array('label'=>'Borrar', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->codpro),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Listado', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->despro; ?></h1>

<?php echo $this->renderPartial('_form',  array('model'=>$model,'proveedor'=>$proveedor,'proveedor2'=>$proveedor2,'proveedor3'=>$proveedor3)); ?>