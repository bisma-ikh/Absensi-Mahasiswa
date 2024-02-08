<?php

include '../../env/env.php';

if(isset($_POST['Submit'])) {
    if((empty($_POST['email']))||(empty($_POST['id_user']))||
	    (empty($_POST['pass']))||(empty($_POST['pass2']))){
      header("../../index.php");
    } else {
      if(req($_POST) > 0 ) {
        echo "<script>
        alert('Pendaftaran Berhasil!');
        document.location.href = '../../index.php';
        </script>";
      } else {
        echo mysqli_error($conn);
      }
    }
  }
  function req($data) {
    global $conn;

    if(isset($_POST['Submit'])) {
        $email = $_POST["email"];
        $id_user = $_POST["id_user"];
        $pass = $_POST["pass"];
        $pass2 = $_POST["pass2"];
        $role = '';

        // Check if the ID is registered as a student (mahasiswa)
        $student_result = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim ='$id_user'");
        if(mysqli_num_rows($student_result) > 0) {
            $role = 'mhs'; // If it's a student, set the role to 'mhs'
        } else {
            // Check if the ID is registered as a lecturer (dosen)
            $lecturer_result = mysqli_query($conn, "SELECT nip FROM dosen WHERE nip ='$id_user'");
            if(mysqli_num_rows($lecturer_result) > 0) {
                $role = 'dosen'; // If it's a lecturer, set the role to 'dosen'
            } else {
                // Handle the case if neither student nor lecturer is found
                echo "<script>
                alert('ID tidak terdaftar sebagai mahasiswa atau dosen!');
                document.location.href = '../../index.php';
                </script>";
                return false;
            }
        }

        $result = mysqli_query($conn, "SELECT id_user FROM user WHERE id_user ='$id_user'");
        $result1 = mysqli_query($conn, "SELECT email FROM user WHERE email ='$email'");
        
        if(mysqli_fetch_array($result)){
            echo "<script>
            alert('ID sudah terdaftar!');
            document.location.href = '../../index.php';
            </script>";
            return false;
        }
  
        if(mysqli_fetch_array($result1)){
            echo "<script>
            alert('Email sudah terdaftar!');
            document.location.href = '../../index.php';
            </script>";
            return false;
        }
  
  
        if($pass !== $pass2){
            echo "<script>
            alert('Password tidak sesuai!!!');
            document.location.href = '../../index.php';
            </script>";
            return false;
        }
  
  
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO user (id_user, email, password, role) VALUE('$id_user','$email','$pass','$role')");
  
        return mysqli_affected_rows($conn);
    }
}

?>