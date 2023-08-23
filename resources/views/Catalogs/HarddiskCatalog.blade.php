@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تعاریف اولیه - مدیریت بر اطلاعات هارد دیسک</h1>

            <div class="bg-white rounded shadow p-6 flex flex-col ">
                <button id="new-harddisk-button" type="button"
                        class="px-4 py-2 bg-green-500 w-36 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    هارد دیسک جدید
                </button>
                <form id="new-harddisk">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newHarddiskModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 add"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف هارد دیسک جدید
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
                                                        ->whereJsonContains('products', ['HDD|SSD|M.2'])
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
                                                       class="block text-gray-700 text-sm font-bold mb-2">نوع*:</label>
                                                <select id="type" class="border rounded-md w-full px-3 py-2"
                                                        name="type">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="Internal">Internal</option>
                                                    <option value="External">External</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="capacity"
                                                       class="block text-gray-700 text-sm font-bold mb-2">ظرفیت*:</label>
                                                <select id="capacity" class="border rounded-md w-full px-3 py-2"
                                                        name="capacity">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="120GB">120GB</option>
                                                    <option value="128GB">128GB</option>
                                                    <option value="250GB">250GB</option>
                                                    <option value="256GB">256GB</option>
                                                    <option value="480GB">480GB</option>
                                                    <option value="500GB">500GB</option>
                                                    <option value="512GB">512GB</option>
                                                    <option value="1TB">1TB</option>
                                                    <option value="2TB">2TB</option>
                                                    <option value="4TB">4TB</option>
                                                    <option value="6TB">6TB</option>
                                                    <option value="8TB">8TB</option>
                                                    <option value="10TB">10TB</option>
                                                    <option value="12TB">12TB</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="connectivity_type"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نوع
                                                    اتصال*:</label>
                                                <select id="connectivity_type"
                                                        class="border rounded-md w-full px-3 py-2"
                                                        name="connectivity_type">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="IDE">IDE</option>
                                                    <option value="SATA">SATA</option>
                                                    <option value="Onboard">Onboard</option>
                                                    <option value="USB">USB</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت هارد دیسک جدید
                                        </button>
                                        <button id="cancel-new-harddisk" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="edit-Harddisk">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editHarddiskModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 edit"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            ویرایش هارد دیسک
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
                                                        ->whereJsonContains('products', ['HDD|SSD|M.2'])
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
                                                    <option value="Internal">Internal</option>
                                                    <option value="External">External</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="capacityForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">ظرفیت*:</label>
                                                <select id="capacityForEdit" class="border rounded-md w-full px-3 py-2"
                                                        name="capacityForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="120GB">120GB</option>
                                                    <option value="128GB">128GB</option>
                                                    <option value="250GB">250GB</option>
                                                    <option value="256GB">256GB</option>
                                                    <option value="480GB">480GB</option>
                                                    <option value="500GB">500GB</option>
                                                    <option value="512GB">512GB</option>
                                                    <option value="1TB">1TB</option>
                                                    <option value="2TB">2TB</option>
                                                    <option value="4TB">4TB</option>
                                                    <option value="6TB">6TB</option>
                                                    <option value="8TB">8TB</option>
                                                    <option value="10TB">10TB</option>
                                                    <option value="12TB">12TB</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="connectivity_typeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نوع
                                                    اتصال*:</label>
                                                <select id="connectivity_typeForEdit"
                                                        class="border rounded-md w-full px-3 py-2"
                                                        name="connectivity_typeForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="IDE">IDE</option>
                                                    <option value="SATA">SATA</option>
                                                    <option value="Onboard">Onboard</option>
                                                    <option value="USB">USB</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <input type="hidden" name="harddisk_id" id="harddisk_id" value="">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ویرایش
                                        </button>
                                        <button id="cancel-edit-harddisk" type="button"
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
                        <th class="px-6 py-3  font-bold ">نوع اتصال</th>
                        <th class="px-6 py-3  font-bold ">عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @foreach ($harddiskList as $harddisk)
                        <tr class="bg-white">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $harddiskInfo=\App\Models\Catalogs\Company::find($harddisk->company_id)
                                @endphp
                                {{ $harddiskInfo->name }}</td>
                            <td class="px-6 py-4">{{ $harddisk->model }}</td>
                            <td class="px-6 py-4">{{ $harddisk->type }}</td>
                            <td class="px-6 py-4">{{ $harddisk->capacity }}</td>
                            <td class="px-6 py-4">{{ $harddisk->connectivity_type }}</td>
                            <td class="px-6 py-4">
                                <button type="submit" data-id="{{ $harddisk->id }}"
                                        class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 HarddiskControl">
                                    جزئیات و ویرایش
                                </button>
                                <button type="submit" data-id="{{ $harddisk->id }}"
                                        class="px-4 py-2 mr-3 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 deactiveHarddiskControl">
                                    @if($harddisk->active==1)
                                        غیرفعالسازی
                                    @else
                                        فعالسازی
                                    @endif
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $harddiskList->links() }}
                </div>
            </div>

        </div>
    </main>
@endsection
