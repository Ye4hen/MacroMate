<?php

namespace App\Http\Controllers\Web;

use App\Contracts\UserRepositoryInterface;
use App\Domain\Models\User;
use App\Domain\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends AdminController
{
    public function __construct(
        private readonly UserRepositoryInterface $user_repository
    ) {
    }

    public function index(Request $request)
    {
        [$q, $per_page, $page] = $this->paginationParams($request);

        $users = $this->user_repository->paginate($per_page, $page);

        return view('admin.users.index', compact('users', 'q'));
    }

    public function search(Request $request): JsonResponse
    {
        return $this->doSearch(
            $request,
            User::class,
            ['mu_code', 'mu_name', 'mu_email', 'mu_role'],
            ['mu_code', 'mu_name', 'mu_email', 'mu_role'],
            function (User $user) {
                return [
                  'code' => $user->mu_code,
                  'name' => $user->mu_name,
                  'email' => $user->mu_email,
                  'role' => $user->role->mur_name ?? 'user',
                ];
            },
            20
        );
    }

    public function edit(User $user_edit): View
    {
        $roles = UserRole::pluck('mur_name', 'mur_code')->toArray();

        return view('admin.users.edit', compact('user_edit', 'roles'));
    }

    public function update(Request $request, User $user_edit)
    {
        $validated = $this->validateData($request, $user_edit);

        $payload = [
          'mu_name' => $validated['name'],
          'mu_email' => $validated['email'],
          'mu_role' => $validated['role'],
        ];

        $this->user_repository->update($user_edit, $payload);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user_edit): RedirectResponse
    {
        $this->user_repository->delete($user_edit);

        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }

    private function validateData(Request $request, User $user_edit): array
    {
        $email_rules = [
          'required',
          'email',
          Rule::unique('mm_users', 'mu_email')
            ->ignore($user_edit->mu_code, 'mu_code')
            ->whereNull('mu_deleted_at'),
        ];

        $role_rules = [
          'required',
          'string',
          Rule::exists('mm_user_roles', 'mur_code')
            ->whereNull('mur_deleted_at'),
        ];

        $rules = [
          'name' => ['required', 'string', 'max:255'],
          'email' => $email_rules,
          'role' => $role_rules,
        ];

        return $request->validate($rules);
    }
}
