  <?php  if(Yii::app()->mobileDetect->isSmallDevice()) 
      $this->renderpartial('titulo');
      ?>

    <?php


$botones=array(


'th-list'=>array(
	'type'=>'B',
	'ruta'=>array('/operadores/OperaCodep/MyMaterials',array()),//apreuba guia
	'visiblex'=>array(true),
    'label'=>'Mis materiales',
	),
	'docs'=>array(
	'type'=>'B',
		'ruta'=>array('/procesardocumento',array('id'=>4,'ev'=>84)),//anula guia
		'visiblex'=>array(true),
 'label'=>'Partes',
		),
'calendar-empty'=>array(
	'type'=>'B',
		'ruta'=>array('/procesardocumento',array('id'=>4,'ev'=>84)),//anula guia
		'visiblex'=>array(true),
 'label'=>'Mantenimiento Autónomo',
		)
		);
	$this->widget('ext.toolbar.Barra',
		array(
						//'botones'=>MiFactoria::opcionestoolbar($model->id,$this->documento,$model->codestado),
		'vertical'=>true,
                    'style'=>'clara',
               'font'=>true,
                  'botones'=>$botones,
		'size'=>24,
		'extension'=>'png',
		'status'=>'10',

		)
				);?>