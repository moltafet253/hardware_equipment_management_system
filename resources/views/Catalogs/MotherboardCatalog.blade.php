@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تعاریف اولیه - مدیریت بر اطلاعات مادربورد</h1>

            <div class="bg-white rounded shadow p-6 flex flex-col ">
                <button id="new-motherboard-button" type="button"
                        class="px-4 py-2 bg-green-500 w-32 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    مادربورد جدید
                </button>
                <form id="new-motherboard">
                    @csrf
                    <div class="mt-4 mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newMotherboardModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف مادربورد جدید
                                        </h3>
                                        <div class="mt-4">
                                            <div class="flex flex-col items-right mb-4">
                                                <label for="name"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نام*:</label>
                                                <input type="text" id="name" name="name" autocomplete="off"
                                                       class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                                       placeholder="نام کاربر">
                                            </div>
                                            <div class="mb-4">
                                                <label for="username"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نام
                                                    کاربری*:</label>
                                                <input type="text" id="username" name="username" autocomplete="off"
                                                       class="border rounded-md w-full px-3 py-2 text-left"
                                                       placeholder="نام کاربری">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="password"
                                                       class="block text-gray-700 text-sm font-bold mb-2">رمز
                                                    عبور*:</label>
                                                <input type="password" autocomplete="new-password" name="password"
                                                       id="password"
                                                       class="border rounded-md w-full mb-4 px-3 py-2 text-left"
                                                       placeholder="رمزعبور">
                                                <label for="repeat-password"
                                                       class="block text-gray-700 text-sm font-bold mb-2">تکرار رمز
                                                    عبور*:</label>
                                                <input type="password" autocomplete="new-password"
                                                       name="repeat-password" id="repeat-password"
                                                       class="border rounded-md w-full px-3 py-2 text-left"
                                                       placeholder="تکرار رمزعبور">
                                            </div>
                                            <div class="mb-4">
                                                <label for="type"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نقش
                                                    کاربر:</label>
                                                <select id="type" class="border rounded-md w-full px-3 py-2"
                                                        name="type">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="1">ادمین کل</option>
                                                    <option value="2">مدیر شهرداری</option>
                                                    <option value="3">معاون شهرداری</option>
                                                    <option value="4">کارشناس مسئول شهرداری</option>
                                                    <option value="5">کارشناس شهرداری</option>
                                                    <option value="6">سازمان</option>
                                                    <option value="7">باسکول</option>
                                                    <option value="8">پیمانکار</option>
                                                    <option value="9">راننده</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت کاربر جدید
                                        </button>
                                        <button id="cancel-new-motherboard" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class=" mb-4 flex items-center">
                    <label for="search-car-catalog-code" class="block font-bold text-gray-700">جستجو در مدل:</label>
                    <input id="search-car-catalog-code" autocomplete="off"
                           placeholder="لطفا مدل مادربورد را وارد نمایید."
                           type="text" name="search-car-catalog-code"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"/>
                </div>
                <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                    <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                        <th class="px-6 py-3  font-bold ">ردیف</th>
                        <th class="px-6 py-3  font-bold ">نام سازنده</th>
                        <th class="px-6 py-3  font-bold ">مدل</th>
                        <th class="px-6 py-3  font-bold ">نسل مادربورد</th>
                        <th class="px-6 py-3  font-bold ">تعداد اسلات cpu</th>
                        <th class="px-6 py-3  font-bold ">تعداد اسلات ram</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @php $row=1 @endphp
                    @foreach ($mbList as $mb)
                        <tr class="bg-white">
                            <td class="px-6 py-4">{{ $row++ }}</td>
                            <td class="px-6 py-4">{{ $mb->company_id }}</td>
                            <td class="px-6 py-4">{{ $mb->model }}</td>
                            <td class="px-6 py-4">{{ $mb->generation }}</td>
                            <td class="px-6 py-4">{{ $mb->cpu_slots_number }}</td>
                            <td class="px-6 py-4">{{ $mb->ram_slots_number }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $mbList->links() }}
                </div>
            </div>

        </div>
    </main>
@endsection
