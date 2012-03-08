<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Lexity_Ganalytics_Model_Index extends Mage_Core_Model_Abstract
{
    protected $misc_value   = 	'OSSD3GtrEAohD1Tj4XPxZ8Ah08gRAjh2fsIenKdGEG4';
      public function adduser($api_key)
        {
            $role = Mage::getModel('api/roles')
            ->setName('lexity')
            ->setPid(false)
            ->setRoleType('G')
            ->save();

            Mage::getModel("api/rules")
            ->setRoleId($role->getId())
            ->setResources(array('all'))
            ->saveRel();


            $user = Mage::getModel('api/user');

            include_once($this->lexity_inc_path('user.php'));

            $user->save()->load($user->getId());

            $user->setRoleIds(array($role->getId()))
            ->setRoleUserId($user->getUserId())
            ->saveRelations();
            

	}
        public function checking_both()
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
        public function addmisc()
	{      
                $lexityjs = @file_get_contents($this->lexity_inc_path());
                if($lexityjs){
		Mage::getModel('core/config')->saveConfig('design/head/includes', $lexityjs );	// have to fix
		Mage::getConfig()->reinit();
                }else{
                    echo "Lexity.txt file is missing, contact lexity for support";
                   
                }
                
	}

        public function lexity_inc_path($file = 'lexity.js')
        {
            $path = Mage::getBaseDir('code').DIRECTORY_SEPARATOR.'local'
                    .DIRECTORY_SEPARATOR.'Lexity'.DIRECTORY_SEPARATOR.'Ganalytics'
                    .DIRECTORY_SEPARATOR.'includes'
                    .DIRECTORY_SEPARATOR.$file;
             return  $path;

       }

       public function do_user($username = 'lexity')
            {
			$resource = Mage::getSingleton('core/resource');
			$readConnection = $resource->getConnection('core_read');
			$tableName = $resource->getTableName('api/user');
                        $results = $readConnection->fetchALL("SELECT * FROM api_user where username = '". $username ."'LIMIT 1");
			
			if($results[0]["email"] == 'support@lexity.com')
			{
				return true;
			}else 
			{
				return false;
			}
                        $dummy = 'imdumpd';
            }

        public function rest_helper($url, $params = null, $verb = 'POST')
        {
                  $cparams = array(
                    'http' => array(
                      'method' => $verb,
                      'ignore_errors' => true,
                          'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    )
                  );

              if ($params !== null) {
                $params = http_build_query($params);
                if ($verb == 'POST') {
                  $cparams['http']['content'] = $params;
                } else {
                  $url .= '?' . $params;
                }
              }

              $context = stream_context_create($cparams);
              $fp = fopen($url, 'rb', false, $context);
       }    
}
?>
