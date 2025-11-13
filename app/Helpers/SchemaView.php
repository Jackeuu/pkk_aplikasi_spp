<?php

namespace App\Helpers;

use DB;

class SchemaView {
    public static function create(string $query): void {
        DB::unprepared($query);
    }
}