<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_pdf extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('http', 'permission', 'common'));
        $this->load->database();
        $this->output->enable_profiler(FALSE);
    }

	public function index($file)
    {
        header("Content-type:application/pdf");
        $data = file_get_contents("/workspace/web/efill/api/docs/scan/pdf/$file");
        echo $data;
    }
}


