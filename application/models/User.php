<?php
/**
 * Copyright (c) 2011, Adler Brediks Medrado
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of the ADLER BREDIKS MEDRADO nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; 
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY 
 * OF SUCH DAMAGE.
 * 
 * @author adlermedrado
 */


/**
 * Example class
 * Simple Plain PHP class that point to an example 'User table on Database'
 * 
 * @author adlermedrado
 *
 */
class Application_Model_User extends Core_Models_Plain
{
    protected $_id, $_name, $_username, $_email, $_passwd;
    protected $_filters = array('*' => 'StringTrim', 'name' => array('StringToUpper'));
    protected $_validators = array('name'     => array('NotEmpty','allowEmpty' => false), // For example purposes only --->,'Alnum',array('Between', 1,10)), 
                                   'username' => array('NotEmpty', 'Alnum'),
                                   'email'    => array('EmailAddress'));
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