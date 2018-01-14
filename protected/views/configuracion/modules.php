<?PHP
$this->breadcrumbs=array(
	yii::t('menu','Modules')=>array('modules'),
	//yii::t('menu','General Settings')=>array('index'),
	//yii::t('menu','Setting Module {modulo}',array('{modulo}'=>$modulename)),
);

$this->menu=array(

	array('label'=>yii::t('menu','General Settings'), 'url'=>array('index')),
	//array('label'=>'Listado', 'url'=>array('admin')),
);
?>

<?php MiFactoria::titulo(yii::t('titulos','Customize Modules '),'gear'); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'settings-form',
    //'action'=>$this->createUrl($this->id.'/SettingsModules'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<div class="row">
          
               <?php
                echo CHtml::label(yii::t('labels','Modules'), uniqid());
                ?>
            
            
		<?php 
               // $name= uniqid();
                $htmlOptions=array(
                    //'name'=>$this->id.'[module]',
                    'ajax'=>array(
                        'type'=>'POST',
                       // 'data'=>array('moduleId'=>"".$name.".value"),
                        'url'=>yii::app()->createUrl($this->id.'/AjaxLoadSettingModule',array()),
                        'update'=>'#zoneSettings',
                       // 'complete'=>'js:function(data){$("#zoneSettings").val(data);}',
                         //'success'=>'js:function(data){$("#zoneSettings").val(data);}',
                    )
                );
                echo CHtml::dropDownList($this->id.'[module]', '--'.yii::t('menu','Choose a Module').'--', $data, $htmlOptions)
                ?>
	 </div>

    <DIV ID="zoneSettings">
        
    </DIV>

<?php $this->endWidget(); ?>

</div><!-- form -->
<br>
     <?php //CHtml::link(yii::t('links','Edit params'),yii::app()->createUrl($this->id.'/settingsModules',array('modulename'=>$modulename)))   ?> 
<br>