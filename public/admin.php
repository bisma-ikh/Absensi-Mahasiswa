<?php
include_once("../env/env.php");
session_start();
if (empty($_SESSION['id_user']) || empty($_SESSION['role'])) {
  header("location:../index.php");
  exit; // Pastikan untuk keluar dari skrip setelah melakukan redirect
}

$userId = mysqli_real_escape_string($conn, $_SESSION['id_user']);
$query = "SELECT * FROM user WHERE id_user = '$userId'";
$result = mysqli_query($conn,$query);
if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    echo "Error: " . mysqli_error($conn);
    // Handle error, misalnya redirect ke halaman error atau tampilkan pesan kesalahan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="img/iconn.png">

	<title>Dashborad</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
  <a href="admin.php" class="brand" style="padding-top: 10px">
      <img src="img/iconn.png" style="width: 50px; margin: 10px">
      <span class="text">UNIBA</span>
    </a>
    <ul class="side-menu top">
      <li class= "active">
        <a href="admin.php">
          <i class='bx bxs-dashboard' ></i>
          <span class="text">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="view/admin/masterdata.php">
          <i class='bx bxs-data' ></i>
          <span class="text">Master Data</span>
        </a>
      </li>
    </ul>
    <ul class="side-menu a">
      <li>
        <a href="#" class="logout" onclick=confirmLogout()>
          <i class='bx bxs-log-out-circle' ></i>
          <span class="text">Logout</span>
        </a>
      </li>
    </ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<form method="post">
				<div class="form-input">
					<button style="display: none;">
						<i class='bx bx-search' ></i>
					</button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<div class="samping" style="display: flex; align-items: center; ;">
				<p class="list" style="color: var(--dark)"><i class='bx bx-user text-lg'></i></p>
				<p class="list" style="color: var(--dark); margin-left: 20px"><?php echo $userData["role"]?><small><br><?php echo $userData["id_user"]?></small></p>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul>
						<li>
							<a href="admin.php" style="color: var(--dark)">Home</a>
						</li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<a href="admin.php">
						<i class='bx bxs-dashboard' ></i>
					</a>
					<span class="text">
						<a href="admin.php">
							<h3>Dashboard</h3>
							<p>Dashboard</p>
						</a>
					</span>
				</li>
				<li>
					<a href="view/admin/masterdata.php">
            			<i class='bx bxs-data' ></i>
					</a>
					<span class="text">
						<a href="view/admin/masterdata.php">
							<h3>Master Data</h3>
							<p>Data</p>
						</a>
					</span>
				</li>
			</ul>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	<script src="js/script.js"></script>
	<script>
    function confirmLogout() {
      var confirmLogout = confirm("Apakah Anda yakin ingin logout?");
      if (confirmLogout) {
          window.location.href = "../controller/app/logout.php"; // Redirect ke halaman logout jika "OK" ditekan
      } else {
          // Tindakan jika "Cancel" ditekan (opsional)
          // Misalnya: tidak melakukan apa-apa atau menutup dialog
      }
    }
  </script>
	<?php
		mysqli_close($conn);
	?>
</body>
</html>