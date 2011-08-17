<?php
/**
 * Data Mapper for Model User
 * @author adlermedrado
 *
 */
class Application_Model_UserMapper 
{
	protected $_dbTable;
    
	/**
	 * 
	 * Defines the dbTable
	 * @param String|Zend_Db_Table_Abstract $dbTable
	 * @throws Exception
	 */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        
        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * 
     * Returns the Zend_Db_Table Object
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }

    /**
     * 
     * Prepare and Execute and Insert and Update Statements
     * @param Application_Model_User $user
     */
    public function save(Application_Model_User $user)
    {
        $data = array(
            'name'     => $user->getEmail(),
            'username' => $user->getUsername(),
            'email'    => $user->getEmail(),
            'passwd'   => $user->getPasswd(),
        );

        if (null === ($id = $user->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    
    /**
     * 
     * Remove an record from database
     * @param Application_Model_User $user
     */
    public function delete(Application_Model_User $user)
    {
        if (NULL === ($id = $user->getId())) {
            throw new Exception('Object ID not set');
        } else {
            $this->getDbTable()->delete(array('id = ?' => $id));
        }
    }
    

    /**
     * 
     * Search for a record on database
     * @param int $id
     * @param Application_Model_User $user
     */
    public function find($id, Application_Model_User $user)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $user->setId($row->id)
             ->setName($row->name)
             ->setUsername($row->username)
             ->setPasswd($row->passwd);
    }

    /**
     * Retrive all records from Database
     */
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_User();
            $entry->setId($row->id)
                  ->setName($row->name)
                  ->setUsername($row->username)
                  ->setEmail($row->email);
            $entries[] = $entry;
        }
        return $entries;
    }
}