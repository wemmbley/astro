<?php

namespace UI\App\Middleware;

use Database\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Modules\Actors\Auth\AuthRole;
use Modules\Scene\Shared\Repositories\NavbarRepository;

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

    public function __construct(
        private NavbarRepository $navbar,
    ) {}

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
        $user = $request->user();

        if(!empty($user)) {
            $authInfo = [
                'user' => $user->toArray(),
                'roles' => $user->getRoleNames()->toArray(),
                'permissions' => $user->getAllPermissions()->toArray(),
            ];
        } else {
            $authInfo = [
                'user' => null,
                'roles' => [AuthRole::Guest->value],
                'permissions' => [],
            ];
        }

        if (!empty($user))
        {
            $notificationsQuery = Notification::where('user_id', $user->getKey());
            $notificationsCount = (clone $notificationsQuery)->where('read', false)->count();
            $notificationsData = $notificationsQuery
                ->latest()
                ->simplePaginate(5)
                ->toArray();
        } else {
            $notificationsCount = 0;
            $notificationsData = [];
        }

        return [
            ...parent::share($request),
            'navbar' => $this->navbar->getByName(
                NavbarRepository::MAIN_NAVBAR
            ),
            'notifications' => $notificationsData,
            'notificationsCount' => $notificationsCount,
            'auth' => $authInfo,
        ];
    }
}
