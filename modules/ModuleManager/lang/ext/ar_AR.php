<?php
$lang['advancedsearch_help']='Specify words to include or exclude from the search using a + or -, surround exact phrases with quotes.  i.e:  +red -apple +&quot;some text&quot;';
$lang['back_to_module_manager']='&laquo; Return to Module Manager';
$lang['error_noresults']='We expected some results to be available from queued operations, but none were found.  Please try to reproduce this experience, and provide sufficient information to support personell for diagnoses';
$lang['error_unsatisfiable_dependency']='Cannot find the required module &quot;%s&quot; (version %s or later) in the repository. It is directly required by %s; this could indicate a problem with the version of this module in the repository. Please contact the module&#039;s author. Aborting.';
$lang['help']='<h3>What Does This Do?</h3>
<p>A client for the ModuleRepository, this module allows previewing, and installing modules from remote sites without the need for ftping, or unzipping archives.  Module XML files are downloaded using REST, integrity verified, and then expanded automatically.</p>
<h3>How Do I Use It</h3>
<p>In order to use this module, you will need the &#039;Modify Modules&#039; permission, and you will also need the complete, and full URL to a &#039;Module Repository&#039; installation.  You can specify this url in the &#039;Extensions&#039; --> &#039;Module Manager&#039; --> &#039;Preferences&#039; page.</p><br/>
<p>You can find the interface for this module under the &#039;Extensions&#039; menu.  When you select this module, the &#039;Module Repository&#039; installation will automatically be queried for a list of it&#039;s available xml modules.  This list will be cross referenced with the list of currently installed modules, and a summary page displayed.  From here, you can view the descriptive information, the help, and the about information for a module without physically installing it.  You can also choose to upgrade or install modules.</p>
<h3>Support</h3>
<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>
<h3>Copyright and License</h3>
<p>Copyright &copy; 2006, calguy1000 <a href="mailto:calguy1000@hotmail.com"><calguy1000@hotmail.com></a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>';
$lang['prompt_settings']='إعدادات';
$lang['search']='بحث';
$lang['search_results']='نتائج البحث';
$lang['submit']='تقديم';
$lang['text_repository_url']='The URL should be in the form http://www.mycmssite.com/ModuleRepository/request/v2 (assuming pretty urls are enabled on the repository server)';
?>