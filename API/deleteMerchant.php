<?php

require('../Config.php');
require('db.class.php');
$id = $_POST['id'];
$sql = "DELETE FROM `merchants` WHERE `merchants`.`id` = $id";
$db->exec($sql);