<?php
    class SimpleCsv
    {
        public static function import($filePath, $delimiter = ";")
        {
            $data = false;
            ini_set('auto_detect_line_endings', true);
            if (is_file($filePath) AND is_readable($filePath)) {
                if (($handle = fopen($filePath, "r")) !== false) {
                    $data = array();
                    $cont =0;
                    while (($line = fgetcsv($handle, null, $delimiter)) !== false) {
                        $cont++;
                        $data[] = $line;
                        //echo " ".$line[0];
                    }
                }
            }
            return $data;
        }
        public static function export($data, $titulos = null, $tipo = 'objetc' ,$delimiter = ";")
        {
            ob_start();
            $fp = fopen("php://output", 'w');
            if($titulos){
                fputcsv($fp, $titulos, $delimiter, '"');
            }
            foreach ($data as $row) {
                if($tipo == 'objetc'){
                    fputcsv($fp, (array) $row, $delimiter, '"');
                }
                else if($tipo == 'enloquent'){
                    fputcsv($fp, $row['attributes'], $delimiter, '"');
                }
            }
            fclose($fp);
            //ob_get_clean();

            $filename = 'csv_' . date('Ymd') .'_' . date('His').'.csv';

            // Output CSV-specific headers
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename={$filename}");
            header("Content-Transfer-Encoding: binary");
             
            exit($result);
        }
    }

