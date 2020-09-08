<?php
/**
 * Created by PhpStorm.
 * User: msbomrel
 * Date: 6/12/18
 * Time: 1:01 PM
 */

namespace App\Http\ViewComposers;


use App\UserOrganization;
use Illuminate\Contracts\View\View;

class NavbarComposer
{
    public function compose(View $view)
    {
        $organization =  UserOrganization::first();
        $view->with(compact('organization'));
    }
}
