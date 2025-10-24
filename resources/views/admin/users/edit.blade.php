<!-- When there is no desire, all things are at peace. - Laozi -->

@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="title">Edit User</h1>
            <div class="flex items-center gap-2">
                <x-mm-button href="{{ route('admin.users.index') }}" variant="secondary" label="Back" />
            </div>
        </div>

        <div class="bg-mm-card p-6 rounded-lg shadow-sm border border-mm-border">
            <form action="{{ route('admin.users.update', $user_edit) }}" method="POST" novalidate>
                @csrf
                @method('PATCH')

                @include('admin.users._form', [
                    'user' => $user_edit,
                    'roles' => $roles,
                    'submit_label' => 'Save changes',
                ])
            </form>

            <div class="mt-4">
                <form action="{{ route('admin.users.destroy', $user_edit) }}" method="POST"
                    onsubmit="return confirm('Delete this user?');">
                    @csrf
                    @method('DELETE')
                    <x-mm-button type="submit" variant="danger" label="Delete user" />
                </form>
            </div>
        </div>
    </div>
@endsection
