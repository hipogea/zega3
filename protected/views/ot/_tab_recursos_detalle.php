

<div class="division">
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'detalleoc-form',

	'enableAjaxValidation'=>true,
	



)); ?>
<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php
	$botones = array(
	'save' => array(
	'type' => 'A',
	'ruta' => array(),
	'visiblex' => array('10'),
	),

      'money' => array(
	'type' => 'C',
	'ruta' => array($this->id . '/verprecios', array(
	'codigomaterial' =>  ``,
	//"id"=>$model->n_direc,
	"asDialog" => 1,
	"gridId" => 'detalle-grid',
	)
	),
	'dialog' => 'cru-dialog3',
	'frame' => 'cru-frame3',
	'visiblex' => array('10'),

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
	<div class="row">
		<?php echo $form->labelEx($model,'hidlabor'); ?>
		<?php
		$criteria = new CDbCriteria();
		$criteria->addCondition("idusertemp=:vuser and hidorden=:vorden");
		$criteria->params = array(":vorden"=>$modelopadre->id,":vuser"=>yii::app()->user->id);
		?>
		<?php  $datos1t1 = CHtml::listData(Tempdetot::model()->findAll($criteria),'idaux','textoactividad');
   //var_dump(Tempdetot::model()->findAll("idusertemp=:vuser and hidorden=:vorden",array(":vorden"=>$modelopadre->id,":vuser"=>yii::app()->user->id)));
	// $datos1t1 = CHtml::listData(Tempdetot::model()->findAll("idusertemp=:vuser ",array(":vuser"=>yii::app()->user->id)),'id','textoactividad');
	//	var_dump($datos1t1);
		echo $form->DropDownList($model,'hidlabor',$datos1t1, array('empty'=>'--Seleccione una labor--','disabled'=>$this->eseditable($modelopadre->codestado))  )  ;
		?>
		<?php echo $form->error($model,'hidlabor'); ?>
	</div>



<div class="row">

						<?php echo $form->labelEx($model,'item'); ?>
						<?php echo $form->textField($model,'item',array('size'=>3,'disabled'=>'disabled')); ?>
</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'imputacion'); ?>
		<?php
			
                  IF($model->escampohabilitado('imputacion')){
                     $this->widget('ext.matchcode.MatchCode',array(
				'nombrecampo'=>'imputacion',
				//'pintarcaja'=>1, ///indica si debe de pintar el textbox al iniciar
				'ordencampo'=>3,
				'controlador'=>'Ot',
				'relaciones'=>$model->relations(),
				'tamano'=>12,
				'model'=>$model,
				'form'=>$form,
				'nombredialogo'=>'cru-dialog3',
				'nombreframe'=>'cru-frame3',
				'nombrearea'=>'mifreerfDDuufu',
				//'nombrecampoareemplazar'=>'imputacion',
				//'comopintar'=>'c_descri',//Significa que va a ha reemplazar al imput del campo
			));

				echo $form->error($model,'imputacion');
                  }else{
                ?>
                  <?php
                  echo $form->textField($model,'imputacion',array('size'=>8,'maxlength'=>8, 'disabled'=>'disabled' ));
                  ?>
             <?php
                  }
			
		?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'cant'); ?>
		<?php echo $form->textField($model,'cant',array('size'=>8,'maxlength'=>8, 'disabled'=>$model->disabledcampo('cant') )); ?>
		<?php 
                
                echo $form->error($model,'cant'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'codart'); ?>
		<?php
               
		if ($model->escampohabilitado('codart') )
		{	$this->widget('ext.matchcode1.MatchCode1',array(
			'nombrecampo'=>'codart',
			'pintarcaja'=>1, ///indica si debe de pintar el textbox al iniciar
			'ordencampo'=>6,
			'controlador'=>'Tempdesolpe',
			'relaciones'=>$model->relations(),
			'tamano'=>10,
			'model'=>$model,
			'form'=>$form,
			'nombredialogo'=>'cru-dialog3',
			'nombreframe'=>'cru-frame3',
			'nombrearea'=>'miffuufu',
			'nombrecampoareemplazar'=>'txtmaterial',
			//'comopintar'=>'c_descri',//Significa que va a ha reemplazar al imput del campo
		));

			echo $form->error($model,'codart');

		} else{
			echo $form->textField($model,'codart',array('disabled'=>'disabled','size'=>10)) ;
			echo $form->textField($model,'txtmaterial',array('disabled'=>'disabled','size'=>60,'maxlength'=>40)) ;

		}
		?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'um'); ?>


		<?php  echo Chtml::ajaxLink(
			Chtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."filter.png"),
			CController::createUrl('Ums/cargaum'), array(
				'type' => 'POST',
				'url' => CController::createUrl('Ums/cargaum'), //  la acci?n que va a cargar el segundo div
				'update' => '#Tempdesolpe_um', // el div que se va a actualizar
				'data'=>array('codigomaterial'=>'js:Tempdesolpe_codart.value'),
			)

		);?>

		<?php IF($model->isNewRecord ){ ?>
<?php
//$datos = CHtml::listData(Ums::model()->findAll(),'um','desum');
			$datos=array();
			echo $form->DropDownList($model,'um',$datos, array('disabled'=>$this->eseditable($modelopadre->codestado), 'maxlength'=>4)  )  ;
			?>
		<?php }  else { 
                     ?>
                               
			<?php echo $form->DropDownList($model,'um',Alconversiones::Listadoums($model->codart), array('empty'=>'--Um--', 'disabled'=>$model->disabledcampo('um'), 'maxlength'=>4)  )  ; ?>


		<?php   } ?>


		<?php  echo Chtml::ajaxLink(
			Chtml::image(Yii::app()->getTheme()->baseUrl.Yii::app()->params["rutatemaimagenes"]."package.png"),
			CController::createUrl('solpe/stock'), array(
			'type' => 'POST',
			'url' => CController::createUrl('solpe/stock'), //  la acci?n que va a cargar el segundo div
			"data"=>array(
				"codiguito"=>"js:Tempdesolpe_codart.value",
				"centrito"=>"js:Tempdesolpe_codal.value",
				"almacencito"=>"js:Tempdesolpe_centro.value",
			),
			"update" => "#zonamaterial",
		),
			array('onClick'=>'Loading.show();Loading.hide(); return false;')
		);?>


		<?php echo $form->error($model,'um'); ?>

	</div>




	<?php
	/*
    echo CHtml::ajaxSubmitButton("Ver detalle material.",
                                                                                    array("solpe/stock"),
                                                                                    array("type"=>"POST",
                                                                                        "data"=>array(
                                                                                            "codiguito"=>"js:Desolpe_codart.value",
                                                                                            "centrito"=>"js:Desolpe_codal.value",
                                                                                            "almacencito"=>"js:Desolpe_centro.value",
                                                                                            ),
                                                                                         "update" => "#zonamaterial",

                                                                                        ),
                                                                                            array('onClick'=>'Loading.show();Loading.hide(); return false;')
                                                                                ) ;
    */
	?>



	<div id ="zonamaterial" class="consultastock">


	</div>





	<div class="row">
		<?php echo $form->labelEx($model,'fechaent'); ?>
		<?php if ($model->escampohabilitado('fechaent'))
		{

			$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				//'name'=>'my_date',
				'model'=>$model,
				'attribute'=>'fechaent',
				'language'=>Yii::app()->language=='es' ? 'es' : null,
				'options'=>array(
					'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
					'showOn'=>'both', // 'focus', 'button', 'both'
					'buttonImage'=>Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'calendar_1.png',
					'buttonImageOnly'=>true,
					'dateFormat'=>'yy-mm-dd',
				),
				'htmlOptions'=>array(
					'style'=>'width:120px;vertical-align:top',
					'readonly'=>'readonly',
					'size'=>12,
				'disabled'=>$this->eseditable($modelopadre->codestado),
				),
			));

		} else{
			echo $form->textField($model,'fechaent',array('disabled'=>'disabled','size'=>10)) ;

		}

		?>
		<?php echo $form->error($model,'fechaent'); ?>
	</div>





	<div class="row">

		<?php //echo $form->labelEx($model,'c_descri'); ?>
		<?php //echo $form->textField($model,'c_descri',array('size'=>40,'maxlength'=>40)); ?>
		<?php //echo $form->error($model,'c_descri'); ?>
	</div>




	<div class="row">
		<?php echo $form->labelEx($model,'centro'); 
                
                   
                ?>
		<?php  $datos1 = CHtml::listData(Centros::model()->findAll(array('order'=>'nomcen')),'codcen','nomcen');
		echo $form->DropDownList($model,'centro',$datos1, array('empty'=>'--Seleccione una referencia--',  'disabled'=>$model->disabledcampo('centro'),
		) ) ;
		?>
		<?php echo $form->error($model,'centro'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'codal');
                
                ?>
		<?php echo $form->textField($model,'codal',array('size'=>3,'maxlength'=>3,'disabled'=>$model->disabledcampo('codal'))); ?>
		<?php echo $form->error($model,'codal'); ?>
	</div>






	<div class="row">
		<?php echo $form->labelEx($model,'solicitanet'); ?>
		<?php echo $form->textField($model,'solicitanet',array( 'disabled'=>$this->eseditable($modelopadre->codestado),'size'=>25,'maxlenght'=>25)); ?>
		<?php echo $form->error($model,'solicitanet'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'textodetalle'); ?>
		<?php echo $form->textArea($model,'textodetalle',array( 'disabled'=>$this->eseditable($modelopadre->codestado),'rows'=>2, 'cols'=>50)); ?>
		<?php echo $form->error($model,'textodetalle'); ?>
	</div>



	<?php $this->endWidget(); ?>

</div><!-- form -->
</div>

<?php
//--------------------- begin new code --------------------------
// add the (closed) dialog for the iframe
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'cru-dialog3',
	'options'=>array(
		'title'=>'',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>600,
		'height'=>420,
		'border'=>0,
	),
));
?>
	<iframe id="cru-frame3" style="border:0px; width:100%; height:100%;" ></iframe>
<?php
 
$this->endWidget();
//--------------------- end new code --------------------------
?>
