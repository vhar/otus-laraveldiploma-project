<?php

namespace App\Services\Telegram;

enum ParseModeEnum: string
{
    case MACKDOWN = 'MarkdownV2';
    case HTML = 'HTML';
}
