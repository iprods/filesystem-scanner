<?php
/*
 * (c) Florian Schuessel <fs@iprods.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Iprods\Filesystem\Scanner;

/**
 * Interface for file system scanners.
 */
interface Scanner
{
    /**
     * Scan the given paths and return the found matches.
     *
     * @param array $paths
     *
     * @return array
     */
    public function scan(array $paths);
}
