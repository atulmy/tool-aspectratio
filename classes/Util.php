<?php

final class Util {

    private static $affiliateArr = null;

    /**
     *  _construct constructs the Instance of Class
     */
    private function __construct() {
        
    }

    /**
     * printArr converts the array data in XML format
     * @param Array $dataArr contains the data which want to convert in XML
     * <p>This function converts the array data in XML format</p>
     * @return void
     */
    public static function printArr($dataArr) {
        echo '<pre>';
        print_r($dataArr);
        echo '</pre>';
    }

    /**
     * viewTransform transform the user on to specified view file
     * @param Array $dataArr contains the data
     * @param String $viewFile contains the name of viewfile
     * <p>This function transform the user on to specified view file</p>
     * @return void
     */
    public static function viewTransform(array $dataArr, $viewFile) {
        if (isset($_GET['debug'])) {
            if ($_GET['debug'] == 1)
                self::printArr($dataArr);
            exit;
        }
        if (strlen($viewFile) < 1) {
            $viewFile = 'index.view.php';
        }
        header("Content-type: text/html; charset=utf-8");
        include_once('view/' . $viewFile . '.view.php');
    }

    /**
     * viewTransformJson transform the user on to specified view file in the form of JSON
     * @param Array $dataArr contains the data
     * @param String $viewFile contains the name of viewfile
     * <p>This function transform the user on to specified view file in the form of JSON</p>
     * @return void
     */
    public static function viewTransformJson(array $dataArr, $viewFile) {
        if (isset($_GET['debug'])) {
            if ($_GET['debug'] == 1)
                self::printArr($dataArr);
            exit;
        }
        if (strlen($viewFile) < 1) {
            $viewFile = 'index.view.php';
        }
        header("Content-type: application/json");
        include_once('view/' . $viewFile . '.view.php');
    }

    /**
     * viewTransformXML transform XML into specified view
     * @param Array $dataArr contains the data
     * @param String $viewFile contains the name of viewfile
     * <p>This function transform XML into specified view</p>
     * @return void
     */
    public static function viewTransformXML(array $dataArr, $viewFile) {
        if (isset($_GET['debug'])) {
            if ($_GET['debug'] == 1)
                self::printArr($dataArr);
            exit;
        }
        if (strlen($viewFile) < 1) {
            $viewFile = 'index.view.php';
        }
        header("Content-type: text/xml");
        include_once('view/' . $viewFile . '.view.php');
    }

    /**
     * viewTransformCSV transform CSV into specified view
     * @param Array $dataArr contains the data
     * @param String $viewFile contains the name of viewfile
     * <p>This function transform CSV into specified view</p>
     * @return void
     */
    public static function viewTransformCSV(array $dataArr, $viewFile) {
        if (isset($_GET['debug'])) {
            if ($_GET['debug'] == 1)
                self::printArr($dataArr);
            exit;
        }
        if (strlen($viewFile) < 1) {
            $viewFile = 'index.view.php';
        }
        header("Content-type: application/octet-stream");
        header("Content-disposition: attachment; filename=" . $dataArr['filename']);
        include_once('view/' . $viewFile . '.view.php');
    }

    public static function processRequest($requestStr) {
        //$ext = pathinfo($requestStr, PATHINFO_EXTENSION);
        //if($ext != "") $requestStr = str_replace(".".$ext, "/", $requestStr);
        $args = explode("/", $requestStr);
        $page = array_shift($args);
        $action = array_shift($args);
        return array($page, $action);
    }

    public static function getRequestVals($requestStr) {
        //$ext = pathinfo($requestStr, PATHINFO_EXTENSION);
        //if($ext != "") $requestStr = str_replace(".".$ext, "/", $requestStr);
        $args = explode("/", $requestStr);
        $page = array_shift($args);
        $action = array_shift($args);
        return $args;
    }

