<?php
/**
MyCrugeAuthManager

Permite autodetectar controllers y actions definidos en modulos.

Al ser definida como clase para el componente authManager actuara
inmediatamente cuando cruge la requiera, listando los modulos
controllers y actions dentro de la rama 'Variados' en la vista
de edicion de tareas y roles.

instalación:

1. copiar esta clase en /protected/components/MyCrugeAuthManager.php

2. editar protected/config/main.php, colocando la ruta de la clase
del componente authManager para que apunte a esta nueva clase.

'components'=>array(
'authManager' => array(
'class' => 'application.components.MyCrugeAuthManager',
),
),

uso:

1. Cruge invocará atomaticamente a Yii::app()->authManager->autoDetect();

2. si se quiere invocar manualmente y ver que actions se detectaron:

$am = new MyCrugeAuthManager;
$am->init();
foreach($am->autoDetect() as $itemName)
printf("%s\n",$itemName);

@author: Christian Salazar H. <christiansalazarh@gmail.com> @salazarchris74
@license protected/modules/cruge/LICENSE
 */
class MyCrugeAuthManager extends CrugeAuthManager
{
	 
}// finclase
