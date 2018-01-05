  <?php  if(Yii::app()->mobileDetect->isSmallDevice()) 
      $this->renderpartial('titulo');
      ?>

<?PHP $this->breadcrumbs=array(
	'Consola'=>array('MyConsole'),
        // 'Consola'=>array('MyConsole'),
	'Recepcion',
); ?>

    <?php
   
$this->widget(
    'booster.widgets.TbExtendedGridView',
    array(
        'id'=>'mygrilla',
        'fixedHeader' => false,
        'headerOffset' =>-23,
        // 40px is the height of the main navigation at bootstrap
        'type' => 'bordered',// 'striped', 'bordered', 'condensed' and/or 'hover'.
        'dataProvider' => $proveedor,
        'responsiveTable' => Yii::app()->mobileDetect->isSmallDevice(),
        //'template' => "{items}",
       'columns' => array(
           'id',
           /*array('name'=>'id','type'=>'raw','value'=>'$this->grid->controller->widget(
	\'booster.widgets.TbButtonGroup\',
	array(
		\'justified\' => Yii::app()->mobileDetect->isSmallDevice(),
		\'buttons\' => array(
            array(\'label\' => \'Left\', \'url\' => yii::app()->createUrl("/operadores/OperaCodep/confirmMaterials",array("id"=>$data->id)  ),\'htmlOptions\' =>array(\'ajax\'=>array("url"=>\'js:$(this).attr("href")\',\'type\'=>\'GET\',\'complete\'=>\'reloadGrid\'      )      ),         ),           
            array(\'label\' => \'Right\', \'url\' => \'#\')
		),
	    )
                ,true)'),*/
           'c_numgui',
           'd_fectra',
           'c_itguia','n_cangui','c_descri','desum','c_codgui',
           array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'buttons'=>array(
			'delete'=>
				array(
					'visible'=>'true',
					'url'=>'$this->grid->controller->createUrl("/operadores/OperaCodep/confirmMaterials", array("id"=>$data->id))',
					'options' => array(
                                            'class'=>'bolabutton',
						'ajax' => array(
							'type' => 'GET',
							'success'=>"function(data) {
							   $.fn.yiiGridView.update('mygrilla'); 
                                                                $.notify(data, 'info');  
                                                                return false;
                                                            }",
                                                         'error'=>"function(data){
                                                             $.notify(data, 'error');
                                                             }",

							'url'=>'js:$(this).attr("href")'


						),

					) ,
					'imageUrl'=>''.Yii::app()->getTheme()->baseUrl.Yii::app()->params['rutatemaimagenes'].'checkgrande.png',
					'label'=>'Desbloquear',
				),
			)
		),
           
           ),
    )
);
 

?>

<?PHP
echo CHtml::script(" function reloadGrid(data) {
    $.fn.yiiGridView.update('mygrilla');
    return false;  
} ");
?>