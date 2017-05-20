<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
#####DEFAULT ROUTES VERSION########
$route['default_controller'] = 'Index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
## users 
$route['users/login']['post'] = 'Users/user_login';
$route['users/logout']['post'] = 'Users/user_logout';
$route['profile']['get'] = 'Users/user_profile';
$route['profile']['put'] = 'Users/update_profile';
$route['users/(:num)']['get'] = 'Users/user_list/$1';
$route['users/(:num)/picture']['get'] = 'Users/user_picture/$1';
$route['users/(:num)/permission']['get'] = 'Permission/user_permission/$1';
$route['users/(:num)']['put'] = 'Users/update_user_by_id/$1';
$route['users/(.+)']['delete'] = 'Users/delete_user_by_id/$1';
$route['users']['get'] = 'Users/user_list';
$route['users/count']['get'] = 'Users/user_count';
$route['users']['post'] = 'Users/create_user';
$route['users']['delete'] = 'Users/user_delete';

## files
$route['file/(:any)']['get'] = 'File/render/$1';
$route['file']['get'] = 'File/render_image_src';
$route['file_pdf/(:any)']['get'] = 'File_pdf/index/$1';

$route['common/genders']['get'] = 'Common/common_gender_list';

#role
$route['roles']['get'] = 'Roles/role_list';
$route['roles/count']['get'] = 'Roles/role_count';
$route['roles/(:any)']['get'] = 'Roles/role_list/$1';

## permissions
$route['permission']['get'] = 'Permission/user_permission';

// development phase only
$route['debug']['get'] = 'Debugger';