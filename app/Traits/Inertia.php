<?php

namespace App\Traits;

use Inertia\Inertia as InertiaPackage;

trait Inertia
{

    public function view(string $view, array $data = [])
    {
        $view = str_replace('.', '/', $view);
        return  InertiaPackage::render($view, $data);
    }
}