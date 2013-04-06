<?php // -*- mode:php; tab-width:4; indent-tabs-mode:t; c-basic-offset:4; -*-
#CMS - CMS Made Simple
#(c)2004-2010 by Ted Kulp (ted@cmsmadesimple.org)
#This project's homepage is: http://cmsmadesimple.org
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
#
#$Id$

/**
 * Class definition and methods for Content
 *
 * @package CMS
 * @license GPL
 */

/**
 * Main class for CMS Made Simple content
 *
 * @package CMS
 * @version $Revision$
 * @license GPL
 */
class Content extends ContentBase
{
	/**
	 * @access private
	 * @var array
	 */
    private $_contentBlocks = null;

	/**
	 * Indicate whether or not this content type may be copied
	 *
	 * @return boolean whether or not it's copyable
	 */
    function IsCopyable()
    {
        return TRUE;
    }

    /**
     * Indicates wether ths page type uses a template.
     * i.e: some content types like sectionheader and separator do not.
     *
     * @since 2.0
     * @abstract
     * @return boolean default FALSE
     */
	public function HasTemplate()
	{
		return TRUE;
	}

	/**
	 * Get the friendly (e.g., human-readable) name for this content type
	 *
	 * @return string a human-readable name for this type of content
	 */
    function FriendlyName()
    {
      return lang('contenttype_content');
    }

	/**
	 * test whether or not content may be made the default content
	 *
	 * @return boolean whether or not content may be made the default content
	 */
    function IsDefaultPossible()
    {
		return TRUE;
    }

	/**
	 * Set up base property attributes for this content type
	 *
	 * @return void
	 */
    function SetProperties()
    {
      parent::SetProperties();
	  $this->AddProperty('design_id',2,self::TAB_OPTIONS);
      $this->AddProperty('template',2,self::TAB_OPTIONS);
      $this->AddProperty('searchable',20,self::TAB_OPTIONS);
      $this->AddProperty('disable_wysiwyg',60,self::TAB_OPTIONS);

      $this->AddProperty('pagemetadata',1,self::TAB_LOGIC);
      $this->AddProperty('pagedata',2,self::TAB_LOGIC);
    }

	/**
	 * Has Preview
	 */
	public function HasPreview()
	{
		return TRUE;
	}

	/**
	 * Set content attribute values (from parameters received from admin add/edit form) 
	 *
	 * @param array $params hash of parameters to load into content attributes
	 * @return void
	 */
    function FillParams($params,$editing = false)
    {
		$gCms = cmsms();
		$config = $gCms->GetConfig();

		if (isset($params)) {
			$parameters = array('pagedata','searchable','disable_wysiwyg','design_id');

			//pick up the template id before we do parameters
			if (isset($params['template_id'])) {
				if ($this->mTemplateId != $params['template_id']) {
					$this->_contentBlocks = null;
				}
				$this->mTemplateId = $params['template_id'];
			}

			// add content blocks
			$blocks = $this->get_content_blocks();
			if( is_array($blocks) && count($blocks) ) {
				foreach($blocks as $blockName => $blockInfo) {
					$parameters[] = $blockInfo['id'];
					if( isset($blockInfo['type']) && $blockInfo['type'] == 'module' ) {
						$module = cms_utils::get_module($blockInfo['module']);
						if( !is_object($module) ) continue;
						if( !$module->HasCapability('contentblocks') ) continue;
						$tmp = $module->GetContentBlockValue($blockName,$blockInfo['params'],$params);
						if( $tmp != null ) $params[$blockInfo['id']] = $tmp;
					}
				}
			}

			// do the content property parameters
			foreach ($parameters as $oneparam) {
				if (isset($params[$oneparam])) {
					$this->SetPropertyValue($oneparam, $params[$oneparam]);
				}
			}

			// metadata
			if (isset($params['metadata'])) {
				$this->mMetadata = $params['metadata'];
			}
		}
		parent::FillParams($params,$editing);
    }

	/**
	 * Gets the main content
	 *
	 * @param string $param which attribute to return
	 * @return string the specified content
	 */
    function Show($param = 'content_en')
    {
		$param = str_replace(' ','_',$param);
		return $this->GetPropertyValue($param);
    }

