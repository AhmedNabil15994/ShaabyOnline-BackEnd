<?php

namespace Modules\User\ViewComposers\Dashboard;

use Modules\User\Repositories\Dashboard\UserRepository as User;
use Illuminate\View\View;
use Cache;

class UserComposer
{
    public $user = [];

    public function __construct(User $user)
    {
        $this->user =  $user->getAllUsers();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('users' , $this->user);
    }
}
