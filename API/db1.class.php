<?php

class db {
    /*     * * Declare instance ** */

    private static $instance = NULL;

    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */
    private function __construct() {
        /*         * * maybe set the db name here later ** */
    }

    /**
     *
     * Return DB instance or create intitial connection
     *
     * @return object (PDO)
     *
     * @access public
     *
     */
    public static function getInstance() {

        if (!self::$instance) {
//            self::$instance = new PDO("mysql:host=10.0.0.2;dbname=vnpt_card", 'pokervmg_tk', 'Z2bLevYRuLtnY');
            self::$instance = new PDO("mysql:host=127.0.0.1;port=3307;dbname=vnpt_card", 'megatron', 'optimus2771983');
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }

    /**
     *
     * Like the constructor, we make __clone private
     * so nobody can clone the instance
     *
     */
    private function __clone() {
        
    }

}

/* * * end of class ** */
$db = db::getInstance();
$db->query("SET NAMES 'utf8'");
?>
