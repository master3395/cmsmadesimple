<?php

$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

$tmp = get_parameter_value($_REQUEST,'filter');
$filter = json_decode($tmp,TRUE);
if( !$this->CheckPermission('Modify Templates') ) $filter[] = 'e:'.get_userid();

$templates = null;
try {
    $tpl_query = new CmsLayoutTemplateQuery($filter);
    $templates = $tpl_query->GetMatches();
}
catch( Exception $e ) {
    // nothing here
}
if( count($templates) ) {
	$smarty->assign('templates',$templates);
	$tpl_nav = array();
	$tpl_nav['pagelimit'] = $tpl_query->limit;
	$tpl_nav['numpages'] = $tpl_query->numpages;
	$tpl_nav['numrows'] = $tpl_query->totalrows;
	$tpl_nav['curpage'] = (int)($tpl_query->offset / $tpl_query->limit) + 1;
	$smarty->assign('tpl_nav',$tpl_nav);
}

$designs = CmsLayoutCollection::get_all();
if( count($designs) ) {
    $smarty->assign('list_designs',$designs);
    $tmp = array();
    for( $i = 0; $i < count($designs); $i++ ) {
        $tmp['d:'.$designs[$i]->get_id()] = $designs[$i]->get_name();
        $tmp2[$designs[$i]->get_id()] = $designs[$i]->get_name();
    }
    $smarty->assign('design_names',$tmp2);
}

$types = CmsLayoutTemplateType::get_all();
$originators = array();
if( count($types) ) {
    $tmp = array();
    $tmp2 = array();
	$tmp3 = array();
    for( $i = 0; $i < count($types); $i++ ) {
        $tmp['t:'.$types[$i]->get_id()] = $types[$i]->get_langified_display_value();
        $tmp2[$types[$i]->get_id()] = $types[$i]->get_langified_display_value();
        $tmp3[$types[$i]->get_id()] = $types[$i];
		if( !isset($originators[$types[$i]->get_originator()]) ) {
			$originators['o:'.$types[$i]->get_originator()] = $types[$i]->get_originator(TRUE);
		}
    }
    $smarty->assign('list_all_types',$tmp3);
    $smarty->assign('list_types',$tmp2);
}

$smarty->assign('coretypename',CmsLayoutTemplateType::CORE);
$smarty->assign('manage_templates',$this->CheckPermission('Modify Templates'));
$smarty->assign('manage_designs',$this->CheckPermission('Manage Designs'));
$smarty->assign('has_add_right',
                $this->CheckPermission('Modify Templates') ||
                $this->CheckPermission('Add Templates'));

echo $this->ProcessTemplate('ajax_get_templates.tpl');
exit;

?>