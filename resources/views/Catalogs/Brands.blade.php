@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تعاریف اولیه - مدیریت بر اطلاعات برند</h1>

            <div class="bg-white rounded shadow p-6 flex flex-col ">
                <button id="new-brand-button" type="button"
                        class="px-4 py-2 bg-green-500 w-32 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                    برند جدید
                </button>
                <form id="new-brand">
                    @csrf
                    <div class="mt-4 mb-4 flex items-center">
                        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="newBrandModal">
                            <div
                                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                </div>
                                <div
                                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                            تعریف شرکت جدید
                                        </h3>
                                        <div class="mt-4">
                                            <div class="flex flex-col items-right mb-4">
                                                <label for="name"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نام شرکت*:</label>
                                                <input type="text" id="name" name="name" autocomplete="off"
                                                       class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                                       placeholder="نام شرکت را به انگلیسی وارد کنید">
                                            </div>
                                            <div class="mb-4">
                                                <label for="products"
                                                       class="block text-gray-700 text-sm font-bold mb-2">نوع محصول*:</label>
                                                <select id="products[]" class="border rounded-md w-full px-3 py-2 h-72" multiple
                                                        name="products[]">
                                                    <option value="Case">Case</option>
                                                    <option value="Motherboard">Motherboard</option>
                                                    <option value="Monitor">Monitor</option>
                                                    <option value="CPU">CPU</option>
                                                    <option value="RAM">RAM</option>
                                                    <option value="Graphic Card">Graphic Card</option>
                                                    <option value="HDD/SSD/M.2">HDD/SSD/M.2</option>
                                                    <option value="Copy Machine">Copy Machine</option>
                                                    <option value="Scanner">Scanner</option>
                                                    <option value="LAN/WLAN Card">LAN/WLAN Card</option>
                                                    <option value="Network Card">Network Card</option>
                                                    <option value="ODD">ODD</option>
                                                    <option value="Power">Power</option>
                                                    <option value="VOIP">VOIP</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                            ثبت شرکت جدید
                                        </button>
                                        <button id="cancel-new-brand" type="button"
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
                    <label for="search-brand-catalog-code" class="block font-bold text-gray-700">جستجو در برند:</label>
                    <input id="search-brand-catalog-name" autocomplete="off"
                           placeholder="نام برند را وارد نمایید."
                           type="text" name="search-brand-catalog-name"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"/>
                </div>
                <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                    <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                        <th class="px-6 py-3  font-bold ">ردیف</th>
                        <th class="px-6 py-3  font-bold ">نام برند</th>
                        <th class="px-6 py-3  font-bold ">نوع محصولات</th>
                        <th class="px-6 py-3  font-bold ">عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @php $row=1 @endphp
                    @foreach ($brandList as $brand)
                        <tr class="bg-white">
                            <td class="px-6 py-4">{{ $row++ }}</td>
                            <td class="px-6 py-4">{{ $brand->name }}</td>
                            <td class="px-6 py-4">{{ $brand->products }}</td>
                            <td class="px-6 py-4">
                                <button type="submit" data-id="{{ $brand->id }}"
                                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                    جزئیات و ویرایش
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $brandList->links() }}
                </div>
            </div>

        </div>
    </main>
@endsection
