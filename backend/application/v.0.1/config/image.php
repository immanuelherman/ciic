<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// only string allowed
$config = array();
// $config['base_path'] = rtrim(FCPATH, "/"); // no trailing slash
$base_path = "/workspace/web/efill/api";
$config['base_path'] = rtrim($base_path, "/"); // no trailing slash
$config['image_library'] = 'gd2';
$config['default_img_user'] = "/assets/users/profile/default/photo.jpg";
$config['default_img'] = "/assets/content/default/default_image.jpg";
$config['thumb_destination_path_profile'] = "/assets/users/profile/thumb";
$config['thumb_destination_path'] = "/assets/content/thumb";
$config['width'] = "width";
$config['height'] = "height";
$config['thumb'] = "thumb";
$config['create_thumb'] = TRUE;
$config['maintain_ratio'] = TRUE;
$config['default_width'] = 96;
$config['default_height'] = 96;
