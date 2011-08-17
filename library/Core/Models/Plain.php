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