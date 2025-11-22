<?php

namespace Tests\Feature\UI;

use Tests\TestCase;

class MMSelectTest extends TestCase
{
    public function test_renders_required_attribute(): void
    {
        $options = ['yes' => 'Yes', 'no' => 'No'];

        $rendered = $this->blade(
            '<x-mm-select name="agree" label="Agree" :options="$options" required />',
            ['options' => $options]
        );

        $rendered->assertSee('required', false);
    }

    public function test_renders_error_message(): void
    {
        $options = ['yes' => 'Yes', 'no' => 'No'];
        $this->withViewErrors(['agree' => 'You must accept.']);

        $rendered = $this->blade(
            '<x-mm-select name="agree" label="Agree" :options="$options" />',
            ['options' => $options]
        );

        $rendered->assertSee('You must accept.');
    }

    public function test_renders_default_options_when_no_slot(): void
    {
        $options = ['a' => 'Option A', 'b' => 'Option B'];

        $rendered = $this->blade(
            '<x-mm-select name="choice" label="Choice" :options="$options" :value="null" />',
            ['options' => $options]
        );

        $rendered->assertSee('value="a"', false);
        $rendered->assertSee('Option A');
        $rendered->assertSee('value="b"', false);
        $rendered->assertSee('Option B');
    }

    public function test_renders_slot_content_instead_of_options(): void
    {
        $slot_html = '<option value="x">X</option><option value="y">Y</option>';

        $rendered = $this->blade(
            '<x-mm-select name="letter" label="Letter">' . $slot_html . '</x-mm-select>'
        );

        $rendered->assertSee('value="x"', false);
        $rendered->assertSee('value="y"', false);
        $rendered->assertSee('X');
        $rendered->assertSee('Y');
    }

    public function test_rendering_does_not_throw_when_slot_is_empty(): void
    {
        $options = ['one' => 'One', 'two' => 'Two'];

        $this->expectNotToPerformAssertions();

        $this->blade('<x-mm-select name="n" label="N" :options="$options" />', [
            'options' => $options,
        ]);
    }
}
