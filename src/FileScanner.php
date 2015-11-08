<?php
/*
 * (c) Florian Schuessel <fs@iprods.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iprods\Filesystem\Scanner;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

/**
 * Scan a directory for files.
 */
class FileScanner implements Scanner
{
    /**
     * Template for the name matching
     */
    const PHP_EXT_REGEX = '/^(?!.*###PATH_FILTER###).*\/(###PATTERN###)(###FILE_EXT_FILTER###)$/i';

    /**
     * Supported extensions
     * Can be overwritten by contructor
     */
    const FILE_EXT_FILTER = '\.php|\.hh';

    /**
     * The computed pattern
     *
     * @var string
     */
    private $pattern;

    /**
     * FileScanner constructor.
     *
     * @param string $pattern The relative pattern
     * @param array $pathFilter The filter for paths
     * @param string $fileExtFilter The filter for file extensions
     */
    public function __construct($pattern = '', array $pathFilter = ['Tests'], $fileExtFilter = self::FILE_EXT_FILTER)
    {
        $this->pattern = str_replace(
            ['###PATH_FILTER###', '###PATTERN###', '###FILE_EXT_FILTER###'],
            ['(?:' . implode('|', $pathFilter) . ')', $pattern, $fileExtFilter],
            self::PHP_EXT_REGEX
        );
    }

    /**
     * Scan the given directories for pattern and return all found matches
     *
     * @param array $directories The list of directories to scan
     *
     * @return array
     */
    public function scan(array $directories)
    {
        $dirs = array_map([$this, 'buildIterator'], $directories);
        $result = [];
        foreach ($dirs as $dir) {
            foreach ($dir as $file) {
                $result[] = $file;
            }
        }

        return $result;
    }

    /**
     * Build the iterator
     *
     * @param string $path The path to build the iterator for
     *
     * @return null|RegexIterator
     */
    private function buildIterator($path)
    {
        if (false === is_dir($path)) {
            return null;
        }
        return new RegexIterator(
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS)
            ),
            $this->pattern,
            RegexIterator::GET_MATCH
        );
    }
}
