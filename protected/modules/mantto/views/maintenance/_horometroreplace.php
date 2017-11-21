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
?>

    
<?php echo $form->errorSummary($model); ?>

  
    <?php      
                            echo $form->hiddenField($model,'hidpadre',array('value'=>$id));    
                            echo $form->hiddenField($model,'hidequipo',array('value'=>$model->hidequipo));    
                            //echo $form->hiddenField($model,'fechainicio',array('value'=>'2017-10-10'));    
                           
                            ?>
        
        


    
   
    
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
			       'style'=>'width:200px;vertical-align:top',
                                    'readonly'=>'readonly',

					),// jquery plugin options

				));

			?>
		<?php echo $form->error($model,'fechainicio'); ?>
	</div>
    

            
<div class="row">
		<?php echo $form->labelEx($model,'lecturainicio'); ?>
         
                <?php      
                echo $form->textField($model,'lecturainicio',array('size'=>8,'disabled'=>''));    
                ?>
		<?php echo $form->error($model,'lecturainicio'); ?>
	</div>
    
                

<div class="row">
		<?php echo $form->labelEx($model,'unidades'); ?>
         
                <?php      
                echo $form->textField($model,'unidades',array('value'=>$model->ums->desum,'size'=>8,'disabled'=>'disabled'));    
                ?>
		
	</div>

   


       
   
	<?php
   
    $this->widget(
    'booster.widgets.TbButton',
    array(
        'label' => 'Replace Measurement Point',
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
