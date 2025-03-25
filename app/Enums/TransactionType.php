<?php
namespace App\Enums;

enum TransactionType: string
{
    case IN = "in";

    case OUT = "out";
}