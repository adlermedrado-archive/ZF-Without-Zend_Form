<?php
class FileWriter
{
    
    private $_entity;
    private $_dbTable;
    private $_mapper;
    
    public function getEntity()
    {
        return $this->_entity;
    }

    public function setEntity(Entity $entity)
    {
        $this->_entity = $entity;
    }
    
    public function getDbTable()
    {
        return $this->_dbTable;
    }

    public function setDbTable($dbTable)
    {
        $this->_dbTable = $dbTable;
    }

    public function getMapper()
    {
        return $this->_mapper;
    }

    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
    }

        
    public function write()
    {
        // Salva entidade;
        $this->saveEntity();
        $this->saveDbTable();
        $this->saveMapper();
        
    }
    
    private function saveEntity()
    {
        $fileContent = $this->getEntity()->createEntity();
        
        $file = ENTITIES_PATH . DIRECTORY_SEPARATOR .  GeneratorUtil::camelize($this->getEntity()->getTableName(), false) . '.php';
        
        $this->checkFileExists($file);
        file_put_contents($file, $fileContent);
    }
    
    private function saveDbTable()
    {
        $fileContent = $this->getDbTable()->createDbTable();
        
        $file = DBTABLE_PATH . DIRECTORY_SEPARATOR . GeneratorUtil::camelize($this->getEntity()->getTableName(), false) . '.php';
        
        $this->checkFileExists($file);
        file_put_contents($file, $fileContent);
    }
    
    private function saveMapper()
    {
        $fileContent = $this->getMapper()->createMapper();
        
        $file = MAPPER_PATH . DIRECTORY_SEPARATOR . GeneratorUtil::camelize($this->getEntity()->getTableName(), false) . 'Mapper.php';
        
        $this->checkFileExists($file);
        file_put_contents($file, $fileContent);
    }    
    
    private function checkFileExists($file)
    {
        if (file_exists($file)) {
            $mensagem = new Message("This file '{$file}' already exists but it was replaced.");
            Messaging::setMessages($mensagem);
        }
    }
}