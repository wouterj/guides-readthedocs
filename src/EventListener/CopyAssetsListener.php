<?php

/*
 * This file is part of the ReadTheDocs package.
 *
 * (c) Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WouterJ\ReadTheDocs\EventListener;

use phpDocumentor\Guides\Event\PostRenderProcess;

final class CopyAssetsListener
{
    public function __invoke(PostRenderProcess $event): void
    {
        if ('html' !== $event->getCommand()->getOutputFormat()) {
            return;
        }

        $filesystem = $event->getCommand()->getDestination();
        foreach (glob(__DIR__.'/../../resources/templates/rtd/assets/{*,*/*}/*', GLOB_BRACE) as $filename) {
            if (is_dir($filename)) {
                continue;
            }

            $path = substr($filename, strpos($filename, 'rtd/assets') + 3);
            $filesystem->put($path, file_get_contents($filename));
        }
    }
}
