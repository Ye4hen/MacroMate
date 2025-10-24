<?php

namespace Tests\Unit;

use App\Domain\Services\CodeGenerator;
use Tests\TestCase;

class CodeGeneratorTest extends TestCase
{
    protected CodeGenerator $codeGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->codeGenerator = new CodeGenerator();
    }

    public function test_generate_code_returns_string_of_correct_length(): void
    {
        $length = 6;
        $code = $this->codeGenerator->generateCode($length);

        $this->assertEquals(floor($length * 8 / log(62)), strlen($code));
    }

    public function test_generate_code_uses_base62_characters(): void
    {
        $code = $this->codeGenerator->generateCode(6);
        $base62Pattern = '/^[0-9A-Za-z]+$/';

        $this->assertMatchesRegularExpression($base62Pattern, $code, 'Code should only contain base62 characters (0-9, A-Z, a-z).');
    }

    public function test_generate_code_produces_unique_codes(): void
    {
        $codes = [];
        $iterations = 100;

        for ($i = 0; $i < $iterations; $i++) {
            $codes[] = $this->codeGenerator->generateCode(6);
        }

        $uniqueCodes = array_unique($codes);
        $this->assertCount($iterations, $uniqueCodes, 'Generated codes should be unique.');
    }

    public function test_generate_code_handles_zero_length(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('random_bytes(): Argument #1 ($length) must be greater than 0');

        $this->codeGenerator->generateCode(0);
    }
}
