<?php

namespace Tests\Feature\UI;

use Tests\TestCase;

class MMInputTest extends TestCase
{
    public function test_password_field_includes_toggle_button(): void
    {
        $rendered = $this->blade('<x-mm-input name="password" label="Password" type="password" />');

        // Input type password should be present
        $rendered->assertSee('type="password"', false);

        // Toggle button present
        $rendered->assertSee('mm-toggle-password', false);

        // Eye icons present (class names used in blade)
        $rendered->assertSee('mm-eye', false);
        $rendered->assertSee('mm-eye-off', false);
    }

    public function test_shows_error_message_when_validation_error_exists(): void
    {
        // Provide validation error for 'email' field
        $this->withViewErrors(['email' => 'The email is invalid.']);

        $rendered = $this->blade('<x-mm-input name="email" label="Email" type="text" />');

        // The @error directive should render the message
        $rendered->assertSee('The email is invalid.');
    }

    public function test_renders_label_tooltip_popover_when_provided(): void
    {
        // Pass raw HTML tooltip using evaluated expression syntax
        $rendered = $this->blade(
            '<x-mm-input name="email" label="Email" :label_tooltip="\'<strong>Use a valid format</strong>\'" />'
        );

        // Should include the popover trigger attribute and content
        $rendered->assertSee('data-popover-target', false);
        $rendered->assertSee('data-popover', false);
        $rendered->assertSee('Use a valid format', false);
    }
}
