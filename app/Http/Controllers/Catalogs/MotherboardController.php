<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Motherboard;
use Illuminate\Http\Request;

class MotherboardController extends Controller
{
    public function newMotherboard()
    {

    }
    public function index()
    {
        $mbList = Motherboard::orderBy('company_id', 'asc')->paginate(20);
        return view('Catalogs.MotherboardCatalog', ['mbList' => $mbList]);
    }
}
