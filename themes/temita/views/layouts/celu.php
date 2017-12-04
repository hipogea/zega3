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
           ?>   
<?php
$this->widget('ext.loaderpage.LoaderPage');
?>
</head> 
<body>
<div id="cssmenu">
    

   <?php  
   $this->widget('zii.widgets.CMenu', array(
            'items'=> Menugeneral::getChildsMenu(1)
            )
           );
            ?>
  
</div>
    
        
            <?php echo $content; ?>  
  
</body>