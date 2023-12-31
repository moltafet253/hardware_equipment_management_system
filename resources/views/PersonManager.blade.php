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
                        {{--                        <div class="fixed z-10 inset-0 overflow-y-auto " id="newPersonModal">--}}
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
                                                <label for="national_code"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کد
                                                    ملی:</label>
                                                <input type="text" name="national_code" id="national_code"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="کد ملی را وارد کنید">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="personnel_code"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کد
                                                    پرسنلی:</label>
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
                                            <div class="mb-4">
                                                <label for="assistance"
                                                       class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                                <select id="assistance" class="border rounded-md w-96 px-3 py-2 select2"
                                                        name="assistance"
                                                        title="معاونت/بخش را انتخاب کنید (اختیاری)">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $assistances=\App\Models\Catalogs\Assistance::where('active',1)->orderBy('name')->get();
                                                    @endphp
                                                    @foreach($assistances as $assistance)
                                                        <option
                                                            value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="establishmentplace"
                                                       class="block text-gray-700 text-sm font-bold mb-2">محل
                                                    استقرار:</label>
                                                <select id="establishmentplace"
                                                        class="border rounded-md w-96 px-3 py-2 select2"
                                                        name="establishmentplace"
                                                        title="محل استقرار را انتخاب کنید (اختیاری)">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $establishmentPlaces=\App\Models\EstablishmentPlace::where('active',1)->orderBy('title')->get();
                                                    @endphp
                                                    @foreach($establishmentPlaces as $establishmentPlace)
                                                        <option
                                                            value="{{ $establishmentPlace->id }}">{{$establishmentPlace->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="executive_position"
                                                       class="block text-gray-700 text-sm font-bold mb-2">سمت
                                                    اجرایی:</label>
                                                <select id="executive_position"
                                                        class="border rounded-md w-96 px-3 py-2 select2"
                                                        name="executive_position"
                                                        title="سمت اجرایی را انتخاب کنید (اختیاری)">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $executivePositions=\App\Models\ExecutivePosition::where('active',1)->orderBy('title')->get();
                                                    @endphp
                                                    @foreach($executivePositions as $executivePosition)
                                                        <option
                                                            value="{{ $executivePosition->id }}">{{$executivePosition->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="room_number"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    اتاق:</label>
                                                <input type="text" name="room_number" id="room_number"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="شماره اتاق را وارد کنید (اختیاری)">
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
                                                <label for="national_codeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کد
                                                    ملی:</label>
                                                <input type="text" name="national_codeForEdit" id="national_codeForEdit"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="کد ملی را وارد کنید">
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="personnel_codeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">کد
                                                    پرسنلی*:</label>
                                                <input type="text" name="personnel_codeForEdit"
                                                       id="personnel_codeForEdit"
                                                       class="border rounded-md  w-full mb-4 px-3 py-2"
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
                                            <div class="mb-4">
                                                <label for="assistanceForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                                <select id="assistanceForEdit"
                                                        class="border rounded-md w-96 px-3 py-2  assistanceForEdit select2"
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
                                            <div class="mb-4">
                                                <label for="establishmentplaceForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">محل
                                                    استقرار:</label>
                                                <select id="establishmentplaceForEdit"
                                                        class="border rounded-md w-96 px-3 py-2 select2 establishmentplaceForEdit"
                                                        name="establishmentplaceForEdit"
                                                        title="محل استقرار را انتخاب کنید (اختیاری)">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $establishmentPlaces=\App\Models\EstablishmentPlace::orderBy('title')->get();
                                                    @endphp
                                                    @foreach($establishmentPlaces as $establishmentPlace)
                                                        <option
                                                            value="{{ $establishmentPlace->id }}">{{$establishmentPlace->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="executive_positionForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">سمت
                                                    اجرایی:</label>
                                                <select id="executive_positionForEdit"
                                                        class="border rounded-md w-96 px-3 py-2 select2 executive_positionForEdit"
                                                        name="executive_positionForEdit"
                                                        title="سمت اجرایی را انتخاب کنید (اختیاری)">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    @php
                                                        $executivePositions=\App\Models\ExecutivePosition::where('active',1)->orderBy('title')->get();
                                                    @endphp
                                                    @foreach($executivePositions as $executivePosition)
                                                        <option
                                                            value="{{ $executivePosition->id }}">{{$executivePosition->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="room_numberForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">شماره
                                                    اتاق:</label>
                                                <input type="text" name="room_numberForEdit" id="room_numberForEdit"
                                                       class="border rounded-md w-full mb-4 px-3 py-2"
                                                       placeholder="شماره اتاق را وارد کنید (اختیاری)">
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
                <form id="search-person">
                <div class="mb-4 flex w-full">
                    <label for="search-personnel-code" class="block mt-3 text-sm font-bold text-gray-700">
                        کد پرسنلی:</label>
                    <input id="search-personnel-code" autocomplete="off"
                           type="text" name="search-personnel-code"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 w-24"/>

                    <label for="search-personnel-national_code" class="block mt-3 text-sm font-bold text-gray-700">
                        کد ملی:</label>
                    <input id="search-personnel-national-code" autocomplete="off"
                           type="text" name="search-personnel-national-code" placeholder="کد ملی را وارد نمایید"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 w-48"/>

                    <label for="search-name" class="block mt-3 text-sm font-bold text-gray-700">
                        نام:</label>
                    <input id="search-name" autocomplete="off"
                           placeholder="نام را وارد نمایید."
                           type="text" name="search-name"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 w-48"/>

                    <label for="search-family" class="block mt-3 text-sm font-bold text-gray-700">
                        نام خانوادگی:</label>
                    <input id="search-family" autocomplete="off"
                           placeholder="نام خانوادگی را وارد نمایید."
                           type="text" name="search-family"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300 w-48"/>

                    <button type="submit"
                            class="px-4 py-2 h-11 mt-1 ml-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                        فیلتر
                    </button>
                    <button type="button"
                            class="px-4 py-2 h-11 mt-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 Reset">
                        بازنشانی
                    </button>
                </div>
                </form>
                <div class="max-w-full overflow-x-auto">
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class=" px-6 py-3  font-bold ">کد پرسنلی</th>
                            <th class=" px-6 py-3  font-bold ">مشخصات</th>
                            <th class=" px-6 py-3  font-bold ">کد ملی</th>
                            <th class=" px-3 py-3  font-bold ">شماره داخلی</th>
                            <th class=" px-3 py-3  font-bold ">شماره همراه</th>
                            <th class=" px-3 py-3  font-bold ">یوزر شبکه</th>
                            <th class=" px-3 py-3  font-bold ">معاونت/بخش</th>
                            <th class=" px-3 py-3  font-bold ">محل استقرار</th>
                            <th class=" px-3 py-3  font-bold ">سمت اجرایی</th>
                            <th class=" px-3 py-3  font-bold ">شماره اتاق</th>
                            <th class=" px-3 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                        @foreach ($personList as $person)
                            <tr class="bg-white">
                                <td class="px-3 py-4">{{ $person->personnel_code }}</td>
                                <td class="px-6 py-4">{{ $person->name . ' ' . $person->family  }}</td>
                                <td class="px-3 py-4">{{ $person->national_code }}</td>
                                <td class="px-3 py-4">{{ $person->phone }}</td>
                                <td class="px-3 py-4">{{ $person->mobile }}</td>
                                <td class="px-3 py-4">{{ $person->net_username }}</td>
                                <td class="px-3 py-4">
                                    @php
                                        $assistanceInfo=\App\Models\Catalogs\Assistance::find($person->assistance);
                                    @endphp
                                    {{ @$assistanceInfo->name }}
                                </td>
                                <td class="px-3 py-4">
                                    @php
                                        $establishmentPlaceInfo=\App\Models\EstablishmentPlace::find($person->establishment_place);
                                    @endphp
                                    {{ @$establishmentPlaceInfo->title }}
                                </td>
                                <td class="px-3 py-4">
                                    @php
                                        $executivePositionInfo=\App\Models\ExecutivePosition::find($person->executive_position);
                                    @endphp
                                    {{ @$executivePositionInfo->title }}
                                </td>
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
    <script>
        function redirectToEquipmentStatus(id) {
            window.location.href = `{{ route('showEquipmentStatus') }}?id=${id}`;
        }

        function swalFire(title = null, text, icon, confirmButtonText) {
            Swal.fire({
                title: title, text: text, icon: icon, confirmButtonText: confirmButtonText,
            });
        }

        function toggleModal(modalID) {
            var modal = document.getElementById(modalID);
            if (modal.classList.contains('modal-active')) {
                modal.classList.remove('animate-fade-in');
                modal.classList.add('animate-fade-out');
                setTimeout(() => {
                    modal.classList.remove('modal-active');
                    modal.classList.remove('animate-fade-out');
                }, 150);
            } else {
                modal.classList.add('modal-active');
                modal.classList.remove('animate-fade-out');
                modal.classList.add('animate-fade-in');
            }
        }
        $(document).on('click', '.EquipmentControl', function () {
            const id = $(this).data('id');
            redirectToEquipmentStatus(id);
        });
        $(document).on('click', '#cancel-edit-person', function () {
            toggleModal(editPersonModal.id)
        });
        $(document).on('click', '.absolute.inset-0.bg-gray-500.opacity-75.edit', function () {
            toggleModal(editPersonModal.id)
        });
        $(document).on('click', '.PersonControl', function () {
            $.ajax({
                type: 'GET', url: '/getPersonInfo', data: {
                    id: $(this).data('id')
                }, success: function (response) {
                    if (response) {
                        personID.value = response.id;
                        nameForEdit.value = response.name;
                        familyForEdit.value = response.family;
                        national_codeForEdit.value = response.national_code;
                        personnel_codeForEdit.value = response.personnel_code;
                        phoneForEdit.value = response.phone;
                        mobileForEdit.value = response.mobile;
                        net_usernameForEdit.value = response.net_username;
                        room_numberForEdit.value = response.room_number;
                        $(".assistanceForEdit").val(response.assistance).trigger("change");
                        $(".establishmentplaceForEdit").val(response.establishment_place).trigger("change");
                        $(".executive_positionForEdit").val(response.executive_position).trigger("change");
                    }
                }
            });
            toggleModal(editPersonModal.id)
        });

        $('#search-person').on('submit', async function (e) {
            e.preventDefault();
            var inputName = $('#search-name').val().trim().toLowerCase();
            var inputFamily = $('#search-family').val().trim().toLowerCase();
            var inputCode = $('#search-personnel-code').val().trim().toLowerCase();
            var inputNationalCode = $('#search-personnel-national-code').val().trim().toLowerCase();

            if (!inputName && !inputFamily && !inputCode && !inputNationalCode) {
                swalFire('خطا!', 'لطفاً یکی از فیلدها را وارد نمایید.', 'error', 'تلاش مجدد');
            } else {
                try {
                    const data = await fetchData(inputName, inputFamily, inputCode,inputNationalCode);
                    let paginationDiv=document.getElementById('laravel-next-prev');
                    paginationDiv.style.display='none';
                    displayData(data);
                } catch (error) {
                    console.error(error);
                    console.log('خطا در ارتباط با سرور');
                }
            }
        });

        async function fetchData(inputName, inputFamily, inputCode,inputNationalCode) {
            return new Promise(async (resolve, reject) => {
                try {
                    const data = await $.ajax({
                        url: '/Search',
                        type: 'GET',
                        data: {
                            name: inputName,
                            family: inputFamily,
                            code: inputCode,
                            national_code: inputNationalCode,
                            work: 'PersonManagerSearch'
                        }
                    });
                    resolve(data);
                } catch (error) {
                    reject(error);
                }
            });
        }

        function displayData(data) {
            var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
            tableBody.empty();

            data.forEach(async function (person) {
                var row = '<tr class="bg-white">';
                var personnel_code = person.personnel_code !== null ? person.personnel_code : "ثبت نشده";
                var name = person.name !== null ? person.name : "ثبت نشده";
                var family = person.family !== null ? person.family : "ثبت نشده";
                var national_code = person.national_code !== null ? person.national_code : "ثبت نشده";
                var phone = person.phone !== null ? person.phone : "ثبت نشده";
                var mobile = person.mobile !== null ? person.mobile : "ثبت نشده";
                var net_username = person.net_username !== null ? person.net_username : "ثبت نشده";
                var assistance = person.assistance !== null ? person.assistance : "ثبت نشده";
                var establishment_place = person.establishment_place !== null ? person.establishment_place : "ثبت نشده";
                var executive_position = person.executive_position !== null ? person.executive_position : "ثبت نشده";
                var room_number = person.room_number !== null ? person.room_number : "ثبت نشده";

                row += '<td class="px-6 py-4">' + personnel_code + '</td>';
                row += '<td class="px-6 py-4">' + name + ' ' + family + '</td>';
                row += '<td class="px-6 py-4">' + national_code + '</td>';
                row += '<td class="px-6 py-4">' + phone + '</td>';
                row += '<td class="px-6 py-4">' + mobile + '</td>';
                row += '<td class="px-6 py-4">' + net_username + '</td>';

                try {
                    const assistanceName = await getAssistanceInfo(assistance);
                    row += '<td class="px-6 py-4">' + assistanceName + '</td>';
                } catch (error) {
                    console.error(error);
                    row += '<td class="px-6 py-4">مشکل در دریافت اطلاعات</td>';
                }

                try {
                    const establishment_placeName = await getEstablishmentPlaceInfo(establishment_place);
                    row += '<td class="px-6 py-4">' + establishment_placeName + '</td>';
                } catch (error) {
                    console.error(error);
                    row += '<td class="px-6 py-4">مشکل در دریافت اطلاعات</td>';
                }

                try {
                    const executive_positionName = await getExecutivePositionInfo(executive_position);
                    row += '<td class="px-6 py-4">' + executive_positionName + '</td>';
                } catch (error) {
                    console.error(error);
                    row += '<td class="px-6 py-4">مشکل در دریافت اطلاعات</td>';
                }

                row += '<td class="px-6 py-4">' + room_number + '</td>';
                row += '<td class="px-6 py-4"><button type="button" data-id="' + person.id + '" class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 PersonControl">جزئیات و ویرایش</button>';
                row += '<button type="button" data-id="' + person.id + '" class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EquipmentControl">وضعیت تجهیزات این کاربر</button>' + '</td>';
                row += '</tr>';
                tableBody.append(row);
            });
        }

        async function getAssistanceInfo(assistanceID) {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await $.ajax({
                        type: 'GET',
                        url: '/getAssistanceInfo',
                        data: {
                            id: assistanceID
                        }
                    });
                    if (response) {
                        resolve(response['name']);
                    } else {
                        reject('اطلاعاتی یافت نشد.');
                    }
                } catch (error) {
                    reject('خطا در ارتباط با سرور.');
                }
            });
        }

        async function getEstablishmentPlaceInfo(establishmentPlaceID) {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await $.ajax({
                        type: 'GET',
                        url: '/getEstablishmentPlaceInfo',
                        data: {
                            id: establishmentPlaceID
                        }
                    });
                    if (response) {
                        resolve(response['title']);
                    } else {
                        reject('اطلاعاتی یافت نشد.');
                    }
                } catch (error) {
                    reject('خطا در ارتباط با سرور.');
                }
            });
        }

        async function getExecutivePositionInfo(assistanceID) {
            return new Promise(async (resolve, reject) => {
                try {
                    const response = await $.ajax({
                        type: 'GET',
                        url: '/getExecutivePositionInfo',
                        data: {
                            id: assistanceID
                        }
                    });
                    if (response) {
                        resolve(response['title']);
                    } else {
                        reject('اطلاعاتی یافت نشد.');
                    }
                } catch (error) {
                    reject('خطا در ارتباط با سرور.');
                }
            });
        }

    </script>
    @include('layouts.JSScripts')
@endsection
