<?php
/* @var $this PeticionController */
/* @var $model Peticion */

$this->breadcrumbs=array(
	'Peticions'=>array('index'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List Peticion', 'url'=>array('index')),
	array('label'=>'Crear Oferta', 'url'=>array('create')),
	array('label'=>'Editar Oferta', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Peticion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Ofertas', 'url'=>array('admin')),
);
?>

<h1>View Peticion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'codpro',
		'numero',
		'fecha',
		'usuario',
		'fechacreac',
		'comentario',
		'textocorto',
		'idcontacto',
		'iduser',
		'codocu',
		'codestado',
		'correlativo',
		'prefijo',
		'codmon',
		'descuento',
	),
)); ?>
