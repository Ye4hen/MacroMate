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
        $this->withViewErrors(['agree' => 'You must accept.']);

        $rendered = $this->blade(
            '<x-mm-select name="agree" label="Agree" :options="[\'yes\' => \'Yes\']" />'
        );

        $rendered->assertSee('You must accept.');
    }

    public function test_renders_slot_content_instead_of_options(): void
    {
        $slotHtml = '<option value="a">A</option><option value="b">B</option>';

        $rendered = $this->blade(
            '<x-mm-select name="letter" label="Letter">' . $slotHtml . '</x-mm-select>'
        );

        $rendered->assertSee('value="a"', false);
        $rendered->assertSee('value="b"', false);
        $rendered->assertSee('A');
        $rendered->assertSee('B');
    }
}
