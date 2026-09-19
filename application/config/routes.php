<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'amuraOS';
$route['404_override'] = '';

// Rotas Amura OS
$route['sistema'] = 'amuraOS/index';
$route['sistema/alternarTema'] = 'amuraOS/alternarTema';
$route['sistema/configurar'] = 'amuraOS/configurar';
$route['sistema/emitente'] = 'amuraOS/emitente';
$route['sistema/backup'] = 'amuraOS/backup';
$route['sistema/minhaConta'] = 'amuraOS/minhaConta';
$route['sistema/alterarSenha'] = 'amuraOS/alterarSenha';
$route['sistema/uploadUserImage'] = 'amuraOS/uploadUserImage';
$route['sistema/emails'] = 'amuraOS/emails';
$route['sistema/excluirEmail'] = 'amuraOS/excluirEmail';
$route['sistema/editarLogo'] = 'amuraOS/editarLogo';
$route['sistema/editarEmitente'] = 'amuraOS/editarEmitente';
$route['sistema/cadastrarEmitente'] = 'amuraOS/cadastrarEmitente';
$route['sistema/pesquisar'] = 'amuraOS/pesquisar';
$route['sistema/calendario'] = 'amuraOS/calendario';
$route['sistema/atualizarBanco'] = 'amuraOS/atualizarBanco';
$route['sistema/atualizarSistema'] = 'amuraOS/atualizarMapos';
$route['sistema/restaurarBackup'] = 'amuraOS/restaurarBackup';
$route['sistema/aplicarPacoteAtualizacao'] = 'amuraOS/aplicarPacoteAtualizacao';
$route['sistema/(:any)'] = 'amuraOS/$1';
$route['mapos/(:any)'] = 'amuraOS/$1';
$route['mapos'] = 'amuraOS/index';

// Rotas da API
if (filter_var($_ENV['API_ENABLED'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
    require APPPATH . 'config/routes_api.php';
}

/* End of file routes.php */
/* Location: ./application/config/routes.php */
