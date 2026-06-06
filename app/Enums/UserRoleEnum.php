<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case TeamMember = 'team_member';
    case Guest = 'guest';
}
