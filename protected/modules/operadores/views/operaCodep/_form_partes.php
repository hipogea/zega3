<?php
/* @var $this DailyworkController */
/* @var $model Dailywork */
/* @var $form CActiveForm */

?>

<div class="form">
    <div class="wide form">
        
 
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dailywork-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
 <div class="row">
                <?php
                
                    $botones = array( 
                        'save' => array(
                            'type' => 'A',
                            'ruta' => array(),
                            'visiblex' => array('10'),
                        ),
                          'back' => array(
                            'type' => 'B',
                            'ruta' => array('/mantto/'.$this->id . '/update/', array('id' => $model->getPrev())),//aprobar
                            'visiblex' => array($anterior>0) ,
                           // 'visiblex' => array( true ),
                        ),
                        'go' => array(
                            'type' => 'B',
                            'ruta' => array('/mantto/'.$this->id . '/update/', array('id' => $model->getNext())),//aprobar
                            'visiblex' => array($siguiente>0) ,
                           // 'visiblex' => array( true ),
                        ),
                        'ok' => array(
                            'type' => 'B',
                            'ruta' => array('/mantto/'.$this->id . '/update/', array('id' => $model->getNext())),//aprobar
                            'visiblex' => array(true) ,
                           // 'visiblex' => array( true ),
                        ),
                        
                        
                        'print' => array(
                            'type' => 'B',
                            'ruta' => array('coordocs/hacereporte', array('id' => $model->id, 'idfiltrodocu' => $model->id, 'file' => 0)),
                            'visiblex' => array('10'),
                        ),
                    'clear' => array(
                            'type' => 'B',
                            'ruta' => array('/mantto/'.$this->id . '/update/', array('id' => $model->getNext())),//aprobar
                            'visiblex' => array(!($siguiente>0)) ,
                           // 'visiblex' => array( true ),
                        ),
                    );
                $this->widget('ext.toolbar.Barra',
                    array(
                        //'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
                        'botones'=>$botones,
                        'size'=>24,
                        'extension'=>'png',
                        'status'=>'10',
                    )
                );
                ?>
            

            </div>
	
	<?php echo $form->errorSummary($model); ?>
      <div class="panelizquierdo">
           <div class="row">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('class'=>'numerodocumento','disabled'=>'disabled','size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'numero'); ?>
            <?php //echo $model->ot->textocorto; ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'codresponsable'); ?>
		<?php
		echo $form->textField($model,'ffd44r',array('disabled'=>'disabled','size'=>28,'value'=>$model->trabajadores->ap.' '.$model->trabajadores->am.' '.$model->trabajadores->nombres  ));
		?>
		<?php echo $form->error($model,'codresponsable'); ?>
	</div>

       

        
	 <div class="row">
                        <?php echo $form->labelEx($model,'fecha'); ?>
                         
             <?php echo $form->textField($model,'fecha',array('disabled'=>'disabled','class'=>'btn btn-info','size'=>12,'maxlength'=>12)); ?>
		
                           
			<?php echo $form->error($model,'fecha'); ?>
                </div>

          <div class="row">
              <?php 
              $dia=substr($model->fecha,0,2);
              $mes=substr($model->fecha,3,2);
              $anno=substr($model->fecha,8,2);
              ?>
              <?php //echo CHtml::link('Go to Daily Work Sheet',$this->createUrl(DIRECTORY_SEPARATOR.'mantto'.DIRECTORY_SEPARATOR.$this->id.DIRECTORY_SEPARATOR.'daily',array('day'=>$dia,'month'=>$mes,'year'=>$anno,'level'=>'byequipo')  )); ?>
          </div>


      </div>
        <div class="panelderecho">
            <div class="row">
                
              
                        
                           <?php //$datos=CHtml::listData(Dailyturnos::model()->findAll($criterio), 'hidturno','regimen.desregimen');  ?>
			<?php echo $form->hiddenField($model,'hidturno',array( 'value'=>$model->hidturno)); ?>
			 
                 <?php //echo CHtml::label($model->regimen->desregimen,'86955jr',array('style'=>'color:white; padding:4px;background-color: #'.(rand(10,99)).(rand(20,90)).rand(00,99).';width:240px !important;')); ?>
                
            </div>
            	<div class="row">
                <?php  echo $form->labelEx($model,'codep'); ?>
              
                        
                           <?php //$datos=CHtml::listData(Dailyturnos::model()->findAll($criterio), 'hidturno','regimen.desregimen');  ?>
			<?php echo $form->textField($model,'codep',array( 'value'=> Embarcaciones::model()->findByPk($model->codep)->nomep,'disabled'=>'disabled','size'=>23)); ?>
			 
                 <?php //echo CHtml::label($model->regimen->desregimen,'86955jr',array('style'=>'color:white; padding:4px;background-color: #'.(rand(10,99)).(rand(20,90)).rand(00,99).';width:240px !important;')); ?>
                
            </div>
            
	 
        </div>

<?php $this->endWidget(); ?>
</div>
    </div>



<?php
 
$claseedit='application.components.booster.widgets.TbEditableColumn';
$clasenormal='zii.widgets.grid.CDataColumn';

?>
   
<?php 
$modelo=New Dailyevents('medida');
$grilla=$this->widget('ext.groupgridview.GroupGridView', array(
      'id' => 'partes-grid',
      //'dataProvider'=>$model->search(),
     // 'mergeColumns' => array('codtipo'),
   'summaryText'=>'',
    'itemsCssClass'=>'table table-striped table-bordered table-hover',
	'dataProvider'=> $modelo->search_por_parte($model->id),	
	//'cssFile' => Yii::app()->getTheme()->baseUrl.'/css/grilla_naranja.css', 
	'columns'=>array(
            
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows' => 100,
			'value'=>'$data->id',
			'checkBoxHtmlOptions' => array(                
				'name' => 'checkselected[]',
				'width'=>'10'
				),
            'id'=>'cajita' // the columnID for getChecked
		),
            
            'id',
            'descripcion',
           array('name'=>'hidequipo','value'=>'$data->getEquipment()'),
             array(
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
            ),
            //'id',
	  //  array('name'=>'hidinventario','visible'=>true),
	   /*array('name'=>'id','type'=>'raw','header'=>'','value'=>'CHtml::link(CHtml::openTag("span",array("class"=>"fa fa-mx fa-color-green fa-plus-square"),true),"#", array("onclick"=>\'$("#cru-frame3").attr("src","\'.Yii::app()->createurl(\'/mantto/dailywork/creaevento\', array(\'id\'=> $data->id ) ).\'");$("#cru-dialog3").dialog("open"); return false;\' ) ) '
               ,'htmlOptions'=>array( 'width'=>50),),
           //  array('header'=>'Ev','type'=>'html','value'=>'($data->neventos>0)?CHtml::openTag("span",array("class"=>"badge badge-error")).$data->neventos.CHtml::closeTag("tag"):""' ),
	   
            //array('name'=>'id','type'=>'html','header'=>'','value'=>'CHtml::openTag("span",array("class"=>"icon icon-folder-plus icon-green icon-fuentesize18"),true)'),
              // CHtml::openTag("span",array("class"=>"icon icon-envelop icon-blue icon-fuentesize16"),true)
            'codtipo',
            array('name'=>'codigoaf','type'=>'html','value'=>'CHtml::link($data->inventario->codigoaf,yii::app()->createUrl("inventario/basicupdate",array("id"=>$data->hidequipo)),array("target"=>"_blank"))' ),
		//array('name'=>'hp','header'=>'hp','value'=>'$data->hp'),
		//array('name'=>'hpp','header'=>'hpp','value'=>'$data->hpp'),
            array(
               // 'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'hp','type'=>'html',
               // 'header'=>'$data->getAttributeLabel("hp")',
                //'editable'=>array('mode'=>'inline'),
                 'value' => '$data->nhorasparada',
                'sortable' => false,
                /*'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                    'url' => $this->createUrl('dailywork/updatedailydet'),
                    'placement' => 'right',
                    'inputclass' => 'input-medium',
                    ///'mode'=>'inline' 
                )
            ),
           
          /* array(
                //'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'np','type'=>'html', 
               // 'header'=>'$data->getAttributeLabel("hpp")',
                 'value' => '$data->nparadasint',
                
            ),
            array(
                //'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'ns','type'=>'html', 
               // 'header'=>'$data->getAttributeLabel("hpp")',
                 'value' => '$data->nparadasext',
                
            ),
           
             array(
                //'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'hpp','type'=>'html',
               // 'header'=>'$data->getAttributeLabel("hp")',
                //'editable'=>array('mode'=>'inline'),
                // 'value' => '$data->hp',
               // 'sortable' => false,
                //'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                   // 'url' => $this->createUrl('dailywork/updatedailydet'),
                   // 'placement' => 'right',
                   //'inputclass' => 'input-medium',
                    //'mode'=>'inline' 
                //)
            ),
            array('name'=>'hd'),
            array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'hidlectura1',
                'type'=>'html',
                'value'=>'$data->getValueMeasurePointFromId($data->hidlectura1)',
                //'type'=>'raw',
               // 'header'=>'$data->getAttributeLabel("hmi")',
                //'value' => '$data->hmi.CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."clock.png","Press To See",array("onClick"=>"js:$.notify(\'Hi! Look here!\', \'info\')")',
                'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                    'url' => $this->createUrl('dailywork/UpdateMeasurePoint'),
                    //'params'=>array('idlectura'=>'$data->id'),
                    'placement' => 'right',
                   'inputclass' => 'input-medium',
                    'htmlOptions'=>array('id'=>'"modern".$data->id',                        
                       // "onmouseover"=>"js:$.notify(\'Hi! Look here!\', \'info\')"
                        ),
                    'success' => 'reloadGrid',
                    //'mode'=>'inline'
                ),
            
            ),
            
            
            
           /* array(
                'name'=>'clock',
                 'type'=>'raw',   
                'value' => 'CHtml::link(CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."clock.png","Press To See"),"#",array("onClick"=>"js:$(\'#modern$data->id\').notify(\"Last Meter Hour :  {$data->getHorometroAnterior(\'hmf\')}\", \'warn\')"))',
                 ),
            
            */
            /*array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'hidlectura2',
                'type'=>'html',
               // 'value'=>'$data->getValueMeasurePointFromId($data->hidlectura2)',
                //'type'=>'raw',
               // 'header'=>'$data->getAttributeLabel("hmi")',
                //'value' => '$data->hmi.CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."clock.png","Press To See",array("onClick"=>"js:$.notify(\'Hi! Look here!\', \'info\')")',
                'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                    'url' => $this->createUrl('dailywork/UpdateMeasurePoint'),
                    //'params'=>array('idlectura'=>'$data->id'),
                    'placement' => 'right',
                   'inputclass' => 'input-medium',
                    'htmlOptions'=>array('id'=>'"modern".$data->id',                        
                       // "onmouseover"=>"js:$.notify(\'Hi! Look here!\', \'info\')"
                        ),
                    'success' => 'reloadGrid',
                    //'mode'=>'inline'
                ),
            
            ),
            
            
             array('name'=>'descripcion','type'=>'html'),
              array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'hidlectura3',
                'type'=>'html',
                'value'=>'$data->getValueMeasurePointFromId($data->hidlectura3)',
                //'type'=>'raw',
               // 'header'=>'$data->getAttributeLabel("hmi")',
                //'value' => '$data->hmi.CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."clock.png","Press To See",array("onClick"=>"js:$.notify(\'Hi! Look here!\', \'info\')")',
                'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                    'url' => $this->createUrl('dailywork/UpdateMeasurePoint'),
                    //'params'=>array('idlectura'=>'$data->id'),
                    'placement' => 'right',
                   'inputclass' => 'input-medium',
                    'htmlOptions'=>array('id'=>'"modern".$data->id',                        
                       // "onmouseover"=>"js:$.notify(\'Hi! Look here!\', \'info\')"
                        ),
                    'success' => 'reloadGrid',
                    //'mode'=>'inline'
                ),
            
            ),
            array(
                'class' => 'application.components.booster.widgets.TbEditableColumn',
                'name' => 'hidlectura4',
                'type'=>'html',
                'value'=>'$data->getValueMeasurePointFromId($data->hidlectura4)',
                //'type'=>'raw',
               // 'header'=>'$data->getAttributeLabel("hmi")',
                //'value' => '$data->hmi.CHtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."clock.png","Press To See",array("onClick"=>"js:$.notify(\'Hi! Look here!\', \'info\')")',
                'sortable' => false,
                'editable' => array( //estas son propiedades del control TEDITABLE FIELD
                    'url' => $this->createUrl('dailywork/UpdateMeasurePoint'),
                    //'params'=>array('idlectura'=>'$data->id'),
                    'placement' => 'right',
                   'inputclass' => 'input-medium',
                    'htmlOptions'=>array('id'=>'"modern".$data->id',                        
                       // "onmouseover"=>"js:$.notify(\'Hi! Look here!\', \'info\')"
                        ),
                    'success' => 'reloadGrid',
                    //'mode'=>'inline'
                ),
            
            ),
		//array('name'=>'mobs','header'=>'Observacion                                                                        '),
		//array('name'=>'usuario','header'=>'Autor'),
		//array('name'=>'estado','header'=>'Estado'),		
		// array('name'=>'ni', 'type'=>'raw', 'value'=>(!(Yii::app()->user->isGuest))?'CHtml::Button("Cerrar",array("id"=>$data->id,"class"=>"bolsita")) ': 'CHtml::Button("Cerrar",array("id"=>$data->id,"class"=>"bolsita", "disabled"=>"disabled")) '),
		//array('name'=>'numerodocumento','header'=>'Comentario'),
		//CHtml::Button('Cancel',array('submit'=>'index.php?r=user/cancel'));
		array('name'=>'util','type'=>'raw', 'value'=>'$data->util*100'),
		array('name'=>'dispo','type'=>'html', 'value' => 'CHtml::openTag("span",array("class"=>"badge badge-warning")).$data->dispo.CHtml::closeTag("span")',
               ),
			
            /*array(
			'class'=>'CButtonColumn',
                    'template'=>'{update}{delete}',
			 'buttons'=>array(
                        'update'=>
                            array(
                                'url'=>'$this->grid->controller->createUrl(
                                    "/inventario/editasignacionot",
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
				'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'lapicito.png', 
			'label'=>'Editar asignacion', 
                                ),
			'delete'=>  array(
	   'visible'=>'true',
	   'url'=>'$this->grid->controller->createUrl("inventario/ajaxdeleteasignacionot", array("id"=>$data->id))',
	   'options' => array( 'ajax' => array('type' => 'GET', 'success'=>'js:function() { $.fn.yiiGridView.update("ot-grid");}' ,'url'=>'js:$(this).attr("href")'),
	   
	   ) ,
	   'imageUrl'=>Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."cerrar.png",
	   'label'=>'Liberar',
	   ),

                            ),
		),*/
            
            
		//array('name'=>'nada','type'=>'raw','header'=>'Notificar','value'=>'CHtml::link("Responder","#",array("onclick"=>$(#cru-frame1).attr("src",""); $(#cru-dialog1).dialog("open");))' ),
		
	),
)); 

