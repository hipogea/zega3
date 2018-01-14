<?PHP
$this->breadcrumbs=array(
	yii::t('menu','Modules')=>array('modules'),
	//yii::t('menu','General Settings')=>array('index'),
	yii::t('menu','Setting Module {modulo}',array('{modulo}'=>$modulename)),
);

$this->menu=array(

	array('label'=>yii::t('menu','General Settings'), 'url'=>array('index')),
	//array('label'=>'Listado', 'url'=>array('admin')),
);
?>

<?php MiFactoria::titulo(yii::t('titulos','Customize Module '.$modulename),'gear'); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings-form',
    'action'=>$this->createUrl($this->id.'/SettingsModules'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php
       // var_dump($aparametros);die();
         foreach($aparametros as $nameparam=>$param){
             $this->renderpartial('_form_one_parameter',array('form'=>$form,'nameparam'=>$nameparam,'param'=>$param  ) );
         }
        
        ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton( 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->