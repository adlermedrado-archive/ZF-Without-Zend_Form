<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{	
	
	public function _initLocalization() {
		
		$locale = new Zend_Locale('pt_BR');
		
		$translator = new Zend_Translate ( 
			array (
				'adapter' => 'array', 
				'content' => '../data/locales', 
				'locale'  => $locale, 
				'scan'    => Zend_Translate::LOCALE_DIRECTORY ) 
			);

		Zend_Locale::setDefault('pt_BR');
		
		Zend_Validate_Abstract::setDefaultTranslator ( $translator );
        Zend_Registry::set('Zend_Translate', $translator);
	}
	
}

