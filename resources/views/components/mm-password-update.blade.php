<form
    method="POST"
    action="{{ route("profile.password.update") }}"
    class="grid gap-y-4"
>
    @csrf
    @method("PATCH")

    <x-mm-input
        label="Current password"
        name="current_password"
        type="password"
        required
    />
    <x-mm-input label="New password" name="password" type="password" required />
    <x-mm-input
        label="Confirm password"
        name="password_confirmation"
        type="password"
        placeholder="Repeat new password"
        required
    />

    <x-mm-button label="Change password" />
</form>
