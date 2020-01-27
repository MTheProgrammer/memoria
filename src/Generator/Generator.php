<?php

declare(strict_types=1);

namespace App\Generator;

use InvalidArgumentException;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class Generator
{
    /**
     * @param string $template
     * @param object|array $values
     *
     * @return string
     */
    public function execute(string $template, $values): string
    {
        if (!(is_object($values) || is_array($values))) {
            throw new InvalidArgumentException('Argument `values` must be an array or an object');
        }

        $options = ['extension' => '.tmpl'];
        $m = new Mustache_Engine([
            'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/../templates', $options),
        ]);

        return $m->render($template, $values);
    }
}
