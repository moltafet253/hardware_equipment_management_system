@php use App\Models\Catalogs\Company;use App\Models\Catalogs\Monitor; @endphp
@switch($logs->equipment_type)
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
