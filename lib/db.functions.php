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

class DB {

	function DB($config) {
		$this->host = $config->db_hostname;
		$this->db = $config->db_name;
		$this->user = $config->db_username;
		$this->pass = $config->db_password;
		$this->link = mysql_connect($this->host, $this->user, $this->pass);
		mysql_select_db($this->db, $this->link);
	}
	
	function query($query) {
		$result = mysql_query($query, $this->link);
		return $result;
	}

	function close() {
		mysql_close($this->link);
	}

}

require_once('Smarty.class.php');

class Smarty_DB extends Smarty {

        function Smarty_DB(&$config)
        {
                $this->Smarty();

                $this->configCMS = $config;

                $this->template_dir = $config->root_path.'/schemas/';
                $this->compile_dir = $config->root_path.'/smarty/cms/templates_c/';
                $this->config_dir = $config->root_path.'/smarty/cms/configs/';
                $this->cache_dir = $config->root_path.'/smarty/cms/cache/';
                $this->plugins_dir = $config->root_path.'/smarty/cms/plugins/';

                $this->compile_check = true;
                $this->caching = false;
                $this->assign('app_name','CMS');
                $this->debugging = false;
                $this->force_compile = true;
	}
}

?>
