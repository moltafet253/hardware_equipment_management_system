@php use App\Models\User; @endphp
@extends('layouts.PanelMaster')

@section('content')
    @php
        $myWorkPlace=User::find(session('id'));
        $personInfo=\App\Models\Person::where('id',$personId)->where('work_place',$myWorkPlace->province_id)->first();
    @endphp

    <main class="flex-1 bg-gray-100 py-6 px-8 ">

        <div class=" mx-auto lg:mr-72">
            <div class="border rounded-lg shadow-md">
                <h1 class="text-xl font-bold m-4">مدیریت اطلاعات تجهیزات کاربر با
                    مشخصات {{ $personInfo->name .' '. $personInfo->family}} با کد پرسنلی {{ $personInfo->personnel_code }}</h1>
                <div class="flex border rounded-lg">
                    <button id="tab1"
                            class="w-1/3 py-2 px-4 bg-blue-400 text-white hover:bg-blue-600 focus:outline-none focus:bg-blue-600 rounded-tr-box">
                        تجهیزات سخت افزاری
                    </button>
                    <button id="tab2" class="w-1/3 py-2 px-4 bg-blue-400 text-white rounded-tl-box">تجهیزات شبکه
                    </button>
                    <button id="tab3" class="w-1/3 py-2 px-4 bg-blue-400 text-white rounded-tl-box">سایر تجهیزات
                    </button>
                </div>
                <div>
                    <div id="content1" class="p-4">
                        {{--            Cases--}}
                        @include('layouts.EquipmentManagerLayers.HardwareEquipments.Cases')

                        {{--            Monitors--}}
                        @include('layouts.EquipmentManagerLayers.HardwareEquipments.Monitors')

                        {{--            Printers--}}
                        @include('layouts.EquipmentManagerLayers.HardwareEquipments.Printers')

                        {{--            Scanners--}}
                        @include('layouts.EquipmentManagerLayers.HardwareEquipments.Scanners')

                        {{--            Copy Machines--}}
                        @include('layouts.EquipmentManagerLayers.HardwareEquipments.CopyMachines')

                        {{--            VOIPs--}}
                        @include('layouts.EquipmentManagerLayers.HardwareEquipments.VOIPs')
                    </div>

                    <div id="content2" class="hidden p-4">
                        {{--                        Switches--}}
                        @include('layouts.EquipmentManagerLayers.NetworkEquipments.Switches')

                        {{--                        Modems--}}
                        @include('layouts.EquipmentManagerLayers.NetworkEquipments.Modems')
                    </div>

                    <div id="content3" class="hidden p-4">
                        {{--                        Laptops--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.Laptops')

                        {{--                        Mobiles--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.Mobiles')

                        {{--                        Tablets--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.Tablets')

                        {{--                        Headphones--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.Headphones')

                        {{--                        Recorders--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.Recorders')

                        {{--                        Speakers--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.Speakers')

                        {{--                        VideoProjectors--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.VideoProjectors')

                        {{--                        VideoProjectorCurtains--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.VideoProjectorCurtains')

                        {{--                        Webcams--}}
                        @include('layouts.EquipmentManagerLayers.OtherEquipments.Webcams')
                    </div>
                </div>

            </div>
        </div>
    </main>

@endsection
