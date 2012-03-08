<?php class Lexity_Ganalytics_IndexController extends Mage_Adminhtml_Controller_Action 
{ 
	
        public function indexAction()
        {

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
        

        $this->_redirect('*/*');
	}
	
	public function miscsetAction()
	{	
          Mage::getModel('ganalytics/index')->addmisc();
          $message = $this->__('Lexity script is now set.');
          Mage::getSingleton('adminhtml/session')->addSuccess($message);
            $this->_redirect('*/*');
	}
	
	public function usersetAction()
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
            $url = @file_get_contents($url_path);
            if($url)
                {
                Mage::getModel('ganalytics/index')->rest_helper($url,$params);
                }
            
          echo  $message = $this->__(' User & Role defined ');
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        
        $this->_redirect('*/*');
	
	}
       
}
?>