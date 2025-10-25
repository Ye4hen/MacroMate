<!-- Do what you can, with what you have, where you are. - Theodore Roosevelt -->

<div class="grid grid-cols-1 gap-4">
    <x-mm-input
        name="name"
        id="name"
        label="Name"
        :value="old('name', $user->mu_name ?? '')"
        placeholder="Enter user name"
    />

    <x-mm-input
        name="email"
        id="email"
        label="Email"
        :value="old('email', $user->mu_email ?? '')"
        placeholder="Enter user email"
    />

    <x-mm-select
        label="Role"
        name="role"
        :options="$roles"
        :value="old('role', $user->mu_role)"
    />

    <div class="flex items-center gap-3 mt-4">
        <x-mm-button
            type="submit"
            variant="primary"
            :label="$submit_label ?? 'Save'"
        />
        <x-mm-button
            href="{{ route('admin.users.index') }}"
            variant="secondary"
            label="Cancel"
        />
    </div>
</div>
