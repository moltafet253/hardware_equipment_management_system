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
                            'title' => 'کاتالوگ تجهیزات سخت افزار',
                            'link' => '',
                            'path1'=>'M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z',
                            'path2'=>'M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z',
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
                                11 => [
                                    'title' => 'مانیتور',
                                    'link' => '/MonitorCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                12 => [
                                    'title' => 'پرینتر',
                                    'link' => '/PrinterCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                13 => [
                                    'title' => 'اسکنر',
                                    'link' => '/ScannerCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                14 => [
                                    'title' => 'دستگاه کپی',
                                    'link' => '/CopyMachineCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                15 => [
                                    'title' => 'VOIP',
                                    'link' => '/VOIPCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                            ]
                        ],
                        2 => [
                            'title' => 'کاتالوگ تجهیزات شبکه',
                            'link' => '',
                            'path1'=>'M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z',
                            'path2'=>'M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z',
                            'childs' => [
                                1 => [
                                    'title' => 'سوییچ',
                                    'link' => '/SwitchCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                            ]
                        ],
                        3 => [
                            'title' => 'کاتالوگ سایر تجهیزات',
                            'link' => '',
                            'path1'=>'M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z',
                            'path2'=>'M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z',
                            'childs' => [
                                1 => [
                                    'title' => 'لپ تاپ',
                                    'link' => '/LaptopCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                2 => [
                                    'title' => 'تلفن همراه',
                                    'link' => '/MobileCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                3 => [
                                    'title' => 'تبلت',
                                    'link' => '/TabletCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                4 => [
                                    'title' => 'وبکم',
                                    'link' => '/WebcamCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                5 => [
                                    'title' => 'مودم',
                                    'link' => '/ModemCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                6 => [
                                    'title' => 'سوییچ',
                                    'link' => '/SwitchCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                7 => [
                                    'title' => 'رکوردر',
                                    'link' => '/RecorderCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                8 => [
                                    'title' => 'هدفون',
                                    'link' => '/HeadphoneCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                9 => [
                                    'title' => 'اسپیکر',
                                    'link' => '/SpeakerCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                10 => [
                                    'title' => 'ویدئو پروژکتور',
                                    'link' => '/VideoProjectorCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                11 => [
                                    'title' => 'پرده ویدئو پروژکتور',
                                    'link' => '/VideoProjectorCurtainCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                            ]
                        ],
                        4 => [
                            'title' => 'کاتالوگ اولیه سامانه',
                            'link' => '',
                            'path1'=>'M18.656.93,6.464,13.122A4.966,4.966,0,0,0,5,16.657V18a1,1,0,0,0,1,1H7.343a4.966,4.966,0,0,0,3.535-1.464L23.07,5.344a3.125,3.125,0,0,0,0-4.414A3.194,3.194,0,0,0,18.656.93Zm3,3L9.464,16.122A3.02,3.02,0,0,1,7.343,17H7v-.343a3.02,3.02,0,0,1,.878-2.121L20.07,2.344a1.148,1.148,0,0,1,1.586,0A1.123,1.123,0,0,1,21.656,3.93Z',
                            'path2'=>'M23,8.979a1,1,0,0,0-1,1V15H18a3,3,0,0,0-3,3v4H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2h9.042a1,1,0,0,0,0-2H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H16.343a4.968,4.968,0,0,0,3.536-1.464l2.656-2.658A4.968,4.968,0,0,0,24,16.343V9.979A1,1,0,0,0,23,8.979ZM18.465,21.122a2.975,2.975,0,0,1-1.465.8V18a1,1,0,0,1,1-1h3.925a3.016,3.016,0,0,1-.8,1.464Z',
                            'childs' => [
                                1 => [
                                    'title' => 'معاونت/بخش',
                                    'link' => '/AssistanceCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                2 => [
                                    'title' => 'محل استقرار',
                                    'link' => '/EstablishmentPlaceCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                3 => [
                                    'title' => 'کارها',
                                    'link' => '/JobCatalog',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                            ]
                        ],
                        5 => [
                            'title' => 'مدیریت پرسنل ستاد',
                            'link' => '/Person',
                            'path1' => 'M12,17a4,4,0,1,1,4-4A4,4,0,0,1,12,17Zm6,4a3,3,0,0,0-3-3H9a3,3,0,0,0-3,3v3H18ZM18,8a4,4,0,1,1,4-4A4,4,0,0,1,18,8ZM6,8a4,4,0,1,1,4-4A4,4,0,0,1,6,8Zm0,5A5.968,5.968,0,0,1,7.537,9H3a3,3,0,0,0-3,3v3H6.349A5.971,5.971,0,0,1,6,13Zm11.651,2H24V12a3,3,0,0,0-3-3H16.463a5.952,5.952,0,0,1,1.188,6Z',
                            'childs' => []
                        ],
                        6 => [
                            'title' => 'گزارشات',
                            'link' => '',
                            'path1'=>'M23,22H5a3,3,0,0,1-3-3V1A1,1,0,0,0,0,1V19a5.006,5.006,0,0,0,5,5H23a1,1,0,0,0,0-2Z',
                            'path2'=>'M6,20a1,1,0,0,0,1-1V12a1,1,0,0,0-2,0v7A1,1,0,0,0,6,20Z',
                            'path3'=>'M10,10v9a1,1,0,0,0,2,0V10a1,1,0,0,0-2,0Z',
                            'path4'=>'M15,13v6a1,1,0,0,0,2,0V13a1,1,0,0,0-2,0Z',
                            'path5'=>'M20,9V19a1,1,0,0,0,2,0V9a1,1,0,0,0-2,0Z',
                            'path6'=>'M6,9a1,1,0,0,0,.707-.293l3.586-3.586a1.025,1.025,0,0,1,1.414,0l2.172,2.172a3,3,0,0,0,4.242,0l5.586-5.586A1,1,0,0,0,22.293.293L16.707,5.878a1,1,0,0,1-1.414,0L13.121,3.707a3,3,0,0,0-4.242,0L5.293,7.293A1,1,0,0,0,6,9Z',
                            'childs' => [
                                1 => [
                                    'title' => 'گزارش گیری سفارشی',
                                    'link' => '/GridReports',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                                2 => [
                                    'title' => 'خروجی تجمیعی اکسل',
                                    'link' => '/ExcelAllReports',
                                    'path1' => 'm15.448,7.931l2.104,2.139-5.293,5.207c-.481.482-1.118.724-1.756.724s-1.282-.244-1.771-.732l-2.776-2.69,2.088-2.154,2.453,2.378,4.951-4.87Zm8.552,4.069c0,6.617-5.383,12-12,12S0,18.617,0,12,5.383,0,12,0s12,5.383,12,12Zm-3,0c0-4.962-4.037-9-9-9S3,7.038,3,12s4.037,9,9,9,9-4.038,9-9Z',
                                ],
                            ]
                        ],
                        7 => [
                            'title' => 'مدیریت کاربران',
                            'link' => '/UserManager',
                            'path1' => 'M5.5,7c1.93,0,3.5-1.57,3.5-3.5S7.43,0,5.5,0,2,1.57,2,3.5s1.57,3.5,3.5,3.5Zm0-5c.827,0,1.5,.673,1.5,1.5s-.673,1.5-1.5,1.5-1.5-.673-1.5-1.5,.673-1.5,1.5-1.5Zm4.5,8c-.827,0-1.5,.673-1.5,1.5,0,.328,.104,.639,.299,.899,.332,.441,.243,1.068-.199,1.4-.18,.135-.391,.201-.6,.201-.304,0-.604-.138-.8-.399-.458-.61-.701-1.336-.701-2.101,0-1.93,1.57-3.5,3.5-3.5,1.095,0,2.142,.523,2.8,1.399,.332,.442,.242,1.069-.199,1.4-.443,.332-1.068,.242-1.4-.199-.286-.382-.724-.601-1.2-.601Zm4.5-3c1.93,0,3.5-1.57,3.5-3.5s-1.57-3.5-3.5-3.5-3.5,1.57-3.5,3.5,1.57,3.5,3.5,3.5Zm0-5c.827,0,1.5,.673,1.5,1.5s-.673,1.5-1.5,1.5-1.5-.673-1.5-1.5,.673-1.5,1.5-1.5Zm8.196,17.134l-.974-.562c.166-.497,.278-1.019,.278-1.572s-.111-1.075-.278-1.572l.974-.562c.478-.276,.642-.888,.366-1.366-.277-.479-.887-.644-1.366-.366l-.973,.562c-.705-.794-1.644-1.375-2.723-1.594v-1.101c0-.552-.448-1-1-1s-1,.448-1,1v1.101c-1.079,.22-2.018,.801-2.723,1.594l-.973-.562c-.48-.277-1.09-.113-1.366,.366-.276,.479-.112,1.09,.366,1.366l.974,.562c-.166,.497-.278,1.019-.278,1.572s.111,1.075,.278,1.572l-.974,.562c-.478,.276-.642,.888-.366,1.366,.186,.321,.521,.5,.867,.5,.169,0,.341-.043,.499-.134l.973-.562c.705,.794,1.644,1.375,2.723,1.594v1.101c0,.552,.448,1,1,1s1-.448,1-1v-1.101c1.079-.22,2.018-.801,2.723-1.594l.973,.562c.158,.091,.33,.134,.499,.134,.346,0,.682-.179,.867-.5,.276-.479,.112-1.09-.366-1.366Zm-5.696,.866c-1.654,0-3-1.346-3-3s1.346-3,3-3,3,1.346,3,3-1.346,3-3,3ZM5,10c-1.654,0-3,1.346-3,3,0,.552-.448,1-1,1s-1-.448-1-1c0-2.757,2.243-5,5-5,.552,0,1,.448,1,1s-.448,1-1,1Zm5,7c0,.552-.448,1-1,1-1.654,0-3,1.346-3,3,0,.552-.448,1-1,1s-1-.448-1-1c0-2.757,2.243-5,5-5,.552,0,1,.448,1,1Z',
                            'childs' => []
                        ],
                    ];
                    break;
                case 2:
                    //کارشناس فناوری استان
                    $menus = [
                        1 => [
                            'title' => 'مدیریت پرسنل',
                            'link' => '/Person',
                            'path1' => 'M12,17a4,4,0,1,1,4-4A4,4,0,0,1,12,17Zm6,4a3,3,0,0,0-3-3H9a3,3,0,0,0-3,3v3H18ZM18,8a4,4,0,1,1,4-4A4,4,0,0,1,18,8ZM6,8a4,4,0,1,1,4-4A4,4,0,0,1,6,8Zm0,5A5.968,5.968,0,0,1,7.537,9H3a3,3,0,0,0-3,3v3H6.349A5.971,5.971,0,0,1,6,13Zm11.651,2H24V12a3,3,0,0,0-3-3H16.463a5.952,5.952,0,0,1,1.188,6Z',
                            'childs' => []
                        ],
                    ];
                    break;
            }
            $request->session()->put('menus', $menus);
            return $next($request);
        }
        return response()->redirectToRoute('login');
    }
}
