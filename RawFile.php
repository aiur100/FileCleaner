<?php
require 'Exceptions/RawFileException.php';
/**
 * Class RawFile
 */
class RawFile
{
    protected $fileRows;
    private $validFileError = "Data requested does not exist or hasn't been set";

    /**
     * RawFile constructor.
     * @param string $filePathAndName
     */
    public function __construct($filePathAndName = ""){
        $this->setFileRowsArray($filePathAndName);
    }

    /**
     * @param string $filePathAndName
     */
    private function setFileRowsArray($filePathAndName = ""){
        if(is_file($filePathAndName)){
            $this->fileRows = file($filePathAndName);
        }
        else
            throw new RawFileException("File not found.");
    }

    /**
     * checks to see if the requested data exists.
     *
     * @param $rowNumber
     * @return bool
     */
    private function validRowRequestCheck($rowNumber){
        if(is_array($this->fileRows)
                && array_key_exists($rowNumber,$this->fileRows)){
            return true;
        }
        else
            return false;
    }

    /**
     * @return bool
     */
    private function validDataRequest(){
        if(is_array($this->fileRows))
            return true;
        else
            return false;
    }

    /**
     * @param int $rowNumber
     */
    public function getRow($rowNumber = 0){
        if($this->validRowRequestCheck($rowNumber))
            return $this->fileRows[$rowNumber];
        else
            throw new RawFileException($this->validFileError);
    }

    /**
     * @param null|string $rowData - enter row string data
     */
    public function setRow($rowNumber = 0,$rowData = null){
        if($this->validRowRequestCheck($rowNumber))
            $this->fileRows[$rowNumber] = $rowData;
        else
            throw new RawFileException($this->validFileError);
    }

    /**
     * @return mixed
     * @throws RawFileException
     */
    public function getFileRows(){
        if(isset($this->fileRows) && is_array($this->fileRows))
            return $this->fileRows;
        else
            throw new RawFileException($this->validFileError);
    }

    /**
     * @return string
     * @throws RawFileException
     */
    public function getFileRowsAsJson(){
        if($this->validDataRequest())
            return json_encode($this->fileRows);
        else
            throw new RawFileException($this->validFileError);
    }

}