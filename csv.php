<?php

class csv
{
    private $db;

    function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=(Put_db_name);charset=utf8","root","");
    }

    public function import($file)
    {
        $reader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $data = [];
  
        if (!empty($sheetData)) {
            for ($i=1; $i<count($sheetData); $i++) { //skipping first row
                if ($sheetData[$i][0] === null) {
                    continue;
                }

                $data[] = [
                    $sheetData[$i][0], // column 1
                    $sheetData[$i][1], // column 2
                    $sheetData[$i][2], // column 3
                    $sheetData[$i][3] === '' ? null : $sheetData[$i][3], // column 4 if can be null
                    
                ];
            }
                
            $chunked = array_chunk($data, 30);

            for($i = 0; $i < count($chunked); $i++) {
                $sql = "INSERT INTO `magazine` (`id`, `type`, `something`, `something`, `date`)
                VALUES";

                for ($j=0; $j < count($chunked[$i]); $j++) { 
                    $sql .= " (NULL, ?, ?, ?, ?)";

                    if ($j != count($chunked[$i]) - 1) {
                        $sql .= ",";
                    }
                }

                $sql .= ";";

                $count = 0;
            
                $stmt = $this->db->prepare($sql);
                
                for ($j=0; $j < count($chunked[$i]); $j++) { 
                    for ($k=0; $k < count($chunked[$i][$j]); $k++) { 
                        $stmt->bindValue(++$count, $chunked[$i][$j][$k]);
                    }
                }

                $stmt->execute();
            }
        }
    }

}

?>
