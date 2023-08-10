<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('username')) {
            $menus = null;
            $user = User::where('username', session('username'))->first();
            switch ($user->type) {
                case 1:
                    //ادمین
                    $menus = [
                        1 => [
                            'title' => 'تعاریف اولیه',
                            'link' => '',
                            'childs' => [
                                1 => [
                                    'title' => 'برند',
                                    'link' => '/Brands'
                                ],
                                3 => [
                                    'title' => 'کیس',
                                    'link' => '/CaseCatalog'
                                ],
                                2 => [
                                    'title' => 'مادربورد',
                                    'link' => '/MotherboardCatalog'
                                ],
                            ]
                        ],
                        2 => [
                            'title' => 'مدیریت کاربران',
                            'link' => '/UserManager',
                            'childs' => []
                        ],
                    ];
                    break;
                case 2:
                    //استان ها
                    $menus = [

                    ];
                    break;
                case 6:
                case 7:
                    break;
            }
            $request->session()->put('menus', $menus);
            return $next($request);
        }
        return response()->redirectToRoute('login');
    }
}
