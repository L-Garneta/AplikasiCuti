<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/third_party/fpdf/fpdf.php';

class Pdf extends FPDF
{
    function __construct()
    {
        parent::__construct();
    }
}