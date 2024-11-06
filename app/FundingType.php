<?php

namespace App;

enum FundingType: string
{
    case FULL = 'full';
    case PRIVATE = 'private';
    case PARTIAL = 'partial';
}