?>



		<?php
		$botones1=array(
		
		
			'add'=>array(
				'type'=>'C',
				'ruta'=>array('/operadores/operaCodep/createEvent',array(
					'id'=>$model->id,
					//'cest'=>$model->{$this->campoestado},
					'asDialog'=>1,
					"gridId"=>'partes-grid',
				)
				),
				'dialog'=>'cru-dialog3',
				'frame'=>'cru-frame3',
				'visiblex'=>array('10'),

			),
			
			
			
			
			'minus'=>array(
				'type'=>'D',
				'ruta'=>array($this->id.'/borraitems',array()),
				'opajax'=>array(
					'type'=>'POST',
					'url'=>Yii::app()->createUrl($this->id.'/borraitems',array()),
					'success'=>"function(data) {
							 $.fn.yiiGridView.update('detallecaja-grid');  $.growlUI(' Aviso ', data, 0, 0, 0); return false;
                                                                       }",
					'beforeSend' => 'js:function(){
                                  				 var r = confirm("Esta seguro de Eliminar estos Items?");
                          						 if(!r){return false;}
                               							 }
                               					',
				),
                               'visiblex'=>array('10'),
				//'visiblex'=>array($this::ESTADO_CREADO,$this::ESTADO_AUTORIZADO,$this::ESTADO_ANULADO),

			),


			


		);





		$this->widget('ext.toolbar.Barra',
			array(
				//'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
				'botones'=>$botones1,
				'size'=>24,
				'extension'=>'png',
				'status'=>'10',

			)
		); ?>
	

<?php //var_dump($grilla->columns[8]);?>
<?php

//--------------------- begin new code --------------------------
// add the (closed) dialog for the iframe
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'cru-dialog3',
	'options'=>array(
            'position'=>array('my'=>'bottom','at'=>'bottom', 'of' => ''),
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