<?php
require 'Exceptions/DataFileException.php';

/**
 * Class DataFile
 */
class DataFile
{
    protected $dataFile;
    protected $RawFile;
    protected $delimiter;
    protected $enclosure;

    /**
     * DataFile constructor.
     * @param RawFile $aRawFile
     */
    public function __construct(RawFile $aRawFile,$aDelimiter,$aEnclosure = null){
        $this->setRawFile($aRawFile);
        $this->setDelimiter($aDelimiter);
        $this->setEnclosure($aEnclosure);
        $this->parseFile();
    }

    /**
     * @param RawFile $aRawFile
     * @throws DataFileException
     */
    private function setRawFile(RawFile $aRawFile){
        if($aRawFile instanceof RawFile)
            $this->RawFile = $aRawFile;
        else
            throw new DataFileException("Object is not RawFile type");
    }

    /**
     * @param $delimiter
     */
    public function setDelimiter($delimiter){
        $this->delimiter = $delimiter;
    }

    /**
     * @param $enclosure
     */
    public function setEnclosure($enclosure){
        $this->enclosure = $enclosure;
    }

    /**
     * @return mixed
     */
    public function getDataFile(){
        return $this->dataFile;
    }

    /**
     *
     */
    private function parseFile(){
        $fileRows   = $this->RawFile->getFileRows();
        $finalData  = [];
        foreach($fileRows as $key => $data){
            $finalData[] = explode($this->delimiter,$data);
        }
        $this->dataFile = $finalData;
    }
}