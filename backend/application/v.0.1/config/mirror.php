<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// only string allowed
$config = array();
// acquiring permission
$config['root_folder'] = rtrim(FCPATH, "/"); // no trailing slash
$config['acquiring_permission']['dir_flag'] = $config['root_folder'];

// on handle process
$config['on_handle_process']['max_task'] = 10;
$config['on_handle_process']['path_upload_file'] = 'protected/cctv/recording';
$config['on_handle_process']['path_video_recorder_log'] = 'temp/on_handle_process/task_log';
$config['on_handle_process']['path_video_file_destination'] = "protected/cctv/result/video";
$config['on_handle_process']['path_thumb_file_destination'] = "protected/cctv/result/thumb";
$config['on_handle_process']['max_file_each_task'] = 3;
$config['on_handle_process']['min_files_to_process'] = 1; // security issue. if only one recording. then don't process. set FALSE to force process
$config['on_handle_process']['order_file_to_process'] = 'ASC';
$config['on_handle_process']['remove_original_file'] = TRUE;
$config['on_handle_process']['desired_thumbnail_format'] = 'jpg';
$config['on_handle_process']['desired_video_format'] = 'mp4';

$config['structure']['filename'][] = 'serial_number';
$config['structure']['filename'][] = 'channel';
$config['structure']['filename'][] = 'stream';
$config['structure']['filename'][] = 'start_date';
$config['structure']['filename'][] = 'end_date';