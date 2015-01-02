<?php
require_once("common.php");
switch ($action) {
    default:
        $viewFile = 'index';
        break;
}
 
Util::viewTransform($dataArr, $viewFile);
?>