<?php

namespace App\Utils;

class UIUtils
{
    public static function includeRouteFiles($folder)
    {
        try {
            $rdi = new \RecursiveDirectoryIterator($folder);
            $it = new \RecursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
