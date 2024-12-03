<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>SISKARA - Isian Rencana Semester (IRS)</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Animasi untuk sidebar */
    .sidebar {
      transition: transform 0.3s ease;
    }

    .sidebar-closed {
      transform: translateX(-100%);
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Header -->
  <header class="bg-gradient-to-r from-sky-500 to-blue-600 text-white p-4 flex justify-between items-center">
    <div class="flex items-center space-x-3">
        <!-- Tombol menu untuk membuka sidebar -->
        <button onclick="toggleSidebar()" class="focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <!-- Logo dan judul aplikasi -->
        <h1 class="text-xl font-bold">SISKARA</h1>
    </div>
    <nav class="space-x-4">
        <a href="{{ url('/') }}" class="hover:underline">Home</a>
        <a href="{{ url('/about') }}" class="hover:underline">About</a>
    </nav>
  </header>

  <div class="flex">
    <!-- Sidebar -->
      <aside id="sidebar" class="sidebar w-1/5 bg-sky-500 h-screen p-4 text-white sidebar-closed fixed lg:static">
        <!-- profil -->
        <div class="p-3 pb-1 bg-gray-300 rounded-3xl text-center mb-6">
            <div class="w-24 h-24 mx-auto bg-gray-400 rounded-full mb-3 bg-center bg-contain bg-no-repeat"
                style="background-image: url(img/fsm.jpg)">
            </div>
            <h2 class="text-lg text-black font-bold">Budi</h2>
            <p class="text-xs text-gray-800">NIM 24060122120033</p>
            <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Mahasiswa</p>
            <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
        </div>
        <nav class="space-y-4">
            <a href="{{ url('/dashboard-mhs') }}"
              class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                <span>Dashboard</span>
            </a>
            <a href="{{ url('/pengisianirs-mhs') }}"
              class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
                <span>Pengisian IRS</span>
            </a>
            <a href="{{ url('/irs-mhs') }}"
              class="flex items-center space-x-2 p-2 bg-sky-800 rounded-xl text-white hover:bg-opacity-70">
                <span>IRS</span>
            </a>
            <a href="{{ url('/dashboard-mhs') }}"
              class="flex items-center space-x-2 p-2 bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white">
              <span>KHS</span>
            </a>
        </nav>
      </aside>

    <!-- Main Content -->
    <main class="w-full lg:w-4/5 lg:ml-auto p-8">
      <span class="toggle-btn text-2xl cursor-pointer mb-4 lg:hidden" onclick="toggleSidebar()">&#9776;</span>
      <h1 class="text-3xl font-bold mb-6">Isian Rencana Semester (IRS)</h1>
      <div class="p-6 bg-gray-200 rounded-lg flex justify-between items-center mb-6">
        <p class="text-lg">Semester 4 <br> Tahun Ajaran 2023/2024 Genap</p>
        <button onclick="showModal()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Lihat Detail IRS</button>
      </div>
    </main>
  </div>

  <!-- Modal for IRS Detail -->
  <div class="modal fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" id="modal">
    <div class="modal-content bg-white p-6 rounded-lg max-w-2xl w-full relative">
      <button class="close-btn text-white bg-blue-500 px-3 py-1 rounded-full absolute top-4 right-4" onclick="closeModal()">Tutup</button>
      <h2 class="text-2xl font-bold mb-4">Isian Rencana Semester 4</h2>
      <table class="w-full border border-gray-300 text-left">
        <thead>
          <tr class="bg-gray-200">
            <th class="p-2 border">No</th>
            <th class="p-2 border">Kode</th>
            <th class="p-2 border">Mata Kuliah</th>
            <th class="p-2 border">Waktu</th>
            <th class="p-2 border">Kelas</th>
            <th class="p-2 border">SKS</th>
            <th class="p-2 border">Ruang</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Nama Dosen</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="p-2 border">1</td>
            <td class="p-2 border">PAIK6401</td>
            <td class="p-2 border">Pemrograman Berorientasi Objek</td>
            <td class="p-2 border">Selasa, 13:00-15:30</td>
            <td class="p-2 border">D</td>
            <td class="p-2 border">3</td>
            <td class="p-2 border">E101</td>
            <td class="p-2 border">Baru</td>
            <td class="p-2 border">Dr. Budi Prasetyo, S.T., M.T.</td>
          </tr>
        </tbody>
      </table>
      <button class="print-btn bg-blue-500 text-white px-4 py-2 rounded-full mt-4 hover:bg-blue-600" onclick="printPDF()">Cetak IRS</button>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
    <hr>
    <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
  </footer>

  <!-- Script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('sidebar-closed');
    }

    function showModal() {
      document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('modal').classList.add('hidden');
    }

    function printPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Header untuk institusi dan judul dokumen
    doc.setFontSize(14);
    doc.text("KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI", 105, 10, { align: "center" });
    doc.text("FAKULTAS SAINS DAN MATEMATIKA", 105, 16, { align: "center" });
    doc.text("UNIVERSITAS DIPONEGORO", 105, 22, { align: "center" });
    doc.setFontSize(12);
    doc.text("ISIAN RENCANA STUDI", 105, 30, { align: "center" });
    doc.text("Semester Ganjil TA 2024/2025", 105, 36, { align: "center" });

    // Data Mahasiswa
    doc.setFontSize(10);
    doc.text("NIM : 24060122120033", 20, 46);
    doc.text("Nama Mahasiswa : Budi Setiawan", 20, 52);
    doc.text("Program Studi : Informatika S1", 20, 58);
    doc.text("Dosen Wali : Adhe Setya Pramayoga, M.T.", 20, 64);

    // Tabel IRS
    doc.autoTable({
        startY: 70,
        head: [['No', 'Kode', 'Mata Kuliah', 'Kelas', 'SKS', 'Ruang', 'Status', 'Nama Dosen', 'Waktu']],
        body: [
            ['1', 'PAIK6401', 'Pemrograman Berorientasi Objek', 'D', '3', 'E101', 'Baru', 'Dr. Budi Prasetyo, S.T., M.T.', 'Selasa, 13:00-15:30'],
            // Tambahkan data mata kuliah lainnya di sini jika ada
        ],
        styles: { fontSize: 10 },
        headStyles: { fillColor: [217, 217, 217] },
    });

    // Tanda tangan
    doc.text("Semarang, 03 November 2024", 140, doc.lastAutoTable.finalY + 10);
    doc.text("Pembimbing Akademik (Dosen Wali)", 20, doc.lastAutoTable.finalY + 30);
    doc.text("Nama Mahasiswa,", 140, doc.lastAutoTable.finalY + 30);

    doc.text("Adhe Setya Pramayoga, M.T.", 20, doc.lastAutoTable.finalY + 45);
    doc.text("Budi Setiawan", 140, doc.lastAutoTable.finalY + 45);

    doc.text("NIP. 199112092024061001", 20, doc.lastAutoTable.finalY + 50);
    doc.text("NIM. 24060122120033", 140, doc.lastAutoTable.finalY + 50);

    // Simpan PDF
    doc.save("IRS_Semester_4.pdf");
}

  </script>

</body>
</html>
