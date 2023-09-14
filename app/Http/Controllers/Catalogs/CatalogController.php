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
use App\Models\Catalogs\OtherEquipments\Recorder;
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
                $this->logActivity('Change Status Of Brand =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                break;
            case 'ChangeMotherboardStatus':
                $this->logActivity('Change Status Of Motherboard =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Motherboard::class;
                break;
            case 'ChangeCaseStatus':
                $this->logActivity('Change Status Of Case =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Cases::class;
                break;
            case 'ChangeCPUStatus':
                $this->logActivity('Change Status Of CPU =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = cpu::class;
                break;
            case 'ChangeRAMStatus':
                $this->logActivity('Change Status Of RAM =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Ram::class;
                break;
            case 'ChangePowerStatus':
                $this->logActivity('Change Status Of Power =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Power::class;
                break;
            case 'ChangeGraphicCardStatus':
                $this->logActivity('Change Status Of Graphic Card =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = GraphicCard::class;
                break;
            case 'ChangeHarddiskStatus':
                $this->logActivity('Change Status Of Harddisk =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Harddisk::class;
                break;
            case 'ChangeODDStatus':
                $this->logActivity('Change Status Of ODD =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Odd::class;
                break;
            case 'ChangeNetworkCardStatus':
                $this->logActivity('Change Status Of Network Card =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = NetworkCard::class;
                break;
            case 'ChangeMonitorStatus':
                $this->logActivity('Change Status Of Monitor =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Monitor::class;
                break;
            case 'ChangePrinterStatus':
                $this->logActivity('Change Status Of Printer =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Printer::class;
                break;
            case 'ChangeScannerStatus':
                $this->logActivity('Change Status Of Scanner =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Scanner::class;
                break;
            case 'ChangeCopyMachineStatus':
                $this->logActivity('Change Status Of Copy Machine =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = CopyMachine::class;
                break;
            case 'ChangeVOIPStatus':
                $this->logActivity('Change Status Of VOIP =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Voip::class;
                break;
            case 'ChangeRecorderStatus':
                $this->logActivity('Change Status Of Recorder =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Recorder::class;
                break;
            case 'ChangeAssistanceStatus':
                $this->logActivity('Change Status Of Assistance =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Assistance::class;
                break;
            case 'ChangeJobStatus':
                $this->logActivity('Change Status Of Job =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
                $model = Job::class;
                break;
            case 'ChangeEstablishmentPlaceStatus':
                $this->logActivity('Change Status Of Establishment Place =>' . $id, \request()->ip(), \request()->userAgent(), \session('id'));
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
