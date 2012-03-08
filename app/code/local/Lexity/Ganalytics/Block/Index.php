<?php 
class Lexity_Ganalytics_Block_Index extends Mage_Adminhtml_Block_Template
{
        
	

     
    public function _construct()
        {
         parent::_construct();
        $this->setTemplate('ganalytics/index.phtml');
        }
    public function checking_both()
    {
        return Mage::getModel('ganalytics/index')->checking_both();
    }
   
   

    
       
   
	
       
}

?>