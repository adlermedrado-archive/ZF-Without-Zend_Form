<?php
/**
 * Methods that will be re-used by plain models
 * 
 * @author adlermedrado
 */
class Core_Models_Plain
{
    /**
     * get the info about the objects
     * @author Adler Medrado
     * @return array
     */
    public function getData ()
    {
        $data = get_object_vars($this);
        $dataProcessed = array();
        foreach ($data as $key => $value) {
            if (($key != '_validators') && ($value != '_filters')) {
                $dataProcessed[str_replace('_', '', $key)] = $value;
            }
        }
        unset($data);
        return $dataProcessed;
    }
    
    /**
     * Executing the validation and filter 
     * @author Adler Medrado
     * @return Zend_Filter_Input|null
     */
    public function validate (&$filter)
    {
        $validator = new Core_Models_Input();
        $filter = $validator->validate($this);
        return $filter->isValid();
    }
}