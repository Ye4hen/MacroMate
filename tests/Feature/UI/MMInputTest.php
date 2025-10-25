<?php

namespace Tests\Feature\UI;

use Tests\TestCase;

class MMInputTest extends TestCase
{
    public function test_password_field_includes_toggle_button(): void
    {
        $rendered = $this->blade('<x-mm-input name="password" label="Password" type="password" />');

        $rendered->assertSee('type="password"', false);

        $rendered->assertSee('mm-toggle-password', false);

        $rendered->assertSee('mm-eye', false);
        $rendered->assertSee('mm-eye-off', false);
    }

    public function test_shows_error_message_when_validation_error_exists(): void
    {
        $this->withViewErrors(['email' => 'The email is invalid.']);

        $rendered = $this->blade('<x-mm-input name="email" label="Email" type="text" />');

        $rendered->assertSee('The email is invalid.');
    }

    public function test_renders_label_tooltip_popover_when_provided(): void
    {
        $rendered = $this->blade(
            '<x-mm-input name="email" label="Email" :label_tooltip="\'<strong>Use a valid format</strong>\'" />'
        );

        $rendered->assertSee('data-popover-target', false);
        $rendered->assertSee('data-popover', false);
        $rendered->assertSee('Use a valid format', false);
    }
}
