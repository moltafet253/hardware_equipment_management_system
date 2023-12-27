@php use App\Models\Catalogs\Company;
use App\Models\Catalogs\Cases;
use App\Models\Catalogs\Monitor;
 @endphp

 {{-- @dd($logs) --}}
@switch($logs->equipment_type)
    @case('case')
        @php
            $eq_logs=json_decode($logs->title,true);
            foreach ($eq_logs as $change) {
                switch ($change['field']){
                    case 'case_id':
                    case 'case':
                        $from=Cases::find($change['from']);
                        $from_company=Company::find($from->company_id);
                        $to=Cases::find($change['to']);
                        $to_company=Company::find($to->company_id);
                        echo 'تغییر کیس از: '.$from_company->name. ' ' . $from->model . ' به: ' . $to_company->name. ' ' .$to->model;
                        break;
                    case 'delivery_date':
                        echo 'تغییر تاریخ تحویل از: '.$change['from']. ' به: ' . $change['to'];
                        break;
                    case 'property_number':
                        echo 'تغییر کد اموال از: '.$change['from']. ' به: ' . $change['to'];
                        break;
                    default:
                    dd($eq_logs);
                }
                echo "<br>";
            }
        @endphp
        @break

    @case('monitor')
        @php
            $eq_logs=json_decode($logs->title,true);
            foreach ($eq_logs as $change) {
                switch ($change['field']){
                    case 'monitor_id':
                        $from=Monitor::find($change['from']);
                        $from_company=Company::find($from->company_id);
                        $to=Monitor::find($change['to']);
                        $to_company=Company::find($to->company_id);
                        echo 'تغییر مانیتور از: '.$from_company->name. ' ' . $from->model . ' به: ' . $to_company->name. ' ' .$to->model;
                        break;
                    case 'delivery_date':
                        echo 'تغییر تاریخ تحویل از: '.$change['from']. ' به: ' . $change['to'];
                        break;
                    case 'property_number':
                        echo 'تغییر کد اموال از: '.$change['from']. ' به: ' . $change['to'];
                        break;
                }
                echo "<br>";
            }
        @endphp
        @break
@endswitch

