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
}
class recordFactory{
    public static function create (array $fieldNames=null , array $value=null){
        $record =new record ($fieldNames,$value);
        return $record;
    }
}
class html{
    public static function createTable($array)
    {
        echo "<html lang=\"en\">
<head>
  <title>Bootstrap Example</title>
  <meta charset=\"utf-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
  <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
  <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
</head>
</html>";
        // start table
        $html = '<table class="table table-striped">';
        // header row
        $html .= '<tr>';
        foreach($array[0] as $key=>$value){
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr>';
        // data rows
        foreach( $array as $key=>$value){
            $html .= '<tr>';
            foreach($value as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }
        // finish table and return it
        $html .= '</table>';
        return $html;
    }
}
class system {
    public static function printPage($page){
        echo $page;
    }
}

