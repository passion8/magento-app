<?php class Lexity_Ganalytics_IndexController extends Mage_Adminhtml_Controller_Action 
{ 
        public function indexAction()
        {
                $this->_title('Lexity');
                $this->loadLayout();        
		$this->_addContent($this->getLayout()->createBlock('ganalytics/index'));
                $this->getLayout();
		$this->_setActiveMenu('Lexity');
                $this->renderLayout();
        }
        
        
	public function allsetAction()
	{
     
            $post = $this->getRequest()->getPost();
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            
            /* here's your form processing */
           $api_key = $post['myform']['api_key'];
            $some = Mage::getModel('ganalytics/index')->adduser($api_key);
            $params  =  array( 'url' => $_SERVER['SERVER_NAME'] );
            $url_path = Mage::getModel('ganalytics/index')->lexity_inc_path('url.txt');
            $url = @file_get_contents($url_path);
            if($url)
                {
                Mage::getModel('ganalytics/index')->rest_helper($url,$params);
                }
            Mage::getModel('ganalytics/index')->addmisc();
            
            $message = $this->__('You  signed in successfully.');
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        

         $this->_redirect('*/index/index');
	}
	
	public function miscsetAction()
	{	
          Mage::getModel('ganalytics/index')->addmisc();
          $message = $this->__('Lexity script is now set.');
          Mage::getSingleton('adminhtml/session')->addSuccess($message);
             $this->_redirect('*/index/index');
	}
	
	public function usersetAction()
	{       	
                $params  =  array( 'url' => $_SERVER['SERVER_NAME'] );
                $url_path = Mage::getModel('ganalytics/index')->lexity_inc_path('url.txt');
                $url = @file_get_contents($url_path);
                if($url)
                    {
                    Mage::getModel('ganalytics/index')->rest_helper($url,$params);
                    }
		$post = $this->getRequest()->getPost();
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            
            /* here's your form processing */
           $api_key = $post['myform']['api_key'];
            $some = Mage::getModel('ganalytics/index')->adduser($api_key);
            
            $message = $this->__('Lexity extension activated .');
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
            
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/index/index');
	
	}
       public function apiupdateAction()
       {
         
           
           $api_key = $this->getRequest()->getPost();
        try {
            if (empty($api_key)) {
                Mage::throwException($this->__('Invalid form data.'));
            }
            $hashkey = Mage::getModel('ganalytics/index')->_getEncodedApiKey($api_key);
            $resource = Mage::getSingleton('core/resource');
			$writeConnection = $resource->getConnection('core_write');
			$tableName = $resource->getTableName('api/user');
                        $sql     =  " UPDATE ";
                        $sql    .=  $tableName;
                        $sql    .=  " SET api_key = '";
                        $sql    .=  $hashkey;
                        $sql    .=  "' WHERE username = ";
                        $sql    .=  "'lexity'";
                      $results = $writeConnection->query($sql);
			
			
            
           $message = $this->__('Your Api key successfully changed. ');
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
           
           
 
           
       }
}
?>