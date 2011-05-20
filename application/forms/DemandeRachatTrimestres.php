<?php

class Application_Form_DemanderachatTrimestres extends ZendX_JQuery_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setName('frm');
        $this->setAction('path/to/action');
        
        $date1 = new ZendX_JQuery_Form_Element_DatePicker(
                'date1',
                array('label' => 'Date:')
             );
             
        $this->addElement($date1);
        
        $elem = new ZendX_JQuery_Form_Element_Spinner(
                "spinner1", 
                array('label' => 'Spinner:')
        );
        
        $elem->setJQueryParams(array('min' => 0, 'max' => 1000, 'start' => 100));
        $this->addElement($elem);
    }
}