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
                                    'link' => '/Brands',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                2 => [
                                    'title' => 'کیس',
                                    'link' => '/CaseCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                3 => [
                                    'title' => 'مادربورد',
                                    'link' => '/MotherboardCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                4 => [
                                    'title' => 'پردازنده',
                                    'link' => '/CPUCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                5 => [
                                    'title' => 'رم',
                                    'link' => '/RAMCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                6 => [
                                    'title' => 'منبع تغذیه',
                                    'link' => '/PowerCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                7 => [
                                    'title' => 'کارت گرافیک',
                                    'link' => '/GraphicCardCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                8 => [
                                    'title' => 'هارد',
                                    'link' => '/HarddiskCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                9 => [
                                    'title' => 'درایو نوری',
                                    'link' => '/ODDCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                10 => [
                                    'title' => 'کارت شبکه',
                                    'link' => '/NetworkCardCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                            ]
                        ],
                        2 => [
                            'title' => 'مدیریت کاربران',
                            'link' => '/UserManager',
                            'path1' => 'M5.5,7c1.93,0,3.5-1.57,3.5-3.5S7.43,0,5.5,0,2,1.57,2,3.5s1.57,3.5,3.5,3.5Zm0-5c.827,0,1.5,.673,1.5,1.5s-.673,1.5-1.5,1.5-1.5-.673-1.5-1.5,.673-1.5,1.5-1.5Zm4.5,8c-.827,0-1.5,.673-1.5,1.5,0,.328,.104,.639,.299,.899,.332,.441,.243,1.068-.199,1.4-.18,.135-.391,.201-.6,.201-.304,0-.604-.138-.8-.399-.458-.61-.701-1.336-.701-2.101,0-1.93,1.57-3.5,3.5-3.5,1.095,0,2.142,.523,2.8,1.399,.332,.442,.242,1.069-.199,1.4-.443,.332-1.068,.242-1.4-.199-.286-.382-.724-.601-1.2-.601Zm4.5-3c1.93,0,3.5-1.57,3.5-3.5s-1.57-3.5-3.5-3.5-3.5,1.57-3.5,3.5,1.57,3.5,3.5,3.5Zm0-5c.827,0,1.5,.673,1.5,1.5s-.673,1.5-1.5,1.5-1.5-.673-1.5-1.5,.673-1.5,1.5-1.5Zm8.196,17.134l-.974-.562c.166-.497,.278-1.019,.278-1.572s-.111-1.075-.278-1.572l.974-.562c.478-.276,.642-.888,.366-1.366-.277-.479-.887-.644-1.366-.366l-.973,.562c-.705-.794-1.644-1.375-2.723-1.594v-1.101c0-.552-.448-1-1-1s-1,.448-1,1v1.101c-1.079,.22-2.018,.801-2.723,1.594l-.973-.562c-.48-.277-1.09-.113-1.366,.366-.276,.479-.112,1.09,.366,1.366l.974,.562c-.166,.497-.278,1.019-.278,1.572s.111,1.075,.278,1.572l-.974,.562c-.478,.276-.642,.888-.366,1.366,.186,.321,.521,.5,.867,.5,.169,0,.341-.043,.499-.134l.973-.562c.705,.794,1.644,1.375,2.723,1.594v1.101c0,.552,.448,1,1,1s1-.448,1-1v-1.101c1.079-.22,2.018-.801,2.723-1.594l.973,.562c.158,.091,.33,.134,.499,.134,.346,0,.682-.179,.867-.5,.276-.479,.112-1.09-.366-1.366Zm-5.696,.866c-1.654,0-3-1.346-3-3s1.346-3,3-3,3,1.346,3,3-1.346,3-3,3ZM5,10c-1.654,0-3,1.346-3,3,0,.552-.448,1-1,1s-1-.448-1-1c0-2.757,2.243-5,5-5,.552,0,1,.448,1,1s-.448,1-1,1Zm5,7c0,.552-.448,1-1,1-1.654,0-3,1.346-3,3,0,.552-.448,1-1,1s-1-.448-1-1c0-2.757,2.243-5,5-5,.552,0,1,.448,1,1Z',
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
