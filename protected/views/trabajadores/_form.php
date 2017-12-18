<?php
/* @var $this TrabajadoresController */
/* @var $model Trabajadores */
/* @var $form CActiveForm */
?>
<div class="division">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trabajadores-form',
	'enableAjaxValidation'=>false,
)); ?>

    
<div class="row">
		<?php
               
		$botones=array(

			'floppy'=>array(
				'type'=>'A',
				'ruta'=>array(),
				'visiblex'=>array('10'),
			),


			
			
                    
                     'camera' => array(
                            'type' => 'C',
                            'ruta' => array($this->id.'/tomafoto', array(
                                'id' => $model->codigotra,                                    
                                "asDialog" => 1,
                                "gridId" => 'detalle-grid',
                            )
                            ),
                            'dialog' => 'cru-dialog3',
                        
                            'frame' => 'cru-frame3',
                           'visiblex'=>array($this->isMyProfile($model->codigotra),  '10'),
//'visiblex'=>array('10'),

                        ),
                    
                    'wrench' => array(
                            'type' => 'C',
                            'ruta' => array($this->id . '/agregaritemsolpe', array(
                                'idguia' => 3,
                            )
                            ),
                            'dialog' => 'cru-dialogdetalle',
                            'frame' => 'cru-detalle',
                            'visiblex' => array(true),

                        ),

                        'minus' => array(
                            'type' => 'D',
                            'ruta' => array($this->id . '/borraitems', array()),

                            'opajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl($this->id . '/borraitems', array()),
                                'success' => "function(data) {
										$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $.fn.yiiGridView.update('detalle-grid');
                                               $.fn.yiiGridView.update('resumenoc-grid');
                                               return false;
                                        }",
                                'beforeSend' => 'js:function(){
                                  				 var r = confirm("Esta seguro de Eliminar estos Items?");
                          						 if(!r){return false;}
                               							 }
                               					',

                            ),
                            'visiblex' => array(true),

                        ),

			
		);
                 //echo "salio"; die();
		$this->widget('ext.toolbar.Barra',
			array(
				//'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
				'botones'=>$botones,
				'size'=>24,
                            'font'=>true,
                            'nameform'=>'trabajadores-form',
				'extension'=>'png',
				'status'=>'10',
			)
		);?>
    
    
      <?php
                /*if($this->estasEnsesion($model->idguia)) {
                    $botones = array(
                        'add' => array(
                            'type' => 'C',
                            'ruta' => array($this->id . '/creadetalle', array(
                                'idcabeza' => $model->idguia,
                                'cest' => $model->{$this->campoestado},
                                //"id"=>$model->n_direc,
                                "asDialog" => 1,
                                "gridId" => 'detalle-grid',
                            )
                            ),
                            'dialog' => 'cru-dialogdetalle',
                            'frame' => 'cru-detalle',
                            'visiblex' => array(self::ESTADO_CREADO),

                        ),

                        'tool' => array(
                            'type' => 'C',
                            'ruta' => array($this->id . '/agregaritemsolpe', array(
                                'idguia' => $model->idguia,
                            )
                            ),
                            'dialog' => 'cru-dialogdetalle',
                            'frame' => 'cru-detalle',
                            'visiblex' => array(self::ESTADO_CREADO),

                        ),

                        'minus' => array(
                            'type' => 'D',
                            'ruta' => array($this->id . '/borraitems', array()),

                            'opajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl($this->id . '/borraitems', array()),
                                'success' => "function(data) {
										$('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');
                                              $.fn.yiiGridView.update('detalle-grid');
                                               $.fn.yiiGridView.update('resumenoc-grid');
                                               return false;
                                        }",
                                'beforeSend' => 'js:function(){
                                  				 var r = confirm("Esta seguro de Eliminar estos Items?");
                          						 if(!r){return false;}
                               							 }
                               					',

                            ),
                            'visiblex' => array(self::ESTADO_CREADO, self::ESTADO_AUTORIZADO, self::ESTADO_ANULADO, self::ESTADO_CONFIRMADO, self::ESTADO_FACTURADO),

                        ),


                        'checklist' => array(
                            'type' => 'C',
                            'ruta' => array($this->id . '/agregardespacho', array(
                                'id' => $model->idguia,
                                //"id"=>$model->n_direc,
                                "asDialog" => 1,
                                "gridId" => 'detalle-grid',
                            )
                            ),
                            'dialog' => 'cru-dialogdetalle',
                            'frame' => 'cru-detalle',
                            'visiblex' => array(self::ESTADO_CREADO),
                        ),
                        'pack2' => array(
                            'type' => 'B',
                            'ruta' => array($this->id . '/procesardocumento', array('id' => $model->idguia, 'ev' => 35)),
                            'visiblex' => array(self::ESTADO_CREADO),

                        ),


                        'briefcase' => array(
                            'type' => 'D',
                            'ruta' => array($this->id . '/Agregardelmaletin', array()),
                            'opajax' => array(
                                'type' => 'GET',
                                'data' => array('id' => $model->idguia),
                                'url' => Yii::app()->createUrl($this->id . '/Agregardelmaletin', array()),
                                'success' => 'js:function(data) {
                            $("#AjFlash").html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut("slow");
                            $.fn.yiiGridView.update("detalle-grid"); alert(data);}',
                                'beforeSend' => 'js:
                               					 function(){
                                  				 var r = confirm("¿Esta seguro de agregar los items del maletin ?");
                          						 if(!r){return false;}
                               							 }
                               					',
                            ),
                            'visiblex' => array(self::ESTADO_CREADO, self::ESTADO_AUTORIZADO, self::ESTADO_ANULADO, self::ESTADO_CONFIRMADO, self::ESTADO_FACTURADO),

                        ),


                        'join' => array(
                            'type' => 'C',
                            'ruta' => array($this->id . '/agregaritemsolpe', array(
                                'idguia' => $model->idguia,
                                //"id"=>$model->n_direc,
                                "asDialog" => 1,
                                "gridId" => 'detalle-grid',
                            )
                            ),
                            'dialog' => 'cru-dialogdetalle',
                            'frame' => 'cru-detalle',
                            'visiblex' => array(self::ESTADO_CREADO),

                        ),

                        'pack' => array(
                            'type' => 'C',
                            'ruta' => array($this->id . '/agregarmasivamente', array(
                                'idguia' => $model->idguia,
                                //"id"=>$model->n_direc,
                                "asDialog" => 1,
                                "gridId" => 'detalle-grid',
                            )
                            ),
                            'dialog' => 'cru-dialogdetalle',
                            'frame' => 'cru-detalle',
                            'visiblex' => array(self::ESTADO_CREADO),

                        ),


                    );


                    $this->widget('ext.toolbar.Barra',
                        array(
                            //'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
                            'botones' => $botones,
                            'size' => 24,
                            'extension' => 'png',
                            'status' => $model->{$this->campoestado},


                        )
                    );
                }*/
                ?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	</div>
    
	<p class="note">Campos con  <span class="required">*</span> Son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>



    <div class="row">
        <?php echo $form->labelEx($model,'activo'); ?>
        <?php echo $form->checkBox($model,'activo');?>
        <?php echo $form->error($model,'activo'); ?>
    </div>



    <div class="row">
        <?php echo $form->labelEx($model,'codigotra'); ?>
        <?php echo $form->textField($model,'codigotra',array('size'=>4,'maxlength'=>4,'disabled'=>'DISABLED')); ?>
        <?php echo $form->error($model,'codigotra'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'ap'); ?>
        <?php echo $form->textField($model,'ap',array('size'=>30,'maxlength'=>30)); ?>
        <?php echo $form->error($model,'ap'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'am'); ?>
        <?php echo $form->textField($model,'am',array('size'=>35,'maxlength'=>35)); ?>
        <?php echo $form->error($model,'am'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model,'nombres'); ?>
        <?php echo $form->textField($model,'nombres',array('size'=>35,'maxlength'=>35)); ?>
        <?php echo $form->error($model,'nombres'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'fecingreso'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            //'name'=>'my_date',
            'model'=>$model,
            'attribute'=>'fecingreso',
            'language'=>Yii::app()->language=='es' ? 'es' : null,
            'options'=>array(
                'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                'showOn'=>'button', // 'focus', 'button', 'both'
                'buttonText'=>Yii::t('ui','...'),
                'dateFormat'=>'yy-mm-dd',
                'changeYear'=>true,
                'yearRange'=>'1950:2020',
            ),
            'htmlOptions'=>array(
                'style'=>'width:80px;vertical-align:top',
                'readonly'=>'readonly',

            ),
        ));
        ?>
        <?php echo $form->error($model,'fecingreso'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'domicilio'); ?>
        <?php echo $form->textField($model,'domicilio',array('size'=>60,'maxlength'=>60)); ?>
        <?php echo $form->error($model,'domicilio'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'tiposangre'); ?>
        <?php echo $form->textField($model,'tiposangre',array('size'=>10,'maxlength'=>10)); ?>
        <?php echo $form->error($model,'tiposangre'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'telfijo'); ?>
        <?php echo $form->textField($model,'telfijo',array('size'=>25,'maxlength'=>25)); ?>
        <?php echo $form->error($model,'telfijo'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'telmoviles'); ?>
        <?php echo $form->textField($model,'telmoviles',array('size'=>25,'maxlength'=>25)); ?>
        <?php echo $form->error($model,'telmoviles'); ?>
    </div>


 <div style="float: left; width:300px;"> 	
						<?php echo $form->labelEx($model,'tipodoc'); ?>
						
						<?php    echo $form->DropDownList($model,'tipodoc',Trabajadores::tipoDocumento(), array('empty'=>'--Seleccione tipo Doc--')  )  ;	?>
						<?php echo $form->error($model,'tipodoc'); ?>	
