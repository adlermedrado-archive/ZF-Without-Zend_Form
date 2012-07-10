<?php
abstract class GeneratorAbstract
{
    private $_tableName;
    private $_table;
    private $_dtCriacao;
    
    public function getTable()
    {
        return $this->_table;
    }

    public function setTable($table)
    {
        $this->_table = $table;
    }
    
    public function getTableName()
    {
        return $this->_tableName;
    }

    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
    }
    
    public function getDtCriacao()
    {
        return $this->_dtCriacao;
    }

    public function setDtCriacao($dtCriacao)
    {
        $this->_dtCriacao = $dtCriacao;
    }

        
    public function __construct($table)
    {
        $this->setTable($table);
        $tableData = current($this->getTable());
        $this->setTableName($tableData['TABLE_NAME']);
        $this->setDtCriacao(date('d/m/Y h:i:s'));
    }
    
}