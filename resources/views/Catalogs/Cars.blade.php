@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-gray-100 py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">تعاریف اولیه - مدیریت بر اطلاعات خودروها</h1>
            <form id="catalog-car" method="post" action="{{ route ('NewCar') }}">
                @csrf
                <div class="mt-4 mb-4 flex items-center">
                    <label for="inputField" class="block font-bold text-gray-700">اضافه کردن خودرو جدید:</label>
                    <input id="name" autocomplete="off" placeholder="لطفا نام خودرو را وارد نمایید." type="text"
                           name="name"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"/>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                        ثبت
                    </button>
                </div>
            </form>
            <div class="bg-white rounded shadow p-6 flex flex-col items-center">
                <div class=" mb-4 flex items-center">
                    <label for="search-car-catalog-code" class="block font-bold text-gray-700">جستجو در کد:</label>
                    <input id="search-car-catalog-code" autocomplete="off"
                           placeholder="لطفا کد خودرو را وارد نمایید."
                           type="text" name="search-car-catalog-code"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"/>
                    <label for="search-car-catalog-name" class="block font-bold text-gray-700">جستجو در نام:</label>
                    <input id="search-car-catalog-name" autocomplete="off"
                           placeholder="لطفا نام خودرو را وارد نمایید."
                           type="text" name="search-name"
                           class="ml-4 mt-1 px-4 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"/>
                </div>
                <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                    <thead>
                    <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                        <th class="px-6 py-3  font-bold ">کد</th>
                        <th class="px-6 py-3  font-bold ">نام خودرو</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    @foreach ($carList as $car)
                        <tr class="bg-white">
                            <td class="px-6 py-4">{{ $car->CarCode }}</td>
                            <td class="px-6 py-4">{{ $car->CarName }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div dir="ltr" class="mt-4 flex justify-center" id="laravel-next-prev">
                    {{ $carList->links() }}
                </div>
            </div>

        </div>
    </main>
@endsection
