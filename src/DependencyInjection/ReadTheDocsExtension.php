<?php

/*
 * This file is part of the ReadTheDocs package.
 *
 * (c) Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WouterJ\ReadTheDocs\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use WouterJ\ReadTheDocs\EventListener\CopyAssetsListener;
use phpDocumentor\Guides\Event\PostRenderProcess;

class ReadTheDocsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->register(CopyAssetsListener::class)
            ->addTag('event_listener', ['event' => PostRenderProcess::class]);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('guides', [
            'themes' => [
                'rtd' => \dirname(__DIR__, 2).'/resources/templates/rtd/html',
            ],
        ]);
    }
}
