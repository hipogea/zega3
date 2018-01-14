	<div class="row">
		<?php
                
                
                
                echo CHtml::label(yii::t('labels',(isset($param['label']))?$param['label']:'Label Undefined'), uniqid()); ?>
                <?php echo CHtml::textField($this->id.'['.$nameparam.']',(isset($param['value']))?$param['value']:'Field Undefined',array('size'=>(isset($param['value']))?$param['size']:10)); ?>
		<?php
                
		//$categorias=array('Sistema','Transporte','Compras','MRP','Email','Costeo');
		//$datos=array_combine($categorias,$categorias);
		?>
		<?php //echo $form->dropDownList($model,'category',$datos,array('empty'=>'Seleccione una categoría')); ?>
		<?php //echo $form->error($model,'category'); ?>
	 </div>

