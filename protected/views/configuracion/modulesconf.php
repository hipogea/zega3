<br><BR>
<?php


echo CHtml::link(yii::t('links',"Edit Params"),yii::app()->createUrl($this->id.'/SettingsModules',array('modulename'=>$modulename)));


?>
<br><BR>




<?php 

//var_dump($aparametros);
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$aparametros,
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


?>
