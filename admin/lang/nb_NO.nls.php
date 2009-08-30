<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://cmsmadesimple.sf.net
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

#NLS (National Language System) array.

#The basic idea and values was taken from then Horde Framework (http://horde.org)
#The original filename was horde/config/nls.php.
#The modifications to fit it for Gallery were made by Jens Tkotz
#(http://gallery.meanalto.com) 

#Ideas from Gallery's implementation made to CMS by Ted Kulp

#Norwegian (bokmål)
#Created by: Roger 'Stigma' Knutsen <stigmaster@gmail.com>
#Maintained by: Jon Arne Holm <jaholm@start.no>

#Native language name
$cms_nls['language']['nb_NO'] = 'Norsk bokmål';
$cms_nls['englishlang']['nb_NO'] = 'Norwegian bokmål';

#Possible aliases for language
$cms_nls['alias']['no'] = 'nb_NO';
$cms_nls['alias']['norwegian'] = 'nb_NO' ;
$cms_nls['alias']['nor'] = 'nb_NO' ;
$cms_nls['alias']['nb_NO'] = 'nb_NO' ;
$cms_nls['alias']['no_NO'] = 'nb_NO' ;
$cms_nls['alias']['nb_NO.ISO8859-1'] = 'nb_NO' ;
$cms_nls['alias']['nb_NO.ISO8859-15'] = 'nb_NO' ;

#Encoding of the language
$cms_nls['encoding']['nb_NO'] = 'UTF-8';

#Location of the file(s)
$cms_nls['file']['nb_NO'] = array(dirname(__FILE__).'/nb_NO/admin.inc.php');

#Language setting for HTML area
# Only change this when translations exist in HTMLarea and plugin dirs
# (please send language files to HTMLarea development)

$cms_nls['htmlarea']['nb_NO'] = 'en';

?>