    public static function getRequestValsId($requestStr) {
        $args = explode("/", $requestStr);
        $page = array_shift($args);
        $action = array_shift($args);
        if (!empty($args)) {
            $id = $args[0];
        } else {
            $id = 0;
        }
        return $id;
    }

    public static function htmlStringTransfrom(array $dataArr, $viewFile) {
        if (isset($_GET['debug'])) {
            if ($_GET['debug'] == 1)
                self::printArr($dataArr);
            exit;
        }
        if (strlen($viewFile) < 1) {
            return '';
        }
        $htmlString = '';
        ob_start();
        include_once('view/' . $viewFile . '.view.php');
        $htmlString = ob_get_contents();
        ob_clean();
        ob_end_clean();
        return $htmlString;
    }

    public static function mailTransform(array $dataArr, $emailFile) {
        if (isset($_GET['debug'])) {
            if ($_GET['debug'] == 1)
                self::printArr($dataArr);
            exit;
        }
        if (strlen($emailFile) < 1) {
            return '';
        }
        $emailHTML = '';
        ob_start();
        include(DEPLOY_PATH . 'emails/' . $emailFile . '.view.php');
        $emailHTML = ob_get_contents();
        ob_clean();
        ob_end_clean();
        return $emailHTML;
    }

    /**
     * sendEmail process & send the email to required person
     * @param String $to contains the email id of receiver of the mail
     * @param String $toName contains the name of receiver of the mail
     * @param String $from contains the email of sender of the mail
     * @param String $fromName contains the name of sender of the mail
     * @param String $subject contains the subject of the mail
     * @param String $mailContent contains the message of the mail
     * <p>This function process & send the email to required person</p>
     * @return Boolean [Returns TRUE if the mail was successfully accepted for delivery, FALSE otherwise. ]
     */
    public static function sendEmail($to, $toName, $from, $fromName, $subject, $mailContent) {
        ini_set('sendmail_from', $from);

        $headers = 'From: ' . $fromName . '<' . $from . '>' . PHP_EOL;
        $headers .= 'Reply-To: ' . FROM_NAME . '<' . FROM_EMAIL . '>' . PHP_EOL;
        $headers .= 'Return-Path: ' . $from . PHP_EOL;
        $headers .= 'X-Mailer: Fermion/' . phpversion() . PHP_EOL;
        $headers .= 'MIME-Version: 1.0' . PHP_EOL;
        $headers .= "Content-Type: text/html; utf-8 " . PHP_EOL;

        return mail($to, $subject, $mailContent, $headers, '-r ' . $from);
    }

