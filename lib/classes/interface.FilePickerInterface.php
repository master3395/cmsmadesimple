<?php
namespace CMSMS;

interface FilePickerInterface
{
    public function get_default_profile();
    public function get_browser_url();
    public function get_html( $name, $value, \CMSMS\FilePickerProfile $profile );
} // end of class