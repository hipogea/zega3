<?php
class Create extends CAction {
    public $_modelo=null;
    public $_scenario='create';
    public $_nameview='create';
 
    public function run() {
    $controller = $this->getController();
    $model = new $this->_modelo ($this->_scenario);
    
    if (isset($_POST[$this->_modelo])) {
        $model->attributes = $_POST[$this->_modelo]; 
        if ($model->save())
            $controller->redirect(array('admin'));
            MiFactoria::mensaje('success',yii::t('acciones','The record has been created'));
    }
    $controller->render($this->_nameview, array(
        'model' => $model,
    ));
    }
 
}

?>