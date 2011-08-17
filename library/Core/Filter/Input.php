<?php
/** 
 * @author adlermedrado
 * Overrides some Zend_Filter_Input classes and add new features
 * 
 */
class Core_Filter_Input extends Zend_Filter_Input
{
    
    private $original;
    
    /**
     * 
     * @param  array $filterRules
     * @param  array $validatorRules
     * @param  array $data       OPTIONAL
     * @param  array $options    OPTIONAL
     */
    public function __construct ($filterRules, $validatorRules, $data = null, $options = null)
    {
        parent::__construct($filterRules, $validatorRules, $data = null, $options = null);
    }
    
    /**
     * Keep the original data
     * @see Zend_Filter_Input::setData()
     */
    public function setData($data)
    {
        $this->original = $data;
        parent::setData($data);
    }
    
    /**
     * Transform some informations gathered from Zend_Filter_Input object in a JSON that can be used on the front-end
     */
    public function toJson() 
    {
        
          $dados = array();
          $dados['valid'] = array();
          $dados['isValid'] = false;
        
          if ($this->isValid()) {
              $dados['valid'] = $this->getEscaped();
              $dados['isValid'] = true;
          }
          
          $dados['original'] = $this->original;
          $dados['errors'] = $this->getMessages();
          
          return Zend_Json_Encoder::encode($dados);
        
    }
    
}