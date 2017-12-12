<?php
/*
 * This Widget, encapsulates the jqueryIntroLoader Plugin
 * http://factory.brainleaf.eu/jqueryIntroLoader
 * You can read the documentation.
 * For aditional options extends this class with changes
 * by register the other files in 'helpers' and  'js' directories :
 * 
 */
class LoaderPage extends CWidget
{ 
    
        public $idWidget="loaderAnyStuff";//
        public $idDiv="element"; //       
	public function init()
	{
	$asset=Yii::app()->assetManager->publish(dirname(__FILE__).'/assets');
	$cs=Yii::app()->clientScript;
    	$cs->registerCssFile($asset."/css/introLoader.min.css");
        $cs->registerScriptFile($asset."/js/jquery.introLoader.pack.min.js");	
             RETURN parent::init();
	}
	public function run()
	{
            echo CHtml::openTag("div",array("id"=>$this->idDiv,"class"=>"introLoading")).CHtml::closeTag("div");
            Yii::app()->getClientScript()->registerScript(
                    $this->idWidget,"$(document).ready(function() {
                         $(\"#element\").introLoader();
                        });",
			CClientScript::POS_END
		);
	}
}
