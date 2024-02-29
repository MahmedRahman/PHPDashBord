<?php

namespace App\Enums;

enum UserRole: string {
    case Admin = 'admin';
    case Employee = 'employee';
    case HR = 'hr';
    case TechLead = 'techlead';
}
