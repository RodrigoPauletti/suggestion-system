<?php

namespace App\Enums;

enum SuggestionStatus: string {
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case UNDER_DEVELOPMENT = 'under development';

}
