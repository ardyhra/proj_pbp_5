<?php
namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    // Menampilkan data monitoring
    public function index()
    {
        $monitoringData = Monitoring::all();
        return view('monitoring.index', compact('monitoringData'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pembimbing' => 'required|string',
            'total_mahasiswa' => 'required|string',
            'persentase' => 'required|string',
        ]);

        Monitoring::create($request->all());
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        $monitoring = Monitoring::find($id);
        if (!$monitoring) {
            return redirect()->route('monitoring.index')->with('error', 'Data tidak ditemukan!');
        }

        $monitoring->update($request->all());
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil diperbarui!');
    }

    // Menghapus data
    public function destroy($id)
    {
        $monitoring = Monitoring::find($id);
        if (!$monitoring) {
            return redirect()->route('monitoring.index')->with('error', 'Data tidak ditemukan!');
        }

        $monitoring->delete();
        return redirect()->route('monitoring.index')->with('success', 'Data berhasil dihapus!');
    }
}
