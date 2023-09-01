@php use App\Models\Catalogs\Assistance;use App\Models\Person; @endphp
@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">گزارش گیری از اطلاعات تجهیزات ثبت شده در ستاد</h1>
            <div class="bg-white rounded shadow p-6 mb-4">
                <h4 class="text-l font-bold">گزارش تجهیزات پرسنل خاص</h4>
                <hr>
                <div class="flex p-4">
                    <p class=" mt-2">لطفا یک پرسنل را انتخاب کنید:</p>
                    <select id="person" class="border rounded-md w-72 px-3 py-2 select2" name="person">
                        <option value="" disabled selected>انتخاب کنید</option>
                        @php
                            $persons = Person::where('work_place',35)->orderBy('family','asc')->get();
                        @endphp
                        @foreach($persons as $person)
                            <option value="{{ $person->id }}">
                                @php
                                    $assistance=Assistance::find($person->assistance);
                                @endphp
                                {{ $person->name . ' ' . $person->family. ' - ' . $assistance->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 GetPersonEquipmentsReport">
                        دریافت گزارش
                    </button>
                </div>
            </div>
            <div class="bg-white rounded shadow p-6 mb-4">
                <h4 class="text-l font-bold">گزارش تجهیزات معاونت خاص</h4>
                <hr>
                <div class="flex p-4">
                    <p class=" mt-2">لطفا یک معاونت را انتخاب کنید:</p>
                    <select id="assistance" class="border rounded-md w-72 px-3 py-2 select2" name="assistance">
                        <option value="" disabled selected>انتخاب کنید</option>
                        @php
                            $assistances = Assistance::orderBy('name','asc')->get();
                        @endphp
                        @foreach($assistances as $assistance)
                            <option value="{{ $assistance->id }}">
                                {{ $assistance->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 GetPersonEquipmentsReport">
                        دریافت گزارش
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection

