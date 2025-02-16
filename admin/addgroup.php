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

$CMS_ADMIN_PAGE=1;

require_once("../lib/include.php");
require_once("../lib/classes/class.group.inc.php");
$urlext='?'.CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY];

check_login();

$error = "";

$group= "";
if (isset($_POST["group"])) $group = cleanValue($_POST["group"]);

$description= "";
if (isset($_POST["description"])) $description = cleanValue($_POST["description"]);

$active = 1;
if (!isset($_POST["active"]) && isset($_POST["addgroup"])) $active = 0;

if (isset($_POST["cancel"])) {
    redirect("listgroups.php".$urlext);
    return;
}

$userid = get_userid();
$access = check_permission($userid, 'Manage Groups');

if ($access) {
    if (isset($_POST["addgroup"])) {
        try {
            if ($group == '') throw new \CmsInvalidDataException(lang('nofieldgiven', lang('groupname')));

            $groupobj = new Group();
            $groupobj->name = $group;
            $groupobj->description = $description;
            $groupobj->active = $active;

            \CMSMS\HookManager::do_hook('Core::AddGroupPre', [ 'group'=>&$groupobj ] );

            $result = $groupobj->save();
            if( !$result ) throw new \RuntimeException(lang('errorinsertinggroup'));

            \CMSMS\HookManager::do_hook('Core::AddGroupPost', [ 'group'=>&$groupobj ] );
            // put mention into the admin log
            audit($groupobj->id, 'Admin User Group: '.$groupobj->name, 'Added');
            redirect("listgroups.php".$urlext);
            return;
        }
        catch( \Exception $e ) {
            $error .= '<li>'.$e->GetMessage().'</li>';
        }
    }
}

include_once("header.php");

if (!$access) {
    echo "<div class=\"pageerrorcontainer\"><p class=\"pageerror\">".lang('noaccessto', array(lang('addgroup')))."</p></div>";
}
else {
    if ($error != "") {
        echo "<div class=\"pageerrorcontainer\"><ul class=\"pageerror\">".$error."</ul></div>";
    }
?>

<div class="pagecontainer">
  <?php echo $themeObject->ShowHeader('addgroup'); ?>
  <form method="post" action="addgroup.php">
  <div>
    <input type="hidden" name="<?php echo CMS_SECURE_PARAM_NAME ?>" value="<?php echo $_SESSION[CMS_USER_KEY] ?>" />
  </div>
     <div class="pagewarning"><?php echo lang('warn_addgroup'); ?></div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="groupname">*<?php echo lang('name')?>:</label></p>
    <p class="pageinput"><input type="text" id="groupname" name="group" maxlength="255" value="<?php echo $group?>" /></p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="description"><?php echo lang('description')?>:</label></p>
    <p class="pageinput"><input type="text" id="description" name="description" maxlength="255" size="80" value="<?php echo $description?>" /></p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="active"><?php echo lang('active')?>:</label></p>
    <p class="pageinput"><input class="pagecheckbox" type="checkbox" id="active" name="active" <?php echo ($active == 1?"checked=\"checked\"":"")?> /></p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">
      <input type="hidden" name="addgroup" value="true" />
      <input type="submit" value="<?php echo lang('submit')?>" class="pagebutton" />
      <input type="submit" name="cancel" value="<?php echo lang('cancel')?>" class="pagebutton" />
    </p>
  </div>
  </form>
</div>

<?php
}

include_once("footer.php");


?>
