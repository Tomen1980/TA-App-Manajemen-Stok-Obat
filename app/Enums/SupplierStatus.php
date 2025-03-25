<?php
namespace App\Enums;

enum SupplierStatus: string
{
    case WAITING = "waiting";
    case APPROVE = "approve";

    case DECLINE = "decline";
}