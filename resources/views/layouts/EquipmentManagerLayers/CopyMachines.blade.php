<form id="new-copymachine">
    @csrf
    <div class="mb-4 flex items-center">
        {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addCopyMachineModal">
            <div
                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 addcopymachine"></div>
                </div>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            تخصیص دستگاه کپی به کاربر
                        </h3>
                        <div class="mt-4">
                            <div class="flex">
                                <div class="ml-3 w-full">
                                    <label for="property_number"
                                           class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                    <input type="text" id="property_number" name="property_number"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                           placeholder="کد اموال را وارد کنید">
                                </div>
                                <div class="w-full">
                                    <label for="delivery_date"
                                           class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                    <input type="text" id="delivery_date" name="delivery_date"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                           placeholder="با فرمت : 1402/05/04">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="copymachine"
                                       class="block text-gray-700 text-sm font-bold mb-2">دستگاه کپی*</label>
                                <select id="copymachine" class="border rounded-md w-full px-3 py-2"
                                        name="copymachine">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $copyMachines = \App\Models\Catalogs\CopyMachine::join('companies', 'copy_machines.company_id', '=', 'companies.id')
                                            ->orderBy('companies.name')
                                            ->get([ 'companies.name', 'copy_machines.id', 'copy_machines.model']);
                                    @endphp
                                    @foreach($copyMachines as $copyMachine)
                                        <option value="{{ $copyMachine->id }}">
                                            {{ $copyMachine->name . ' - ' . $copyMachine->model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            اضافه کردن
                        </button>
                        <button id="cancel-add-copymachine" type="button"
                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                            انصراف
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="flex pb-3 pt-6">
    <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات دستگاه کپی</h3>
    <button type="submit"
            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddCopyMachine">
        ثبت دستگاه کپی جدید
    </button>
</div>
<div class="bg-white rounded shadow flex flex-col">
    <div class="max-w-full items-center overflow-x-auto">
        @php
            $eq_copy_machines=\App\Models\EquipmentedCopyMachine::where('person_id',$personId)->get();
        @endphp
        @if(!$eq_copy_machines->isEmpty())
            <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                <thead>
                <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                    <th class=" px-6 py-3  font-bold ">کد اموال</th>
                    <th class=" px-3 py-3  font-bold ">شرکت سازنده</th>
                    <th class=" px-3 py-3  font-bold ">مدل</th>
                    <th class=" px-3 py-3  font-bold ">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($eq_copy_machines as $copy_machines)
                    <tr class="even:bg-gray-300 odd:bg-white">
                        <td class=" px-3 py-3 "> {{ $copy_machines->property_number }}</td>
                        <td class=" px-3 py-3 ">
                            @php
                                $copy_machineInfo = \App\Models\Catalogs\CopyMachine::join('companies', 'copy_machines.company_id', '=', 'companies.id')
                                ->select('copy_machines.*', 'companies.name as company_name')
                                ->find($copy_machines->copy_machine_id);
                            @endphp
                            {{ $copy_machineInfo->company_name  }}
                        </td>
                        <td class=" px-3 py-3 ">
                            {{ $copy_machineInfo->model }}
                        </td>
                        <td class=" px-3 py-3 ">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditCopyMachine">
                                ویرایش
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="flex p-3">
                <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر دستگاه کپی ثبت شده
                    ندارد</h3>
            </div>
        @endif
    </div>
</div>
