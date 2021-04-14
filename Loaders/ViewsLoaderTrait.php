<?php

namespace Apiato\Core\Loaders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait ViewsLoaderTrait
{
    public function loadViewsFromContainers($containerPath): void
    {
        $containerViewDirectory = $containerPath . '/UI/WEB/Views/';
        $containerMailTemplatesDirectory = $containerPath . '/Mails/Templates/';

        $containerName = basename($containerPath);
        $pathParts = explode(DIRECTORY_SEPARATOR, $containerPath);
        $sectionName = $pathParts[count($pathParts) - 2];

        $this->loadViews($containerViewDirectory, $containerName, $sectionName);
        $this->loadViews($containerMailTemplatesDirectory, $containerName, $sectionName);
    }

    private function loadViews($directory, $containerName, $sectionName = null): void
    {
        if (File::isDirectory($directory)) {
            $this->loadViewsFrom($directory, $this->buildNamespace($sectionName, $containerName));
        }
    }

    private function buildNamespace(string $sectionName, string $containerName): string
    {
        return $sectionName ? (Str::camel($sectionName) . '@' . Str::camel($containerName)) : Str::camel($containerName);
    }

    public function loadViewsFromShip(): void
    {
        $portMailTemplatesDirectory = base_path('app/Ship/Mails/Templates/');
        $this->loadViews($portMailTemplatesDirectory, 'ship'); // Ship views accessible via `ship::`.
    }
}
