 
<?php MiFactoria::titulo("Crear Parte", 'gear'); ?>
<div style="
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);">

<?php 

 $this->widget('zii.widgets.jui.CJuiDatePicker',
         array(
		'name'=>'my_date',
			'model'=>null,
             'flat'=>true,//remove to hide the datepicker
		'attribute'=>null,
		//'value'=>date(),
		'language'=>Yii::app()->language=='es' ? 'es' : null,
		'options'=>array(
			'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
			'showOn'=>'button', // 'focus', 'button', 'both'
				//'buttonText'=>Yii::t('ui','...'),
					//'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.png',
				//'buttonImageOnly'=>true,
			     	'onSelect'=>'js:function(selected) {
                                    location.href="'.yii::app()->baseUrl.'/operadores/operaCodep/createDailyReport?codep='.$barco.'&codof='.$oficio.'&fecha="+this.value+"  ";	
				}',
													
                    'dateFormat'=>'yy-mm-dd',		
														
                    ),
		'htmlOptions'=>array(
			'style'=>'width:90px;vertical-align:top',
			'readonly'=>'readonly',
		//'visible'=>'false',
			),
			));
				?>
	
 </div>			