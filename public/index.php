<?php
/**
 * Created by PhpStorm.
 * User: rohan
 * Date: 9/25/18
 * Time: 9:34 PM
 */
main::start('example.csv');
class main{
    static public function start($filename){
        $records = csv::getRecords($filename);
        $table =html::createTable($records);
        system::printPage($table);
    }
}
