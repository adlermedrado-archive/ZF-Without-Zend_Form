<?php
class Application_Model_User extends Core_Models_Plain
{
    protected $_id, $_name, $_username, $_email, $_passwd;
    protected $_filters = array('name' => array('StringToUpper'));
    protected $_validators = array('name'     => array('NotEmpty'), // For example purposes only --->,'Alnum',array('Between', 1,10)), 
    							   'username' => array('NotEmpty', 'Alnum'),
                                   'email'    => array('EmailAddress'));
    /**
     * @return array
     */
    public function getFilters ()
    {
        return $this->_filters;
    }

	/**
     * @return array
     */
    public function getValidators ()
    {
        return $this->_validators;
    }
    /**
     * @return int
     */
    public function getId ()
    {
        return $this->_id;
    }
    /**
     * @return String
     */
    public function getName ()
    {
        return $this->_name;
    }
    /**
     * @return String
     */
    public function getUsername ()
    {
        return $this->_username;
    }
    /**
     * @return String
     */
    public function getEmail ()
    {
        return $this->_email;
    }
    /**
     * @return String
     */
    public function getPasswd ()
    {
        return $this->_passwd;
    }
    /**
     * @param int $_id
     * @return Application_Model_User
     */
    public function setId ($_id)
    {
        $this->_id = $_id;
        return $this;
    }
    /**
     * @param String $_name
     * @return Application_Model_User 
     */
    public function setName ($_name)
    {
        $this->_name = $_name;
        return $this;
    }
    /**
     * @param String $username
     * @return Application_Model_User 
     */
    public function setUsername ($username)
    {
        $this->_username = $username;
        return $this;
    }
    /**
     * @param String $email
     * @return Application_Model_User 
     */
    public function setEmail ($email)
    {
        $this->_email = $email;
        return $this;
    }
    /**
     * @param String $passwd
     * @return Application_Model_User 
     */
    public function setPasswd ($passwd)
    {
        $this->_passwd = $passwd;
        return $this;
    }
}