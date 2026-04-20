<ul>
<li>Version 1.0. 10 January 2006. Initial Release.</li>
<li>Version 1.1. July, 2006. Released with the 1.0- beta</li>
<li>Version 1.1.1 August, 2006.  Require 1.0.1 of nuSOAP</li>
<li>Version 1.1.2 September, 2006.  Fixed a mistake that resulted in upgrade not not working at all</li>
<li>Version 1.1.3 September, 2006.
  <ul>
  <li>Bumped minimum CMS Version to 1.0</li>
  <li>Now use 1 request to get the complete list of modules from the repository</li>
  <li>Added some missing lang strings</li>
  <li>Added the ability to reset the local cache of repository information</li>
  <li>Added the ability to restore the repository url to factory defaults</li>
  </ul>
</li>
<li>Version 1.1.4 February, 2007.  Now handles the safe mode check, and disables upgrading or installing modules if the permissions are wrong.</li>
<li>Version 1.1.5 September, 2007. New preference to make only latest module version show. Added nice message after saving preferences</li>
</li>
<li>Version 1.1.6 May, 2008. Now show if available modules are incompatible with the current CMS_VERSION.</li>
</li>
<li>Version 1.2 June, 2008.<br />
This version should reduce the memory requirements of this module, and trade it off for performance on the server, and more requests to the server.
   <ul>
    <li>Bumped Minimum CMS Version to 1.3</li>
    <li>Bumped Minimum repository version to 1.1</li>
    <li>Get rid of all of the session stuff</li>
    <li>Add support for requesting modules beginning with a prefix (usually a single letter)</li>
    <li>Add support for requesting only the newest versions of the modules</li>
   </ul>
</li>
<li>Version 1.2.1 August, 2008.<br />
Added a warning message to the top of the admin display.
</li>
<li>Version 1.3 May, 2009.<br />
Added dependency checking.
</li>
<li>Version 1.3.3 March, 2010.<br />
<ul>
  <li>PHP 5.x improvements (specifically remove warnings for PHP 5.3)</li>
  <li>Minor bug fixes.</li>
</ul>
</li>
<li>Version 1.4 June, 2010.<br />
<ul>
  <li>Implemented automatic dependency calculation, and one-click installation.</li>
  <li>Assorted usability improvements.</li>
  <li>Minor bug fixes.</li>
</ul>
<li>Version 1.5  - July, 2011
<ul>
  <li>Changes to REST API.. No longer uses nuSOAP.</li>
  <li>Many optimizations to downloading and installing modules.</li>
  <li>Can now install older versions of modules easily.</li>
  <li>Handle automatic upgrading of ddependencies.</li>
</ul>
</li>
<li>Version 2.1.11 April, 2026
<ul>
  <li>Raised minimum CMS Made Simple version to 2.2.17 (aligns with core releases that support PHP 8.x reliably; this module is hardened for PHP 8).</li>
  <li>Reference for upstream v2.1.10 changes: <a href="https://github.com/cmsmadesimple/cmsmadesimple/pull/23" target="_blank">PR #23</a>.</li>
  <li>Updated default repository endpoint and added fallback checks for both API and WWW repository URLs.</li>
  <li>Fixed &quot;Available Modules&quot; and related repository calls: server-side requests use the API gateway only (the CDN host can block PHP/curl traffic with HTTP 403). The module list now retries the known API and WWW bases if the stored URL fails.</li>
  <li>When the database still records a higher Module Manager version than the files on disk, opening Module Manager now aligns the stored version, clears module cache, and redirects once so the Installed list shows the correct version (fixes persistent &quot;Database Version Newer&quot; after a file downgrade).</li>
  <li>Added recovery-safe settings rendering to ensure repository URL can always be edited.</li>
  <li>Added beta/pre-release visibility setting, repository request method compatibility updates, and module icon UI updates.</li>
  <li>Hardened module list/search flows for PHP 8 by avoiding non-array `count()` calls in admin listing actions.</li>
  <li>Fixed search term session persistence key (`modmgr_searchterm`) so search values are retained correctly.</li>
  <li>Improved cached repository response handling to safely recover from invalid cache payloads and re-fetch cleanly.</li>
  <li>Replaced placeholder search form defaults in admin modules tab with proper localized labels.</li>
  <li>Extended PHP 8 compatibility hardening across upgrade/dependency/install flows to avoid unsafe `count()` usage on non-arrays.</li>
  <li>Fixed repository multi-module info validation by throwing the missing-parameter exception when no valid records are generated.</li>
  <li>Improved dependency error fallback handling to avoid undefined offset notices when remote responses are malformed.</li>
  <li>Hardened ModuleManager tab-state handling to prevent malformed active-tab keys from forcing incorrect tab rendering.</li>
  <li>Normalized Settings redirects and removed duplicate tab parameters that could cause sticky or polluted prefs URLs.</li>
  <li>Added a guarded Settings-content fallback render path with debug marker support for environments where page_content can remain blank.</li>
</ul>
</li>
</ul>