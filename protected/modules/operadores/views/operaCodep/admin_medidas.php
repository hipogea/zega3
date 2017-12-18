<?php 
MiFactoria::titulo('Catalogo de medidas', 'gear');

$this->breadcrumbs=array(
	'Crear Medida'=>array('createMeasure'),
	'Admiinistrar',
);

$this->menu=array(
	array('label'=>'List OperaCodep', 'url'=>array('index')),
	array('label'=>'Create OperaCodep', 'url'=>array('create')),
);
?>
<?PHP
$grilla=$this->widget('ext.groupgridview.GroupGridView', array(
      'id' => 'ot-grid',
      //'dataProvider'=>$model->search(),
     // 'mergeColumns' => array('codtipo'),
    
    'itemsCssClass'=>'table table-striped table-bordered table-hover',
	'dataProvider'=> $model->search(),	
	//'cssFile' => Yii::app()->getTheme()->baseUrl.'/css/grilla_naranja.css', 
	'columns'=>array(
           'id',
            array('name'=>'descripcion','type'=>'html','value'=>'CHtml::link($data->descripcion,yii::app()->createUrl("/operadores/operaCodep/updateMeasure",array("id"=>$data->id)))'),
            'ums.desum',
             array('header'=>'Asoc Eq','type'=>'raw','value'=>'CHtml::checkBox($data->requireid,"$data->requireid",array("disabled"=>"disabled"))' ),
		array('header'=>'Obligatorio','type'=>'raw','value'=>'CHtml::checkBox($data->obligatorio,"$data->obligatorio",array("disabled"=>"disabled"))' ),
		
          // array('name'=>'hidequipo','value'=>'$data->getEquipment()'),
            /* array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'valor','type'=>'html',
               // 'header'=>'$data->getAttributeLabel("hp")',
                //'editable'=>array('mode'=>'inline'),
                 'value' => '$data->valor',
                'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                    'url' => $this->createUrl('dailywork/updatedailydet'),
                    'placement' => 'right',
                    'inputclass' => 'input-medium',
                    'params'=>array('scenario'=>'medida'),
                    ///'mode'=>'inline' 
                )
            ),*/
            
	),
)); 

?>

<?php //var_dump($grilla->columns[8]);?>
<?php

//--------------------- begin new code --------------------------
// add the (closed) dialog for the iframe
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'cru-dialog3',
	'options'=>array(
		'title'=>'Evento',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>800,
		'height'=>600,
	),
));
?>
<iframe id="cru-frame3" width="100%" height="100%"></iframe>
<?php

$this->endWidget();

//--------------------- end new code --------------------------
?>

<?PHP
echo CHtml::script(" function reloadGrid(data) {
    $.fn.yiiGridView.update('ot-grid');
} ");

?>