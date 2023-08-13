@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8 ">
        <div class=" mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">مدیریت پرسنل</h1>
            <div class="flex">
                <button id="new-person-button" type="button"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    پرسنل جدید
                </button>
                <form id="new-person">
                    @csrf
                    <div class="mt-4 mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newPersonModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 add"></div>
                                </div>

                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف پرسنل جدید
                                        </h3>
                                        <div class="mt-4">
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="name"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نام*:</label>
                                                <input type="text" id="name" name="name" autocomplete="off"
                                                       class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                                       placeholder="نام پرسنل را وارد کنید">
                                                <label for="family"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نام
                                                    خانوادگی*:</label>
                                                <input type="text" id="family" name="family" autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="نام خانوادگی پرسنل را وارد کنید">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="personnel_code"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کد
                                                    پرسنلی*:</label>
                                                <input type="text" name="personnel_code" id="personnel_code"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="کد پرسنلی را وارد کنید">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="phone"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    داخلی:</label>
                                                <input type="text" name="phone" id="phone"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="شماره داخلی را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="mobile"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    همراه:</label>
                                                <input type="text" name="mobile" id="mobile"
                                                       class="border rounded-md w-full mb-4 px-3 py-2 "
                                                       placeholder="شماره همراه را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="net_username"
                                                       class="block text-gray-700 text-sm font-bold mb-2">یوزر
                                                    شبکه:</label>
                                                <input type="text" name="net_username" id="net_username"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="یوزر شبکه را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="room_number"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    اتاق:</label>
                                                <input type="text" name="room_number" id="room_number"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="شماره اتاق را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="mb-4">
                                                <label for="assistance"
                                                       class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                                <select id="assistance" class="border rounded-md w-full px-3 py-2"
                                                        name="assistance"
                                                        title="معاونت/بخش را وارد کنید (اختیاری)">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                                    @endphp
                                                    @foreach($assistances as $assistance)
                                                        <option
                                                            value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت پرسنل جدید
                                        </button>
                                        <button id="cancel-new-person" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form id="edit-person">
                    @csrf
                    <div class="mt-4 mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editPersonModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 edit"></div>
                                </div>

                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            ویرایش پرسنل
                                        </h3>
                                        <div class="mt-4">
                                            <div class="flex flex-col items-right mb-2">
                                                <label for="nameForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نام*:</label>
                                                <input type="text" id="nameForEdit" name="nameForEdit"
                                                       autocomplete="off"
                                                       class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                                       placeholder="نام پرسنل را وارد کنید">
                                                <label for="familyForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نام
                                                    خانوادگی*:</label>
                                                <input type="text" id="familyForEdit" name="familyForEdit"
                                                       autocomplete="off"
                                                       class="border rounded-md w-full mb-2 px-3 py-2 text-right"
                                                       placeholder="نام خانوادگی پرسنل را وارد کنید">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="personnel_codeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کد
                                                    پرسنلی*:</label>
                                                <input type="text" disabled name="personnel_codeForEdit"
                                                       id="personnel_codeForEdit"
                                                       class="border rounded-md bg-gray-300 w-full mb-4 px-3 py-2"
                                                       placeholder="کد پرسنلی را وارد کنید">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="phoneForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    داخلی:</label>
                                                <input type="text" name="phoneForEdit" id="phoneForEdit"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="شماره داخلی را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="mobileForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    همراه:</label>
                                                <input type="text" name="mobileForEdit" id="mobileForEdit"
                                                       class="border rounded-md w-full mb-4 px-3 py-2 "
                                                       placeholder="شماره همراه را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="net_usernameForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">یوزر
                                                    شبکه:</label>
                                                <input type="text" name="net_usernameForEdit" id="net_usernameForEdit"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="یوزر شبکه را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="room_numberForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    اتاق:</label>
                                                <input type="text" name="room_numberForEdit" id="room_numberForEdit"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="شماره اتاق را وارد کنید (اختیاری)">
                                            </div>
                                            <div class="mb-4">
                                                <label for="assistanceForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                                <select id="assistanceForEdit"
                                                        class="border rounded-md w-full px-3 py-2"
                                                        name="assistanceForEdit"
                                                        title="معاونت/بخش را وارد کنید (اختیاری)">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                                    @endphp
                                                    @foreach($assistances as $assistance)
                                                        <option
                                                            value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <input type="hidden" name="personID" id="personID" value="">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ویرایش پرسنل
                                        </button>
                                        <button id="cancel-edit-person" type="button"
                                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                            انصراف
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                <div class=" mb-4 flex w-full">
                    {{--                    <label for="search-Username-UserManager" class="block mt-3 text-sm font-bold text-gray-700">جستجو در--}}
                    {{--                        کد--}}
                    {{--                        پرسنلی:</label>--}}
                    {{--                    <input id="search-Username-UserManager" autocomplete="off"--}}
                    {{--                           placeholder="لطفا کد پرسنلی را وارد نمایید."--}}
                    {{--                           type="text" name="search-Username-UserManager"--}}
                    {{--                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"/>--}}
                    {{--                    <label for="search-type-UserManager"--}}
                    {{--                           class="block text-gray-700 text-sm font-bold mt-3 ">جستجو در نقش--}}
                    {{--                        پرسنلی:</label>--}}
                    {{--                    <select id="search-type-UserManager" class="border rounded-md  px-3 "--}}
                    {{--                            name="search-type-UserManager">--}}
                    {{--                        <option value="">بدون فیلتر</option>--}}
                    {{--                        @foreach($personList->pluck('type', 'subject')->unique() as $type => $subject)--}}
                    {{--                            <option value="{{ $subject }}">{{ $type }}</option>--}}
                    {{--                        @endforeach--}}
                    {{--                    </select>--}}
                </div>
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class=" px-6 py-3  font-bold ">کد پرسنلی</th>
                            <th class=" px-6 py-3  font-bold ">مشخصات</th>
                            <th class=" px-3 py-3  font-bold ">شماره داخلی</th>
                            <th class=" px-3 py-3  font-bold ">شماره همراه</th>
                            <th class=" px-3 py-3  font-bold ">یوزر شبکه</th>
                            <th class=" px-3 py-3  font-bold ">معاونت</th>
                            <th class=" px-3 py-3  font-bold ">شماره اتاق</th>
                            <th class=" px-3 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($personList as $person)
                            <tr class="bg-white">
                                <td class="px-3 py-4">{{ $person->personnel_code }}</td>
                                <td class="px-6 py-4">{{ $person->name . ' ' . $person->family  }}</td>
                                <td class="px-3 py-4">{{ $person->phone }}</td>
                                <td class="px-3 py-4">{{ $person->mobile }}</td>
                                <td class="px-3 py-4">{{ $person->net_username }}</td>
                                <td class="px-3 py-4">
                                    @php
                                        $assistanceInfo=\App\Models\Catalogs\Assistance::find($person->assistance);
                                    @endphp
                                    {{ @$assistanceInfo->name }}</td>
                                <td class="px-3 py-4">{{ $person->room_number }}</td>
                                <td class="px-6 py-4">
                                    <button type="submit" data-id="{{ $person->id }}"
                                            class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 PersonControl">
                                        جزئیات و ویرایش
                                    </button>
                                    <button type="submit" data-id="{{ $person->id }}"
                                            class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EquipmentControl">
                                        وضعیت تجهیزات این کاربر
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $personList->links() }}
                </div>

            </div>

        </div>
    </main>
    @include('layouts.JSScripts')
@endsection
