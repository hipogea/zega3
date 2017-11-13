<?php
/* @var $this OtController */
/* @var $model Ot */

$this->breadcrumbs=array(
	'Ots'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Nueva orden', 'url'=>array('creadocumento')),
	array('label'=>'Modificar','url'=>array('editadocumento','id'=>$model->id)),
	array('label'=>'Listado', 'url'=>array('admin')),
);
?>

<h1>View Ot #<?php echo $model->numero; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'numero',
		'fechacre',
		'fechafinprog',
		'codpro',
		'idobjeto',
		'codresponsable',
		'textocorto',
		ARRAY('name'=>'textolargo','type'=>'html'),
		'grupoplan',
		'codcen',
		'iduser',
		'codocu',
		'codestado',
		'clase',
		'hidoferta',
	),
)); ?>


 <?php 
        
       $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ot-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false, 
)); ?>


<?php
 if(!$model->isNewRecord){
     $modelin=New Ottraba('search_por_ot');
$this->widget('zii.widgets.jui.CJuiTabs', array(
		'theme' => 'default',
		'tabs' => array(
			'Actividades'=>array('id'=>'tab_',
				'content'=>$this->renderPartial('tab_labores', array('form'=>$form,'model'=>$model),TRUE)
			),
			/*'Personal'=>array('id'=>'tab_x',
				'content'=>$this->renderPartial('tab_personal', array('form'=>$form,'model'=>$model,'modelin'=>$modelin),TRUE)
			),*/

		),
		'options' => array('overflow'=>'auto','collapsible' => false,),
		'id'=>'MyTabi',)
);

 }
?>



<?php
$this->endWidget();?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'cru-dialogdetalle',
	'options'=>array(
		'title'=>'Explorador',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>800,
		'height'=>600,
	),
));
?>
	<iframe id="cru-detalle" width="100%" height="100%"></iframe>
<?php
$this->endWidget();?>
