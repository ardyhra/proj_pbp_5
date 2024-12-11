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
  @php
    $menus = [
      (object) [
        "title" => "Dasboard",
        "path" => "dashboard-mhs",
      ],
      (object) [
        "title" => "Pengisian IRS",
        "path" => "pengisianirs-mhs",
      ],
      (object) [
        "title" => "IRS",
        "path" => "irs-mhs",
      ]
    ];
  @endphp
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
            <h2 class="text-lg text-black font-bold">{{ $mhs->nama }}</h2>
            <p class="text-xs text-gray-800">NIM {{ $mhs->nim }}</p>
            <p class="text-sm bg-sky-700 rounded-full px-3 py-1 mt-2 font-semibold">Mahasiswa</p>
            <a href="{{ route('login') }}" class="text-sm w-full bg-red-700 py-1 rounded-full mb-4 mt-2 text-center block font-semibold hover:bg-opacity-70">Logout</a>
        </div>
        <nav class="space-y-4">
          {{-- active : bg-sky-800 rounded-xl text-white hover:bg-opacity-70 --}}
          {{-- passive : bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white --}}
          @foreach ($menus as $menu)
          <a href="{{ url($menu->path) }}"
            class="flex items-center space-x-2 p-2 {{ Str::startsWith(request()->path(), $menu->path) ? 'bg-sky-800 rounded-xl text-white hover:bg-opacity-70' : 'bg-gray-300 rounded-xl text-gray-700 hover:bg-gray-700 hover:text-white' }}">
            <span>{{$menu->title}}</span>
          </a>
          @endforeach
        </nav>
      </aside>

    <!-- Main Content -->
    <main class="w-full lg:w-8/5 lg:ml-auto p-8">
      <!-- <span class="toggle-btn text-2xl cursor-pointer mb-4 lg:hidden" onclick="toggleSidebar()">&#9776;</span> -->
      
      <h1 class="text-4xl font-bold mb-6">Isian Rencana Semester (IRS)</h1>
      @foreach ($filtered_tahun_ajaran as $ta)
      <div class="p-6 bg-gray-200 rounded-lg flex justify-between items-center mb-6">
        <p class="text-xl">Semester {{ $ta['semester'] }} <br> {{ $ta['tahun_ajaran'] }}</p>
        <button onclick="showModal({{ $ta['id_tahun'] }}, {{ $ta['semester'] }})" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Lihat Detail IRS</button>
      </div>
      @endforeach
    </main>
  </div>

  <!-- Modal for IRS Detail -->
  <div class="modal fixed z-10 inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden" id="modal">
    <div class="modal-content bg-white p-6 rounded-lg max-w-7xl w-full relative">
      <button class="close-btn text-white bg-blue-500 px-3 py-1 rounded-full absolute top-4 right-4 hover:bg-blue-600" onclick="closeModal()">Tutup</button>
      <h2 class="text-xl font-bold mb-4" id="semester-title">Isian Rencana Semester</h2>
      <table class="w-full border border-gray-300" id="irs-table">
        <thead>
          <tr class="bg-gray-200">
            <th class="p-1 border">No</th>
            <th class="p-1 border">Kode</th>
            <th class="p-1 border">Mata Kuliah</th>
            <th class="p-1 border">Waktu</th>
            <th class="p-1 border">Kelas</th>
            <th class="p-1 border">SKS</th>
            <th class="p-1 border">Ruang</th>
            <th class="p-1 border">Status</th>
            <th class="p-1 border">Nama Dosen</th>
          </tr>
        </thead>
        <tbody>
          <!-- Isi Tabel IRS -->
        </tbody>
      </table>
      <button class="print-btn text-white bg-blue-500 px-3 py-1 rounded-full absolute bottom-4 right-4 hover:bg-blue-600" id="cetak-irs" onclick="printPDF({{ $mhs }})">Cetak IRS</button>
      <p class="text-lg px-3 py-1" id="total-sks">Total SKS: </p>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-sky-500 to-blue-600 text-white text-center p-4 absolute w-full">
    <hr>
    <p class="text-sm text-center">&copy; Siskara Inc. All rights reserved.</p>
  </footer>

  <!-- Script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('sidebar-closed');
    }

    // Fungsi untuk menampilkan modal dan memuat data IRS berdasarkan tahun ajaran
    function showModal(id_tahun, semester) {
      // Set judul modal sesuai dengan semester yang dipilih
      $('#semester-title').text('Isian Rencana Studi Semester ' + semester);

      // Kirim request AJAX untuk mendapatkan detail IRS
      $.ajax({
        url: "{{ route('getIrsDetail') }}",  // URL untuk mendapatkan data IRS
        type: "GET",
        data: {
          id_tahun: id_tahun  // Mengirimkan id_tahun untuk filter data IRS
        },
        success: function(response) {
          var irsHtml = '';
          var totalSks = 0;

          // Cek apakah response.irs kosong
          if (response.irs.length === 0) {
            irsHtml = `
              <tr>
                <td colspan="9" class="p-4 text-center text-red-500">Mahasiswa belum menyimpan IRS</td>
              </tr>
            `;
            totalSks = 0;
            $('#cetak-irs').addClass('hidden');
          } else {
            // Iterasi melalui data IRS dan buat baris tabel
            $.each(response.irs, function(index, irs) {
              var waktuMulai = irs.waktu_mulai.slice(0, 5);
              var waktuSelesai = irs.waktu_selesai.slice(0, 5);
              // Menampilkan daftar dosen dalam format yang sesuai, setiap dosen di baris baru
              var dosenList = '';
              $.each(irs.dosen, function(i, dosen) {
                dosenList += dosen + "<br>"; // Menambahkan <br> agar nama dosen berada di baris baru
              });

              irsHtml += `
                <tr>
                  <td class="p-1 border text-center">${index + 1}</td>
                  <td class="p-1 border text-left">${irs.kode_mk}</td>
                  <td class="p-1 border text-left">${irs.nama_mk}</td>
                  <td class="p-1 border text-left">${irs.hari}, <br> ${waktuMulai}-${waktuSelesai}</td>
                  <td class="p-1 border text-center">${irs.kelas}</td>
                  <td class="p-1 border text-center">${irs.sks}</td>
                  <td class="p-1 border text-left">${irs.id_ruang}</td>
                  <td class="p-1 border text-left">${irs.status}</td>
                  <td class="p-1 border text-left">${dosenList}</td>
                </tr>
              `;
              totalSks += parseInt(irs.sks);
            });
          }

          // Memasukkan data IRS ke dalam tabel
          $('#irs-table tbody').html(irsHtml);

          // Menampilkan total SKS
          $('#total-sks').text('Total SKS: ' + totalSks);

          // Menampilkan modal
          $('#modal').removeClass('hidden');
        }
      });
    }

    // function showModal() {
    //   document.getElementById('modal').classList.remove('hidden');
    // }

    function closeModal() {
      document.getElementById('modal').classList.add('hidden');
    }

    function printPDF(mhs) {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      // Menggunakan font Times New Roman
      // doc.addFileToVFS('times-new-roman.ttf', TimesNewRoman);
      // doc.addFont('times-new-roman.ttf', 'TimesNewRoman', 'normal');
      doc.setFont('TimesNewRoman');

      // Header untuk institusi dan judul dokumen
      doc.setFontSize(14);
      doc.text("KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI", 105, 10, { align: "center" });
      doc.text(`${mhs.nama_fakultas}`, 105, 16, { align: "center" });
      doc.text("UNIVERSITAS DIPONEGORO", 105, 22, { align: "center" });
      doc.setFontSize(12);
      doc.text("ISIAN RENCANA STUDI", 105, 30, { align: "center" });
      doc.text("Semester Ganjil TA 2024/2025", 105, 36, { align: "center" });

      // Data Mahasiswa
      doc.setFontSize(12);
      doc.text(`NIM : ${mhs.nim}`, 20, 46);
      doc.text(`Nama Mahasiswa : ${mhs.nama}`, 20, 52);
      doc.text(`Program Studi : ${mhs.nama_prodi} ${mhs.strata}`, 20, 58);
      doc.text(`Dosen Wali : ${mhs.nama_dosen}`, 20, 64);

      // Ambil data IRS dari tabel modal
      var irsData = [];
      $('#irs-table tbody tr').each(function() {
        var row = [];
        $(this).find('td').each(function(index) {
          if (index === 8) {
            // Kolom Nama Dosen, gabungkan dosen yang berada dalam baris baru
            row.push($(this).html().replace(/<br>/g, '\n').trim());
          } else {
            row.push($(this).text().trim());
          }
        });
        irsData.push(row);
      });

      // Tabel IRS
      doc.autoTable({
        startY: 70,
        head: [['No', 'Kode', 'Mata Kuliah', 'Waktu', 'Kelas', 'SKS', 'Ruang', 'Status', 'Nama Dosen']],
        body: irsData,
        styles: { fontSize: 10, font: 'TimesNewRoman', lineColor: [0, 0, 0], lineWidth: 0.1 },  // Menggunakan font Times New Roman dan border hitam
        headStyles: { fillColor: [255, 255, 255], textColor: [0, 0, 0] },  // Header tabel dengan warna putih dan teks hitam
        bodyStyles: { textColor: [0, 0, 0] },  // Teks tabel hitam
        theme: 'grid',  // Menggunakan tema grid dengan garis border
      });

      // Tanda tangan dan tanggal dinamis
      const today = new Date();
      const formattedDate = today.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
      });

      doc.setFontSize(12);
      doc.text(`Semarang, ${formattedDate}`, 140, doc.lastAutoTable.finalY + 10);
      doc.text("Pembimbing Akademik (Dosen Wali)", 20, doc.lastAutoTable.finalY + 15);
      doc.text("Nama Mahasiswa,", 140, doc.lastAutoTable.finalY + 15);

      doc.text(`${mhs.nama_dosen}`, 20, doc.lastAutoTable.finalY + 35);
      doc.text(`${mhs.nama}`, 140, doc.lastAutoTable.finalY + 35);

      doc.text(`NIDN. ${mhs.nidn}`, 20, doc.lastAutoTable.finalY + 40);
      doc.text(`NIM. ${mhs.nim}`, 140, doc.lastAutoTable.finalY + 40);

      // Simpan PDF
      doc.save("Isian Rencana Studi.pdf");
    }
  </script>

</body>
</html>
