<?php MiFactoria::titulo(" Documentos en el maletin de  :  '".yii::app()->user->name."  '","briefcase");  ?><div class="division">	<?php //echo isset(Yii::app()->session['codigoprov'])?Yii::app()->session['codigoprov']:'caramola'; ?><?php $this->widget('zii.widgets.grid.CGridView', array(	'id'=>'maletin-grid',	'dataProvider'=>$model->search_por_usuario(),	//'cssFile' => Yii::app()->getTheme()->baseUrl.'/css/grilla_naranja.css',	'filter'=>$model,	'summaryText'=>'',	'columns'=>array(						array(									'class'=>'CCheckBoxColumn',									'selectableRows' => 10,									'value'=>'$data->id',									'checkBoxHtmlOptions' => array(                																'name' => 'checkselected[]',																	),           // 'id'=>'cajita' // the columnID for getChecked							),					'codocu',		'documentos.desdocu',            'idregistro',		            array(			'class'=>'CButtonColumn',                                          'template'=>'{delete}',                    'buttons'=>array(                         'delete' => array(                                                'label'=>' Eliminar',                   // 'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'22060.png',                    'click'=>"function(){                                    $.fn.yiiGridView.update('maletin-grid', {                                        type:'GET',                                        url:$(this).attr('href'),                                        success:function(data) {                                              $.growlUI('Growl Notification', data);                                               $.fn.yiiGridView.update('maletin-grid');                                        }                                    })                                    return false;                              }                     ",                    'url'=>'$this->grid->controller->createUrl("/site/borrafilamaletin",array("id"=>$data->id))',                ),                        		                                                               ),				),                        			),)); ?></div >