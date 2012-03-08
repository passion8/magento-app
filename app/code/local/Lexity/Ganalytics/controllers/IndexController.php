<?php class Lexity_Ganalytics_IndexController extends Mage_Adminhtml_Controller_Action 
{ 
	
//	public function indexAction()
//        {
//			$this->loadLayout();
//			
//			if( (Mage::getModel('ganalytics/index')->checking_both() == 'nothingset') ) // will call allset controller
//			{ 
//                            $this->_addContent($this->getLayout()->createBlock('ganalytics/index'));
//                            $this->getLayout();
//			$test = Mage::getStoreConfig('design/head/includes');
//			$url =  $this->getUrl('/index/allset');
//			$block = $this->getLayout()->createBlock('core/text', 'activation-block')->setText('<button onclick="setLocation(\''.$url.
//					'\')">SIGN UP</button>');
////						
//			
//                        $this->getLayout()->getBlock('content')->append($block);
////                        echo "hjgj";
//                        }
//
//			elseif(  )  // will call userset controller
//			{
//			// misc script is set , now we need to set user role .
//			 $test 	= Mage::getStoreConfig('design/head/includes');
//			$url 	=  $this->getUrl('/index/userset');
//			$block 	= $this->getLayout()->createBlock('core/text', 'activation-block')->setText('<button onclick="setLocation(\''.$url.
//							'\')">Fix the issue</button>');
////			$this->getLayout()->getBlock('ganalytics')->append($block);
//			
//                        $this->getLayout()->getBlock('content')->append($block);
//                        echo "hjgj";
//                        }
//			
//			elseif((Mage::getModel('ganalytics/index')->checking_both() == 'notmisc'))  // will call miscset controller
//			{
//				$test 	= Mage::getStoreConfig('design/head/includes');  
//				$url 	=  $this->getUrl('/index/miscset');
//				$block 	= $this->getLayout()->createBlock('core/text', 'activation-block')->setText('<button onclick="setLocation(\''
//							.$url.
//							'\')">Fix the issue</button>');
//                                
////                              $this->getLayout()->getBlock('ganalytics')->append($block);
//				$this->getLayout()->getBlock('content')->append($block);
//                                echo "hjgj";
//			} 
//			
//			else 
//			{
//				$block 	= $this->getLayout()->createBlock('core/text', 'activation-block')->setText('<h5>you have already configure Lexity app</h5>');
////				$this->getLayout()->getBlock('ganalytics')->append($block);
//			
//                                $this->getLayout()->getBlock('content')->append($block);
//                                echo "hjgj";
//                        }
//                        
//		
//                       
//                        $this->_setActiveMenu('Lexity/first_page');
//                        $this->renderLayout();
//    }
	
        public function indexAction()
        {
//            var_dump();
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
            
          echo  $message = $this->__('You  signed in successfully.');
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