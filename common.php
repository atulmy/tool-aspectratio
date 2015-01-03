<?php
require_once("includes/config.php");
function __autoload($sClassName) {
    if (file_exists(DEPLOY_PATH . 'classes/' . $sClassName . '.php')) {
        require_once(DEPLOY_PATH . 'classes/' . $sClassName . '.php');
    }
}
function closeDBConnections() {
    DbConn::closeConnections();
}
register_shutdown_function('closeDBConnections');

// common code

// get action for switch cases
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// set data for view
$dataArr["website"]["title"] = WEBSITE_TITLE;
$dataArr["website"]["description"] = 'Calculate aspect ratio online for images, display screens, montors and mobile easily';
$dataArr["website"]["keywords"] = 'calculate aspect ratio, calculate aspect ratio online, easily calculate aspect ratio, width height ratio';