</div>
 
 
 
    <div class="row">
        <?php echo $form->labelEx($model,'dni'); ?>
        <?php echo $form->textField($model,'dni',array('size'=>8,'maxlength'=>8)); ?>
        <?php echo $form->error($model,'dni'); ?>
    </div>



<div class="row">
        <?php echo $form->labelEx($model,'cumple'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        //'name'=>'my_date',
                                        'model'=>$model,
                                        'attribute'=>'cumple',
                                        'language'=>Yii::app()->language=='es' ? 'es' : null,
                                            'options'=>array(
                                                    'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
                                                    'showOn'=>'button', // 'focus', 'button', 'both'
                                                    'buttonText'=>Yii::t('ui','...'),
                                                    'dateFormat'=>'yy-mm-dd',

                                                //'changeMonth'=>true,
                                                'changeYear'=>true,
                                                'yearRange'=>'1950:2020',
                                                        ),
                                                'htmlOptions'=>array(
                                                            'style'=>'width:80px;vertical-align:top',
                                                            'readonly'=>'readonly',

                                                            ),
                                                            ));
            ?>
        <?php echo $form->error($model,'cumple'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'codpuesto'); ?>

        <?php  $datos = CHtml::listData(Oficios::model()->findAll(array('order'=>'oficio')),'codof','oficio');
                    echo $form->DropDownList($model,'codpuesto',$datos, array('empty'=>'--Seleccione un oficio --')  );
                    ?>



        <?php //echo $form->textField($model,'codpuesto',array('size'=>3,'maxlength'=>3)); ?>
        <?php echo $form->error($model,'codpuesto'); ?>
    </div>

            <div class="row">
        <?php echo $form->labelEx($model,'iduser'); ?>
        <?php
            $comboList = array();
                foreach(Yii::app()->user->um->listUsers() as $user){
        // evitando al invitado
                /*if($user->primaryKey == CrugeUtil::config()->guestUserId)
                        break;*/
        // en este caso 'firstname' y 'lastname' son campos personalizados
                //$firstName = Yii::app()->user->um->getFieldValue($user,'firstname');
                //$lastName = Yii::app()->user->um->getFieldValue($user,'lastname');
                $comboList[$user->primaryKey] = $user->username;
                    }
          if(Yii::app()->user->isSuperAdmin){
              echo $form->dropDownList($model,'iduser',$comboList, array('empty'=>'--Seleccione usuario--'));

          }else{
             echo $form->textField($model,'iduser',array('value'=>yii::app()->user->um->LoadUserbyId(Yii::app()->user->id)->userName,'disabled'=>'disabled','size'=>8,'maxlength'=>8)); 
        
          }
    


        ?>



        <?php echo $form->error($model,'iduser'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar'); ?>
    </div>

<?php $this->endWidget(); ?>
</div>
</div><!-- form -->




<?php
//--------------------- begin new code --------------------------
   // add the (closed) dialog for the iframe
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog3',
    'options'=>array(
        'title'=>'Explorador',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>300,
        'height'=>300,
    ),
    ));
?>
<iframe id="cru-frame3" width="100%" height="100%"></iframe>
<?php
 
$this->endWidget();
//--------------------- end new code --------------------------
?>
