

    
    <?PHP 
    ECHO "ELK ARBOL";
    $this->widget('CTreeView',array(
	'id'=>'unit-treeview',
	'url'=>yii::app()->createUrl('/wo/Locations/fillLocations'),
	'htmlOptions'=>array(
'class'=>'filetree'
	)
));  ?>
        
       
    
    







