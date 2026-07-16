<?php

namespace App\Util;

use Illuminate\Http\Request;

class ReportValidator
{
    public static function validate(Request $request): void
    {
        $request->validate([
            'file_type' => ['required', 'in:json,xlsx'],
        ]);
    }
}
