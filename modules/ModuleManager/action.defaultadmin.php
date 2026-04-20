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
# Visit our homepage at: http://www.cmsmadesimple.org
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
if( !isset($gCms) ) exit;

if( isset($params['modulehelp']) ) {
    // this is done before permissions checks
    $params['mod'] = $params['modulehelp'];
    unset($params['modulehelp']);
    include(__DIR__.'/action.local_help.php');
    return;
}

if( !$this->VisibleToAdminUser() ) exit;

// When the database still holds a higher version than the files (manual downgrade or file deploy),
// align the stored version and refresh caches so the Installed list shows the correct number.
if( $this->CheckPermission('Modify Modules') ) {
    $file_version = $this->GetVersion();
    $db = cmsms()->GetDb();
    $row = $db->GetRow('SELECT version FROM '.CMS_DB_PREFIX.'modules WHERE module_name = ?',array('ModuleManager'));
    if( is_array($row) && isset($row['version']) && $row['version'] !== '' && version_compare($row['version'],$file_version,'>') ) {
        $db->Execute('UPDATE '.CMS_DB_PREFIX.'modules SET version = ? WHERE module_name = ?',array($file_version,'ModuleManager'));
        if( class_exists('\CMSMS\internal\global_cache') ) {
            \CMSMS\internal\global_cache::clear('modules');
        }
        cmsms()->clear_cached_files();
        $this->SetMessage($this->Lang('msg_stored_version_synced',$file_version));
        $tab_for_redirect = get_parameter_value($params,'__activetab','');
        if( $tab_for_redirect === '' ) $tab_for_redirect = get_parameter_value($params,$id.'__activetab','');
        if( $tab_for_redirect === '' && isset($_GET[$id.'__activetab']) ) $tab_for_redirect = (string)$_GET[$id.'__activetab'];
        if( $tab_for_redirect === '' && isset($_GET['__activetab']) ) $tab_for_redirect = (string)$_GET['__activetab'];
        if( $tab_for_redirect === '' ) $tab_for_redirect = 'installed';
        $this->Redirect($id,'defaultadmin',$returnid,array('__activetab'=>$tab_for_redirect));
        return;
    }
}

$active_tab = get_parameter_value($params,'__activetab','');
if( $active_tab === '' ) $active_tab = get_parameter_value($params,$id.'__activetab','');
if( $active_tab === '' && isset($_GET[$id.'__activetab']) ) {
    $active_tab = (string)$_GET[$id.'__activetab'];
}
if( $active_tab === '' && isset($_GET['__activetab']) ) {
    $active_tab = (string)$_GET['__activetab'];
}
if( $active_tab === '' ) $active_tab = 'installed';
// Normalize active tab key for CMS tab renderer, which expects __activetab.
$params['__activetab'] = $active_tab;
$params[$id.'__activetab'] = $active_tab;
$tmp = ModuleOperations::get_instance()->GetQueueResults();
if( is_array($tmp) && count($tmp) ) {
    $tmp2 = array();
    foreach( $tmp as $key => $data ) {
        $msg = $data[1];
        if( !$msg ) {
            $msg = $this->Lang('unknown');
            if( $data[0] ) $msg = $this->Lang('success');
        }
        $tmp2[] = $key.': '.$msg;
    }
    echo $this->ShowMessage($tmp2);
}

echo '<div class="pagewarning">'."\n";
echo '<h3>'.$this->Lang('notice')."</h3>\n";
$link = '<a target="_blank" href="http://dev.cmsmadesimple.org">forge</a>';
echo '<p>'.$this->Lang('general_notice',$link,$link)."</p>\n";
echo '<h3>'.$this->Lang('use_at_your_own_risk')."</h3>\n";
echo '<p>'.$this->Lang('compatibility_disclaimer')."</p></div>\n";

$skip_connection_check = ($active_tab === 'prefs' && $this->CheckPermission('Modify Site Preferences'));
$connection_ok = TRUE;
if( !$skip_connection_check ) {
    $connection_ok = modmgr_utils::is_connection_ok();
    if( !$connection_ok ) echo $this->ShowErrors($this->Lang('error_request_problem'));
}
else {
    // Avoid forcing a repository call when user is opening settings to fix URL.
    $connection_ok = FALSE;
}

// this is a bit ugly.
modmgr_utils::get_images();

