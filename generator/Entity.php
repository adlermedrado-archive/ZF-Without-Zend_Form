<?php
class Entity extends GeneratorAbstract
{
    private $_class;
    private $_classProperties;
    
    public function __construct($table)
    {
        $this->_class = "";
        $this->_classProperties = array();
        parent::__construct($table);
    }
    
    public function getClass()
    {
        return $this->_class;
    }

    public function getClassProperties()
    {
        return $this->_classProperties;
    }

    public function setClassProperties($classProperties)
    {
        $this->_classProperties = $classProperties;
    }
            
    private function _createAttributes()
    {
        $properties = array();
        foreach($this->getTable() as $fields) {
            $properties[] = '$_' . GeneratorUtil::camelize($fields['COLUMN_NAME']);
        }
        
        $this->_class .= 'protected ' . implode(', ', $properties) . ";\n";
        $this->_class .= <<<HEADER_CLASS
    
   /**
     * @todo config filters and validators
     */
     
    protected \$_filters = array();
    protected \$_validators = array();

HEADER_CLASS;
        
        $this->setClassProperties($properties);
    }
    
    private function _createSettersAndGetters()
    {
        $settersAndGetters = '';
        foreach($this->getClassProperties() as $property) {
            
            $property = str_replace('$_', '', $property);
            $methodName = GeneratorUtil::camelize($property, false);
            $settersAndGetters .= <<<CREATE_SETTERS_AND_GETTERS

    public function set{$methodName}(\${$property})
    {
        \$this->_{$property} = \${$property};
    }
    
    public function get{$methodName}()
    {
        return \$this->_{$property};
    }

CREATE_SETTERS_AND_GETTERS;
        }
        
        $this->_class .= $settersAndGetters;
    }
    
    
    
    public function createEntity() 
    {
        $this->_createAttributes();
        $this->_createSettersAndGetters();
        $className = 'Application_Model_' . GeneratorUtil::camelize($this->getTableName(), false);
        
        $generatedClass = <<<CLASS_SKULL_BONES
<?php\n
/**
* @author Class Generator
* Generated at {$this->getDtCriacao()}
*/
class {$className} extends Core_Models_Plain
{
    $this->_class
}
        
CLASS_SKULL_BONES;
        
        return $generatedClass;
    }
    
}