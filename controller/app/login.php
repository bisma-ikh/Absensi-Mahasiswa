<?php

require "../../env/env.php";

// loginnnnn
if(isset($_POST["login"])){
    $id_user = $_POST["id_user"];
    $password = $_POST["password"];

    // Memulai atau melanjutkan sesi jika belum ada
    session_start();
    // Cek apakah variabel sesi 'login_attempts' sudah ada
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0; // Jika belum ada, inisialisasi dengan 0
    }

    $result = mysqli_query($conn, "SELECT * FROM user WHERE id_user = '$id_user'");
    if(mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['email'] = $row['email'];

        if (password_verify($password, $row["password"])) {
            // Peran pengguna diperoleh dari hasil query
            $role = $row["role"];

            // Berdasarkan peran, arahkan pengguna ke lokasi yang sesuai
            if ($role == "mhs") {
                header("location:../../public/view/mhs/absensi.php");
            } elseif ($role == "dosen") {
                header("location:../../public/view/dosen/dosen.php");
            } elseif ($role == "admin") {
                header("location:../../public/admin.php");
            } else {
                // Jika peran tidak dikenali, atur penggunaan lokasi default atau tampilkan pesan kesalahan
                header("location:../../index.php");
            }            
        } else {
            // Penanganan kesalahan login
            $_SESSION['login_attempts']++;

            // Jika jumlah kesalahan login lebih dari 3, tampilkan alert dan atur timeout
            if ($_SESSION['login_attempts'] >= 3) {
                echo "<script>
                        alert('Terlalu banyak kesalahan login. Akses login ditunda selama 20 detik.');
                      </script>";
                echo "<script>
                        setTimeout(function() {
                            document.location.href = '../../index.php';
                            " . '$_SESSION["login_attempts"] = 0;' . "
                        }, 20000);
                      </script>";
            } else {
                // Jika jumlah kesalahan kurang dari 3, tampilkan pesan kesalahan dan arahkan kembali ke halaman login
                echo "<script>
                        alert('NIM or Password Salah!!!');
                        document.location.href = '../../index.php';
                      </script>";
            }
        }
    } else {
        echo "<script>
                alert('NIM Tidak Ditemukan!!!');
                document.location.href = '../../index.php';
              </script>";
    }
} 
?>
