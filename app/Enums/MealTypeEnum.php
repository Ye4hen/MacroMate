<?php

namespace App\Enums;

enum MealTypeEnum: string
{
    case BREAKFAST = 'Breakfast';
    case MIDMORNING_SNACK = 'Mid-Morning Snack';
    case LUNCH = 'Lunch';
    case AFTERNOON_SNACK = 'Afternoon Snack';
    case DINNER = 'Dinner';
    case LATE_DINNER = 'Late Dinner';
}