	public function GetEditableProperties()
	{
		$props = parent::GetEditableProperties();

		// add in content blocks
		$blocks = $this->get_content_blocks();
		if( is_array($blocks) && count($blocks) ) {
			$priority = 100;
			foreach( $blocks as $block ) {
				// todo, skip this block if permissions don't allow.

				$prop = new stdClass;
				$prop->name = $block['name'];
				$prop->extra = $block;
				if( !isset($block['tab']) || $block['tab'] == '' ) $block['tab'] = self::TAB_MAIN;
				$prop->tab = $block['tab'];
				$prop->priority = $priority++;
				$props[] = $prop;
			}
		}

		return $props;
	}

	/**
	 * Validate the user's entries in the content add/edit form
	 *
	 * @return mixed either an array of validation error strings, or false to indicate no errors
	 */
	function ValidateData()
	{
		$errors = parent::ValidateData();
		$gCms = cmsms();
		if( $errors === FALSE ) {
			$errors = array();
		}

		if ($this->mTemplateId <= 0 ) {
			$errors[] = lang('nofieldgiven',array(lang('template')));
			$result = false;
		}

// 		if ($this->GetPropertyValue('content_en') == '') {
// 			$errors[]= lang('nofieldgiven',array(lang('content')));
// 			$result = false;
// 		}

		$blocks = $this->get_content_blocks();
		if( !$blocks ) {
		    $errors[] = lang('error_parsing_content_blocks');
		    $result = false;
		}

		$have_content_en = FALSE;
		foreach($blocks as $blockName => $blockInfo) {
			if( $blockInfo['id'] == 'content_en' ) {
				$have_content_en = TRUE;
		    }
			if( $blockInfo['required'] && ($val = $this->GetPropertyValue($blockName)) == '' ) {
				$errors[] = lang('emptyblock',array($blockName));
			}
			if( isset($blockInfo['type']) && $blockInfo['type'] == 'module' ) {
				$module = cms_utils::get_module($blockInfo['module']);
				if( !is_object($module) ) continue;
				if( !$module->HasCapability('contentblocks') ) continue;
				$value = $this->GetPropertyValue($blockInfo['id']);
				$tmp = $module->ValidateContentBlockValue($blockName,$value,$blockInfo['params']);
				if( !empty($tmp) ) {
					$errors[] = $tmp;
					$result = false;
				}
			}
		}

		if( !$have_content_en ) {
		    $errors[] = lang('error_no_default_content_block');
		    $result = false;
		}

		return (count($errors) > 0?$errors:FALSE);
	}

	/**
	 * Parse content blocks in the current page's templates.
	 *
	 * This method can only be called once per request.
	 *
	 * @access private
	 * @internal
	 */
    private function get_content_blocks()
    {
		if( is_array($this->_contentBlocks) ) return $this->_contentBlocks;

		$parser = cmsms()->get_template_parser();
		$parser->fetch('cms_template:'.$this->TemplateId()); // do the magic.

		$this->_contentBlocks = CMS_Content_Block::get_content_blocks();
		return $this->_contentBlocks;
    }
	
