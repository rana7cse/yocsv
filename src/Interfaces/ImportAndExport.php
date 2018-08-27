<?php
namespace MsRana\YoCsv\Interfaces;

interface ImportAndExport
{
    public function read($file);
    public function write($file,$data = null,$options = []);
}