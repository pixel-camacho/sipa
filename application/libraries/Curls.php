<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class curls
{
     public function __construct()
    {
        require_once(str_replace("\\", "/", APPPATH) . 'libraries/curl/curl.php'); //If we are executing this script on a Windows server
    }
}
?>