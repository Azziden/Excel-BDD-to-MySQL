<?php

class csv
{
    private $db;

    function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;port=3308;dbname=trycvs;charset=utf8","root","Nasusmid80");
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
                    $sheetData[$i][0] === 'Détail' ? 'DETAIL' : 'DETAIL', // type
                    $sheetData[$i][1], // numero
                    $sheetData[$i][2], // intitule de la section
                    $sheetData[$i][3] === '' ? null : $sheetData[$i][3], // date fin
                    $sheetData[$i][4] === '' ? null : $sheetData[$i][4], // date debut
                    $sheetData[$i][5] === 'Proposition' ? 'PROPOSITION' : 'PROPOSITION', // statut
                    $sheetData[$i][7], // affectation
                    $sheetData[$i][8], // mois analy
                    $sheetData[$i][9], // titre
                    $sheetData[$i][10], // 01_07_2021
                    $sheetData[$i][11] // 30_06_2022
                ];
            }
                
            $chunked = array_chunk($data, 30);

            for($i = 0; $i < count($chunked); $i++) {
                $sql = "INSERT INTO `magazine` (`id`, `type`, `numero`, `intitule_de_la_section`, `date_de_fin`, `date_de_debut`, `statut`, `affectation`, `mois_analy`, `titre`, `01_07_2021`, `30_06_2022`)
                VALUES";

                for ($j=0; $j < count($chunked[$i]); $j++) { 
                    $sql .= " (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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