@php
    use App\Models\Catalogs\Company;
    use App\Models\Catalogs\Cases;
    use App\Models\Catalogs\Monitor;
    use App\Models\Catalogs\Motherboard;
    use App\Models\Catalogs\cpu;
    use App\Models\Catalogs\Ram;
    use App\Models\Catalogs\Harddisk;
    use App\Models\Catalogs\GraphicCard;
    use App\Models\Catalogs\NetworkCard;
    use App\Models\Catalogs\Odd;
@endphp

@switch($logs->equipment_type)
    @case('case')
        @php
            $eq_logs = json_decode($logs->title, true);

            foreach ($eq_logs as $change) {
                switch ($change['field']) {
                    case 'case_id':
                    case 'delivery_date':
                        echo 'تغییر تاریخ تحویل از: ' . $change['from'] . ' به: ' . $change['to'];
                        break;
                    case 'property_number':
                        echo 'تغییر کد اموال از: ' . $change['from'] . ' به: ' . $change['to'];
                        break;
                    case 'case':
                        $from_company = Cases::with('company')->find($change['from']);
                        $to_company = Cases::with('company')->find($change['to']);
                        echo 'تغییر کیس از: ' . $from_company->company->name . ' ' . $from_company->model . ' به: ' . $to_company->company->name . ' ' . $to_company->model;
                        break;
                    case 'motherboard':
                        $from_company = Motherboard::with('company')->find($change['from']);
                        $to_company = Motherboard::with('company')->find($change['to']);
                        echo 'تغییر مادربورد از: ' . $from_company->company->name . ' ' . $from_company->model . ' به: ' . $to_company->company->name . ' ' . $to_company->model;
                        break;
                    case 'cpu':
                        $from_company = cpu::with('company')->find($change['from']);
                        $to_company = cpu::with('company')->find($change['to']);
                        echo 'تغییر پردازنده از: ' . $from_company->company->name . ' ' . $from_company->model . ' به: ' . $to_company->company->name . ' ' . $to_company->model;
                        break;
                        break;
                    case 'ram1':
                        $from_company = Ram::with('company')->find($change['from']);
                        $to_company = Ram::with('company')->find($change['to']);
                        echo 'تغییر رم 1 از: ' . $from_company->company->name . ' ' . $from_company->model . ' ' . $from_company->type . ' ' . $from_company->size . ' ' . $from_company->frequerncy . ' به: ' . $to_company->company->name . ' ' . $to_company->model . ' ' . $to_company->type . ' ' . $to_company->size . ' ' . $to_company->frequerncy;
                        break;
                    case 'ram2':
                        $from_company = Ram::with('company')->find($change['from']);
                        $to_company = Ram::with('company')->find($change['to']);
                        echo 'تغییر رم 2 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->type . ' ' . @$from_company->size . ' ' . @$from_company->frequerncy . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->type . ' ' . @$to_company->size . ' ' . @$to_company->frequerncy;
                        break;
                    case 'ram3':
                        $from_company = Ram::with('company')->find($change['from']);
                        $to_company = Ram::with('company')->find($change['to']);
                        echo 'تغییر رم 3 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->type . ' ' . @$from_company->size . ' ' . @$from_company->frequerncy . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->type . ' ' . @$to_company->size . ' ' . @$to_company->frequerncy;
                        break;
                    case 'ram4':
                        $from_company = Ram::with('company')->find($change['from']);
                        $to_company = Ram::with('company')->find($change['to']);
                        echo 'تغییر رم 4 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->type . ' ' . @$from_company->size . ' ' . @$from_company->frequerncy . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->type . ' ' . @$to_company->size . ' ' . @$to_company->frequerncy;
                        break;
                    case 'hdd1':
                        $from_company = Harddisk::with('company')->find($change['from']);
                        $to_company = Harddisk::with('company')->find($change['to']);
                        echo 'تغییر هارد 1 از: ' . $from_company->company->name . ' ' . $from_company->model . ' ' . $from_company->capacity . ' ' . $from_company->type . ' ' . $from_company->connectivity_type . ' به: ' . $to_company->company->name . ' ' . $to_company->model . ' ' . $to_company->capacity . ' ' . $to_company->type . ' ' . $to_company->connectivity_type;
                        break;
                    case 'hdd2':
                        $from_company = Harddisk::with('company')->find($change['from']);
                        $to_company = Harddisk::with('company')->find($change['to']);
                        echo 'تغییر هارد 2 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type;
                        break;
                    case 'hdd3':
                        $from_company = Harddisk::with('company')->find($change['from']);
                        $to_company = Harddisk::with('company')->find($change['to']);
                        echo 'تغییر هارد 3 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type;
                        break;
                    case 'hdd4':
                        $from_company = Harddisk::with('company')->find($change['from']);
                        $to_company = Harddisk::with('company')->find($change['to']);
                        echo 'تغییر هارد 4 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type;
                        break;
                    case 'graphic_card':
                        $from_company = GraphicCard::with('company')->find($change['from']);
                        $to_company = GraphicCard::with('company')->find($change['to']);
                        echo 'تغییر کارت گرافیک از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type;
                        break;
                    case 'network_card':
                        $from_company = NetworkCard::with('company')->find($change['from']);
                        $to_company = NetworkCard::with('company')->find($change['to']);
                        echo 'تغییر کارت شبکه از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type;
                        break;
                    case 'odd':
                        $from_company = Odd::with('company')->find($change['from']);
                        $to_company = Odd::with('company')->find($change['to']);
                        echo 'تغییر کارت شبکه از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type;
                        break;
                    default:
                    // اگر نیاز به انجام عملیاتی برای حالت‌های دیگر هست، می‌توانید اینجا اضافه کنید.
                }
                echo '<br>';
            }

        @endphp
    @break

    @case('monitor')
        @php
            $eq_logs = json_decode($logs->title, true);
            foreach ($eq_logs as $change) {
                switch ($change['field']) {
                    case 'monitor_id':
                        $from = Monitor::find($change['from']);
                        $from_company = Company::find($from->company_id);
                        $to = Monitor::find($change['to']);
                        $to_company = Company::find($to->company_id);
                        echo 'تغییر مانیتور از: ' . $from_company->name . ' ' . $from->model . ' به: ' . $to_company->name . ' ' . $to->model;
                        break;
                    case 'delivery_date':
                        echo 'تغییر تاریخ تحویل از: ' . $change['from'] . ' به: ' . $change['to'];
                        break;
                    case 'property_number':
                        echo 'تغییر کد اموال از: ' . $change['from'] . ' به: ' . $change['to'];
                        break;
                }
                echo '<br>';
            }
        @endphp
    @break
@endswitch
