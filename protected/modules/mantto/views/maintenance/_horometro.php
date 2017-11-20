<br>

<?php $this->widget(
                    'booster.widgets.TbLabel',
                        array(
                        'context' => 'warning',
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => '                             Machine :     ',
                            )
                         );

?>
<div class="form">
<div class="division">
    <div class="wide form">
       
<?php 
$form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'verticalForm',
       // 'htmlOptions' => array('class' => 'well'), // for inset effect
    )
);
if($model->hasMeasures()){
   $lecturaac=$model->getLastObject()->lectura;
   
}else{
    $lecturaac=$model->lecturainicio;
}
?>

    
<?php echo $form->errorSummary($model); ?>

  
    <?php      
                            echo $form->hiddenField($model,'hidequipo',array('value'=>$id));    
                            ?>
        
        


    
    <div class="row"> 
		<?php echo $form->labelEx($model,'incremental'); ?>
		<?php  $datos1 = array('-1'=>'Falling','1'=>'Incremental');
		  echo $form->DropDownList($model,'incremental',$datos1, array('disabled'=>($model->escampohabilitado('incremental')  )?'':'disabled'  ,'empty'=>'--Choose Behavior--')  )  ;
                        ?>
                    <?php echo $form->error($model,'incremental'); ?>
                 </div>
    
     <div class="row">
		<?php echo $form->labelEx($model,'codigo');    ?>
                <?php      
                echo $form->textField($model,'codigo',array('size'=>12,'disabled'=>''));    
                ?>
		<?php echo $form->error($model,'codigo'); ?>
	</div>
    
     <div class="row">
		<?php echo $form->labelEx($model,'ubicacion'); ?>
         
                <?php      
                echo $form->textField($model,'ubicacion',array('size'=>12,'disabled'=>''));    
                ?>
		<?php echo $form->error($model,'ubicacion'); ?>
	</div>
    
 <div class="row">
		<?php echo $form->labelEx($model,'fechainicio'); ?>
     <?php if($model->escampohabilitado('fechainicio')  ){ ?>
		 <?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
			$this->widget('CJuiDateTimePicker',array(
					'model'=>$model, //Model object
					'attribute'=>'fechainicio', //attribute name
					'language'=>'es',
					'mode'=>'datetime', //use "time","date" or "datetime" (default)
					'options'=>array('dateFormat'=>'dd/mm/yy',
							'showOn'=>'button', // 'focus', 'button', 'both'
                                                        'buttonText'=>Yii::t('ui',' ... '),
							//'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
							//'buttonImageOnly'=>true,
								),
				'htmlOptions'=>array(
			       'style'=>'width:150px;vertical-align:top',
                                   // 'readonly'=>'readonly',

					),// jquery plugin options

				));

			?>
     <?php }else{ ?>
      <?php      
          echo $form->textField($model,'fechainicio',array('size'=>18,'disabled'=>'disabled'));    
                ?>
      <?php } ?>
		<?php echo $form->error($model,'fechainicio'); ?>
	</div>

            
        <div class="row">
		<?php echo $form->labelEx($model,'lecturainicio'); ?>
         
                <?php      
                echo $form->textField($model,'lecturainicio',array('size'=>8,'disabled'=>$model->escampohabilitado('lecturainicio')?'':'disabled'));    
                ?>
		<?php echo $form->error($model,'lecturainicio'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'lecturaactual'); ?>
         
                <?php      
                echo $form->textField($model,'lecturaactual',array('value'=>$lecturaac,'size'=>8,'disabled'=>'disabled'));    
                ?>
		<?php echo $form->error($model,'lecturaactual'); ?>
	</div>
<div class="row">
		<?php echo $form->labelEx($model,'unidades'); ?>
		<?php 
$datos = CHtml::listData(Ums::model()->findAll(),'um','desum');
echo $form->DropDownList($model,'unidades',$datos, array('disabled'=>($model->escampohabilitado('unidades') )?'':'disabled','empty'=>'--Choose unit --')  )  ;						     
 ?>
		<?php echo $form->error($model,'unidades'); ?>
	</div>

       <div class="row">
		<?php echo $form->labelEx($model,'fechafin'); ?>
         
                <?php      
                echo $form->textField($model,'fechafin',array('size'=>12,'disabled'=>'disabled'));    
                ?>
		<?php echo $form->error($model,'fechafin'); ?>
	</div>     


        <div class="row">
		<?php echo $form->labelEx($model,'activo'); ?>
		<?php echo $form->checkBox($model,'activo',array('disabled'=>'disabled'));?>
		<?php //echo $form->error($model,'tarifamensual'); ?>
	</div> 
        <div class="row">
		<?php echo $form->labelEx($model,'lecturaacumulada'); ?>
         
                <?php      
                echo $form->textField($model,'lecturaacumulada',array('value'=>$model->getAccumulatedValueFromEquipment(),'size'=>12,'disabled'=>'disabled'));    
                ?>
		
	</div>  
        <div class="row">
             
		<?php echo $form->labelEx($model,'orden'); ?>
         
                <?php      
                echo $form->textField($model,'orden',array('size'=>1,'disabled'=>''));    
                ?>
            
		
	</div>  
        
        <div class="row">
             
		<?php echo $form->labelEx($model,'hidpadre'); ?>
         
                <?php   
                   echo CHtml::checkBox('activrtro',($model->hidpadre>0),
                           array('disabled'=>'disabled'));
                   ?> 
            
		
	</div>  
   
	<?php
   
    $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Create Measurement Point',
        'context' => 'success',
        'context' => 'success',
        'htmlOptions'=>array('type'=>'input')
    )
); echo ' ';


    ?>
    </div>
</div>
    
</div>

		
					
	<?php $this->endWidget(); ?>
<?php unset($form); ?>
