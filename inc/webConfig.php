<?php
/**
 * 定義各目錄及資料庫參數的常數
 */
// 定義網站目錄的設定

define("WEB_DIR", dirname(dirname(__FILE__)));
define("INCLUDE_DIR", WEB_DIR.'/inc/');
define("WEB_ROOT", dirname(__FILE__) . '/');

// 定義資料庫的設定
define("DB_HOST", 'localhost');
define("DB_USER", 'enccom');
define("DB_PASSWORD", '!@#enccom');
define("DB_DATABASE", 'enccom_eeee');

?>