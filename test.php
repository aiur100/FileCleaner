<?php
require 'RawFile.php';
require 'DataFile.php';

function correctIt($data,$refCount){
    $final = [];
    for($i = 0,$z = 0; $i < count($data); $i++,$z++){
        $row = $data[$i];
        if((count($row) < $refCount)){
            $row = array_merge($row,$data[$i + 1]);
            $row = array_filter($row, create_function('$value', 'return $value !== "\n";'));
            $i++;
        }
        $final[$z] = $row;
    }
    return $final;
}

function newFile($fileName,$data,$saveTo){
    $fp = fopen($saveTo.'/'.$fileName, 'w');
    foreach ($data as $fields) {
        fputs($fp, implode($fields, "\t"));
    }
    fclose($fp);
}


try{
    $file       = $argv[1];
    $saveTo     = $argv[2];
    echo 'File Requested: '.$file."\n";
    sleep(2);
    $RawFile        = new RawFile($file);
    $DataFile       = new DataFile($RawFile,"\t");
    $FileData       = $DataFile->getDataFile();
    $RefColCount    = count($FileData[0]);
    $i              = 0;
    $final          = correctIt($FileData,$RefColCount);
    //print_r($final);
    newFile("CLEANED_DCS.csv",$final,$saveTo);


}
catch(RawFileException $e){
    echo "\n ERROR:";
    echo $e->getMessage();
}
catch(Exception $e){
    echo "\n ERROR:";
    echo $e->getMessage();
}

