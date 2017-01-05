<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (ted@cmsmadesimple.org)
#Visit our homepage at: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOpUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
use \FilePicker\TemporaryInstanceStorage;
use \FilePicker\TemporaryProfileStorage;
use \FilePicker\PathAssistant;
use \FilePicker\utils;
if( !isset($gCms) ) exit;
if( !check_login(FALSE) ) exit; // admin only.... but any admin

//$handlers = ob_list_handlers();
//for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

//
// initialization
//
$sesskey = md5(__FILE__);
$inst = get_parameter_value($_GET,'inst');
$sig = trim(cleanValue(get_parameter_value($_GET,'sig')));
$type = trim(cleanValue(get_parameter_value($_GET,'type')));
$nosub = (int) get_parameter_value($_GET,'nosub');
$profile = null;
if( $sig ) $profile = TemporaryProfileStorage::get($sig);
if( !$sig ) $profile = $this->get_default_profile();
if( $type && $profile ) {
    $profile = $profile->overrideWith( [ 'type'=>$type ] );
}
if( !$this->CheckPermission('Modify Files') ) {
    $parms = ['can_upload'=>FALSE, 'can_delete'=>FALSE, 'can_mkdir'=>FALSE ];
    $profile = $profile->overrideWith( $parms );
}

$filemanager = cms_utils::get_module('FileManager');

// get our absolute top directory, and it's matching url
$topdir = $profile->top;
if( !$topdir ) $topdir = $config['uploads_path'];
$assistant = new PathAssistant($config,$topdir);

// get our current working directory relative to $topdir
// use cwd stored in session first... then if necessary the profile topdir, then if necessary, the absolute topdir
$cwd = '';
if( isset($_SESSION[$sesskey]) ) $cwd = trim($_SESSION[$sesskey]);
if( !$cwd && $profile->top ) $cwd = $assistant->to_relative($profile->top);
if( !$nosub && isset($_GET['subdir']) ) {
    $cwd .= '/' . trim(cleanValue($_GET['subdir']));
    $cwd = $assistant->to_relative($assistant->to_absolute($cwd));
}
// failsave, if we don't have a valid working directory, set it to the top
if( $cwd && !$assistant->is_valid_relative_path( $cwd ) ) {
    $cwd = '';
}
$_SESSION[$sesskey] = $cwd;

// now we're set to go.
$starturl = $assistant->relative_path_to_url($cwd);
$startdir = $assistant->to_absolute($cwd);

$is_image = function($filename) {
    $ext = strtolower(substr($filename,strrpos($filename,'.')+1));
    if( in_array($ext,array('jpg','jpeg','bmp','wbmp','gif','png','webp')) ) return TRUE;
    return FALSE;
};


$is_media = function($filename) {
    $ext = strtolower(substr($filename,strrpos($filename,'.')+1));
    if( in_array($ext,array('swf','dcr','mov','qt','mpg','mp3','mp4','ogg','mpeg','wmp','avi','wmv',
                            'wm','asf','asx','wmx','rm','ra','ram')) ) {
        return TRUE;
    }
    return FALSE;
};

$is_archive = function($filename) {
    $list = ['.zip', '.tar.gz', '.tar.bz2' ];
    $filename = strtolower($filename);
    foreach( $list as $one ) {
        if( endswith( $filename, $one ) ) return TRUE;
    }
    return FALSE;
};

$sortfiles = function($file1,$file2) {
    if ($file1["isdir"] && !$file2["isdir"]) return -1;
    if (!$file1["isdir"] && $file2["isdir"]) return 1;
    return strnatcasecmp($file1["name"],$file2["name"]);
};

$accept_file = function(\CMSMS\FilePickerProfile $profile,$cwd,$path,$filename) use (&$filemanager,&$assistant,&$is_image,&$is_media,&$is_archive) {
    if( $filename == '.' ) return FALSE;
    $fullpath = cms_join_path($path,$filename);
    if( $filename == '..' ) {
        if( !$assistant->is_relative($fullpath) ) return FALSE;
        return TRUE;
    }
    if( (startswith($filename,'.') || startswith($filename,'_')) && !$profile->show_hidden ) return FALSE;
    if( is_dir($fullpath) && $assistant->is_relative($fullpath) ) return TRUE;

    if( $profile->match_prefix && !startswith( $filename, $profile->match_prefix) ) return FALSE;
    if( $profile->exclude_prefix && startswith( $filename, $profile->exclude_prefix) ) return FALSE;
    switch( $profile->type ) {
    case 'image':
        if( $is_image($filename) ) return TRUE;
        return FALSE;

    case 'archive':
        if( $is_archive($filename) ) return TRUE;
        return FALSE;

    case 'media':
        if( $is_media($filename) ) return TRUE;
        return FALSE;

    case 'file':
    case 'any':
    default:
        return TRUE;
    }
};

