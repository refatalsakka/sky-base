<?php

namespace App\Enum\Admin;

enum PermissionScope: string
{
    case GLOBAL = 'global';
    case UNIT = 'unit';
}
