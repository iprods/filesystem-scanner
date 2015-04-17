<?php

/**
 * Scan a directory for PHP files.
 */
class DirectoryScanner
{
    const PHP_EXT_REGEX = '/^.+###PATTERN###(\.php|\.hh)$/i';

    private $pattern;

    public function __construct($pattern = '')
    {
        $this->pattern = str_replace('###PATTERN###', $pattern, self::PHP_EXT_REGEX);
    }
    
    public function scan(array $directories)
    {
        $files = new \AppendIterator();
        $dirs = array_map([$this, 'buildIterator'], $directories);
        //array_map(array($files, 'append'), array_map([$this, 'buildIterator'], $directories));
        foreach ($dirs as $dir) {
            foreach ($dir as $file) {
                var_dump($file);
            }
        }
    }

    private function buildIterator($path)
    {
        if (false === realpath($path)) {
            return null;
        }
        return new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS)
            ),
            $this->pattern,
            \RegexIterator::GET_MATCH
        );
    }
}
