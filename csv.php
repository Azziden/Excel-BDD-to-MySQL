<?php

class csv extends mysqli
{

    function __construct()
    {

        parent::__construct("localhost","root","Nasusmid80","trycvs","3308");
        if($this->connect_error) {
            echo "Fail to connect to DataBase : ". $this-> connect_error;
        }
    }

    public function import($file)
    {
        $file = fopen($file, 'r');
        while ($row = fgetcsv($file)) {
            print "<pre>";
            print_r($row);
            print "</pre>";

        }

    }

}

?>