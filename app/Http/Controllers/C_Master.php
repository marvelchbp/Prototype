<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class C_Master extends Controller
{
    public function ViewDashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function ViewMasterBarang()
    {
        return Inertia::render('Master/MasterBarangView');
    }

    public function ViewMasterKategori()
    {
        return Inertia::render('Master/MasterKategoriView');
    }

    public function ViewMasterUser()
    {
        return Inertia::render('Master/MasterPegawaiView');
    }

    public function ViewMasterMember()
    {
        return Inertia::render('Master/MasterMemberView');
    }

    public function ViewMasterPromo()
    {
        return Inertia::render('Master/MasterPromoView');
    }

    public function ViewMasterStok()
    {
        return Inertia::render('Master/MasterStokView');
    }
}
