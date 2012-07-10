<?php
class Mapper extends GeneratorAbstract
{
    private $_class;
    private $_primaryColumn;
    
    public function getClass()
    {
        return $this->_class;
    }
        
    public function __construct($table)
    {
        parent::__construct($table);
    }
    
    private function createProperties()
    {
        $classProperties = <<<CLASS_SKELETON
protected \$_dbTable;
CLASS_SKELETON;
        return $classProperties;
    }
    
    private function createGetterSetterDbTable()
    {
        $dbTableName = "Application_Model_DbTable_" . GeneratorUtil::camelize($this->getTableName(),false);
        $setterGetterDbTable = <<<SETTER_GETTER_SKELETON_GREYSKULL

    /**
     * 
     * Defines the dbTable
     * @param String|Zend_Db_Table_Abstract \$dbTable
     * @throws Exception
     */
    public function setDbTable(\$dbTable)
    {
        if (is_string(\$dbTable)) {
            \$dbTable = new \$dbTable();
        }
        
        if (!\$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        
        \$this->_dbTable = \$dbTable;
        return \$this;
    }

    /**
     * 
     * Returns the Zend_Db_Table Object
     */
    public function getDbTable()
    {
        if (null === \$this->_dbTable) {
            \$this->setDbTable('{$dbTableName}');
        }
        return \$this->_dbTable;
    }
SETTER_GETTER_SKELETON_GREYSKULL;
            
    return $setterGetterDbTable;
            
    }
    
	/**
	 * @todo Refactor this code to work with composite keys
	 * @author Adler Medrado
	 */
    private function generateSave()
    {
        $objectName = '$' . strtolower($this->getTableName());
        $className  = 'Application_Model_' . GeneratorUtil::camelize($this->getTableName(), false);
        $insertUpdateParams  = '$data = array(';
        
        $primaryColumn = null;
		
        foreach($this->getTable() as $column => $columnProps) {
            
            if ($columnProps['PRIMARY'] === false) {
                $insertUpdateParams .= "\n\t\t'" . $column . "' => " . $objectName 
                                    . '->get' 
                                    . GeneratorUtil::camelize($column, false) . '(),';
            } else {
                $primaryColumn['name'] = $column;
                $primaryColumn['props'] = $columnProps;
                $primaryColumn['method'] = GeneratorUtil::camelize($column, false);
                $this->_primaryColumn = $primaryColumn;
            }
        }
        
        $insertUpdateParams .= "\n\t\t" . ');';
        
        $finalPart = <<<FINALPART_METHOD_SAVE
if (null === (\${$primaryColumn['name']} = {$objectName}->get{$primaryColumn['method']}())) {
            unset(\$data['{$primaryColumn['name']}']);
            \$this->getDbTable()->insert(\$data);
        } else {
            \$this->getDbTable()->update(\$data, array('{$primaryColumn['name']} = ?' => \${$primaryColumn['name']}));
        }
FINALPART_METHOD_SAVE;
        
        $methodSave = <<<METHOD_SAVE_SKELETON
    /**
     * 
     * Prepare and Execute and Insert and Update Statements
     * @param {$className} {$objectName}
     */
    public function save({$className} {$objectName})
    {
        {$insertUpdateParams}

        {$finalPart}
        
    }
METHOD_SAVE_SKELETON;
        
        return $methodSave;
    }
    
    public function generateDelete()
    {
        $objectName = '$' . strtolower($this->getTableName());
        $className  = 'Application_Model_' . GeneratorUtil::camelize($this->getTableName(), false);
        
        $methodDefinition = <<<DELETE_METHOD_SKELETON_SKULL_AND_BONES
/**
    * Remove an record from database
    * @param {$className} {$objectName}
    */
    public function delete({$className} {$objectName})
    {
        if (null === (\${$this->_primaryColumn['name']} = {$objectName}->get{$this->_primaryColumn['method']}())) {
            throw new Exception('Object that represents primary key not set');
        } else {
            \$this->getDbTable()->delete(array('{$this->_primaryColumn['name']} = ?' => \${$this->_primaryColumn['name']}));
        }
    }
DELETE_METHOD_SKELETON_SKULL_AND_BONES;
        
        return $methodDefinition;
        
    }
    
    public function generateFind()
    {
        $objectName = '$' . strtolower($this->getTableName());
        $className  = 'Application_Model_' . GeneratorUtil::camelize($this->getTableName(), false);
        
        $carregaEntidade = '';
        
        foreach($this->getTable() as $column => $columnProps) {
            $carregaEntidade .= "\n\t{$objectName}->set" . GeneratorUtil::camelize($column, false) . "(\$row->{$column});";
        }
        
        $methodDefinition = <<<FIND_METHOD_SKELETON_SKULL_AND_BONES
/**
    * Search for a record on database
    * @param int \${$this->_primaryColumn['name']}
    * @param {$className} {$objectName}
    */
    public function find(\${$this->_primaryColumn['name']}, {$className} {$objectName})
    {
        \$result = \$this->getDbTable()->find(\${$this->_primaryColumn['name']});
        if (0 == count(\$result)) {
            return;
        }
        
        \$row = \$result->current();
{$carregaEntidade}
        
        return {$objectName};
    }
FIND_METHOD_SKELETON_SKULL_AND_BONES;
        
        return $methodDefinition;
        
    }
    
    public function generateFetchAll()
    {
        
        $objectName = '$' . strtolower($this->getTableName());
        $className  = 'Application_Model_' . GeneratorUtil::camelize($this->getTableName(), false);
        $carregaEntidade = '';
        
        foreach($this->getTable() as $column => $columnProps) {
            $carregaEntidade .= "            " . '$entry->set' . GeneratorUtil::camelize($column, false) . "(\$row->{$column});\n";
        }
        
        $methodDefinition = <<<FETCHALL_METHOD_SKELETON_SKULL_AND_BONES
/**
     * Retrive all records from Database
     */
    public function fetchAll()
    {
        \$resultSet = \$this->getDbTable()->fetchAll();
        \$entries   = array();
        foreach (\$resultSet as \$row) {
            \$entry = new {$className}();
{$carregaEntidade}
            \$entries[] = \$entry;
        }
        return \$entries;
    }
FETCHALL_METHOD_SKELETON_SKULL_AND_BONES;
    return $methodDefinition;
    }
    
    
    public function createMapper()
    {
        $className = GeneratorUtil::camelize($this->getTableName(),false);
        $properties = $this->createProperties();
        $getterSetterDbTable = $this->createGetterSetterDbTable();
        $methodSave = $this->generateSave();
        $methodDelete = $this->generateDelete();
        $methodFind = $this->generateFind();
        $methodFetchAll = $this->generateFetchAll();
        
        $generatedClass = <<<GENERATED_CLASS_SKELETON_BONES
<?php\n
/**
* @author Class Generator
* Gerado automaticamente em {$this->getDtCriacao()}
*/
class Application_Model_{$className}Mapper
{

    {$properties}

    {$getterSetterDbTable}
    
    {$methodSave}

    {$methodDelete}

    {$methodFind}

    {$methodFetchAll}
        
}
GENERATED_CLASS_SKELETON_BONES;
    
    return $generatedClass;
    }
    
}