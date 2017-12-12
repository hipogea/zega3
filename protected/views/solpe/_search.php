<?php
/* @var $this SolpeController */
/* @var $model Solpe */
/* @var $form CActiveForm */
?>
<div class="division">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get','id'=>'buscasolpes-form'
)); ?>
	<div class="row">
		<?php
		$botones=array(
			'binoculars'=>array(
				'type'=>'A',
				'ruta'=>array(),
				'visiblex'=>array('10'),
			),
			'eraser'=>array(
				'type'=>'E',
				'ruta'=>array(),
				'visiblex'=>array('10'),
			),
		);
		$this->widget('ext.toolbar.Barra',
			array(
				//'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
				'botones'=>$botones,
                                 'font'=>true,
				'size'=>24,
                            'nameform'=>'buscasolpes-form',
				'extension'=>'png',
				'status'=>'10',

			)
		); ?>
	</div>
	<DIV class="panelizquierdo">


	<div class="row">
		<?php echo $form->label($model,'numsolpe'); ?>
		<?php echo $form->textField($model,'numsolpe',array('size'=>10,'maxlength'=>10)); ?>
	</div>
		<div class="row">
			<?php echo $form->label($model,'txtmaterial'); ?>
			<?php echo $form->textField($model,'txtmaterial',array('size'=>25,'maxlength'=>40)); ?>
		</div>




		<div class="row">
			<?php echo $form->labelEx($model,'est'); ?>
			<?php $datos111=CHTml::listData(Estado::model()->findAll("codocu=:vcodocu",array(":vcodocu"=>$this::CODIGO_DOC_DESOLPE)),'codestado','estado'); ?>

			<?php echo $form->dropDownList($model,'est',$datos111,array('empty'=>'--Seleccione un estado--'));?>

		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'escompra'); ?>
			<?php  $datos1 = CHtml::listData(Tiposolpe::model()->findAll(),'codtipo','destipo');
			echo $form->DropDownList($model,'escompra',$datos1, array('empty'=>'--Seleccione un tipo--','disabled'=>(!$model->isNewRecord)?'disabled':'')  )  ;
			?>
			<?php echo $form->error($model,'escompra'); ?>
		</div>

	<div class="row">
    <?php  
		/*$documento='350';
		$criteria = new CDbCriteria;
		$criteria->condition='codocu=:docu';
		$criteria->params=array(':docu'=>$documento);
		//$post = Post::model()->find($criteria);
	//$datos = CHtml::listData(Estado::model()->find('codocu=:c_hcod', array(':c_hcod'=>$documento)),'codestado','estado');
		//datos = CHtml::listData(Estado::model()->find($criteria),'codestado','estado');
	 echo $form->label($model,'codestado'); 
		 $datos = CHtml::listData(Estado::model()->findall($criteria),'codestado','estado');
		 				 echo $form->DropDownList($model,'est',$datos, array('empty'=>'--Indique el status del detalle--')  )  ;

			*/	?>
	</div>

		<div class="row">
			<?php echo $form->labelEx($model,'codart'); ?>
			<?php
			$this->widget('ext.matchcode1.Seleccionavarios',array(
					'nombrecampo'=>'codart',
					//'ordencampo'=>1,
					'controlador'=>'VwSolpe',
					'relaciones'=>$model->relations(),
					'tamano'=>10,
					'model'=>$model,
					'nombremodelo'=>'Maestrocompo',
					'form'=>$form,
					'nombredialogo'=>'cru-dialog3',
					'nombreframe'=>'cru-frame3',
					//'nombrearea'=>'fehdfj',
				)

			);


			?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'imputacion'); ?>
			<?php
			$this->widget('ext.matchcode1.Seleccionavarios',array(
					'nombrecampo'=>'imputacion',
					//'ordencampo'=>1,
					'controlador'=>'VwSolpe',
					'relaciones'=>$model->relations(),
					'tamano'=>14,
					'model'=>$model,
					'nombremodelo'=>'Cc',
					'form'=>$form,
					'nombredialogo'=>'cru-dialog3',
					'nombreframe'=>'cru-frame3',
					//'nombrearea'=>'fehdfj',
				)

			);


			?>
		</div>



	
	

	<div class="row">
		<?php echo $form->labelEx($model,'centro'); ?>
		<?php  $datos1 = CHtml::listData(Centros::model()->findAll(array('order'=>'nomcen')),'codcen','nomcen');
		  echo $form->DropDownList($model,'centro',$datos1, array('empty'=>'--Seleccione una referencia--',  
													    ) ) ;
		?>
		<?php echo $form->error($model,'centro'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'codal'); ?>
		<?php echo $form->textField($model,'codal',array('size'=>3,'maxlength'=>3, )); ?>
		<?php echo $form->error($model,'codal'); ?>
	</div>

	</div> <!--Fin del div panmel izquierdo !-->
	<div class="panelderecho">

	    <div class="row">
		<?php echo $form->labelEx($model,'imputacion'); ?>
		<?php
			$this->widget('ext.matchcode.MatchCode',array(		
												'nombrecampo'=>'imputacion',												
												'ordencampo'=>1,
												'controlador'=>'VwSolpe',
												'relaciones'=>$model->relations(),
												'tamano'=>10,
												'model'=>$model,
												'form'=>$form,
												'nombredialogo'=>'cru-dialog3',
												'nombreframe'=>'cru-frame3',
												'nombrearea'=>'fehdeeefj',
													)
													
								);
									
			   ?>
	</div>

			<div class="row">

						<?php echo $form->labelEx($model,'fechaent'); ?>
 								<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
 										array(
												 'model'=>$model,
 												'attribute'=>'fechaent',
												 'value'=>$model->fechaent,
 												'language' => 'es',
												 'htmlOptions' => array('readonly'=>"readonly"),
												 'options'=>array(
 												'autoSize'=>true,
 												'defaultDate'=>$model->fechaent,
													 'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
													 'showOn'=>'both', // 'focus', 'button', 'both'
													 'buttonImage'=>Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'calendar_1.png',
													 'buttonImageOnly'=>true,
													 'dateFormat'=>'dd/mm/yy',
												 'selectOtherMonths'=>true,
 													'showAnim'=>'slide',
 													'showButtonPanel'=>false,
													 'showOtherMonths'=>true,
													 'changeMonth' => 'true',
 													'changeYear' => 'true',
													 ),
 														)
							);?>
          </div>
		<div class="row">
							<?php echo $form->labelEx($model,'fechaent1'); ?>
											<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
 														array(
 													'model'=>$model,
 													'attribute'=>'fechaent1',
 													'value'=>$model->fechaent1,
													 'language' => 'es',
 														'htmlOptions' => array('readonly'=>"readonly"),
															'options'=>array(
																'autoSize'=>true,
																'defaultDate'=>$model->fechaent,
																'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
																'showOn'=>'both', // 'focus', 'button', 'both'
																'buttonImage'=>Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'calendar_1.png',
																'buttonImageOnly'=>true,
																'dateFormat'=>'dd/mm/yy',
																'selectOtherMonths'=>true,
																'showAnim'=>'slide',
																'showButtonPanel'=>false,
																'showOtherMonths'=>true,
																'changeMonth' => 'true',
																'changeYear' => 'true',
															),
 																		)
											);?>
				    </div>

		<div class="row">
						<?php echo $form->labelEx($model,'fechacrea'); ?>
		
						<?php //echo $form->labelEx($model,'fecha_nac_ciudadano');  //En este caso fecha_nac_ciudadano es nuestro campo fecha ?>
 								<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
 										array(
												 'model'=>$model,
 												'attribute'=>'fechacrea',
												 'value'=>$model->fechacrea,
 												'language' => 'es',
												 'htmlOptions' => array('readonly'=>"readonly"),
											'options'=>array(
												'autoSize'=>true,
												'defaultDate'=>$model->fechaent,
												'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
												'showOn'=>'both', // 'focus', 'button', 'both'
												'buttonImage'=>Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'calendar_1.png',
												'buttonImageOnly'=>true,
												'dateFormat'=>'dd/mm/yy',
												'selectOtherMonths'=>true,
												'showAnim'=>'slide',
												'showButtonPanel'=>false,
												'showOtherMonths'=>true,
												'changeMonth' => 'true',
												'changeYear' => 'true',
											),
 														)
							);?>
		
               </div>
		      <div class="row">
							<?php echo $form->labelEx($model,'fechacrea1'); ?>
		
		
											<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
 														array(
 													'model'=>$model,
 													'attribute'=>'fechacrea1',
 													'value'=>$model->fechacrea1,
													 'language' => 'es',
 														'htmlOptions' => array('readonly'=>"readonly"),
															'options'=>array(
																'autoSize'=>true,
																'defaultDate'=>$model->fechaent,
																'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
																'showOn'=>'both', // 'focus', 'button', 'both'
																'buttonImage'=>Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'calendar_1.png',
																'buttonImageOnly'=>true,
																'dateFormat'=>'dd/mm/yy',
																'selectOtherMonths'=>true,
																'showAnim'=>'slide',
																'showButtonPanel'=>false,
																'showOtherMonths'=>true,
																'changeMonth' => 'true',
																'changeYear' => 'true',
															),
 																		)
											);?>
		
					</div>


	<div class="row">
		<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>10,'maxlength'=>10, )); ?>
		
	</div>
	
                                        <div class="row buttons">
								<?php echo CHtml::submitButton('Buscarv ',array('style'=>'visibility:hidden;')); ?>
					</div>


<?php $this->endWidget(); ?>


	</div> 	 <!-- fin del div panel derecho -->

</div><!-- search-form -->

</div><!--divisaio -->


<?php
//--------------------- begin new code --------------------------
   // add the (closed) dialog for the iframe
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'cru-dialog3',
    'options'=>array(
        'title'=>'Explorador',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>400,
        'height'=>300,
    ),
    ));
?>
<iframe id="cru-frame3" width="100%" height="100%"></iframe>
<?php
 
$this->endWidget();
//--------------------- end new code --------------------------
?>



	