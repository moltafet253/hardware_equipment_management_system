@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تعاریف اولیه - مدیریت بر اطلاعات لپ تاپ</h1>

            <div class="bg-white rounded shadow p-6 flex flex-col ">
                <button id="new-laptop-button" type="button"
                        class="px-4 py-2 bg-green-500 w-32 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    لپ تاپ جدید
                </button>
                <form id="new-laptop">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newLaptopModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 add"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف لپ تاپ جدید
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
                                                        ->whereJsonContains('products', ['Laptop'])
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
                                                <label for="cpu"
                                                       class="block text-gray-700 text-sm font-bold mb-2">پردازنده*:</label>
                                                <input type="text" id="cpu" name="cpu" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="پردازنده را به انگلیسی وارد کنید">
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="graphic_card"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کارت گرافیک*:</label>
                                                <input type="text" id="graphic_card" name="graphic_card" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="کارت گرافیک را به انگلیسی وارد کنید. پیش فرض: Onboard">
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="screen_size"
                                                       class="block text-gray-700 text-sm font-bold mb-2">سایز نمایشگر:</label>
                                                <select id="screen_size" class="border rounded-md w-full px-3 py-2"
                                                        name="screen_size">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="15.6">15.6</option>
                                                    <option value="17.3">17.3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت لپ تاپ جدید
                                        </button>
                                        <button id="cancel-new-laptop" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="edit-laptop">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editLaptopModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 edit"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            ویرایش لپ تاپ
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
                                                        ->whereJsonContains('products', ['Laptop'])
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
                                                <label for="cpuForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">پردازنده*:</label>
                                                <input type="text" id="cpuForEdit" name="cpuForEdit" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="پردازنده را به انگلیسی وارد کنید">
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="graphic_cardForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کارت گرافیک*:</label>
                                                <input type="text" id="graphic_cardForEdit" name="graphic_cardForEdit" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="کارت گرافیک را به انگلیسی وارد کنید. پیش فرض: Onboard">
                                            </div>
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="screen_sizeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">سایز نمایشگر:</label>
                                                <select id="screen_sizeForEdit" class="border rounded-md w-full px-3 py-2"
                                                        name="screen_sizeForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="15.6">15.6</option>
                                                    <option value="17.3">17.3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <input type="hidden" name="laptop_id" id="laptop_id" value="">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ویرایش
                                        </button>
                                        <button id="cancel-edit-laptop" type="button"
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
                        <th class="px-6 py-3  font-bold ">پردازنده</th>
                        <th class="px-6 py-3  font-bold ">کارت گرافیک</th>
                        <th class="px-6 py-3  font-bold ">سایز نمایشگر</th>
                        <th class="px-6 py-3  font-bold ">عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @foreach ($laptopList as $laptop)
                        <tr class="bg-white">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $laptopInfo=\App\Models\Catalogs\Company::find($laptop->company_id)
                                @endphp
                                {{ $laptopInfo->name }}</td>
                            <td class="px-6 py-4">{{ $laptop->model }}</td>
                            <td class="px-6 py-4">{{ $laptop->cpu }}</td>
                            <td class="px-6 py-4">{{ $laptop->graphic_card }}</td>
                            <td class="px-6 py-4">{{ $laptop->screen_size }}</td>
                            <td class="px-6 py-4">
                                <button type="submit" data-id="{{ $laptop->id }}"
                                        class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 LaptopControl">
                                    جزئیات و ویرایش
                                </button>
                                @if($laptop->active==1)
                                    <button type="submit" data-id="{{ $laptop->id }}"
                                            class="px-4 py-2 mr-3 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 deactiveLaptopControl">
                                        غیرفعالسازی
                                    </button>
                                @else
                                    <button type="submit" data-id="{{ $laptop->id }}"
                                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 deactiveLaptopControl">
                                        فعالسازی
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $laptopList->links() }}
                </div>
            </div>

        </div>
    </main>
@endsection