$get_thumbnail_tag = function($file,$path,$url) {
    $imagetag = null;
    $imagepath = $path.'/thumb_'.$file;
    $imageurl = $url.'/thumb_'.$file;
    if( is_file($imagepath) ) $imagetag="<img src='".$imageurl."' alt='".$file."' title='".$file."' />";
    return $imagetag;
};

/*
 * A quick check for a file type based on extension
 * @String $filename
 */
$get_filetype = function($filename) use (&$is_image,&$is_archive) {
    $ext = strtolower(substr($filename,strrpos($filename,".")+1));
	$filetype = 'file'; // default to all file
	$imgext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'wbmp', 'webp'); // images
	$videoext = array('mov', 'mpeg', 'mp4', 'avi', 'mpg','wma', 'flv', 'webm', 'wmv', 'qt', 'ogg'); // videos
	$audioext = array('mp3', 'm4a', 'ac3', 'aiff', 'mid', 'wav'); // audio
	$archiveext = array('zip', 'rar', 'gz', 'tar', 'iso', 'dmg'); // archives

	if( $is_image($filename) ) {
		$filetype = 'image';
	} elseif(in_array($ext, $videoext)) {
		$filetype = 'video';
	} elseif(in_array($ext, $audioext)) {
		$filetype = 'audio';
	} elseif( $is_archive($filename) ) {
		$filetype = 'archive';
	}

	return $filetype;
};

$is_thumb = function($filename) use (&$is_image) {
    return ($is_image($filename) && startswith($filename,'thumb_'));
};


//
// get our file list
//
$files = array();
$dh = dir($startdir);
while( false !== ($filename = $dh->read()) ) {
    if( !$accept_file( $profile, $cwd, $startdir, $filename ) ) continue;
    $fullname = cms_join_path($startdir,$filename);

    $file = array();
    $file['name'] = $filename;
    $file['fullpath'] = $fullname;
    $file['fullurl'] = $starturl.'/'.$filename;
    $file['isdir'] = is_dir($fullname);
    $file['isparent'] = false;
    if( $file['isdir'] ) {
        if( $filename == '..' ) $file['isparent'] = true;
        $file['relurl'] = $file['fullurl'];
    } else {
        $file['relurl'] = $assistant->to_relative($fullname);
    }
    $file['ext'] = strtolower(substr($filename,strrpos($filename,".")+1));
    $file['is_image'] = $is_image($filename);
    $file['icon'] = $filemanager->GetFileIcon('.'.$file['ext'],$file['isdir']);
    $file['filetype'] = $get_filetype($filename);
    $file['is_thumb'] = $is_thumb($filename);
    $file['dimensions'] = '';
    if( $file['is_image'] && !$file['is_thumb'] ) {
        $file['thumbnail'] = $get_thumbnail_tag($filename,$startdir,$starturl);
        $imgsize = @getimagesize($fullname);
        if( $imgsize ) $file['dimensions'] = $imgsize[0].' x '.$imgsize[1];
    }
    $info = @stat($fullname);
    $filesizename = array(" Bytes", " KB", " MB");
    if( $info && $info['size'] > 0) {
        $file['size'] = round($info['size']/pow(1024, ($i = floor(log($info['size'], 1024)))), 2) . $filesizename[$i];
    } else {
        $file['size'] = null;
    }
    if( $file['isdir'] ) {
        $url = $this->create_url($id,'filepicker',$returnid)."&showtemplate=false&subdir=$filename&inst=$inst&sig=$sig";
        if( $type ) $url .= "&type=$type";
        $file['chdir_url'] = str_replace('&amp;','&',$url);
    }
    $files[] = $file;
}
// done the loop, now sort
usort($files,$sortfiles);

$cwd_for_display = null;
$assistant2 = new PathAssistant($config,$config['root_path']);
$cwd_for_display = $assistant2->to_relative( $startdir );
$css_files = [ '/lib/css/filepicker.css', '/lib/css/filepicker.min.css' ];
$mtime = -1;
$sel_file = null;
foreach( $css_files as $file ) {
    $fp = $this->GetModulePath().'/'.$file;
    if( is_file($fp) ) {
        $fmt = filemtime($fp);
        if( $fmt > $mtime ) {
            $mtime = $fmt;
            $sel_file = $file;
        }
    }
}
$smarty->assign('cssurl',$this->GetModuleURLPath().'/'.$sel_file);
$smarty->assign('cwd_for_display',$cwd_for_display);
$smarty->assign('cwd',$cwd);
$smarty->assign('files',$files);
$smarty->assign('sig',$sig);
$smarty->assign('inst',$inst);
$smarty->assign('mod',$this);
$smarty->assign('profile',$profile);
$lang = [];
$lang['confirm_delete'] = $this->Lang('confirm_delete');
$lang['ok'] = $this->Lang('ok');
$smarty->assign('lang_js',json_encode($lang));
echo $this->ProcessTemplate('filepicker.tpl');

#
# EOF
#
