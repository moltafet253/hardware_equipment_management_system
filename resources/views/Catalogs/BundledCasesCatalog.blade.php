@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تعاریف اولیه - مدیریت بر اطلاعات کیس های آماده</h1>

            <div class="bg-white rounded shadow p-6 flex flex-col ">
                <button id="new-bundled_case-button" type="button"
                        class="px-4 py-2 bg-green-500 w-32 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    کیس جدید
                </button>
                <form id="new-bundled-case">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newBundledCaseModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 add"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف کیس آماده جدید
                                        </h3>
                                        <div class="mt-4">
                                            <div class="mb-4">
                                                <label for="brand"
                                                       class="block text-gray-700 text-sm font-bold mb-2">برند:</label>
                                                <select id="brand" class="border rounded-md w-full px-3 py-2"
                                                        name="brand">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $brands=\App\Models\Catalogs\Company::
                                                        where('name','!=','ONBOARD')
                                                        ->whereJsonContains('products', ['Case'])
                                                        ->orderBy('name')->get();
                                                    @endphp
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="model"
                                                       class="block text-gray-700 text-sm font-bold mb-2">مدل*:</label>
                                                <input type="text" id="model" name="model" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="مدل را به انگلیسی وارد کنید">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت کیس جدید
                                        </button>
                                        <button id="cancel-new-case" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                    <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                        <th class=" px-3 py-3  font-bold ">کیس</th>
                        <th class=" px-3 py-3  font-bold ">پاور</th>
                        <th class=" px-3 py-3  font-bold ">مادربورد</th>
                        <th class=" px-3 py-3  font-bold ">پردازنده</th>
                        <th class=" px-3 py-3  font-bold ">رم</th>
                        <th class=" px-3 py-3  font-bold ">کارت گرافیک</th>
                        <th class=" px-3 py-3  font-bold ">هارد</th>
                        <th class=" px-3 py-3  font-bold ">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bundledCaseList as $case)
                        <tr class="even:bg-gray-300 odd:bg-white">
                            <td class=" px-3 py-3 ">
                                @php
                                    $caseInfo = \App\Models\Catalogs\Cases::join('companies', 'cases.company_id', '=', 'companies.id')
                                    ->select('cases.*', 'companies.name as company_name') // انتخاب فیلدهای مورد نیاز
                                    ->find($case->case);
                                @endphp
                                {{ $caseInfo->company_name . ' ' . $caseInfo->model  }}
                            </td>
                            <td class=" px-3 py-3 ">
                                @php
                                    $powerInfo = \App\Models\Catalogs\Power::join('companies', 'powers.company_id', '=', 'companies.id')
                                    ->select('powers.*', 'companies.name as company_name')
                                    ->find($case->power);
                                @endphp
                                {{ $powerInfo->company_name . ' ' . $powerInfo->model. ' ' . $powerInfo->output_voltage  }}
                            </td>
                            <td class=" px-3 py-3 ">
                                @php
                                    $motherboardInfo = \App\Models\Catalogs\Motherboard::join('companies', 'motherboards.company_id', '=', 'companies.id')
                                    ->select('motherboards.*', 'companies.name as company_name')
                                    ->find($case->motherboard);
                                @endphp
                                {{ $motherboardInfo->company_name . ' ' . $motherboardInfo->model. ' ' . $motherboardInfo->ram_slot_generation  }}
                            </td>
                            <td class=" px-3 py-3 ">
                                @php
                                    $cpuInfo = \App\Models\Catalogs\cpu::join('companies', 'cpus.company_id', '=', 'companies.id')
                                    ->select('cpus.*', 'companies.name as company_name')
                                    ->find($case->cpu);
                                @endphp
                                {{ $cpuInfo->company_name . ' ' . $cpuInfo->model. ' ' . $cpuInfo->generation  }}
                            </td>
                            <td class=" px-3 py-3 ">
                                @php
                                    $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                    ->select('rams.*', 'companies.name as company_name')
                                    ->find($case->ram1);
                                @endphp
                                {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency  }}

                                @if($case->ram2)
                                    <hr>
                                    @php
                                        $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                        ->select('rams.*', 'companies.name as company_name')
                                        ->find($case->ram2);
                                    @endphp
                                    {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency }}
                                @endif

                                @if($case->ram3)
                                    <hr>
                                    @php
                                        $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                        ->select('rams.*', 'companies.name as company_name')
                                        ->find($case->ram3);
                                    @endphp
                                    {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency }}
                                @endif

                                @if($case->ram4)
                                    <hr>
                                    @php
                                        $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                        ->select('rams.*', 'companies.name as company_name')
                                        ->find($case->ram4);
                                    @endphp
                                    {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency }}
                                @endif

                            </td>
                            <td class=" px-3 py-3 ">
                                @if($case->graphic_card)
                                    @php
                                        $graphicCardInfo = \App\Models\Catalogs\GraphicCard::join('companies', 'graphic_cards.company_id', '=', 'companies.id')
                                        ->select('graphic_cards.*', 'companies.name as company_name')
                                        ->find($case->graphic_card);
                                    @endphp
                                    {{ $graphicCardInfo->company_name . ' ' . $graphicCardInfo->model. ' ' . $graphicCardInfo->ram_size }}
                                @else
                                    Onboard
                                @endif
                            </td>
                            <td class=" px-3 py-3 ">
                                @php
                                    $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                    ->select('harddisks.*', 'companies.name as company_name')
                                    ->find($case->hdd1);
                                @endphp
                                {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity }}

                                @if($case->hdd2)
                                    <hr>
                                    @php
                                        $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                        ->select('harddisks.*', 'companies.name as company_name')
                                        ->find($case->hdd2);
                                    @endphp
                                    {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity  }}
                                @endif

                                @if($case->hdd3)
                                    <hr>
                                    @php
                                        $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                        ->select('harddisks.*', 'companies.name as company_name')
                                        ->find($case->hdd3);
                                    @endphp
                                    {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity }}
                                @endif

                                @if($case->hdd4)
                                    <hr>
                                    @php
                                        $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                        ->select('harddisks.*', 'companies.name as company_name')
                                        ->find($case->hdd4);
                                    @endphp
                                    {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity }}
                                @endif
                            </td>
                            <td class=" px-3 py-3 ">
                                <button type="submit" data-type="case" data-id="{{ $case->id }}"
                                        class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditEqCase">
                                    ویرایش
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $bundledCaseList->links() }}
                </div>
            </div>

        </div>
    </main>
@endsection
