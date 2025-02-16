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

$CMS_ADMIN_PAGE = 1;
require_once ('../lib/include.php');

check_login();
$userid = get_userid();

if (!check_permission($userid, 'Manage Users')) die('Permission Denied');

/*--------------------
 * Variables
 ---------------------*/

$urlext            = '?' . CMS_SECURE_PARAM_NAME . '=' . $_SESSION[CMS_USER_KEY];
$gCms              = cmsms();
$db                = $gCms->GetDb();
$assign_group_perm = check_permission($userid, 'Manage Groups');
$groupops          = $gCms->GetGroupOperations();
$error             = '';
$adminaccess       = 1;
$active            = 1;
$sel_groups        = array();
// Post data
$user              = isset($_POST["user"]) ? cleanValue($_POST["user"]) : '';
$password          = isset($_POST["password"]) ? trim($_POST["password"]) : '';
$passwordagain     = isset($_POST["passwordagain"]) ? trim($_POST["passwordagain"]) : '';
$firstname         = isset($_POST["firstname"]) ? cleanValue($_POST["firstname"]) : '';
$lastname          = isset($_POST["lastname"]) ? cleanValue($_POST["lastname"]) : '';
$email             = isset($_POST["email"]) ? trim(strip_tags($_POST["email"])) : '';
$copyusersettings  = isset($_POST['copyusersettings']) ? (int)$_POST['copyusersettings'] : null;
$sel_groups        = (isset($_POST['sel_groups']) && is_array($_POST['sel_groups'])) ? $_POST['sel_groups'] : $sel_groups;

/*--------------------
 * Variables
 ---------------------*/

if (isset($_POST["cancel"])) {
    redirect('listusers.php' . $urlext);
    return;
}

if (isset($_POST["submit"])) {

    $active      = !isset($_POST["active"]) ? 0 : 1;
    $adminaccess = !isset($_POST["adminaccess"]) ? 0 : 1;
    $validinfo   = true;

    if ($user == "") {
        $validinfo = false;
        $error .= "<li>" . lang('nofieldgiven', array(lang('username'))) . "</li>";
    } else if (!preg_match("/^[a-zA-Z0-9\._ ]+$/", $user)) {
        $validinfo = false;
        $error .= "<li>" . lang('illegalcharacters', array(lang('username'))) . "</li>";
    }

    if ($password == "") {
        $validinfo = false;
        $error .= "<li>" . lang('nofieldgiven', array(lang('password'))) . "</li>";
    } else if ($password != $passwordagain) {
        // We don't want to see this if no password was given
        $validinfo = false;
        $error .= "<li>" . lang('nopasswordmatch') . "</li>";
    }

    if (!empty($email) && !is_email($email)) {
        $validinfo = false;
        $error .= '<li>' . lang('invalidemail') . '</li>';
    }

    if ($validinfo) {
        $newuser = new User();

        $newuser->username    = $user;
        $newuser->active      = $active;
        $newuser->firstname   = $firstname;
        $newuser->lastname    = $lastname;
        $newuser->email       = $email;
        $newuser->adminaccess = $adminaccess;
        $newuser->SetPassword($password);

        \CMSMS\HookManager::do_hook('Core::AddUserPre', [ 'user'=>&$newuser ] );

        $result = $newuser->save();

        if ($result) {
            \CMSMS\HookManager::do_hook('Core::AddUserPost', [ 'user'=>&$newuser ] );

            // set some default preferences, based on the user creating this user
            $adminid = get_userid();
            $userid = $newuser->id;
            if ($copyusersettings > 0) {
                $prefs = cms_userprefs::get_all_for_user($copyusersettings);
                if (is_array($prefs) && count($prefs)) {
                    foreach ($prefs as $k => $v) {
                        cms_userprefs::set_for_user($userid, $k, $v);
                    }
                }
            } else {
                cms_userprefs::set_for_user($userid, 'default_cms_language', cms_userprefs::get_for_user($adminid, 'default_cms_language'));
                cms_userprefs::set_for_user($userid, 'wysiwyg', cms_userprefs::get_for_user($adminid, 'wysiwyg'));
                cms_userprefs::set_for_user($userid, 'admintheme', get_site_preference('logintheme', CmsAdminThemeBase::GetDefaultTheme()));
                cms_userprefs::set_for_user($userid, 'bookmarks', cms_userprefs::get_for_user($adminid, 'bookmarks'));
                cms_userprefs::set_for_user($userid, 'recent', cms_userprefs::get_for_user($adminid, 'recent'));
            }

            if ($assign_group_perm && is_array($sel_groups) && count($sel_groups)) {
                $iquery = "INSERT INTO " . cms_db_prefix() . "user_groups (user_id,group_id) VALUES (?,?)";
                foreach ($sel_groups as $gid) {
                    $gid = (int)$gid;
                    if ($gid < 1)
                        continue;
                    $db->Execute($iquery, array(
                        $userid,
                        $gid
                    ));
                }
            }

            // put mention into the admin log
            audit($newuser->id, 'Admin Username: ' . $newuser->username, 'Added');
            redirect("listusers.php" . $urlext);
        } else {
            $error .= "<li>" . lang('errorinsertinguser') . "</li>";
        }
    }
}

/*--------------------
 * Display view
 ---------------------*/

include_once ('header.php');

if ($error != '') {
    echo $themeObject->ShowErrors('<ul class="error">' . $error . '</ul>');
}

$out      = array(-1 => lang('none'));
$userlist = UserOperations::get_instance()->LoadUsers();

foreach ($userlist as $one) {
    $out[$one->id] = $one->username;
}

if ($assign_group_perm) {
    $groups = GroupOperations::get_instance()->LoadGroups();
    $smarty->assign('groups', $groups);
}

$smarty->assign('adminaccess', $adminaccess);
$smarty->assign('active', $active);
$smarty->assign('user', $user);
$smarty->assign('password', $password);
$smarty->assign('passwordagain', $passwordagain);
$smarty->assign('firstname', $firstname);
$smarty->assign('lastname', $lastname);
$smarty->assign('email', $email);
$smarty->assign('copyusersettings', $copyusersettings);
$smarty->assign('sel_groups', $sel_groups);
$smarty->assign('my_userid', get_userid());
$smarty->assign('users', $out);

$smarty->display('adduser.tpl');

include_once ('footer.php');
?>
