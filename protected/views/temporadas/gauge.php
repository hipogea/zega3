     <div>
		
			<?php $this->widget('ext.kpi.Kpi',array(
		
													'startAngle'=>-150,
													'endAngle'=>150,
													'min'=>0,
													'max'=>100,
													'step'=>2,
													'texto'=>'%',
													'ancholinea'=>0,
													'titulo'=>'Avance cuota',
													'rangocolores'=>array(
																			array('from'=>90,'to'=>100,'color'=>'#55BF3B'),
																			array('from'=>30,'to'=>50,'color'=>'#FFBF00'),
																			array('from'=>50,'to'=>90,'color'=>'#DDDF0D'),
																			array('from'=>0,'to'=>30,'color'=>'#DF5353'),
																	),
													'valor'=>$dato+0,
													'sufix'=>'hola :',
													)
													
								);
								
			?>
															
	</div>