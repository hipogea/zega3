<?php MiFactoria::titulo(yii::t('manttoModule.titulos','Measure Points '),'clock');  ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'horometro-grid',
	//'filter'=>$model,
    'itemsCssClass'=>'table table-striped table-bordered table-hover',
	'dataProvider'=> $proveedor,	
	//'cssFile' => Yii::app()->getTheme()->baseUrl.'/css/grilla_naranja.css', 
	'columns'=>array(
           // 'numero',
            array(
			'class'=>'CButtonColumn',
                    'template'=>'{update}{view}',
                    'htmlOptions'=>array('width'=>100),
			 'buttons'=>array(
                       'update'=> array(
					 'url'=>'$this->grid->controller->createUrl("/mantto/Maintenance/AjaxShowDocumentsPoints", array("id"=>$data->id))',
					 'options' => array(
						 'ajax' => array(
							 'type' => 'GET',
							 'success'=>"function(data) {
							 $('#lecturas').html(data);
                                                                       }",
							 'url'=>'js:$(this).attr("href")'


						 ),

					 ) ,
					 'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'History.png',
					 'label'=>'See Measures',
				 ),

			 'view'=>
                            array(
                                'url'=>'$this->grid->controller->createUrl(
                                    "/mantto/Maintenance/CreateValuePoint",
					array("id"=>$data->id,																					      
                                                "asDialog"=>1,
                                                "gridId"=>$this->grid->id
                                                )
                                                                            )',
                                    'click'=>'function(){
                                        $("#cru-frame1").attr("src",$(this).attr("href")); 
					$("#cru-dialog1").dialog("open");  
					return false;
						 }',
				'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'mas.png', 
			'label'=>'Add Measure', 
                                ),

                            ),
		),
	 	array('name'=>'Codigo','header'=>'Code','value'=>'$data->codigo'),
		array('name'=>'ubicacion','header'=>'Location','value'=>'$data->ubicacion'),
            array('name'=>'fechainicio','header'=>'Begin Date','value'=>'$data->fechainicio'),
             array('name'=>'lecturaactual','header'=>'Current Value','value'=>'$data->lecturaactual'),
		array('name'=>'unidades','header'=>'Unit Measur','value'=>'$data->ums->desum'),
		
		//array('name'=>'nada','type'=>'raw','header'=>'Notificar','value'=>'CHtml::link("Responder","#",array("onclick"=>$(#cru-frame1).attr("src",""); $(#cru-dialog1).dialog("open");))' ),
		
	),
)); 

?>