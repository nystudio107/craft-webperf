<?php

use craft\ecs\SetList;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
    ]);
    $ecsConfig->parallel();
    $ecsConfig->sets([SetList::CRAFT_CMS_4]);
};
