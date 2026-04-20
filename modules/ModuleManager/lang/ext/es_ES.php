<?php
$lang['abouttxt']='Acerca de';
$lang['accessdenied']='Acceso Denegado. Comprueba los permisos.';
$lang['action_activated']='Se ha activado el m&oacute;dulo %s.';
$lang['action_installed']='Se ha instalado el m&oacute;dulo %s con el siguiente mensaje(s) : %s';
$lang['action_upgraded']='Se ha actualizado el m&oacute;dulo %s';
$lang['admindescription']='Una herramienta para instalar m&oacute;dulos desde servidores remotos.';
$lang['advancedsearch_help']='Especificar palabras para incluir o excluir de la b&uacute;squeda usando + o -, rodee las frases exactas entre comillas, por ejemplo +manzana -roja &quot;alg&uacute;n texto&quot;';
$lang['all_modules_up_to_date']='No existen m&oacute;dulos m&aacute;s nuevos en el repositirio';
$lang['available_updates']='M&oacute;dulos disponibles para actualizar. Antes de actualizar, lea las notas de la versi&oacute;n en el Forge y cree una copia de respaldo del sitio web. ';
$lang['availablemodules']='El estado actual de m&oacute;dulos disponibles en el repositorio actual';
$lang['availmodules']='M&oacute;dulos Disponibles';
$lang['back_to_module_manager']='&amp;#171; Regresar al Administrador de M&oacute;dulos';
$lang['cantdownload']='No se puede Descargar';
$lang['compatibility_disclaimer']='Los m&oacute;dulos que se muestran aqu&iacute; han sido aportados tanto por los desarrolladores del CMS como por terceras partes independientes. No se garantiza que los m&oacute;dulos disponibles sean funcionales, est&eacute;n comprobados o sean compatibles con su sistema. Se recomienda que, antes de instalar un m&oacute;dulo, lea la informaci&oacute;n ayuda y los enlaces &#039;acerca de&#039; correspondientes.';
$lang['depend_activate']='Se activar&aacute; el m&oacute;dulo %s.';
$lang['depend_install']='Se instalar&aacute; el m&oacute;dulo %s (versi&oacute;n %s).';
$lang['depend_upgrade']='Se actualizar&aacute; el m&oacute;dulo %s a la versi&oacute;n %s.';
$lang['dependstxt']='Dependencias';
$lang['download']='Descargar e Instalar';
$lang['error']='&iexcl;Error!';
$lang['error_checksum']='Error de suma de comprobaci&oacute;n (checksum). Probablemente se deba a un archivo con errores, producidos cuando su subi&oacute; &eacute;ste al repositorio o cuando se estaba descargando a su m&aacute;quina. (Se esperaba % y se ha obtenido %s.)';
$lang['error_connectnomodules']='Aunque se conect&oacute; correctamente al repositorio especificado, parece que este repositorio ya no comparte ning&uacute;n m&oacute;dulo';
$lang['error_downloadxml']='Ha ocurrido un problema al bajar el archivo XML: %s';
$lang['error_internal']='Error Interno... Informe al administrador del sistema';
$lang['error_minimumrepository']='La versi&oacute;n del repositorio no es compatible con este gestor de m&oacute;dulos';
$lang['error_module_object']='Error: no se pudo obtener una instancia de el m&oacute;dulo %s ';
$lang['error_moduleinstallfailed']='Ha fallado la instalaci&oacute;n del m&oacute;dulo';
$lang['error_nofilename']='No se ha especificado el nombre del archivo';
$lang['error_nofilesize']='No se ha especificado el tama&ntilde;o del archivo';
$lang['error_nomatchingmodules']='Error: no se pudieron encontrar m&oacute;dulos similares en el repositorio';
$lang['error_nomodules']='Error: no se pudo obtener la lista de m&oacute;dulos instalados';
$lang['error_norepositoryurl']='No se ha especificado la URL del Repositorio del M&oacute;dulo';
$lang['error_noresults']='Se esperaban obtener algunos resultados de las operaciones pendientes, pero no se ha encontrado nada. Intente reproducir el problema y proporcione informaci&oacute;n suficiente al personal de soporte para su diagn&oacute;stico';
$lang['error_permissions']='<strong><em>AVISO></em></strong> Los permisos de directorio son insuficientes para instalar los m&oacute;dulos.  Puede que tambi&eacute;n tenga problemas con el &#039;modo seguro&#039; de PHP (PHP Safe mode).  Aseg&uacute;rese de que el &#039;modo seguro&#039; est&aacute; desactivado, y de que los permisos del sistema de archivo son los adecuados.';
$lang['error_request_problem']='Ha ocurrido una problema al comunicar con el servidor de m&oacute;dulos';
$lang['error_search']='Error de b&uacute;squeda';
$lang['error_searchterm']='Especificar un termino v&aacute;lido para iniciar la busqueda';
$lang['error_skipping']='Se cortado la instalaci&oacute;n/actualizaci&oacute;n de %s debido a errores al configurar las dependencias. Lea el mensaje de arriba e int&eacute;ntelo de nuevo.';
$lang['error_unsatisfiable_dependency']='No se puede encontrar el modulo requerido &quot;%s&quot; (versi&oacute;n %s o superior) en el repositorio. %s lo requiere; esto podr&iacute;a indicar un problema con la versi&oacute;n de este m&oacute;dulo en el repositorio. Contacte con el autor del m&oacute;dulo. Abortando...';
$lang['error_upgrade']='&iexcl;La actualizaci&oacute;n del modulo %s ha fallado!';
$lang['friendlyname']='Gestor de M&oacute;dulos';
$lang['general_notice']='Las versiones mostradas aqu&iacute; representan los archivos XML mas recientes que se han sido subido al repositorio seleccionado (normalmente CMS %s). Puede ser o no las versiones m&aacute;s recientes disponibles.';
$lang['help']='<h3>&iquest;Que Hace Esto?</h3>
<p>Este m&oacute;dulo, que es un cliente para el Repositorio de M&oacute;dulos, permite efectuar una vista previa de m&oacute;dulos e instalarlos desde sitios remotos sin la necesidad de hacer ftp, ni descomprimir archivos.  Los archivos XML de los m&oacute;dulos son descargados usando SOAP y, tras comprobar su integridad, se descomprimen autom&aacute;ticamente.</p>
<h3>Como lo Puedo Usar</h3>
<p>Para usar este m&oacute;dulo necesita el permiso &#039;Modificar M&oacute;dulos&#039;. Tambi&eacute;n necesita toda la URL completa de un &#039;Repositorio de M&oacute;dulos&#039;. Puede indicar esta url en la p&aacute;gina &#039;Extensiones&#039; --&amp;gt; &#039;Gestor de m&oacute;dulos&#039; --&amp;gt; &#039;Preferencias&#039;.</p><br/>
<p>Puede encontrar la interfaz de este m&oacute;dulo en el men&uacute; &#039;Extensiones&#039;.  Cuando selecciona este m&oacute;dulo, a la instalaci&oacute;n del &#039;Repositorio de M&oacute;dulo&#039; se le pedir&aacute; una lista de los m&oacute;dulos xml disponibles.  Esta lista ser&aacute; cruzada con la lista de los m&oacute;dulos que ya est&aacute;n instalados, y se mostrar&aacute; una p&aacute;gina con el resumen de esta comprobaci&oacute;n. Aqu&iacute; podr&aacute; ver la descripci&oacute;n, la ayuda, y la informaci&oacute;n &#039;acerca de&#039; de cualquier m&oacute;dulo sin necesidad  instalarlo f&iacute;sicamente. Tambi&eacute;n podr&eacute; elegir si instala o actualiza el m&oacute;dulo.</p>
<h3>Soporte</h3>
<p>De acuerdo con GPL, este software se proporciona tal como es. Lea el texto de la licencia para conocer la exenci&oacute;n de responsabilidad completa.</p>
<h3>Derechos de autor and Licencia</h3>
<p>Copyright &amp;copy; 2006, calguy1000 <a href="mailto:calguy1000@hotmail.com">&amp;lt;calguy1000@hotmail.com&amp;gt;</a>. Todos los derechos reservados.</p>
<p>Este m&oacute;dulo ha sido publicado bajo la licencia <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. Tiene la traducci&oacute;n al espa&ntilde;ol en <a href="http://www.gnu.org/licenses/licenses.html#GPL">Licencia P&uacute;blica General de GNU</a>. Debe de estar de acuerdo con esta licencia antes de usar el m&oacute;dulo.</p>';
$lang['helptxt']='Ayuda';
$lang['incompatible']='Incompatible ';
$lang['info_disable_caching']='<strong>No recomendado</strong>.  Por motivos de rendimiento, ModuleManager almacenar&aacute; en cach&eacute; (por defecto una hora) gran cantidad de la informaci&oacute;n recibidad desde el servidor remoto';
$lang['info_latestdepends']='Si instala un m&oacute;dulo que tenga dependencias, esta opci&oacute;n asegura que se instale la &uacute;ltima versi&oacute;n de la dependencia';
$lang['install']='instalar';
$lang['install_submit']='Instalar';
$lang['install_with_deps']='Evaluar todas las dependencias e instalar';
$lang['installed']='M&oacute;dulo versi&oacute;n %s instalado.';
$lang['instcount']='M&oacute;dulos ya instalados';
$lang['latestdepends']='Siempre instalar los m&oacute;dulos m&aacute;s recientes';
$lang['mod_name_ver']='%s versi&oacute;n %s';
$lang['moddescription']='Un cliente para el M&oacute;dulo Repositorio, este m&oacute;dulo permite pre-visualizar e instalar m&oacute;dulos desde sitios remotos sin usar ftp o descomprimir archivos. Los archivos XML de los M&oacute;dulos se descargan usando SOAP, se verifica su integridad y luego se descomprimen autom&aacute;ticamente.';
$lang['msg_nodependencies']='Este archivo no tiene referenciada ninguna dependencia';
$lang['nametext']='Nombre del M&oacute;dulo';
$lang['newerversion']='Versi&oacute;n nueva instalada';
$lang['newversions']='Actualizaciones Disponibles';
$lang['notice']='Aviso';
$lang['notice_depends']='%s tiene dependencias sin resolver. Para poder instalar este m&oacute;dulo, se tienen que realizar las siguientes acciones';
$lang['onlynewesttext']='Mostrar s&oacute;lo la versi&oacute;n m&aacute;s nueva';
$lang['operation_results']='Resultados de la Operaci&oacute;n';
$lang['postinstall']='El Gestor de M&oacute;dulos se ha instalado correctamente.';
$lang['postuninstall']='Se ha desinstalado el Gestor de M&oacute;dulos. No se podr&aacute;n instalar m&oacute;dulos desde los repositorios remotos, aunque todav&iacute;a es posible la instalaci&oacute;n local.';
$lang['preferences']='Preferencias';
$lang['preferencessaved']='Preferencias guardadas';
$lang['prompt_advancedsearch']='B&uacute;squeda avanzada';
$lang['prompt_disable_caching']='Deshabilitar el almacenamiento en cach&eacute; de las peticiones del servidor';
$lang['prompt_dl_chunksize']='Tama&ntilde;o del bloque de Descarga (Kb)';
$lang['prompt_otheroptions']='Otras Opciones';
$lang['prompt_repository_url']='URL del Repositorio';
$lang['prompt_resetcache']='Resetear la cach&eacute; local del repositorio';
$lang['prompt_reseturl']='Restaurar a la URL por defecto';
$lang['prompt_settings']='Opciones';
$lang['really_uninstall']='&iquest;Est&aacute; seguro de que quiere desinstalar el m&oacute;dulo? Va a perder mucha funcionalidad.';
$lang['repositorycount']='M&oacute;dulos encontrados en el repositorio';
$lang['reset']='Resetear';
$lang['search']='Buscar';
$lang['search_input']='Campo de b&uacute;squeda';
$lang['search_noresults']='La busqueda no encontro resultados con los terminos proporcionados';
$lang['search_results']='Resultados de la b&uacute;squeda';
$lang['searchterm']='T&eacute;rmino de b&uacute;squeda';
$lang['sizetext']='Tama&ntilde;o (Kilobytes)';
$lang['statustext']='Estado/Acci&oacute;n';
$lang['submit']='Enviar';
$lang['text_dl_chunksize']='La cantidad m&aacute;xima de datos que se pueden descargar en un bloque desde el servidor (cuando se instala un m&oacute;dulo)';
$lang['text_repository_url']='La URL debe tener el formato http://www.misitio.com/ruta/soap.php?module=ModuleRepository';
$lang['time_warning']='Se tienen que realizar dos o m&aacute;s acciones. Tenga en cuenta que la instalaci&oacute;n puede tardar varios minutos; sea paciente.';
$lang['title_installation']='Instalaci&oacute;n';
$lang['title_installation_complete']='&iexcl;La actualizaci&oacute;n ha finalizado!.';
$lang['uninstalled']='M&oacute;dulo Desinstalado.';
$lang['unknown']='Desconocido';
$lang['upgrade']='Actualizar';
$lang['upgrade_available']='Nueva versi&oacute;n disponible (%s), versi&oacute;n instalada: (%s)';
$lang['upgraded']='M&oacute;dulo actualizado a versi&oacute;n %s.';
$lang['uptodate']='Instalado';
$lang['use_at_your_own_risk']='&Uacute;selo bajo su propia responsabilidad';
$lang['versionsformodule']='Versiones disponibles del m&oacute;dulo %s';
$lang['vertext']='Versi&oacute;n';
$lang['xmltext']='Archivo XML';
$lang['yourversion']='Su Versi&oacute;n';
?>