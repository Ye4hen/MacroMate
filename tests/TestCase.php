<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Helper function used in the test above to detect a column presence.
     * We define it here so test file stays self-contained. You can also move it to a TestCase helper.
     */
    public function SchemaHasColumn(string $table, string $column): bool
    {
        return \Illuminate\Support\Facades\Schema::hasColumn($table, $column);
    }
}
