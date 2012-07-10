<?php
class DbTable extends GeneratorAbstract
{
    public function createDbTable()
    {
        
        $className  = "Application_Model_DbTable_";
        $className .= GeneratorUtil::camelize($this->getTableName(), false);
        
        $primaryKey = array();
        
        foreach ($this->getTable() as $column => $columnProps) {
            if ($columnProps['PRIMARY'] === true) {
                $primaryKey[] = $column;
            }
        }

		if (count($primaryKey) > 1) {
			$keys = 'array(';
			foreach($primaryKey as $campo) {
				$keys .= "'{$campo}',";
			}
			
			$keys = substr($keys, 0, -1);
			$keys .= ')';
		} else {
			$keys = "'" . current($primaryKey) . "'";
		}
		
        $generatedClass = <<<CLASS_SKULL_BONES
<?php\n
/**
* @author Class Generator
* Generated at {$this->getDtCriacao()}
*/
class {$className} extends Zend_Db_Table_Abstract
{
    protected \$_name = '{$this->getTableName()}';
    protected \$_primary = {$keys};
}
        
CLASS_SKULL_BONES;
    
    return $generatedClass;
    
    }
}