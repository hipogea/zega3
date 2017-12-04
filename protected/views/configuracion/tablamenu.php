<?php
/* @var $this CotiController */
/* @var $model Coti */

$this->breadcrumbs=array(
	'Cotis'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'Liberacion masiva', 'url'=>array('libmasiva')),
	array('label'=>'Crear Oc', 'url'=>array('CreaDocumento')),
	//array('label'=>'Valores por defecto', 'url'=>$this->createUrl('Opcionescamposdocu/configurausuario',array('docu'=>$this->documento,'docuhijo'=>$this->documentohijo))),

);
?>

<?php MiFactoria::titulo(yii::t('titles','Administrar menu'),'basket1');?>

<?PHP
 $this->widget('ext.groupgridview.GroupGridView', array(
      'id' => 'grid1',
      'dataProvider'=>$model->search_by_active(),
      'filter'=>$model,
      'mergeColumns' => array('modulo', 'controlador'),
	 'itemsCssClass'=>'table table-striped table-bordered table-hover',
	 /*'extraRowColumns' => array('controlador'),
	 'extraRowTotals' => function($data, $row, &$totals) {
		 if(!isset($totals['count_codaccion'])) $totals['count_codaccion'] = 0;
		 $totals['count_codaccion']+=$data['codaccion'];

	 },
	 'extraRowExpression' => '"<span style=\"font-weight: bold;color: orangered;font-size:13px;\"> Total Oc : ".MiFactoria::decimal($totals["count_codaccion"],2)." </span>"',
	 'extraRowPos'=>'below',*/
      'columns' => array(
           array('name'=>'id') ,
           
		  ARRAY('name'=>'codaccion','header'=>'Action','type'=>'raw','value'=>'$data->codaccion'),
		 ARRAY('name'=>'ruta','header'=>'Path','type'=>'raw','value'=>'$data->ruta'),

		  array('name'=>'controlador','header'=>'Controlador','value'=>'$data->controlador','htmlOptions'=>array('width'=>'40')),
        array('name'=>'modulo','value'=>'$data->modulo'),
      	  array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'activa',
              'header'=>'Activo',
                //'type'=>'html',
                'value'=>'$data->activa',
               'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                     'url' => $this->createUrl('configuracion/ajaxEditAliasMenu'),
                    'placement' => 'right',
                    // 'attribute' => 'activa',
                    'type'=>'select',
                    'source' => array(0=>'Disabled',1=>'Enabled'),
                  // 'inputclass' => 'input-medium',   
                    'success' => 'reloadGrid',
                   // "success"=>"js:function(data) { $.fn.yiiGridView.update(\'grid1\'); $.notify(data, \"info\");       }",
                    ),
            
            ),
          
          array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'alias',
                //'type'=>'html',
                'value'=>'$data->alias',
               'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                     'url' => $this->createUrl('configuracion/ajaxEditAliasMenu'),
                    'placement' => 'right',
                  // 'inputclass' => 'input-medium',   
                    
                  'success' => 'reloadGrid',
                    ),
            
            ),
          
           array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'hidpadre',
                //'type'=>'html',
                'value'=>'$data->hidpadre',
               'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                     'url' => $this->createUrl('configuracion/ajaxEditHidparentMenu'),
                    'placement' => 'right',
                  // 'inputclass' => 'input-medium',   
                    
                  'success' => 'reloadGrid',
                    ),
            
            ),
          ),
    ));

?>

<?PHP
echo CHtml::script(" function reloadGrid(data) {
    $.fn.yiiGridView.update('grid1');
} ");

?>

