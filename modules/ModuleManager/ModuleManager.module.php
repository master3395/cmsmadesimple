<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: ModuleManager (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow browsing remotely stored
#  modules, viewing information about them, and downloading or upgrading
# 
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin 
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
if (!isset($gCms)) exit;

define('MINIMUM_REPOSITORY_VERSION','1.3');


class ModuleManager extends CMSModule
{
  private $_connection_ok;

  function GetName()
  {
    return 'ModuleManager';
  }


  /*---------------------------------------------------------
   GetFriendlyName()
   ---------------------------------------------------------*/
  function GetFriendlyName()
  {
    return $this->Lang('friendlyname');
  }

	
  /*---------------------------------------------------------
   GetVersion()
   ---------------------------------------------------------*/
  function GetVersion()
  {
    return '1.4.2';
  }


  /*---------------------------------------------------------
   GetHelp()
   ---------------------------------------------------------*/
  function GetHelp()
  {
    return $this->Lang('help');
  }


  /*---------------------------------------------------------
   GetAuthor()
   ---------------------------------------------------------*/
  function GetAuthor()
  {
    return 'calguy1000';
  }


  /*---------------------------------------------------------
   GetAuthorEmail()
   ---------------------------------------------------------*/
  function GetAuthorEmail()
  {
    return 'calguy1000@hotmail.com';
  }


  /*---------------------------------------------------------
   GetChangeLog()
   ---------------------------------------------------------*/
  function GetChangeLog()
  {
    return $this->Lang('changelog');
  }


  /*---------------------------------------------------------
   IsPluginModule()
   ---------------------------------------------------------*/
  function IsPluginModule()
  {
    return false;
  }


  /*---------------------------------------------------------
   HasAdmin()
   ---------------------------------------------------------*/
  function HasAdmin()
  {
    return true;
  }


  /*---------------------------------------------------------
   IsAdminOnly()
   ---------------------------------------------------------*/
  function IsAdminOnly()
  {
    return true;
  }


  /*---------------------------------------------------------
   GetAdminSection()
   ---------------------------------------------------------*/
  function GetAdminSection()
  {
    return 'extensions';
  }


  /*---------------------------------------------------------
   GetAdminDescription()
   ---------------------------------------------------------*/
  function GetAdminDescription()
  {
    return $this->Lang('admindescription');
  }


  /*---------------------------------------------------------
   VisibleToAdminUser()
   ---------------------------------------------------------*/
  function VisibleToAdminUser()
  {
    if( $this->CheckPermission('Modify Site Preferences') ||
	$this->CheckPermission('Modify Modules') )
      {
	return true;
      }
    return false;
  }
	

  /*---------------------------------------------------------
   SetParameters()
   ---------------------------------------------------------*/
  function SetParameters()
  {
	  $this->RestrictUnknownParams();
	  $this->SetParameterType('curletter',CLEAN_STRING);
	  $this->SetParameterType('name',CLEAN_STRING);
	  $this->SetParameterType('version',CLEAN_STRING);
	  $this->SetParameterType('filename',CLEAN_STRING);
	  $this->SetParameterType('size',CLEAN_INT);
  }
  


  /*---------------------------------------------------------
   CheckAccess()
   ---------------------------------------------------------*/
  function CheckAccess($id, $params, $returnid,$perm = 'Modify Modules')
  {
    if (! $this->CheckPermission($perm))
      {
	$this->_DisplayErrorPage($id, $params, $returnid,
				$this->Lang('accessdenied'));
	return false;
      }
    return true;
  }
	
  /*---------------------------------------------------------
   _DisplayErrorPage()
   This is a simple function for generating error pages.
   ---------------------------------------------------------*/
  function _DisplayErrorPage($id, &$params, $returnid, $message='')
  {
    $this->smarty->assign('title_error', $this->Lang('error'));
    $this->smarty->assign_by_ref('message', $message);
	$this->smarty->assign('link_back',$this->CreateLink($id,'defaultadmin',$returnid, $this->Lang('back_to_module_manager')));	
	  
    // Display the populated template
    echo $this->ProcessTemplate('error.tpl');
  }
	

  /*---------------------------------------------------------
   MinimumCMSVersion()
   ---------------------------------------------------------*/
  function MinimumCMSVersion()
  {
    return "1.10-beta1";
  }


  /*---------------------------------------------------------
   Install()
   ---------------------------------------------------------*/
  function Install()
  {
    $this->SetPreference('module_repository',
			 'http://calguy1000.dyndns.org/cms17/index.php/ModuleRepository/request/v2');

    // put mention into the admin log
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
  }

  /*---------------------------------------------------------
   InstallPostMessage()
   ---------------------------------------------------------*/
  function InstallPostMessage()
  {
    return $this->Lang('postinstall');
  }


  /*---------------------------------------------------------
   UninstallPostMessage()
   ---------------------------------------------------------*/
  function UninstallPostMessage()
  {
    return $this->Lang('postuninstall');
  }


  /*---------------------------------------------------------
   Upgrade()
   ---------------------------------------------------------*/
  function Upgrade($oldversion, $newversion)
  {
    $current_version = $oldversion;
    switch($current_version)
      {
      case "1.0":
	$this->SetPreference('module_repository','http://modules.cmsmadesimple.org/soap.php?module=ModuleRepository');
	break;
      }
		
    // put mention into the admin log
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('upgraded',$this->GetVersion()));
  }


  /**
   * UninstallPreMessage()
   */
  function UninstallPreMessage()
  {
    return $this->Lang('really_uninstall');
  }

	
  /*---------------------------------------------------------
   Uninstall()
   ---------------------------------------------------------*/
  function Uninstall()
  {
    $this->RemovePreference();

    // put mention into the admin log
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));
  }


  /*---------------------------------------------------------
   DoAction($action, $id, $params, $returnid)
   ---------------------------------------------------------*/
  function DoAction($action, $id, $params, $returnid=-1)
  {
    switch ($action)
      {
      case 'recurseinstall':
	{
	  die('call installmodule action');
	}

      // fallback through to call the action.xxxx.php file
      default:
	parent::DoAction( $action, $id, $params, $returnid );
	break;
      }
  }


  /*
   function _DoInstallLoop($id, &$params, $returnid)
		{
		global $gCms;
		$db = $gCms->GetDb();
		
		if (isset($params['cancel']))
			{
			return $this->DoAction('defaultadmin', $id, $params, $returnid);
			}
		
		@set_time_limit(999);
		$installs = array_reverse(unserialize(base64_decode($params['modlist'])));
	    $url = $this->GetPreference('module_repository');
	    if( $url == '' )
			{
			$this->_DisplayErrorPage( $id, $params, $returnid,
					  $this->Lang('error_norepositoryurl'));
			return;
			}
		
		$nusoap = $this->GetModuleInstance('nuSOAP');
	    $nusoap->Load();
	    $nu_soapclient = new nu_soapclient($url,false,false,false,false,false,90,90);
	    if( $err = $nu_soapclient->GetError() )
	      {
			$this->_DisplayErrorPage( $id, $params, $returnid,
					  $this->Lang('soaperror',$err));
			return;
	      }
		$messages = array();
		$ok = true;
		foreach($installs as $this_inst)
			{
			$thisRes = new stdClass();
			$thisRes->success = false;
			$thisRes->module_name = $this_inst['name'];
			if ($ok)
				{
				if ($this_inst['status'] == 'a')
					{
					// activating
					$query = "UPDATE ".cms_db_prefix()."modules SET active = ? WHERE module_name = ?";
					$db->Execute($query, array(1,$this_inst['name']));
					$thisRes->message = $this->Lang('action_activated',$this_inst['name']);
					$thisRes->success = true;
					}
				else if ($this_inst['status'] == 'u')
					{
					// upgrading	
					list($success, $msgs) = $this->_DoInstallOperation($this_inst, $nu_soapclient, true);
					if (!$success)
						{
						$ok = false;
						}
					else
						{
						$thisRes->success = true;
						}
					$thisRes->message = $msgs;
					}
				else if ($this_inst['status'] == 'i')
					{
					// installing
					list($success, $msgs) = $this->_DoInstallOperation($this_inst, $nu_soapclient, false);
					if (!$success)
						{
						$ok=false;
						}
					else
						{
						$thisRes->success = true;
						}
					$thisRes->message = $msgs;
					}
				}
			else
				{
				$thisRes->message = $this->Lang('error_skipping',$this_inst['name']);
				}
			if ($this_inst['status'] != 's')
				{
				$messages[] = $thisRes;
				}
			}
		if ($ok)
			{
			$this->smarty->assign('title_installation_complete', $this->Lang('title_installation_complete'));	
			}
		else
			{
			$this->smarty->assign('title_installation_complete', $this->Lang('error_moduleinstallfailed'));
			}
	    
	    $this->smarty->assign_by_ref('messages', $messages);
		$this->smarty->assign('link_back',$this->CreateLink($id,'defaultadmin',$returnid, $this->Lang('back_to_module_manager')));	
	    echo $this->ProcessTemplate('postinstall.tpl');
		return;		
		}
*/

	/* actual install or upgrade process; adapted from Calguy's code, extended madly */
	function _DoInstallOperation(&$mod, &$nu_soapclient, $upgrade=false)
	{
	  global $gCms;
	  $db = $gCms->GetDb();
	  
	  // get the xml file from soap
	  $xml_file = $this->_GetRepositoryXML($nu_soapclient,$mod['filename']);
	  if( $err = $nu_soapclient->GetError() )
	    {
	      return array(false,"<pre>".htmlspecialchars($nu_soapclient->response)."</pre><br/>");
	    }

	  // get the md5sum from soap
	  $svrmd5 = $nu_soapclient->call('ModuleRepository.soap_modulemd5sum',array('name' => $mod['filename']));
	  if( $err = $nu_soapclient->GetError() )
	    {
	      return array(false,$this->Lang('soaperror',$err));
	    }
	  
	  // calculate our own md5sum
	  // and compare
	  $clientmd5 = md5_file( $xml_file );
	  
	  if( $clientmd5 != $svrmd5 )
	    {
	      return array(false,$this->Lang('error_checksum',array($svrmd5,$clientmd5)));
	    }
	  
		// woohoo, we're ready to rock and roll now
		// just gotta expand the module
		$modoperations = $gCms->GetModuleOperations();
		if (!$modoperations->ExpandXMLPackage( $xml_file, 1 ) )
			{
			return array(false,$modoperations->GetLastError());
			}
		if ($upgrade)
			{
			// upgrade module
			$query = "SELECT * FROM ".cms_db_prefix()."modules WHERE module_name = ?";
		  	$dbresult = $db->Execute( $query, array( $mod['name'] ) );
		  	$row = $dbresult->FetchRow();
		  	$oldversion = $row['version'];
			if ( !$modoperations->UpgradeModule( $mod['name'], $oldversion, $mod['version'] ) )
				{
				return array(false,$this->Lang('error_upgrade',$mod['name']).' '.$modoperations->GetLastError());	
				}
			return array(true,$this->Lang('action_upgraded',array($mod['name'])));
			}
		else
			{
			// and install it
			$result = $modoperations->InstallModule( $mod['name'], true );	
			}
	 
		if( $result[0] == true )
			{
			  if( !($module = cms_utils::get_module($name)) )
			    {
			      // hopefully this will never happen
			      return array(false,$this->Lang('error_moduleinstallfailed'));
			    }
			  else
			    {
			      $msg = $module->InstallPostMessage();
			      return array(true,$msg);
			    }
			}
		else
			{
			return array(false,$this->Lang('error_moduleinstallfailed')."&nbsp;:".$result[1]);
			}
		}
	

  /*----------------------------------------------------------
   _GetRepositoryXML
   Get the xml file for a specific module from the repository
   
   if the expected file size is less than the block size
   then the file will be downloaded in it's entirety
   otherwise it will be downloaded in chunks
   ---------------------------------------------------------*/
  function _GetRepositoryXML( &$nu_soapclient, $filename, $size = -1)
  {
    $orig_chunksize = $this->GetPreference('dl_chunksize',256);
    $chunksize = $orig_chunksize * 1024;
    if( $size <= $chunksize && $size > 0 ) 
      {
	$tmpname = tempnam(TMP_CACHE_LOCATION,'modmgr_');
	if( $tmpname === FALSE )
	  {
	    return false;
	  }
	$fh = fopen($tmpname,'w');
	// we're downloading at one shot
	$nbytes = @fwrite($fh, $nu_soapclient->call('ModuleRepository.soap_modulexml',
				    array('name' => $filename )));
	@fflush($fh);
	@fclose($fh);
	if( $nu_soapclient->GetError() )
	  {
	    return false;
	  }
      }
    else
      {
	global $gCms;
	$tmpname = tempnam(TMP_CACHE_LOCATION,'modmgr_');
	if( $tmpname === FALSE )
	  {
	    return false;
	  }

	// we're downloading in chunks
	// to a temporary file someplace
	// that we will delete afterwards
	$fh = fopen($tmpname,'w');
	$nchunks = (int)($size / $chunksize) + 1;
	for( $i = 0; $i < $nchunks; $i++ )
	  {
 	    $data = $nu_soapclient->call('ModuleRepository.soap_modulegetpart',
 					 array('name' => $filename,
 					       'partnum' => $i,
 					       'sizekb' => $orig_chunksize));
 	    if( $nu_soapclient->GetError() )
 	      {
		echo $nu_soapclient->GetError()."<br/><br/>";
		echo htmlspecialchars($nu_soapclient->response);
 		@fclose($fh);
 		@unlink($tmpname);
 		return false;
 	      }
	    $data = base64_decode( $data );
 	    $nbytes = @fwrite($fh,$data);
	  }
	// we got here so everything theoretically worked
	@fflush($fh);
	@fclose($fh);
      }
    return $tmpname;
  }


  /*----------------------------------------------------------
   _GetRepositoryModules
   Get the xml modules from the repository, in an array of
   hashes, each hash has name and version keys
   ---------------------------------------------------------*/
  function _GetRepositoryModules($prefix = '',$newest = 1)
  {
    global $CMS_VERSION;

    $url = $this->GetPreference('module_repository');
    if( $url == '' )
      {
	return array(false,$this->Lang('error_norepositoryurl'));
      }

    $nusoap = $this->GetModuleInstance('nuSOAP');
    $nusoap->Load();
    $nu_soapclient = new nu_soapclient($url,false,false,false,false,false,90,90);
    if( $err = $nu_soapclient->GetError() )
      {
	return array(false,$this->Lang('error_nosoapconnect'));
      }

    $allmoduledetails = array();
    $repversion = $nu_soapclient->call('ModuleRepository.soap_version');
    if( $err = $nu_soapclient->GetError() )
      {
	return array(false,$this->Lang('error_soaperror').' ('.$url.'): '.$err);
      }
    if( version_compare( $repversion, MINIMUM_REPOSITORY_VERSION ) < 0 )
      {
	return array(false,$this->Lang('error_minimumrepository'));
      }

    $qparms = array();
    if( !empty($prefix) )
      {
	$qparms['prefix'] = $prefix;
      }
    $qparms['newest'] = $newest;
    $qparms['clientcmsversion'] = $CMS_VERSION;
    $allmoduledetails = $nu_soapclient->call('ModuleRepository.soap_moduledetailsgetall',$qparms);
    if( $err = $nu_soapclient->GetError() )
      {
	return array(false,$this->Lang('error_soaperror').' ('.$url.'): '.$err);
      }
    return array(true,$allmoduledetails);
  }


  public function is_connection_ok()
  {
    if( is_null($this->_connection_ok) )
      {
	$url = $this->GetPreference('module_repository');
	if( $url )
	  {
	    $url .= '/version';
	    $req = new cms_http_request();
	    $req->setTimeout(3); // really quick
	    $req->useCurl(FALSE);
	    $req->execute($url,'','POST');
	    if( $req->getStatus() != 200 )
	      {
		$this->_connection_ok = FALSE;
	      }
	    else
	      {
		$this->_connection_ok = TRUE;
	      }
	  }
      }
    return $this->_connection_ok;
  }
}

?>
