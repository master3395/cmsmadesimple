<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#Visit our homepage at: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id$

/**
 * @package CMS
 * @ignore
 */

/*
function __cms_load($filename)
{
  $gCms = CmsApp::get_instance(); // wierd, but this is required.
  require_once($filename);
}
*/

/**
 * A function for auto-loading classes.
 *
 * @since 1.7
 * @internal
 * @ignore
 * @param string A class name
 * @return boolean
 */
function cms_autoloader($classname)
{
    $gCms = CmsApp::get_instance();

  // standard classes
  $fn = cms_join_path(CMS_ROOT_PATH,'lib','classes',"class.{$classname}.php");
  if( is_file($fn) ) {
      require_once($fn);
      return;
  }

  // standard internal classes
  $fn = cms_join_path(CMS_ROOT_PATH,'lib','classes','internal',"class.{$classname}.php");
  if( is_file($fn) ) {
      require_once($fn);
      return;
  }

  // lowercase classes
  $lowercase = strtolower($classname);
  $fn = cms_join_path(CMS_ROOT_PATH,'lib','classes',"class.{$lowercase}.inc.php");
  if( is_file($fn) && $classname != 'Content' ) {
      require_once($fn);
      return;
  }

  // lowercase internal classes
  $lowercase = strtolower($classname);
  $fn = cms_join_path(CMS_ROOT_PATH,'lib','classes','internal',"class.{$lowercase}.inc.php");
  if( is_file($fn) && $classname != 'Content' ) {
      require_once($fn);
      return;
  }

  // standard interfaces
  $fn = cms_join_path(CMS_ROOT_PATH,'lib','classes',"interface.{$classname}.php");
  if( is_file($fn) ) {
      require_once($fn);
      return;
  }

  // internal interfaces
  $fn = cms_join_path(CMS_ROOT_PATH,'lib','classes','internal',"interface.{$classname}.php");
  if( is_file($fn) ) {
      require_once($fn);
      return;
  }

  // standard content types
  $fn = cms_join_path(CMS_ROOT_PATH,'lib','classes','contenttypes',"{$classname}.inc.php");
  if( is_file($fn) ) {
      require_once($fn);
      return;
  }

  $fn = CMS_ROOT_PATH."/modules/{$classname}/{$classname}.module.php";
  if( is_file($fn) ) {
      require_once($fn);
      return;
  }

  $list = ModuleOperations::get_instance()->GetLoadedModules();
  if( is_array($list) && count($list) ) {
      foreach( array_keys($list) as $modname ) {
          $fn = CMS_ROOT_PATH."/modules/$modname/lib/class.$classname.php";
          if( is_file( $fn ) ) {
              require_once($fn);
              return;
          }
      }
  }
  // module classes
}

spl_autoload_register('cms_autoloader');

#
# EOF
#
?>