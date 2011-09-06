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
         $translate = Zend_Registry::get('Zend_Translate');
         
         $this->setTranslator($translate);
		 $notEmptyMessage = $translate->_('notEmptyValue');
		
		if (is_null($options)) { 
			$options = array(
			    'notEmptyMessage' => $notEmptyMessage
			);
		} else {
			$options['notEmptyMessage'] = $notEmptyMessage;
		}
         parent::__construct($filterRules, $validatorRules, $data = null, $options);
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