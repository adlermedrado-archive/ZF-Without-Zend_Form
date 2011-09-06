<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction() 
    {
        $userMapper = new Application_Model_UserMapper();
        
        echo "<h2>Getting Records</h2>";
        $records = $userMapper->fetchAll();
        Zend_Debug::dump($records);
        
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
            
            // $filterUser is passed by reference
            $filterUser = null;
            $validUser = $user->validate($filterUser);
            if ($validUser) {
                $userMapper->save($user);
            } else {
            	$this->view->formData = $filterUser->toJson();
            }
            
        }
        
        
    }


}

