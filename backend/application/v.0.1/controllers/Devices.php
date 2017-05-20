<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Devices extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('http', 'common', 'url', 'directory'));
    }

    public function find_scanner()
    {
        $devices = modules::run("Device_module/find_scanner");
        $status = 0;
        $keyword = "fujitsu";
        if (strpos($devices, $keyword) !== false) $status = 1;
        $devices = array(array('id' => 1, 'name' => $keyword, 'picture' => "/assets/content/default/fujitsu_ix500.jpg", 'status' => $status));
        response(200, array_merge(array("responseStatus" => "SUCCESS"), array('data'=> $devices)));
    }

    public function prepare_scan($agreement_id)
    {
        $basepath = "/workspace/web/efill/api/tmp";
        $map = directory_map($basepath);
        if (!empty($map))
        {
            response(200, array_merge(array("responseStatus" => "SUCCESS"), array("data" => array("message" => "Scanner is busy!"))));
        }
        $agreement_path = "$basepath/$agreement_id";
        $this->create_folder($agreement_path);
        
        response(200, array_merge(array("responseStatus" => "SUCCESS"), array("data" => array("message" => "Scanner start!"))));
    }

    public function scan_batch()
    {
        echo "start scanner";
        echo modules::run("Device_module/scan_batch");
        echo "stop scanner";
    }

    public function scan()
    {
        $devices = modules::run("Device_module/scan", $device_name, $format, $mode, $destination);
    }

    protected function create_folder($path)
    {
        if (!file_exists($path))
        {
            if (!mkdir($path, 0777, true)) {
                die('Failed to create folders...'.$path);
            }
        }
    }
}