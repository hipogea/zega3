



<h1>Actualizar solicitud <?php echo $model->numformato; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
												'fotos'=>$fotos,
												'ruta'=>Yii::app()->params['rutafotosinventario_'],

												)); ?>

