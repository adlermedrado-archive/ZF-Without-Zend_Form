<?php
class Core_Models_Input
{
    /**
     * 
     * Keep the validation object after it be used
     * @var Zend_Filter_Input
     */
    private $filterInput;
    
    /**
     * @return Zend_Filter_Input
     */
    public function getFilterInput ()
    {
        return $this->filterInput;
    }
    
    /**
     * Execute the filters and validators according to the filters and validators configured on model object
     * @param Core_Models_Plain $model
     */
    public function validate (Core_Models_Plain $model)
    {
        $filterInput = new Core_Filter_Input($model->getFilters(), $model->getValidators());
        $filterInput->setData($model->getData());
        return $filterInput;
    }
}