	/**
	 * undocumented function
	 *
	 * @param string $one 
	 * @param string $adding 
	 * @return void
	 * @internal
	 */
    protected function display_single_element($one,$adding)
    {
		$gCms = cmsms();
		static $_designs;
		static $_types;
		static $_designtree;
		static $_designlist;
		static $_templates;
		if( $_designlist == null ) {
			$_tpl = CmsLayoutTemplate::template_query(array('as_list'=>1));
			if( is_array($_tpl) && count($_tpl) > 0 ) {
				$_templates = array();
				foreach( $_tpl as $tpl_id => $tpl_name ) {
					$_templates[] = array('key'=>$tpl_id,'value'=>$tpl_name);
				}
			}
			$_designlist = CmsLayoutCollection::get_list();
		}
		
		switch($one) {
		case 'design_id':
			// get the dflt/current design id.
			try {
				$dflt_design = CmsLayoutCollection::load_default();
				$dflt_design_id = $dflt_design->get_id();
				$design_id = $this->GetPropertyValue('design_id');
				if( $design_id < 1 ) $design_id = $dflt_design_id;

				$out = '';
				if( is_array($_designlist) && count($_designlist) ) {
					$out = CmsFormUtils::create_dropdown('design_id',$_designlist,
														 $this->GetPropertyValue('design_id'),
														 array('id'=>'design_id'));
					$help = '&nbsp;'.cms_admin_utils::get_help_tag('core','info_editcontent_design');
					return array('<label for="design_id">*'.lang('design').':</label>'.$help,$out);
				}
			}
			catch( CmsException $e ) {
				// nothing here yet.
			}
			break;

		case 'template':
			try {
				$dflt_tpl = CmsLayoutTemplate::load_dflt_by_type('__CORE__::page');
				$template_id = $this->TemplateId();
				if( $template_id < 1 ) $template_id = $dflt_tpl->get_id();
				$out = CmsFormUtils::create_dropdown('template_id',$_templates,$template_id,array('id'=>'template_id'));
				$help = '&nbsp;'.cms_admin_utils::get_help_tag('core','info_editcontent_template');
				return array('<label for="template_id">*'.lang('template').':</label>'.$help,$out);
			}
			catch( CmsException $e ) {
				// nothing here yet.
			}
			break;

		case 'pagemetadata':
			$help = '&nbsp;'.cms_admin_utils::get_help_tag('core','help_content_pagemeta');
			return array('<label for="id_pagemetadata">'.lang('page_metadata').':</label>'.$help,create_textarea(false, $this->Metadata(), 'metadata', 'pagesmalltextarea', 'metadata', '', '', '80', '6'));

		case 'pagedata':
			$help = '&nbsp;'.cms_admin_utils::get_help_tag('core','help_content_pagedata');
			return array('<label for="id_pagedata">'.lang('pagedata_codeblock').':</label>'.$help,
						 create_textarea(false,$this->GetPropertyValue('pagedata'),'pagedata','pagesmalltextarea','id_pagedata','','','80','6'));

		case 'searchable':
			$searchable = $this->GetPropertyValue('searchable');
			if( $searchable == '' ) $searchable = 1;
			$help = '&nbsp;'.cms_admin_utils::get_help_tag('core','help_page_searchable');
			return array('<label for="id_searchable">'.lang('searchable').':</label>'.$help,
						 '<input type="hidden" name="searchable" value="0"/>
                          <input id="id_searchable" type="checkbox" name="searchable" value="1" '.($searchable==1?'checked="checked"':'').'/>');

		case 'disable_wysiwyg':
			$disable_wysiwyg = $this->GetPropertyValue('disable_wysiwyg');
			if( $disable_wysiwyg == '' ) $disable_wysiwyg = 0;
			$help = '&nbsp;'.cms_admin_utils::get_help_tag('core','help_page_disablewysiwyg');
			return array('<label for="id_disablewysiwyg">'.lang('disable_wysiwyg').':</label>'.$help,
						 '<input type="hidden" name="disable_wysiwyg" value="0" />
             <input id="id_disablewysiwyg" type="checkbox" name="disable_wysiwyg" value="1"  '.($disable_wysiwyg==1?'checked="checked"':'').' onclick="this.form.submit()" />');
			break;

		default:
			// check if it's content block
			$blocks = $this->get_content_blocks();
			if( isset($blocks[$one]) ) {
				// its a content block
				$block = $blocks[$one];
				$data = $this->GetPropertyValue($block['id']);
				return $this->display_content_block($one,$block,$data,$adding);
			}
			else {
				// call the parent class
				return parent::display_single_element($one,$adding);
			}
		}
    }

	/*
	* return the HTML to create the text area in the admin console.
	* does not include a label.
	*/
	private function _display_text_block($blockInfo,$value,$adding)
	{
		$ret = '';
		$oneline = isset($blockInfo['oneline']) && cms_to_bool($blockInfo['oneline']);
		if ($oneline) {
			$size = (isset($blockInfo['size']))?$blockInfo['size']:50;
			$maxlength = (isset($blockInfo['maxlength']))?$blockInfo['maxlength']:255;
			$ret = '<input type="text" size="'.$size.'" maxlength="'.$maxlength.'" name="'.$blockInfo['id'].'" value="'.cms_htmlentities($value, ENT_NOQUOTES, get_encoding('')).'" />';
		}
		else {
			$block_wysiwyg = true;
			$hide_wysiwyg = $this->GetPropertyValue('disable_wysiwyg');

			if ($hide_wysiwyg) {
				$block_wysiwyg = false;
			}
			else {
				$block_wysiwyg = $blockInfo['usewysiwyg'] == 'false'?false:true;
			}

			$ret = create_textarea($block_wysiwyg, $value, $blockInfo['id'], '', $blockInfo['id']);
		}
		return $ret;
	}

	/*
	* return the HTML to create an image dropdown in the admin console.
	* does not include a label.
	*/
	private function _display_image_block($blockInfo,$value,$adding)
	{
		$gCms = cmsms();
		$config = $gCms->GetConfig();
		$adddir = get_site_preference('contentimage_path');
		if( $blockInfo['dir'] != '' ) {
			$adddir = $blockInfo['dir'];
		}
		$dir = cms_join_path($config['uploads_path'],$adddir);
		$optprefix = '';
		$inputname = $blockInfo['id'];
		if( isset($blockInfo['inputname']) ) {
			$inputname = $blockInfo['inputname'];
		}
		$prefix = '';
		if( isset($blockInfo['exclude']) ) {
			$prefix = $blockInfo['exclude'];
		}
		if( isset($blockInfo['sort']) ) {
			$sort = (int)$blockInfo['sort'];
		}
		$dropdown = create_file_dropdown($inputname,$dir,$value,'jpg,jpeg,png,gif',$optprefix,true,'',
										 $prefix,1,$sort);
		if( $dropdown === false ) {
			$dropdown = lang('error_retrieving_file_list');
		}
		return $dropdown;
	}

   /*
	* return the HTML to create the text area in the admin console.
	* may include a label.
    */
	private function _display_module_block($blockName,$blockInfo,$value,$adding)
	{
		$gCms = cmsms();
		$ret = '';
		if( !isset($blockInfo['module']) ) return FALSE;
		$module = cms_utils::get_module($blockInfo['module']);
		if( !is_object($module) ) return FALSE;
		if( !$module->HasCapability('contentblocks') ) return FALSE;
		if( isset($blockInfo['inputname']) && !empty($blockInfo['inputname']) ) {
			// a hack to allow overriding the input field name.
			$blockName = $blockInfo['inputname'];
		}
		$tmp = $module->GetContentBlockInput($blockName,$value,$blockInfo['params'],$adding);
		return $tmp;
	}

	/**
	* Return an array of two elements
	* the first is the string for the label for the field
	* the second is the html for the input field
	*/
	private function display_content_block($blockName,$blockInfo,$value,$adding = false)
	{
		// it'd be nice if the content block was an object..
		// but I don't have the time to do it at the moment.
		$field = '';
		$label = '';
		if( isset($blockInfo['label']) && $blockInfo['label'] != '') {
			$label = '<label for="'.$blockInfo['id'].'">'.$blockInfo['label'].':</label>';
		}
		switch( $blockInfo['type'] ) {
		case 'text':
			if( $blockName == 'content_en' && $label == '' ) {
				$help = '&nbsp;'.cms_admin_utils::get_help_tag('core','help_content_content_en');
				$label = '<label for="content_en">*'.lang('content').':</label>&nbsp;'.$help;
			}
			$field = $this->_display_text_block($blockInfo,$value,$adding);
			break;

		case 'image':
			$field = $this->_display_image_block($blockInfo,$value,$adding);
			break;

		case 'module':
			$tmp = $this->_display_module_block($blockName,$blockInfo,$value,$adding);
			if( is_array($tmp) ) {
				if( count($tmp) == 2 ) {
					$label = $tmp[0];
					$field = $tmp[1];
				}
				else {
					$field = $tmp[0];
				}
			}
			else {
				$field = $tmp;
			}
			break;
		}
		if( empty($field) ) return FALSE;
		if( empty($label) ) $label = $blockName.':';
		return array($label,$field);
	}

} // end of class

# vim:ts=4 sw=4 noet
?>