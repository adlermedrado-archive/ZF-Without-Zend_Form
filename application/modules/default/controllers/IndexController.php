<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
    public function indexAction() 
    {
        $userMapper = new Application_Model_UserMapper();
        
        echo "<h2>Obtendo Registros</h2>";
        $registros = $userMapper->fetchAll();
        Zend_Debug::dump($registros);
        
    }

    public function formAction()
    {
        $userMapper = new Application_Model_UserMapper();
        
        if ($this->getRequest()->isPost()) {
            
            $user = new Application_Model_User();
            $user->setName($this->getRequest()->getParam('name',''));
            $user->setUsername($this->getRequest()->getParam('username',''));
            $user->setEmail($this->getRequest()->getParam('email',''));
            $user->setPasswd('12345');
            
            $validUser = $user->validate($filterUser);
            if ($validUser) {
                $userMapper->save($user);
            } else {
                // Faz algo se nao ok
            }
            
            $this->view->formData = $filterUser->toJson();
            
        }
        
        
    }


}

