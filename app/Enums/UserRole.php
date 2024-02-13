<?php


namespace App\Enums;

enum UserRole
{
    const SUPER_ADMIN = "super_admin";
    const ADMIN = "admin";
    const EDITOR = "editor";
    const USER = "user";
    const GUEST = "guest";
}
