<?php
class GeneratorUtil
{
    public static function camelize($value, $lowerFirst = true) 
    {
        $aCamelParts = explode("_", $value);
        $camelized = '';
        
        $countParts = 0;
        
        foreach ($aCamelParts as $part) {
            
            if ($lowerFirst) {
                if ($countParts > 0) {
                    $camelized .= ucfirst($part);
                } else {
                    $camelized .= $part;
                }
                
                $countParts++;
            } else {
                $camelized .= ucfirst($part);
            }
            
        }
        
        return $camelized;
    }
    
    public static function indent($qtd = 1)
    {
        $indent = chr(32) . chr(32) . chr(32) . chr(32);
        
        if ($qtd > 1) {
            for ($i=1; $i<=$qtd; $i++) {
                $indent .= $indent;
            }
        }
        
        return $indent;
    }
}