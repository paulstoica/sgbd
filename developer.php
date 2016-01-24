<?php

define('BASE_PATH', dirname(__FILE__));

if (!function_exists('pr')) {

    function pr($p_mData, $p_bReturn = false, $p_sBeginsWith = null, $forcePrint = true) {
        if (!$forcePrint) {
            //return false;
        }
        if (defined('__SUMMIT_IS_AJAX_REQUEST') && __SUMMIT_IS_AJAX_REQUEST === true) {
            return false;
        }
        $l_aUseData = $p_mData;
        if (is_array($p_mData) && !empty($p_sBeginsWith)) {
            $l_aUseData = array();
            foreach ($p_mData as $l_sKey => $l_mValue) {
                if (strpos($l_sKey, $p_sBeginsWith) === 0) {
                    $l_aUseData[$l_sKey] = $l_mValue;
                }
            }
        }
        if (PHP_SAPI === 'cli') {
            if (!$p_bReturn) {
                print_r($l_aUseData);
                return;
            }
            return print_r($l_aUseData, true);
        }
        if (!$p_bReturn) {
            echo '<div style="font-weight: normal; font-size: 12px; color: black; overflow: auto; padding: 3px; background-color: #ffffff; text-align: left;border: 1px dashed red; display: block; margin-bottom: 5px;"><pre style="margin: 0px 0px;">' . print_r($l_aUseData, true) . '</pre></div>';
        }
        return '<div style="font-weight: normal; font-size: 12px; color: black; overflow: auto; padding: 5px; background-color: #ffffff; text-align: left;border: 1px dashed red; display: block; margin-bottom: 5px;"><pre>' . print_r($l_aUseData, true) . '</pre></div>';
    }

}


if (!function_exists('l')) {

    function l($p_mData, $p_bReturn = false) {

        $logFile = BASE_PATH . "/log/debug.log";
        $file = null;
        
        if (!file_exists($logFile)) {
            $file = fopen($logFile, 'a');
        }
        
        $date = date('m/d/Y-h:i:s: ', time());
        
        error_log($date.print_r($p_mData, true). "\n", 3, $logFile);
        
        if ($file) {
            fclose($file);
        }
    }
}


