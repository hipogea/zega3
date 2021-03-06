<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
        <script src="http://code.jquery.com/jquery-migrate-1.4.1.js"></script>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<?php
//echo Yii::app()->user->ui->displayErrorConsole

?>
<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Inicio', 'url'=>array('/index')),
				array('label'=>'Motorista', 'url'=>array('/partes')),
				array('label'=>'inventario AF', 'url'=>array('/inventario/admin')),
				array('label'=>'Movimientos', 'url'=>array('/vwguia/admin')),
				array('label'=>'Pe', 'url'=>array('/temporadas/admin')),
				array('label'=>'Administrar Usuarios'
, 'url'=>Yii::app()->user->ui->userManagementAdminUrl
, 'visible'=>!Yii::app()->user->isGuest),
array('label'=>'Login'
, 'url'=>Yii::app()->user->ui->loginUrl
, 'visible'=>Yii::app()->user->isGuest),
array('label'=>'Logout ('.Yii::app()->user->name.')'
, 'url'=>Yii::app()->user->ui->logoutUrl
, 'visible'=>!Yii::app()->user->isGuest),
				//array('label'=>'Iniciar sesion ', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'Cerrar sesion ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
		
		
		
		
	</div><!-- mainmenu -->

	
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> Exalmar<br/>
		Derechos Reservados.<br/>
		
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
