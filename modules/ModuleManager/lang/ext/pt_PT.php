<?php
$lang['abouttxt']='Sobre';
$lang['accessdenied']='Acesso negado. Confira as suas permiss&otilde;es.';
$lang['action_activated']='M&oacute;dulo %s foi activado.';
$lang['action_installed']='M&oacute;dulo %s foi instalado ocm as seguintes mensagem(s): %s';
$lang['action_upgraded']='M&oacute;dulo %s foi actualizado.';
$lang['admindescription']='Uma ferramenta para recuperar e instalar m&oacute;dulos de servidores remotos.';
$lang['all_modules_up_to_date']='N&atilde;o existem mais novos m&oacute;dulos dispon&iacute;veis no reposit&oacute;rio';
$lang['available_updates']='M&oacute;dulos dispon&iacute;veis para a Actualiza&ccedil;&atilde;o';
$lang['availablemodules']='O actual estado de m&oacute;dulos dispon&iacute;veis a partir do actual reposit&oacute;rio';
$lang['availmodules']='M&oacute;dulos Dispon&iacute;veis';
$lang['back_to_module_manager']='&laquo; Voltar ao Gestor de M&oacute;dulos';
$lang['cantdownload']='N&atilde;o pode realizar o Download';
$lang['compatibility_disclaimer']='Os m&oacute;dulos aqui  exibidos foram contribu&iacute;dos tanto pelos desenvolvedores do CMS , e/ou terceiros independentes. N&oacute;s n&atilde;o damos nenhuma garantia de que os m&oacute;dulos dispon&iacute;veis aqui s&atilde;o funcionais, analisados, ou compat&iacute;vel com seu sistema. &Eacute; encorajado a ler as informa&ccedil;&otilde;es encontradas para nos ajudar &agrave; cerca de liga&ccedil;&otilde;es para cada m&oacute;dulo antes de tentar a instala&ccedil;&atilde;o.';
$lang['depend_activate']='M&oacute;dulo %s necessita de ser activado.';
$lang['depend_install']='M&oacute;dulo %s (vers&atilde;o %s ou posterior) necessita de ser instalado.';
$lang['depend_upgrade']='M&oacute;dulo %s necessita de ser actualizado para a vers&atilde;o %s.';
$lang['dependstxt']='Depend&ecirc;ncias';
$lang['download']='Download e Instala&ccedil;&atilde;o';
$lang['error']='Erro!';
$lang['error_checksum']='Erro. Provavelmente indica um arquivo corrompido, quer quando foi carregado para o reposit&oacute;rio, ou um problema de tr&aacute;fego para a sua m&aacute;quina.';
$lang['error_connectnomodules']='Embora a liga&ccedil;&atilde;o tenha sido feita para o m&oacute;dulo especificado. Parece que este reposit&oacute;rio ainda n&atilde;o est&aacute; a compartilhar os m&oacute;dulos';
$lang['error_minimumrepository']='A vers&atilde;o do reposit&oacute;rio n&atilde;o &eacute; compat&iacute;vel com este m&oacute;dulo de gest&atilde;o';
$lang['error_module_object']='Erro: N&atilde;o foi poss&iacute;vel obter uma inst&acirc;ncia do m&oacute;dulo  %s';
$lang['error_moduleinstallfailed']='A instala&ccedil;&atilde;o do M&oacute;dulo falhou';
$lang['error_nofilename']='Nenhum par&acirc;metro relactivo ao tamanho foi fornecido';
$lang['error_nofilesize']='Nenhum par&acirc;metro relactivo ao tamanho foi fornecido';
$lang['error_nomatchingmodules']='Erro: N&atilde;o foi poss&iacute;vel encontrar nenhuma correspond&ecirc;ncia dos m&oacute;dulos na pesquisar do reposit&oacute;rio ';
$lang['error_nomodules']='Erro: N&atilde;o foi poss&iacute;vel obter lista dos m&oacute;dulos instalados';
$lang['error_norepositoryurl']='O URL para o M&oacute;dulo Reposit&oacute;rio n&atilde;o foi especificado';
$lang['error_permissions']='<strong><em>AVISO:</em></strong> Insuficientes permiss&otilde;es nos diret&oacute;rios para instalar m&oacute;dulos. Tamb&eacute;m pode estar enfrentando problemas com PHP Safe Mode. Verifique se o modo seguro est&aacute; desativado, e o sistema de arquivos que t&ecirc;m permiss&otilde;es s&atilde;o suficientes.';
$lang['error_skipping']='Ignorar instala&ccedil;&atilde;o/actualiza&ccedil;&atilde;o do %s devido a erros na cria&ccedil;&atilde;o de depend&ecirc;ncias. Por favor, veja a(s) mensagem acima, e tente novamente.';
$lang['error_unsatisfiable_dependency']='N&atilde;o foi poss&iacute;vel encontrar o m&oacute;dulo obrigat&oacute;rio &quot;%s&quot; (vers&atilde;o %s ou posterior) no reposit&oacute;rio. &Eacute; exigido directamente por %s, o que poderia indicar um problema com a vers&atilde;o deste m&oacute;dulo no reposit&oacute;rio. Entre em contacto com o autor do m&oacute;dulo. Abortando.';
$lang['error_upgrade']='A actualiza&ccedil;&atilde;o do m&oacute;dulo %s falhou!';
$lang['friendlyname']='Gestor de M&oacute;dulos';
$lang['general_notice']='As vers&otilde;es aqui exibidas representam os &uacute;ltimos arquivos XML carregados e seleccionados no seu reposit&oacute;rio  (geralmente o CMS %s). Eles podem ou n&atilde;o representar as &uacute;ltimas vers&otilde;es dispon&iacute;veis. Poder&aacute;  querer visualizar os arquivos seleccionados, dispon&iacute;veis em vers&otilde;es no reposit&oacute;rio. Se estiver a usar o reposit&oacute;rio padr&atilde;o, pode faz&ecirc;-lo, digitando o nome do m&oacute;dulo na caixa de pesquisa do %s e clicar no bot&atilde;o &quot;Arquivos&quot;.';
$lang['help']='<h3>What Does This Do?</h3>
<p>A client for the ModuleRepository, this module allows previewing, and installing modules from remote sites without the need for ftping, or unzipping archives.  Module XML files are downloaded using SOAP, integrity verified, and then expanded automatically.</p>
<h3>How Do I Use It</h3>
<p>In order to use this module, you will need the &#039;Modify Modules&#039; permission, and you will also need the complete, and full URL to a &#039;Module Repository&#039; installation.  You can specify this url in the &#039;Extensions&#039; --&amp;gt; &#039;Module Manager&#039; --&amp;gt; &#039;Preferences&#039; page.</p><br/>
<p>You can find the interface for this module under the &#039;Extensions&#039; menu.  When you select this module, the &#039;Module Repository&#039; installation will automatically be queried for a list of it&#039;s available xml modules.  This list will be cross referenced with the list of currently installed modules, and a summary page displayed.  From here, you can view the descriptive information, the help, and the about information for a module without physically installing it.  You can also choose to upgrade or install modules.</p>
<h3>Support</h3>
<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>
<h3>Copyright and License</h3>
<p>Copyright &amp;copy; 2006, calguy1000 <a href="mailto:calguy1000@hotmail.com">&amp;lt;calguy1000@hotmail.com&amp;gt;</a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>
<h3>Tradu&ccedil;&atilde;o Portuguesa</h3>
<p>Copyright &copy; 2008, Nuno Costa <nuno.mfcosta@sapo.pt>.</p>';
$lang['helptxt']='Ajuda';
$lang['incompatible']='Incompativel';
$lang['install']='instalar';
$lang['install_submit']='Instalar';
$lang['install_with_deps']='Avaliar todas as depend&ecirc;ncias e instalar';
$lang['installed']='M&oacute;dulo vers&atilde;o %s instalado.';
$lang['instcount']='M&oacute;dulos actualmente instalados';
$lang['mod_name_ver']='%s vers&atilde;o %s';
$lang['moddescription']='Um cliente para o ModuleRepository, este m&oacute;dulo permite a visualiza&ccedil;&atilde;o, e a instala&ccedil;&atilde;o de m&oacute;dulos a partir de locais remotos, sem a necessidade de ftping, ou unzipping de arquivos. M&oacute;dulo com arquivos XML s&atilde;o baixados usando SOAP, integridade verificada e, em seguida, expande-se automaticamente.';
$lang['msg_nodependencies']='Este arquivo n&atilde;o tem quaisquer depend&ecirc;ncias enumeradas';
$lang['nametext']='M&oacute;dulo Nome';
$lang['newerversion']='Vers&atilde;o mais recente instalada';
$lang['newversions']='M&oacute;dulos instalados';
$lang['notice']='Aviso';
$lang['notice_depends']='%s depende das ac&ccedil;&otilde;es a seguir. Clique em &quot;Instalar&quot; para proseguir.';
$lang['onlynewesttext']='Mostrar somente a vers&atilde;o mais recente';
$lang['postinstall']='M&oacute;dulo Manager foi instalado com &ecirc;xito.';
$lang['postuninstall']='M&oacute;dulo Manager foi desinstalado. Utilizadores deixar&atilde;o de ter a possibilidade de instalar m&oacute;dulos dos reposit&oacute;rios remotos. No entanto, a instala&ccedil;&atilde;o local ainda &eacute; poss&iacute;vel.';
$lang['preferences']='Prefer&ecirc;ncias';
$lang['preferencessaved']='Prefer&ecirc;ncias salvas';
$lang['prompt_dl_chunksize']='Download tamanho (Kb)';
$lang['prompt_otheroptions']='Outras Op&ccedil;&otilde;es';
$lang['prompt_repository_url']='Module Repository URL:';
$lang['prompt_resetcache']='Redefinir o cache local do reposit&oacute;rio de dados';
$lang['prompt_reseturl']='Redefinir URL para o padr&atilde;o';
$lang['prompt_settings']='Configura&ccedil;&otilde;es';
$lang['really_uninstall']='Tem certeza de que deseja desinstalar? Ficar&aacute; em falta um grande n&uacute;mero de funcionalidades.';
$lang['repositorycount']='M&oacute;dulos encontrados no reposit&oacute;rio';
$lang['reset']='Redefinir';
$lang['sizetext']='Tamanho (Kilobytes)';
$lang['statustext']='Estado/Ac&ccedil;&atilde;o';
$lang['submit']='Submeter';
$lang['text_dl_chunksize']='A quantidade m&aacute;xima de dados para download a partir do servidor em uma &uacute;nica vez (quando instalar um m&oacute;dulo)';
$lang['text_repository_url']='O URL deve estar no formato
http://www.mycmssite.com/path/soap.php?module=ModuleRepository';
$lang['time_warning']='A lista de instala&ccedil;&atilde;o tem mais de um ou dois m&oacute;dulos. Esteja ciente de que a instala&ccedil;&atilde;o pode demorar alguns minutos. Por favor, seja paciente!';
$lang['title_installation']='Instala&ccedil;&atilde;o';
$lang['title_installation_complete']='Processo de instala&ccedil;&atilde;o foi completa!';
$lang['uninstalled']='M&oacute;dulos Desinstalado';
$lang['unknown']='Desconhecido';
$lang['upgrade']='Actualizar';
$lang['upgrade_available']='Vers&atilde;o mais recente dispon&iacute;vel (%s), a actual instalada &eacute; (%s)';
$lang['upgraded']='M&oacute;dulo actualizado vers&atilde;o %s';
$lang['uptodate']='Instalado';
$lang['use_at_your_own_risk']='Use por sua conta e risco';
$lang['vertext']='Vers&atilde;o';
$lang['xmltext']='Arquivo XML';
?>