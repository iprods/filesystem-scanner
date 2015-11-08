<?php
/*
 * (c) Florian Schuessel <fs@iprods.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Iprods\Filesystem\Scanner;

use Iprods\Filesystem\Scanner\FileScanner;
use Iprods\Filesystem\Scanner\Scanner;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin FileScanner
 */
class FileScannerSpec extends ObjectBehavior
{
    /**
     * @var vfsStreamDirectory
     */
    private $fileSystem;

    public function __construct()
    {
        $this->fileSystem = vfsStream::setup('root', null, [
            'Acme' => [
                'AppBundle' => [
                    'AcmeAppBundle.php' => '',
                ],
            ],
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileScanner::class);
    }

    function it_implements_the_scanner_interface()
    {
        $this->shouldHaveType(Scanner::class);
    }

    function it_should_return_one_result_when_scanning_directory_tree()
    {
        $this->beConstructedWith('[^\/]+Bundle');
        $this->scan([$this->fileSystem->url()])->shouldReturn([[
            'vfs://root/Acme/AppBundle/AcmeAppBundle.php',
            'AcmeAppBundle',
            '.php'
        ]]);
    }

    function it_should_return_an_empty_result_list_if_pattern_is_not_matching()
    {
        $this->beConstructedWith('[^\/]+Something');
        $this->scan([$this->fileSystem->url()])->shouldReturn([]);
    }

    function it_should_return_an_empty_result_list_if_the_result_path_is_filtered()
    {
        $this->beConstructedWith('[^\/]+Bundle', ['Acme']);
        $this->scan([$this->fileSystem->url()])->shouldReturn([]);
    }

    function it_should_return_an_empty_result_list_if_the_file_extension_is_filtered()
    {
        $this->beConstructedWith('[^\/]+Bundle', [], '\.exe');
        $this->scan([$this->fileSystem->url()])->shouldReturn([]);
    }
}
