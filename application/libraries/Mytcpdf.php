<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Class MY_Form_validation
 */

require_once APPPATH . 'third_party/tcpdf/tcpdf.php';
class Mytcpdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
    }
}