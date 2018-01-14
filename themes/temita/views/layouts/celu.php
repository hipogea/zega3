<head>
 <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<title>Nautilus Solver</title>
    <?php       
	  $baseUrl = Yii::app()->theme->baseUrl;
	  $cs = Yii::app()->getClientScript();
           $cs->registerCssFile($baseUrl.'/css/menu.css');
            $cs->registerScriptFile($baseUrl.'/js/menu.js');
            $cs->registerCssFile($baseUrl.'/css/abound.css');
            $cs->registerScriptFile($baseUrl.'/js/plugins/blockuiplugin.js',CClientScript::POS_HEAD); 
        
           ?>   

<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/img/icons/favicon.png" type="image/png" />

</head> 
<?php
$this->widget('ext.loaderpage.LoaderPage');
?>
<body>
    
    <?php  
echo CHtml::script("$(document).ajaxStart(function () {
  $.blockUI({ 
  message: ' Procesando...',
  css: { border: 'none',
                backgroundColor: '#5bc0de',
                color:'white',
                width:'9em',
                padding:'0.8em',                
                'border-radius':'0.5em',
                opacity: '0.8'}
}
  ); 
}).ajaxStop($.unblockUI);"       
        
        );  ?>
    
    
<div id="cssmenu"> 
   <?php  
   //var_dump(yii::app()->mobileDetect->isSmallDevice());die();
   $this->widget('zii.widgets.CMenu', array(
            'items'=> Menugeneral::getChildsMenu()
            )
           );
            ?>
</div>
    
    
<?php $this->widget('zii.widgets.CBreadcrumbs', array(
      'links'=>$this->breadcrumbs,
    'separator'=>'',
      'homeLink'=>CHtml::link('Main', Yii::app()->homeUrl), 
)); ?>

    <div class="barrasuperior">
        <?php 
                    $botones=array(

			'th-list'=>array(
				'type'=>'B',
				'ruta'=>array('/listamateriales/admin',ARRAY()),
				'visiblex'=>array('10'),
			),


			'star' => array(
                            'type' => 'C',
                            'ruta' => array('/site/agregafavorito',
                           array(
                            'maccion'=>$this->getAction()->id,
                            'mcontrolador'=>$this->getId(),
                            'ritu'=>yii::app()->request->url,
                            "asDialog"=>1,
                            "gridId"=>'favoritos-grid',
                                    )
                              ),
                         
                            'dialog' => 'cru-dialoggeneral',
                            'frame' => 'cru-framegeneral',
                           'visiblex'=>array(true),


                        ),
			
                    
                     'suitcase' => array(
                            'type' => 'C',
                            'ruta' => array('site/revisamaletin', array(
                                'maccion'=>$this->getAction()->id,
                                'mcontrolador'=>$this->getId(),
                                "asDialog"=>1,
                            )
                            ),
                          'contador'=>yii::app()->maletin->cuantoshay(),
                            'dialog' => 'cru-dialoggeneral',
                            'frame' => 'cru-framegeneral',
                           'visiblex'=>array(true),


                        ),
                    
                    'wrench' => array(
                            'type' => 'B',
                            'ruta' => array('/documentos/prefdoc', array(
                            )
                            ),
                       
                            'visiblex' => array(true),

                        ),
                        'cog' => array(
                            'type' => 'B',
                            'ruta' => array('/trabajadores/perfil', array(
                               
                            )
                            ),
                            
                            'visiblex' => array(true),

                        ),
                    'bell' => array(
                            'type' => 'B',
                            'ruta' => array('/noticias/adminusuariopendientes', array(
                                
                            )
                            ),
                           
                            'visiblex' => array(true),

                        ),
                        'lock' => array(
                            'type' => 'B',
                            'ruta' => array('/usuariosfavoritos/misbloqueos', array()),
                              'contador' => Bloqueos::conteo(yii::app()->user->id),
                            'visiblex' => array(true),

                        ),

			
		);
                    if(Noticias::isAdminTablon()) 
                        $botones['bell-alt']= array(
                            'type' => 'B',
                            'ruta' => array('/noticias/poraprobar', array(
                                
                            )
                            ),
                           
                            'visiblex' => array(true),

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
		);
                    
                    ?>
        <div style="float:right;margin-top: 0.6em;">
            <?php $this->widget(
                'booster.widgets.TbLabel',
                         array(
                            'context' => 'success',
                            // 'default', 'primary', 'success', 'info', 'warning', 'danger'
                            'label' => 'DEV',
                                )
                   ); ?>
        </div>
    </div>
    
        
            <?php echo $content; ?>  
  
</body>