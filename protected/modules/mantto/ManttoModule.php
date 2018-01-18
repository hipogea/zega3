<?php

class ManttoModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'mantto.models.*',
			'mantto.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
		       
                 
                    // this method is called before any module controller action is performed
			// you may place customized code here
                   if(!ManttoConfig::checkDeafultValues())
                   {
                       $message=yii::t('manttoModule.errors','Before  use module {module}; You should set some parameters. Fill this values and try Again',array('{module}'=> strtoupper(ManttoConfig::getModuleName())));
                       MiFactoria::Mensaje('notice', $message);
                         $controller->redirect(yii::app()->createUrl('/documentos/configuraop',array('codocupadre'=> ManttoConfig::DOCU_DAILYWORK)));
                
                       
                   }
			return true;
		}
		else
			return false;
	}
}
