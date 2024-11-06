<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usulan Ruang Kuliah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            flex: 1; /* Membuat container menyesuaikan tinggi halaman */
        }
        .sidebar {
            width: 25%;
            background-color: #4aa3e0;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .profile {
            display: flex;
            align-items: center;
            margin-bottom: 50px;
        }

        .profile img {
            width: 60px;
            height: 60px;
            background-color: #ddd;
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .profile p {
            font-size: 12px;
        }

        .profile button {
            margin-top: 10px;
            background-color: #b3e3ff;
            color: #004680;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            margin-bottom: 10px;
            background-color: #888;
            border-radius: 5px;
            text-align: center;
        }

        .menu a.active {
            background-color: #666;
        }

        .logout {
            background-color: white;
            color: #4aa3e0;
            border: none;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            width: 75%;
            padding: 40px;
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 24px;
        }

        .header nav a {
            margin-left: 20px;
            color: #666;
            text-decoration: none;
        }
        
        .content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        /* Popup Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .modal h2 {
            margin-bottom: 20px;
        }

        .modal select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal button {
            padding: 10px 20px;
            background-color: #4aa3e0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal button:hover {
            background-color: #367bb3;
        }

        /* Disable background while modal is active */
        body.modal-active {
            overflow: hidden;
        }

        /* Form Content (Hidden Initially) */
        .form-content {
            display: none;
        }

        .form-content.active {
            display: block;
        }

        .button-blue {
            background-color: #0000FF;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }

        .button-green {
            background-color: #00ff00;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        form {
            margin-bottom: 30px;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4aa3e0;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit-button {
            background-color: #4aa3e0;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
        }

        .delete-button {
            background-color: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
        }

        .save-button, .reset-button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .save-button {
            background-color: #00ff00;
        }

        .reset-button {
            background-color: red;
            color: white;
        }
        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #4aa3e0;
            color: white;
            position: relative;
        }

        footer p {
            margin-bottom: 10px;
        }

        footer a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div>
                <div class="profile">
                    <img src="img/user.png" alt="Profile Image">
                    <div>
                        <h2>Budi, S.Kom</h2>
                        <p>NIP: 123431431431415</p>
                        <button>Bagian Akademik</button>
                    </div>
                </div>
                <nav class="menu">
                    <a href="/dashboard-ba">Dashboard</a>
                    <a href="/buatusulan" class="active">Buat Usulan</a>
                    <a href="/daftarusulan">Daftar Usulan</a>
                </nav>
            </div>
            <button class="logout">Logout</button>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Dashboard</h1>
                <nav>
                    <a href="/dashboard">Home</a>
                    <a href="#">About</a>
                    <a href="#">Profile</a>
                </nav>
            </header>

            
            <div class="form-content" id="form-content">
                <h1>Usulan Ruang Kuliah</h1>
                <a href="#" class="button-blue">Buat Usulan Baru</a>
                <h2>Form Buat Usulan</h2>
                <form>
                    <label for="program-studi">Program Studi</label>
                    <select id="program-studi">
                        <option value="informatika">Informatika</option>
                        <option value="sistem-informasi">Sistem Informasi</option>
                        <option value="teknik-komputer">Teknik Komputer</option>
                    </select>
        
                    <label for="ruang">Ruang</label>
                    <select id="ruang">
                        <option value="e101">E101</option>
                        <option value="e102">E102</option>
                        <option value="e103">E103</option>
                    </select>
        
                    <label for="kapasitas">Kapasitas</label>
                    <input type="text" id="kapasitas" placeholder="Masukkan Kapasitas">
        
                    <button type="button" class="button-green">Tambah</button>
                </form>
        
                <h3>Ganjil 2024/2025</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Program Studi</th>
                            <th>Ruang Kuliah</th>
                            <th>Kapasitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Informatika</td>
                            <td>E101</td>
                            <td>50</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="edit-button">Edit</a>
                                    <a href="#" class="delete-button">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Informatika</td>
                            <td>E102</td>
                            <td>45</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="edit-button">Edit</a>
                                    <a href="#" class="delete-button">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
        
                <button class="save-button">Simpan</button>
                <button class="reset-button">Reset</button>
            </div>
            
        </main>
        
    </div>

    <!-- Popup Modal for Tahun Ajaran -->
    <div class="modal" id="yearModal">
        <div class="modal-content">
            <h2>Pilih Tahun Ajaran</h2>
            <select id="tahunAjaran">
                <option value="">-- Pilih Tahun Ajaran --</option>
                <option value="2023/2024 Genap">2023/2024 (Genap)</option>
                <option value="2024/2025 Ganjil">2024/2025 (Ganjil)</option>
            </select>
            <button id="continueBtn">Lanjutkan</button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 SISKARA</p>
        <p>Don't Forget To Follow Diponegoro University Social Media!</p>
        <div>
            <a href="#">Facebook</a>
            <a href="#">YouTube</a>
            <a href="#">Instagram</a>
        </div>
    </footer>

    <script>
        // Show modal on page load
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('yearModal');
            const continueBtn = document.getElementById('continueBtn');
            const selectTahunAjaran = document.getElementById('tahunAjaran');
            const formContent = document.getElementById('form-content');

            continueBtn.addEventListener('click', function () {
                const selectedYear = selectTahunAjaran.value;
                if (selectedYear) {
                    // Hide modal and show form content
                    modal.style.display = 'none';
                    formContent.classList.add('active');
                    document.body.classList.remove('modal-active');
                } else {
                    alert('Silakan pilih tahun ajaran terlebih dahulu!');
                }
            });
        });
    </script>

</body>
</html>
