<form id="new-printer">
    @csrf
    <div class=" flex items-center">
        {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addPrinterModal">
            <div
                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 addprinter"></div>
                </div>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            تخصیص پرینتر به کاربر
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
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right deliveryDate"
                                           placeholder="با فرمت : 1402/05/04">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="printer"
                                       class="block text-gray-700 text-sm font-bold mb-2">پرینتر*</label>
                                <select id="printer" class="border rounded-md w-96 px-3 py-2 select2" name="printer">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $printers = \App\Models\Catalogs\Printer::join('companies', 'printers.company_id', '=', 'companies.id')
                                            ->orderBy('companies.name')
                                            ->get([ 'companies.name', 'printers.id', 'printers.model']);
                                    @endphp
                                    @foreach($printers as $printer)
                                        <option value="{{ $printer->id }}">
                                            {{ $printer->name . ' - ' . $printer->model }}
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
                        <button id="cancel-add-printer" type="button"
                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                            انصراف
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="edit-printer">
    @csrf
    <div class="mb-2 flex items-center">
        {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editPrinterModal">
            <div
                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 editprinter"></div>
                </div>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            ویرایش پرینتر اختصاص داده شده به کاربر
                        </h3>
                        <div class="mt-4">
                            <div class="flex">
                                <div class="ml-3 w-full">
                                    <label for="edited_printer_property_number"
                                           class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                    <input type="text" id="edited_printer_property_number" name="edited_printer_property_number"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                           placeholder="کد اموال را وارد کنید">
                                </div>
                                <div class="w-full">
                                    <label for="edited_printer_delivery_date"
                                           class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                    <input type="text" id="edited_printer_delivery_date" name="edited_printer_delivery_date"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right deliveryDate"
                                           placeholder="با فرمت : 1402/05/04">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edited_printer"
                                       class="block text-gray-700 text-sm font-bold mb-2">پرینتر*</label>
                                <select id="edited_printer" class="border rounded-md w-96 px-3 py-2 select2" name="edited_printer">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $printers = \App\Models\Catalogs\Printer::join('companies', 'printers.company_id', '=', 'companies.id')
                                            ->orderBy('companies.name')
                                            ->get([ 'companies.name', 'printers.id', 'printers.model']);
                                    @endphp
                                    @foreach($printers as $printer)
                                        <option value="{{ $printer->id }}">
                                            {{ $printer->name . ' - ' . $printer->model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <input type="hidden" name="eq_id" value="" class="eq_id">
                        <input type="hidden" name="eq_type" value="" class="eq_type">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش
                        </button>
                        <button id="cancel-edit-printer" type="button"
                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                            انصراف
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
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

    $(document).on('click', '.EditEqPrinter', function () {
        toggleModal(editPrinterModal.id);
        $.ajax({
            type: 'GET', url: '/getEquipmentInfo', data: {
                id: $(this).data('id'),
                type: $(this).data('type')
            }, success: function (response) {
                if (response) {
                    $(".eq_id").val(response.id);
                    $(".eq_type").val('printer');
                    edited_printer_property_number.value=response.property_number;
                    edited_printer_delivery_date.value=response.delivery_date;
                    $("#edited_printer").val(response.printer_id).trigger("change");
                }
            }
        });
    });
</script>

<div class="bg-white rounded shadow flex flex-col">
    <div class="max-w-full items-center overflow-x-auto">
        @php
            $eq_printers=\App\Models\EquipmentedPrinter::where('person_id',$personId)->get();
        @endphp
            <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                <thead>
                <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                    <th class="font-bold w-8">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddPrinter">
                            جدید
                        </button>
                    </th>
                    <th class="font-bold ">کد اموال پرینتر</th>
                    <th class="font-bold ">شرکت سازنده پرینتر</th>
                    <th class="font-bold ">مدل پرینتر</th>
                    <th class="font-bold ">نوع کارکرد پرینتر</th>
                    <th class="font-bold ">عملیات</th>
                </tr>
                </thead>
                @if(!$eq_printers->isEmpty())
                <tbody>
                @foreach($eq_printers as $printers)
                    <tr class="even:bg-gray-300 odd:bg-white">
                        <td class=" px-3 py-1 "> </td>
                        <td class=" px-3 py-1 "> {{ $printers->property_number }}</td>
                        <td class=" px-3 py-1 ">
                            @php
                                $printerInfo = \App\Models\Catalogs\Printer::join('companies', 'printers.company_id', '=', 'companies.id')
                                ->select('printers.*', 'companies.name as company_name')
                                ->find($printers->printer_id);
                            @endphp
                            {{ $printerInfo->company_name  }}
                        </td>
                        <td class=" px-3 py-1 ">
                            {{ $printerInfo->model }}
                        </td>
                        <td class=" px-3 py-1 ">
                            {{ $printerInfo->function_type }}
                        </td>
                        <td class=" px-3 py-1 ">
                            <button type="submit" data-type="printer" data-id="{{ $printers->id }}"
                                    class="px-1 py-1 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditEqPrinter">
                                ویرایش
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                @endif
            </table>
    </div>
</div>
