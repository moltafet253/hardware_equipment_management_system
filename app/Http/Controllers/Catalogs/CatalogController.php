<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Assistance;
use App\Models\Catalogs\Cases;
use App\Models\Catalogs\Company;
use App\Models\Catalogs\CopyMachine;
use App\Models\Catalogs\cpu;
use App\Models\Catalogs\GraphicCard;
use App\Models\Catalogs\Harddisk;
use App\Models\Catalogs\Job;
use App\Models\Catalogs\Monitor;
use App\Models\Catalogs\Motherboard;
use App\Models\Catalogs\NetworkCard;
use App\Models\Catalogs\Odd;
use App\Models\Catalogs\Power;
use App\Models\Catalogs\Printer;
use App\Models\Catalogs\Ram;
use App\Models\Catalogs\Scanner;
use App\Models\Catalogs\Voip;
use App\Models\EstablishmentPlace;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function manage(Request $request)
    {
        $work = $request->input('work');
        $id = $request->input('id');

        // تعیین مدل مورد نظر بر اساس نام عملیات (work)
        switch ($work) {
            case 'ChangeBrandStatus':
                $model = Company::class;
                break;
            case 'ChangeMotherboardStatus':
                $model = Motherboard::class;
                break;
            case 'ChangeCaseStatus':
                $model = Cases::class;
                break;
            case 'ChangeCPUStatus':
                $model = cpu::class;
                break;
            case 'ChangeRAMStatus':
                $model = Ram::class;
                break;
            case 'ChangePowerStatus':
                $model = Power::class;
                break;
            case 'ChangeGraphicCardStatus':
                $model = GraphicCard::class;
                break;
            case 'ChangeHarddiskStatus':
                $model = Harddisk::class;
                break;
            case 'ChangeODDStatus':
                $model = Odd::class;
                break;
            case 'ChangeNetworkCardStatus':
                $model = NetworkCard::class;
                break;
            case 'ChangeMonitorStatus':
                $model = Monitor::class;
                break;
            case 'ChangePrinterStatus':
                $model = Printer::class;
                break;
            case 'ChangeScannerStatus':
                $model = Scanner::class;
                break;
            case 'ChangeCopyMachineStatus':
                $model = CopyMachine::class;
                break;
            case 'ChangeVOIPStatus':
                $model = Voip::class;
                break;
            case 'ChangeAssistanceStatus':
                $model = Assistance::class;
                break;
            case 'ChangeJobStatus':
                $model = Job::class;
                break;
            case 'ChangeEstablishmentPlaceStatus':
                $model = EstablishmentPlace::class;
                break;
            default:
                return 0;
        }

        $info = $model::find($id);

        if ($info) {
            $info->active = $info->active == 1 ? 0 : 1;
            $info->save();
        }
    }
}
