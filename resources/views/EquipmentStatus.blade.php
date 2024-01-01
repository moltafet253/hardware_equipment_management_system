@php use App\Models\User; @endphp
@extends('layouts.PanelMaster')

@section('content')
    @php
        $myWorkPlace=User::find(session('id'));
        $personInfo=\App\Models\Person::where('id',$personId)->where('work_place',$myWorkPlace->province_id)->first();
    @endphp
    <main class="flex-1 bg-gray-100 py-6 px-8 ">

        <form id="move-equipment">
            @csrf
            <div class="flex items-center">
                {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addCaseModal">--}}
                <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="moveEquipmentModal">
                    <div
                        class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75 moveequipment"></div>
                        </div>
                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                    انتقال دستگاه به پرسنل دیگر
                                </h3>
                                <div class="mt-4">
                                    <div class="flex">
                                        <div class="ml-3 w-full">
                                            <label for="person"
                                                   class="block text-gray-700 text-sm font-bold mb-2">پرسنلی که میخواهید دستگاه انتخاب شده را به آن منتقل کنید*</label>
                                            <select id="person" class="border rounded-md w-96 px-3 py-2 select2"
                                                    name="person">
                                                @foreach($allPersons as $person)
                                                    <option value="{{ $person->id }}">
                                                        {{ "$person->name - $person->family - $person->personnel_code - $person->national_code" }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <input type="hidden" name="eq_id" value="" class="eq_id">
                                <input type="hidden" name="eq_type" value="" class="eq_type">
                                <button type="submit"
                                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                    انتقال
                                </button>
                                <button id="cancel-move-equipment" type="button"
                                        class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                    انصراف
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
