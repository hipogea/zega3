<?php
$this->widget('zii.widgets.jui.CJuiTabs', array(
		'theme' => 'default',
		'tabs' => array(
			'generales'=>array('id'=>'tab_..',
				'content'=>$this->renderPartial('_tab_recursos_detalle', array('modelopadre'=>$modelopadre,'editable'=>$editable,'model'=>$model),TRUE)
			),


			'Auditoria'=>array('id'=>'tab___._..__',
				'content'=>$this->renderPartial('//site/tab_auditoria', array('modelopadre'=>$modelopadre,'model'=>$model),TRUE)
			),



		),
		'options' => array('overflow'=>'auto','collapsible' => false,),
		'id'=>'MyTabidetealle',)
);
?>
