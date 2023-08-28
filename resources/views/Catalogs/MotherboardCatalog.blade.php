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
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newMotherboardModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 add"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف مادربورد جدید
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
                                                        ->whereJsonContains('products', ['Motherboard'])
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
                                            <div class="flex flex-col items-right mb-4">
                                                <label for="mb_gen"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نسل
                                                    مادربورد:</label>
                                                <select id="mb_gen" class="border rounded-md w-full px-3 py-2"
                                                        name="mb_gen">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="ATX">ATX</option>
                                                    <option value="E-ATX">E-ATX</option>
                                                    <option value="Mini-ITX">Mini-ITX</option>
                                                    <option value="Micro-ATX">Micro-ATX</option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="ram_slot_gen"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نسل اسلات
                                                    رم:</label>
                                                <select id="ram_slot_gen" class="border rounded-md w-full px-3 py-2"
                                                        name="ram_slot_gen">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="DDR1">DDR1</option>
                                                    <option value="DDR2">DDR2</option>
                                                    <option value="DDR3">DDR3</option>
                                                    <option value="DDR4">DDR4</option>
                                                    <option value="DDR5">DDR5</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="cpu_slot_type"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نوع سوکت
                                                    پردازنده:</label>
                                                <select id="cpu_slot_type" class="border rounded-md w-full px-3 py-2"
                                                        name="cpu_slot_type">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="771">771</option>
                                                    <option value="775">775</option>
                                                    <option value="1150">1150</option>
                                                    <option value="1151">1151</option>
                                                    <option value="1155">1155</option>
                                                    <option value="1156">1156</option>
                                                    <option value="1200">1200</option>
                                                    <option value="1248">1248</option>
                                                    <option value="1356">1356</option>
                                                    <option value="1567">1567</option>
                                                    <option value="1700">1700</option>
                                                    <option value="1851">1851</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2066">2066</option>
                                                    <option value="3647">3647</option>
                                                    <option value="4189">4189</option>
                                                    <option value="4677">4677</option>
                                                    <option value="7529">7529</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="cpu_slot_num"
                                                       class="block text-gray-700 text-sm font-bold mb-2">تعداد سوکت
                                                    پردازنده:</label>
                                                <select id="cpu_slot_num" class="border rounded-md w-full px-3 py-2"
                                                        name="cpu_slot_num">
                                                    <option selected value="1">1</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="ram_slot_num"
                                                       class="block text-gray-700 text-sm font-bold mb-2">تعداد سوکت
                                                    رم:</label>
                                                <select id="ram_slot_num" class="border rounded-md w-full px-3 py-2"
                                                        name="ram_slot_num">
                                                    <option selected value="2">2</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت مادربورد جدید
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
                <form id="edit-motherboard">
                    @csrf
                    <div class="mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editMotherboardModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75 edit"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            ویرایش مادربورد
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
                                                        ->whereJsonContains('products', ['Motherboard'])
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
                                            <div class="flex flex-col items-right mb-4">
                                                <label for="mb_genForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نسل
                                                    مادربورد:</label>
                                                <select id="mb_genForEdit" class="border rounded-md w-full px-3 py-2"
                                                        name="mb_genForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="ATX">ATX</option>
                                                    <option value="E-ATX">E-ATX</option>
                                                    <option value="Mini-ITX">Mini-ITX</option>
                                                    <option value="Micro-ATX">Micro-ATX</option>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="ram_slot_genForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نسل اسلات
                                                    رم:</label>
                                                <select id="ram_slot_genForEdit"
                                                        class="border rounded-md w-full px-3 py-2"
                                                        name="ram_slot_genForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="DDR1">DDR1</option>
                                                    <option value="DDR2">DDR2</option>
                                                    <option value="DDR3">DDR3</option>
                                                    <option value="DDR4">DDR4</option>
                                                    <option value="DDR5">DDR5</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="cpu_slot_typeForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نوع سوکت
                                                    پردازنده:</label>
                                                <select id="cpu_slot_typeForEdit"
                                                        class="border rounded-md w-full px-3 py-2"
                                                        name="cpu_slot_typeForEdit">
                                                    <option value="" disabled selected>انتخاب کنید</option>
                                                    <option value="771">771</option>
                                                    <option value="775">775</option>
                                                    <option value="1150">1150</option>
                                                    <option value="1151">1151</option>
                                                    <option value="1155">1155</option>
                                                    <option value="1156">1156</option>
                                                    <option value="1200">1200</option>
                                                    <option value="1248">1248</option>
                                                    <option value="1356">1356</option>
                                                    <option value="1567">1567</option>
                                                    <option value="1700">1700</option>
                                                    <option value="1851">1851</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2066">2066</option>
                                                    <option value="3647">3647</option>
                                                    <option value="4189">4189</option>
                                                    <option value="4677">4677</option>
                                                    <option value="7529">7529</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="cpu_slot_numForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">تعداد سوکت
                                                    پردازنده:</label>
                                                <select id="cpu_slot_numForEdit"
                                                        class="border rounded-md w-full px-3 py-2"
                                                        name="cpu_slot_numForEdit">
                                                    <option selected value="1">1</option>
                                                    <option value="2">2</option>
                                                </select>
                                            </div>
                                            <div class="flex flex-col mb-4">
                                                <label for="ram_slot_numForEdit"
                                                       class="block text-gray-700 text-sm font-bold mb-2">تعداد سوکت
                                                    رم:</label>
                                                <select id="ram_slot_numForEdit"
                                                        class="border rounded-md w-full px-3 py-2"
                                                        name="ram_slot_numForEdit">
                                                    <option selected value="2">2</option>
                                                    <option value="4">4</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <input type="hidden" name="mb_id" id="mb_id" value="">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ویرایش
                                        </button>
                                        <button id="cancel-edit-motherboard" type="button"
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
                        <th class="px-6 py-3  font-bold ">نسل</th>
                        <th class="px-6 py-3  font-bold ">نسل اسلات رم</th>
                        <th class="px-6 py-3  font-bold ">نوع سوکت پردازنده</th>
                        <th class="px-6 py-3  font-bold ">تعداد اسلات پردازنده</th>
                        <th class="px-6 py-3  font-bold ">تعداد اسلات رم</th>
                        <th class="px-6 py-3  font-bold ">عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @foreach ($mbList as $mb)
                        <tr class="bg-white">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $motherboardInfo=\App\Models\Catalogs\Company::find($mb->company_id)
                                @endphp
                                {{ $motherboardInfo->name }}</td>
                            <td class="px-6 py-4">{{ $mb->model }}</td>
                            <td class="px-6 py-4">{{ $mb->generation }}</td>
                            <td class="px-6 py-4">{{ $mb->ram_slot_generation }}</td>
                            <td class="px-6 py-4">LGA {{ $mb->cpu_slot_type }}</td>
                            <td class="px-6 py-4">{{ $mb->cpu_slots_number }}</td>
                            <td class="px-6 py-4">{{ $mb->ram_slots_number }}</td>
                            <td class="px-6 py-4">
                                <button type="submit" data-id="{{ $mb->id }}"
                                        class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 MotherboardControl">
                                    جزئیات و ویرایش
                                </button>
                                @if($mb->active==1)
                                    <button type="submit" data-id="{{ $mb->id }}"
                                            class="px-4 py-2 mr-3 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-red-300 deactiveMotherboardControl">
                                        غیرفعالسازی
                                    </button>
                                @else
                                    <button type="submit" data-id="{{ $mb->id }}"
                                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-green-300 deactiveMotherboardControl">
                                        فعالسازی
                                    </button>
                                @endif
                            </td>
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
