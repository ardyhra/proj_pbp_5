<?php
// app/Http/Controllers/SemesterController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return view('manajemen-jadwal-kaprodi', compact('semester'));
    }

    public function view($id)
    {
        // View semester details logic here
    }

    public function edit($id)
    {
        // Edit semester logic here
    }

    public function apply($id)
    {
        // Apply semester schedule logic here
    }
}
