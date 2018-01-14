<?php 
$ap=array();
foreach($aparametros as $clave=>$parametros){
  $ap[$clave]=array(
      'label'=>$clave,
      'type'=>'raw',
      'value'=>''
  );
}
foreach($aparametros as $clave=>$parametros){
  
    MiFactoria::titulo('hola','gear'); 
    
    
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$parametros,
    /*'attributes'=>array(
        'title',             // title attribute (in plain text)
        'owner.name',        // an attribute of the related object "owner"
        'description:html',  // description attribute in HTML
        array(               // related city displayed as a link
            'label'=>'City',
            'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode($model->city->name),
                                 array('city/view','id'=>$model->city->id)),
        ),
    ),*/
));

}


?>