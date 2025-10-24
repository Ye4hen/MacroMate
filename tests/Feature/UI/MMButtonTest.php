<?php

namespace Tests\Feature\UI;

use Tests\TestCase;

class MMButtonTest extends TestCase
{
    public function test_renders_anchor_when_href_provided()
    {
        $rendered = $this->blade('<x-mm-button label="Save" href="/some/path" variant="secondary" />');

        $rendered->assertSee('Save');
        $rendered->assertSee('href="/some/path"', false);
        $rendered->assertSee('mm-btn--secondary');
    }

    public function test_renders_button_when_no_href()
    {
        $rendered = $this->blade('<x-mm-button label="Submit" />');

        $rendered->assertSee('Submit');
        $rendered->assertSee('<button', false);
        $rendered->assertSee('type="submit"', false);
    }

    public function test_disabled_class_and_extra_classes_are_applied()
    {
        $rendered = $this->blade('<x-mm-button label="Remove" variant="danger" class="my-class" disabled />');

        $rendered->assertSee('my-class');
        $rendered->assertSee('disabled');
        $rendered->assertSee('mm-btn--danger');
    }

    public function test_blade_tag_renders_same()
    {
        $rendered = $this->blade('<x-mm-button label="Hello" href="/x" />');
        $rendered->assertSee('Hello');
        $rendered->assertSee('href="/x"', false);
    }
}
