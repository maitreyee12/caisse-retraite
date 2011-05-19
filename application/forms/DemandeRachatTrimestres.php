<?php

class Application_Form_DemandeRachatTrimestres extends Zend_Form
{

    public function init()
    {
		
		// Add Element Date Picker
		$elem = new ZendX_JQuery_Form_Element_DatePicker(
						"datePicker1", array("label" => "Date Picker:")
					);
		$elem->setJQueryParam('dateFormat', 'dd.mm.yy');
		$this->addElement($elem);
    }


}

