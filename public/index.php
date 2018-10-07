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
class csv
{
    static public function getRecords($filename)
    {
        $file =fopen($filename,'r');
        $fields = array();
        $count = 0;
        while(! feof($file))
        {
            $record = fgetcsv($file);
            if ($count == 0) {
                $fields = $record;
            }
            else
            {
                $records[] = recordFactory::create($fields, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}
class record
{
    public function __construct(Array $fieldNames = null, Array $value = null)
    {
        $record = array_combine($fieldNames, $value);
        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }
    }
    public function createProperty($name, $value)
    {
        $this->{$name} = $value;
        $name = '<th>' . $name . '</th>';
        $value = '<td>' . $value . '</td>';
    }
