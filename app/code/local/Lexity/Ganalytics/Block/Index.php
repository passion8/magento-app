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
   
   public function newkey()
   {
      $api_key = Mage::getModel('ganalytics/index')->_getEncodedApiKey('darling');
        echo $api_key;
   }
 public function auth_t()
 {
//     $auth = Mage::getModel('api/user')->authenticate('lexity', 'darling');
       $auth = Mage::getModel('api/user')->loadByUsername('lexity');
   
         var_dump($auth);
 }
    
       
   
	
       
}

?>