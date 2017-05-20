<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('http', 'common', 'url'));
    }

    public function render($file_id)
    {
        $this->load->database();
        
        $file_detail = modules::run("File_module/get_file_detail", $file_id);
        if ($file_detail->type == "image")
        {
            modules::run("File_module/render_image", $file_detail);
        }
        else if ($file_detail->type == "video")
        {
            modules::run("File_module/render_video", $file_detail);
        }
    }

    public function render_image_src()
    {
        modules::run("File_module/render_image_src");
    }
}