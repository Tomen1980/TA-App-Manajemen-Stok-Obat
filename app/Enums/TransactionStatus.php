<?php
namespace App\Enums;

enum TransactionStatus: string
{
    case ARREARS = "arrears";

    case PAID = "paid";
}