<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Middleware;
use App\Traits\AllFunction; 

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

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
            'customer'=>AllFunction::get_customer_data(),       
            'common_data'=>AllFunction::get_common_data(),
        ]);
    }
    
}
