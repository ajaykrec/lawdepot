<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Traits\AllFunction; 

class HandleInertiaAdminRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'admin_app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'flash' => [                
                'success_message' => fn () => $request->session()->get('success'),
                'error_message' => fn () => $request->session()->get('error')
            ],
            'file_storage_url'=>env('FILE_STORAGE_URL'),
            'user'=>AllFunction::get_admin_user_data(),
            'settings'=>AllFunction::get_admin_settings(),
        ]);
    }
}
