<?php

namespace App\Service;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class PollService
{
    private $_dbFile = "poll.json";
    private $_file;
    private $_fileSystem;
    private $_dbFolder = __DIR__.'/../Db';

    public function __construct()
    {
        $finder = new Finder();
        $this->_fileSystem = new Filesystem();
        $this->_file = $finder->files()->in($this->_dbFolder)->name($this->_dbFile);
    }

    public function getPoll()
    {
        foreach ($this->_file as $file) {
            $contents = $file->getContents();
        }
        return json_decode($contents, true);
    }

    public function setVote($votes)
    {
        $this->_fileSystem->dumpFile($this->_dbFolder.'/'.$this->_dbFile,$votes);
        return;
    }
}