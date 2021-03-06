# Iprods Filesystem Scanner

[![Build Status](https://travis-ci.org/iprods/filesystem-scanner.svg?branch=master)](https://travis-ci.org/iprods/filesystem-scanner)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/iprods/filesystem-scanner/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/iprods/filesystem-scanner/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/iprods/filesystem-scanner/badges/build.png?b=master)](https://scrutinizer-ci.com/g/iprods/filesystem-scanner/build-status/master)

This small library aims to add some useful helpers for working with file systems.

## Installation

    composer require iprods/filesystem-scanner

## Usage

In order to use the path filtering you need to define what file name pattern to apply. 
Optionally you can add a filter for blacklisting paths (absolute or relative). It defaults to `Tests`.
Another option is to set the supported file extensions. This defaults to `.php` and `.hh`.

    $scanner = new \Iprods\Filesystem\Scanner\FileScanner('[^\/]+Bundle', ['Tests', 'App']);
    $info = $scanner->scan(['/path/to/scan', '/path/to/scan_too]);

`$info` will then contain a list of items consisting of:

* full path
* file name
* file extension

## License

This software is released under the MIT license (see included license file).

## Credits

Everyone who writes open source code and therefore lets other people use it and learn from it.