    /**
     * isAjax check that specified request is ajax request or not
     * <p>This function check that specified request is ajax request or not</p>
     * @return Boolean [True or False]
     */
    public static function isAjax() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    /**
     * isGuid check that specified ID is GUID or not
     * @param String $guid contains the UID which want to check
     * <p>This function check that specified ID is GUID or not</p>
     * @return Boolean [True or False]
     */
    public static function isGuid($guid) {
        return preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $guid);
    }

    /**
     * getControllerAction gets the action performed by the controller
     * @param String $default contains the default action which will perform if action is not set by controller
     * <p>This function gets the action performed by the controller, if action is set then gets this action otherwise sets the default action</p>
     * @return String [Controller Action]
     */
    public static function getControllerAction($action, $default = '') {
        if (strlen($action) > 0) {
            return $action;
        }
        $action = (isset($_GET['action']) && strlen($_GET['action']) > 0) ? $_GET['action'] : '';
        if ($action == '') {
            $action = (isset($_POST['action']) && strlen($_POST['action']) > 0) ? $_POST['action'] : $default;
        }
        return strtolower($action);
    }

    /**
     * validateEmail checks that Username is valid or not
     * @param String $email contains the email which want to validate
     * <p>This function compaire the specified email with regular expression & check that email is valid or not</p>
     * @return String [validated Email]
     */
    public static function validateEmail($email) {
        return preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", $email);
    }

    /**
     * br2nl replace all HTML <br> to the PHP \n new line format
     * @param String $string contains the text message in which new line want to add
     * <p>This function replace all HTML <br> to the PHP \n new line format</p>
     * @return String [Converted String]
     */
    public static function br2nl($string) {
        return preg_replace('/<br\\s*?\/??>/i', '', $string);
    }

    /**
     * nonxmlcharreplace replace all non xml characters from a given string
     * @param String $str contains the text message
     * <p>This function replace all non xml characters from a given string</p>
     * @return String [Converted String]
     */
    public static function nonxmlcharreplace($str) {
        $string = preg_replace('/[^a-zA-Z0-9\-]/', '-', $str);
        $newstr = preg_replace('/\-\-+/', '-', strtolower($string));
        return $newstr;
    }

    /**
     * nonxmlcharreplaceTitle replace non XML characters as a string
     * @param String $str contains the text
     * <p>This function replace non XML characters as a string</p>
     * @return String [Converted String]
     */
    public static function nonxmlcharreplaceTitle($str) {
        $string = preg_replace('/[^a-zA-Z0-9\[\]\(\)\'\-\/:,;!$@%&]/', ' ', $str);
        $newstr = preg_replace('/\s\s+/', ' ', $string);
        return $newstr;
    }

    /**
     * getHashKey Converts the Key as Hash Key
     * @param String $key contains the Key String
     * <p>This function first check is key equls 0, if yes then returns 0 otherwise converts key in hash key</p>
     * @return String [Either 0 or Hash Key]
     */
    public static function getHashKey($key) {
        if ($key == 0) {
            return 0;
        } else {
            return $key % HASH_KEY_SPLIT;
        }
    }

    /**
     * setCookie sets new cookie containing specified cookie data
     * @param String $cookieName contains the name of Cookie
     * @param String $cookieData contains the value of Cookie
     * @param String $validity contains the validity of Cookie
     * <p>This function sets new cookie containing specified cookiename , cookiedata & it's validity</p>
     * @return void
     */
    public static function setCookie($cookieName, $cookieData, $validity = 0) {
        if ($validity > 0) {
            setcookie($cookieName, self::encryptData($cookieData), time() + $validity, '/');
        } else {
            setcookie($cookieName, self::encryptData($cookieData), 0, '/');
        }
    }

    /**
     * getCookie gets cookie containing specified cookie data
     * @param String $cookieName contains the name of Cookie
     * <p>This function check cookie is set or not if set then gets the cookie value otherwise false</p>
     * @return String [Cookie Value]
     */
    public static function getCookie($cookieName) {
        if (isset($_COOKIE[$cookieName]))
            return @self::decryptData($_COOKIE[$cookieName]);
        else
            return false;
    }

    /**
     * encryptData encrypts the specified data
     * @param String $data contains the String to encrypt
     * <p>This function encrypts the specified data</p>
     * @return String [Encrypted Data]
     */
    public static function encryptData($data) {
        return strrev(base64_encode($data));
    }

    /**
     * decryptData decrypts the specified encrypted data
     * @param String $data contains the String to decrypt
     * <p>This function decrypts the specified encrypted data</p>
     * @return String [Decrypted Data]
     */
    public static function decryptData($data) {
        return base64_decode(strrev($data));
    }

    /**
     * rupeesFormat converts the data into the rupees format
     * @param String $data contains the String to convert
     * <p>This function converts the data into the rupees format</p>
     * @return String [Data converted in Rupees Format]
     */
    public static function rupeesFormat($data) {
        return number_format($data, 2, '.', ',');
    }

    /**
     * toXML converts the string or array data in the form of XML
     * @param String $array contains the array of data
     * @param String $tag contains main starting tag of XML
     * @param String $subTag contains sub tag of XML
     * <p>This function converts the string or array data in the form of XML by calling ia2xml method</p>
     * @return XML [Returns data in the form of XML]
     */
    public static function toXml($array, $tag, $subTag) {
        return '<' . $tag . '>' . self::ia2xml($array, $subTag) . '</' . $tag . '>';
    }

    /**
     * ia2xml converts the string or array data in the form of XML
     * @param String $array contains the array of data
     * @param String $subTag contains sub tag of XML
     * <p>This function converts the string or array data in the form of XML</p>
     * @return XML [Returns data in the form of XML]
     */
    public static function ia2xml($array, $subTag) {
        $xml = '';
        foreach ($array as $key => $value) {
            $key = is_string($key) ? $key : $subTag;
            $key = str_replace(' ', '_', $key);
            if (is_array($value)) {
                $xml .= '<' . $key . '>' . self::ia2xml($value, $subTag) . '</' . $key . '>';
            } else {
                if (is_string($value)) {
                    $xml .= '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>';
                } else {
                    $xml .= '<' . $key . '>' . $value . '</' . $key . '>';
                }
            }
        }
        return $xml;
    }

    /**
     * getDurationInDays gets the duration
     * @param String $startDate contains the starting date
     * @param String $endDate contains the ending date
     * <p>This function gets the difference in between the startDate & endDate in days</p>
     * @return INT [ Duration in Days]
     */
    public static function getDurationInDays($startDate, $endDate = '') {
        if ($endDate == '') {
            $endDate = date('Y-m-d');
        }
        return ceil((strtotime($endDate) - strtotime($startDate)) / 86400);
    }

    /**
     * getDate converts the current provided date in proper format
     * @param String $dateStr contains the String date
     * @param String $format contains the date patterns
     * <p>This function gets the date in String format & converts it in proper specified format</p>
     * @return String [Date]
     */
    public static function getDate($dateStr, $format = '') {
        $dateStr = str_replace('/', '-', $dateStr);
        if ($format == '') {
            $format = 'd-m-Y';
        }
        try {
            return date_format(date_create($dateStr), $format);
        } catch (Exception $e1) {
            try {
                return date($format, strtotime($dateStr));
            } catch (Exception $e2) {
                
            }
        }
        return date($format);
    }

    /**
     * getDateAdvanceDays gets the date of advance days
     * @param String $dateStr contains the String date
     * @param INT $noOfDays contains number of days to increase in current date
     * @param String $format contains format of date
     * <p>This function gets gets the date of advance days</p>
     * @return String [Date]
     */
    public static function getDateAdvanceMonths($dateStr, $noOfMonths, $format = '') {
        if ($format == '') {
            $format = 'd-m-Y';
        }
        return date($format, strtotime("+$noOfMonths month", strtotime($dateStr)));
    }

    /**
     * getDateAdvanceDays gets the date of advance days
     * @param String $dateStr contains the String date
     * @param INT $noOfDays contains number of days to increase in current date
     * @param String $format contains format of date
     * <p>This function gets gets the date of advance days</p>
     * @return String [Date]
     */
    public static function getDateAdvanceDays($dateStr, $noOfDays, $format = '') {
        if ($format == '') {
            $format = 'd-m-Y';
        }
        return date($format, strtotime("+$noOfDays days", strtotime($dateStr)));
    }

    /**
     * getDateTime24 gets the date 24 hours format
     * @param String $dateStr contains the date in string format
     * <p>This function gets the date in 24 hours format</p>
     * @return String [Date]
     */
    public static function getDateTime24($dateStr) {
        return date('d-m-Y H:i:s', strtotime($dateStr));
    }

    /**
     * getDateTime24 gets the date 12 hours format
     * @param String $dateStr contains the date in string format
     * <p>This function gets the date in 12 hours format</p>
     * @return String [Date]
     */
    public static function getDateTime12($dateStr) {
        return date('d-m-Y h:i:s a', strtotime($dateStr));
    }

    /**
     * getPreviousDayDate gets the previous date of a specified date
     * @param String $date contains the date in string format
     * <p>This function gets the previous date of a specified date</p>
     * @return String [Date]
     */
    public static function getPreviousDayDate($date = '') {
        if ($date == '') {
            $date = date('Y-m-d');
        }
        return date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($date)), date('d', strtotime($date)) - 1, date('Y', strtotime($date))));
    }

    /**
     * getNextDayDate gets the Next date of a specified date
     * @param String $date contains the date in string format
     * <p>This function gets the Date of next Day of the specified date</p>
     * @return String [Date]
     */
    public static function getNextDayDate($date = '') {
        if ($date == '') {
            $date = date('Y-m-d');
        }
        return date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($date)), date('d', strtotime($date)) + 1, date('Y', strtotime($date))));
    }

    /**
     * dateToMysql gets date to mysql date
     * @param String $date contains the date in string format
     * <p>This function gets date to mysql date</p>
     * @return String [Date]
     */
    public static function dateToMysql($date, $suffix = ' 00:00:00') { // date to mysql date
        $date = str_replace('/', '-', $date);
        if (strlen($date) > 0) {
            try {
                return date_format(date_create($date), 'Y-m-d') . $suffix;
            } catch (Exception $e1) {
                try {
                    return date('Y-m-d', strtotime($date)) . $suffix;
                } catch (Exception $e2) {
                    
                }
            }
        }
        return '0000-00-00 00:00:00';
    }

    /**
     * mysqlToDateTime gets mysql date to date
     * @param String $date contains the date in string format
     * <p>This function gets date to mysql date to date</p>
     * @return String [Date]
     */
    public static function mysqlToDateTime($date) { // mysql date to date
        $date = str_replace('/', '-', $date);
        if (strlen($date) > 0) {
            try {
                return date_format(date_create($date), 'd-m-Y H:i:s');
            } catch (Exception $e1) {
                try {
                    return date('d-m-Y H:i:s', strtotime($date));
                } catch (Exception $e2) {
                    
                }
            }
        }
        return '';
    }

    /**
     * mysqlToDate converts mysql date string to a normal date string
     * @param String $date contains the date in string format
     * <p>This function converts mysql date string to a normal date string</p>
     * @return String [Date]
     */
    public static function mysqlToDate($date) { // mysql date to date
        if (strlen($date) > 0 && $date != '0000-00-00 00:00:00') {
            try {
                return date_format(date_create($date), 'd-m-Y');
            } catch (Exception $e1) {
                try {
                    return date('d-m-Y', strtotime($date));
                    ;
                } catch (Exception $e2) {
                    
                }
            }
        }
        return '';
    }

    /**
     * getCurrentTimeInMillisecond gets the current time in milliseconds
     * <p>This function returns the current time in milliseconds</p>
     * @return INT [Milliseconds]
     */
    public static function getCurrentTimeInMillisecond() {
        list($timestamp, $sec) = explode(" ", microtime());
        $timestamp += $sec;
        $timestamp = str_replace('.', '', $timestamp);
        return $timestamp;
    }

    /**
     * replaceNonAscii replace the the non ASCII string from given String Variable
     * @param String $val contains the text
     * <p>This function replace the the non ASCII string from given String Variable</p>
     * @return String
     */
    public static function repalceNonAscii($val) {
        $val = preg_replace('/[^(\x20-\x7F)]*/', '', $val);
        return $val;
    }

    /**
     * getFirstOfMonth gets the first date of current month
     * @param String $format contains the format of date
     * <p>This function gets the first date of current month</p>
     * @return String [Date]
     */
    public static function getFirstOfMonth($format = 'Y-m-d 00:00:00') {
        return date($format, strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
    }

    /**
     * getLastOfMonth gets the last date of current month
     * @param String $format contains the format of date
     * <p>This function gets the last date of current month</p>
     * @return String [Date]
     */
    public static function getLastOfMonth($format = 'Y-m-d 00:00:00') {
        return date($format, strtotime('-1 second', strtotime('+1 month', strtotime(date('Y') . '-' . date('m') . '-01' . ' 00:00:00'))));
    }

    /**
     * getFirstDayofWeek gets the date of first day from current week
     * @param String $format contains the format of date
     * <p>This function gets the date of first day from current week</p>
     * @return String [ Date ]
     */
    public static function getFirstDayofWeek($format = 'Y-m-d 00:00:00') {
        $currentDateofWeek = date('w');
        return self::getDateAdvanceDays(date('Y-m-d'), $currentDateofWeek * (-1), $format);
    }

    /**
     * getLastDayofWeek gets the date of last day from current week
     * @param String $format contains the format of date
     * <p>This function gets the date of last day from current week</p>
     * @return String [ Date ]
     */
    public static function getLastDayofWeek($format = 'Y-m-d 00:00:00') {
        $currentDateofWeek = date('w');
        return self::getDateAdvanceDays(date('Y-m-d'), 6 - $currentDateofWeek, $format);
    }

    /**
     * getTodaysDateStartofDay gets the todays date
     * @param String $format contains the format of date
     * <p>This function gets the todays date, current date</p>
     * @return String [ Date ]
     */
    public static function getTodaysDateStartofDay($format = 'Y-m-d 00:00:00') {
        return Util::getDate(date('Y-m-d'), $format);
    }

    /**
     * getTomorrowsDate gets the date of next day
     * @param String $format contains the format of date
     * <p>This function gets the date of next day</p>
     * @return String [ Date ]
     */
    public static function getTomorrowsDate($format = 'Y-m-d 00:00:00') {
        Util::getDate(Util::getDateAdvanceDays(date('Y-m-d'), 1, 'Y-m-d 00:00:00'), $format);
    }

    /**
     * getTodaysDateLastMinute gets the current date last minute
     * @param String $format contains the format of date
     * <p>This function gets the current date last minute</p>
     * @return String [ Date ]
     */
    public static function getTodaysDateLastMinute($format = 'Y-m-d 23:59:59') {
        return Util::getDate(date('Y-m-d'), $format);
    }

    /**
     * array_to_csv converts the array data into CSV file
     * @param Array $array contains the data which want to store in CSV file
     * @param Boolean $header_row contains true or false
     * @param String $col_sep contains separator of string
     * @param String $row_sep contains separator of rows
     * @param String $qut contains double quotation marks
     * <p>This function converts the array data into CSV file</p>
     * @return String
     */
    public static function array_to_csv($array, $header_row = true, $col_sep = ",", $row_sep = "\n", $qut = '"') {
        if (!is_array($array) or ! is_array($array[0]))
            return false;

        $output = '';
        //Header row.
        if ($header_row) {
            foreach ($array[0] as $key => $val) {
                //Escaping quotes.
                $key = str_replace($qut, "$qut$qut", $key);
                $output .= "$col_sep$qut$key$qut";
            }
            $output = substr($output, 1) . "\n";
        }
        //Data rows.
        foreach ($array as $key => $val) {
            $tmp = '';
            foreach ($val as $cell_key => $cell_val) {
                //Escaping quotes.
                $cell_val = str_replace($qut, "$qut$qut", $cell_val);
                $tmp .= "$col_sep$qut$cell_val$qut";
            }
            $output .= substr($tmp, 1) . $row_sep;
        }
        return $output;
    }

    public static function removeDirectory($dir) {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file)
                continue;
            if (is_dir("$dir/$file"))
                rmdir_recursive("$dir/$file");
            else
                unlink("$dir/$file");
        }
        rmdir($dir);
    }

    public static function curlCall($url, $postStr = '') {
        $response = '';
        if ($url != '') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            if ($postStr != '') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postStr);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        return $response;
    }

    public static function booleanString($boolvalue) {
        return ($boolvalue) ? 'true' : 'false';
    }

}

?>