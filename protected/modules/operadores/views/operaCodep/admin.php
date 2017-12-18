<?php
/* @var $this OperaCodepController */
/* @var $model OperaCodep */

$this->breadcrumbs=array(
	'Crear'=>array('create'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List OperaCodep', 'url'=>array('index')),
	array('label'=>'Create OperaCodep', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#opera-codep-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Opera Codeps</h1>


<?php echo CHtml::link('Filtrar','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 

$this->widget('ext.groupgridview.GroupGridView', array(
     // 'id' => 'grid1',      
      'mergeColumns' => array('codep'),
    'id'=>'opera-codep-grid',
	'dataProvider'=>$model->search(),
     'itemsCssClass'=>'table table-striped table-bordered table-hover',	
	//'filter'=>$model,
	'columns'=>array(
		//'codep',
            array('name'=>'codep','value'=>'$data->embarcaciones->nomep','htmlOptions'=>array("width"=>350)),
		array('name'=>'codtra','type'=>'html','value'=>'($data->fotoprimera()=="")?"":CHtml::link(CHtml::image($data->fotoprimera(),"#",array("class"=>"imgRedonda100")),yii::app()->createurl("/operadores/operaCodep/createDailyReport",array("codep"=>$data->codep,"codof"=>$data->codof) ))','htmlOptions'=>array("width"=>50)),
           // 'codtra',
            array('name'=>'codtra','value'=>'$data->trabajadores->ap."-".$data->trabajadores->am."-".$data->trabajadores->nombres','htmlOptions'=>array("width"=>500)),
           
             
		//'id',
		'finicio',
		array('name'=>'codof','type'=>'raw','value'=>'CHtml::link($data->oficios->oficio,yii::app()->createUrl("/operadores/operaCodep/update",array("id"=>$data->id)))','htmlOptions'=>array("width"=>200)),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
