@extends('layouts.PanelMaster')

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">ایجاد بکاپ کامل از دیتابیس</h1>
            <div class="bg-white rounded shadow p-6 mb-4">
                <form id="create-backup">
                    <button type="button"
                            class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 GetPersonEquipmentsReport">
                        ایجاد بکاپ
                    </button>
                </form>
                <hr>
            </div>
        </div>
    </main>
@endsection