$newversions = [];
if( $connection_ok ) {
    try {
        $newversions = modulerep_client::get_newmoduleversions();
    }
    catch(ModuleNoDataException $e) {
      // nothing here TODO handle this a bit better (JM)
    }
    catch( Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}

echo $this->StartTabHeaders();
if( $this->CheckPermission('Modify Modules') ) {
    echo $this->SetTabHeader('installed',$this->Lang('installed'));
    if( $connection_ok ) {
        $num = ( is_array($newversions) ) ? count($newversions) : 0;
        echo $this->SetTabHeader('newversions',$num.' '.$this->Lang('tab_newversions') );
        echo $this->SetTabHeader('search',$this->Lang('search'));
        echo $this->SetTabHeader('modules',$this->Lang('availmodules'));
    }
}
if( $this->CheckPermission('Modify Site Preferences') ) echo $this->SetTabHeader('prefs',$this->Lang('prompt_settings'));
echo $this->EndTabHeaders();

$prefs_html = '';
echo $this->StartTabContent();
if( $this->CheckPermission('Modify Modules') ) {
    echo $this->StartTab('installed',$params);
    include(dirname(__FILE__).'/function.admin_installed.php');
    echo $this->EndTab();

    if( $connection_ok ) {
        echo $this->StartTab('newversions',$params);
        include(dirname(__FILE__).'/function.newversionstab.php');
        echo $this->EndTab();

        echo $this->StartTab('search',$params);
        include(dirname(__FILE__).'/function.search.php');
        echo $this->EndTab();

        echo $this->StartTab('modules',$params);
        include(dirname(__FILE__).'/function.admin_modules_tab.php');
        echo $this->EndTab();
    }
}
if( $this->CheckPermission('Modify Site Preferences') ) {
    echo $this->StartTab('prefs',$params);
    ob_start();
    include(dirname(__FILE__).'/function.admin_prefs_tab.php');
    $prefs_html = ob_get_clean();
    echo $prefs_html;
    echo $this->EndTab();
}
echo $this->EndTabContent();

if( $prefs_html !== '' ) {
    $prefs_html_js = json_encode($prefs_html);
    echo '<script>(function(){';
    echo 'var prefsHtml = '.$prefs_html_js.';';
    echo 'var fallbackMarker = "<!-- MM_PREFS_FALLBACK_INJECTED -->";';
    echo 'var forcePrefsRender = false;';
    echo 'function isPrefsRequested(){';
    echo '  try {';
    echo '    var url = new URL(window.location.href);';
    echo '    var a = url.searchParams.get("'.$id.'__activetab");';
    echo '    var b = url.searchParams.get("__activetab");';
    echo '    return a === "prefs" || b === "prefs";';
    echo '  } catch(e) { return false; }';
    echo '}';
    echo 'function ensurePrefsVisible(){';
    echo '  var prefsTab = document.getElementById("prefs");';
    echo '  var installedTab = document.getElementById("installed");';
    echo '  var pageContent = document.getElementById("page_content");';
    echo '  if(!prefsTab || !pageContent) return;';
    echo '  var prefsActive = (prefsTab.className || "").indexOf("active") !== -1;';
    echo '  var installedActive = installedTab && (installedTab.className || "").indexOf("active") !== -1;';
    echo '  var shouldInject = isPrefsRequested() || forcePrefsRender || prefsActive;';
    echo '  if(!shouldInject) return;';
    echo '  if(installedActive) return;';
    echo '  var hasPrefsField = !!pageContent.querySelector("#mr_url");';
    echo '  var alreadyInjected = (pageContent.innerHTML || "").indexOf("MM_PREFS_FALLBACK_INJECTED") !== -1;';
    echo '  if(hasPrefsField && !alreadyInjected) return;';
    echo '  pageContent.style.height = "auto";';
    echo '  pageContent.style.minHeight = "260px";';
    echo '  pageContent.style.overflow = "visible";';
    echo '  pageContent.innerHTML = prefsHtml + fallbackMarker;';
    echo '}';
    echo 'var prefsTab = document.getElementById("prefs");';
    echo 'var installedTab = document.getElementById("installed");';
    echo 'if(prefsTab){';
    echo '  prefsTab.addEventListener("click",function(){ forcePrefsRender = true; setTimeout(ensurePrefsVisible,0); setTimeout(ensurePrefsVisible,100); setTimeout(ensurePrefsVisible,220); });';
    echo '}';
    echo 'if(installedTab){';
    echo '  installedTab.addEventListener("click",function(){ forcePrefsRender = false; });';
    echo '}';
    echo 'if(document.readyState === "loading"){ document.addEventListener("DOMContentLoaded",ensurePrefsVisible); } else { ensurePrefsVisible(); }';
    echo 'setTimeout(ensurePrefsVisible,80);';
    echo '})();</script>';
}
