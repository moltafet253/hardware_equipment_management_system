@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تعاریف اولیه - مدیریت بر اطلاعات رم</h1>

            <div class="bg-white rounded shadow p-6 flex flex-col ">
                <button id="new-ram-button" type="button"
                        class="px-4 py-2 bg-green-500 w-32 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    رم جدید
                </button>
                <form id="new-ram">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newRAMModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 add"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف رم جدید
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
                                                        ->whereJsonContains('products', ['RAM'])
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
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="type"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نسل*:</label>
                                                <select id="type" class="border rounded-md w-full px-3 py-2"
                                                        name="type">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="DDR1">DDR1</option>
                                                    <option value="DDR2">DDR2</option>
                                                    <option value="DDR3">DDR3</option>
                                                    <option value="DDR4">DDR4</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="size"
                                                       class="block text-gray-700 text-sm font-bold mb-2">ظرفیت*:</label>
                                                <select id="size" class="border rounded-md w-full px-3 py-2"
                                                        name="size">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="512MB">512MB</option>
                                                    <option value="1GB">1GB</option>
                                                    <option value="2GB">2GB</option>
                                                    <option value="4GB">4GB</option>
                                                    <option value="8GB">8GB</option>
                                                    <option value="16GB">16GB</option>
                                                    <option value="32GB">32GB</option>
                                                    <option value="64GB">64GB</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="frequency"
                                                       class="block text-gray-700 text-sm font-bold mb-2">فرکانس*:</label>
                                                <input type="text" id="frequency" name="frequency" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="فرکانس را وارد کنید">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت رم جدید
                                        </button>
                                        <button id="cancel-new-ram" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="edit-ram">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editRAMModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 edit"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            ویرایش رم
                                        </h3>
                                        <div class="mt-4">
                                            <div class="mb-4">
                                                <label for="brandForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">برند:</label>
                                                <select id="brandForEdit" class="border rounded-md w-full px-3 py-2"
                                                        name="brandForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $brands=\App\Models\Catalogs\Company::
                                                        where('name','!=','ONBOARD')
                                                        ->whereJsonContains('products', ['RAM'])
                                                        ->orderBy('name')->get();
                                                    @endphp
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="modelForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">مدل*:</label>
                                                <input type="text" id="modelForEdit" name="modelForEdit"
                                                       autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="مدل را به انگلیسی وارد کنید">
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="typeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نوع*:</label>
                                                <select id="typeForEdit" class="border rounded-md w-full px-3 py-2"
                                                        name="typeForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="DDR1">DDR1</option>
                                                    <option value="DDR2">DDR2</option>
                                                    <option value="DDR3">DDR3</option>
                                                    <option value="DDR4">DDR4</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="sizeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نسل*:</label>
                                                <select id="sizeForEdit" class="border rounded-md w-full px-3 py-2"
                                                        name="sizeForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="512MB">512MB</option>
                                                    <option value="1GB">1GB</option>
                                                    <option value="2GB">2GB</option>
                                                    <option value="4GB">4GB</option>
                                                    <option value="8GB">8GB</option>
                                                    <option value="16GB">16GB</option>
                                                    <option value="32GB">32GB</option>
                                                    <option value="64GB">64GB</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="frequencyForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">فرکانس*:</label>
                                                <input type="text" id="frequencyForEdit" name="frequencyForEdit" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="فرکانس را وارد کنید">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <input type="hidden" name="ram_id" id="ram_id" value="">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ویرایش
                                        </button>
                                        <button id="cancel-edit-ram" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                    <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                        <th class="px-6 py-3  font-bold ">ردیف</th>
                        <th class="px-6 py-3  font-bold ">نام سازنده</th>
                        <th class="px-6 py-3  font-bold ">مدل</th>
                        <th class="px-6 py-3  font-bold ">نوع</th>
                        <th class="px-6 py-3  font-bold ">سایز</th>
                        <th class="px-6 py-3  font-bold ">فرکانس</th>
                        <th class="px-6 py-3  font-bold ">عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @foreach ($ramList as $ram)
                        <tr class="bg-white">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $ramInfo=\App\Models\Catalogs\Company::find($ram->company_id)
                                @endphp
                                {{ $ramInfo->name }}</td>
                            <td class="px-6 py-4">{{ $ram->model }}</td>
                            <td class="px-6 py-4">{{ $ram->type }}</td>
                            <td class="px-6 py-4">{{ $ram->size }}</td>
                            <td class="px-6 py-4">{{ $ram->frequency }}</td>
                            <td class="px-6 py-4">
                                <button type="submit" data-id="{{ $ram->id }}"
                                        class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 RAMControl">
                                    جزئیات و ویرایش
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $ramList->links() }}
                </div>
            </div>

        </div>
    </main>
@endsection
