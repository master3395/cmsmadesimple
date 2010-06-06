<?php
class ClearCacheTask implements CmsRegularTask
{
  const  LASTEXECUTE_SITEPREF   = 'ClearCache_lastexecute';
  const  CACHEDFILEAGE_SITEPREF = 'auto_clear_cache_age';


  public function get_name()
  {
    return lang('clearcache_taskname');
  }


  public function get_description()
  {
    return lang('clearcache_taskdescription');
  }


  public function test($time = '')
  {
    $age_days = (int)get_site_preference(self::CACHEDFILEAGE_SITEPREF,0);
    if( $age_days == 0 ) return FALSE;

    // do we need to do this task.
    // we only do it daily.
    if( !$time ) $time = time();
    $last_execute = get_site_preference(self::LASTEXECUTE_SITEPREF,time());
    if( ($time - 24*60*60*$age_days) >= $last_execute )
      {
	return TRUE;
      } 
    return FALSE;
  }


  public function execute($time = '')
  {
    if( !$time ) $time = time();
    
    // do the task.
    $age_days = (int)get_site_preference(self::CACHEDFILEAGE_SITEPREF,0);
    global $gCms;
    $gCms->clear_cached_files($age_days);
    return TRUE;
  }


  public function on_success($time = '')
  {
    if( !$time ) $time = time();
    set_site_preference(self::LASTEXECUTE_SITEPREF,$time);
  }


  public function on_failure($time = '')
  {
    if( !$time ) $time = time();
    // nothing here.
  }
}

?>