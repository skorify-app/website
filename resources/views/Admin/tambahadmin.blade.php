<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Tambah Admin</title>
	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
	<link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/owl-carousel/css/owl.theme.default.min.css') }}">
	<link href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dropdown.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.3.67/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
	<!--*******************
		Preloader start
	********************-->
	<div id="preloader">
		<div class="sk-three-bounce">
			<div class="sk-child sk-bounce1"></div>
			<div class="sk-child sk-bounce2"></div>
			<div class="sk-child sk-bounce3"></div>
		</div>
	</div>
	<!--*******************
		Preloader end
	********************-->

	<div id="main-wrapper">
		<!-- Nav header (brand) -->
		<div class="nav-header" style="background-color: #001D39;">
			<a href="index.html" class="brand-logo">
				<img class="logo-abbr" src="{{ asset('images/skorify-logo.png') }}" width="400" alt="">
				<img class="logo-compact" src="{{ asset('images/skorify-logo.png') }}" alt="">
				<img class="brand-title" src="{{ asset('images/skorify-text.png') }}" alt="">
			</a>

			<div class="nav-control">
				<div class="hamburger">
					<span style="background-color: #001D39;" class="line"></span>
					<span style="background-color: #001D39;" class="line"></span>
					<span style="background-color: #001D39;" class="line"></span>
				</div>
			</div>
		</div>

		<!-- Header -->
		<div class="header">
			<div class="header-content">
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse justify-content-between">
						<div class="header-left">
							<div class="search_bar dropdown">
								<span class="search_icon p-3 c-pointer" data-toggle="dropdown">
									<i class="mdi mdi-magnify"></i>
								</span>
								<div class="dropdown-menu p-0 m-0">
									<form>
										<input class="form-control" type="search" placeholder="Cari" aria-label="Search">
									</form>
								</div>
							</div>
						</div>

						<ul class="navbar-nav header-right">
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
									<i class="mdi mdi-bell"></i>
									<div class="pulse-css"></div>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<h6 class="dropdown-header">Notifikasi</h6>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">
										<div class="d-flex align-items-center">
											<div class="notification-box bg-light-primary">
												<i class="mdi mdi-account text-primary"></i>
											</div>
											<div class="ml-3">
												<p class="mb-0"><strong>Juan</strong> menambahkan <strong>subtes</strong> matematika.</p>
												<small class="text-muted">3:20 WIB</small>
											</div>
										</div>
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item text-center" href="#">Lihat Semua Notifikasi</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
									<i class="mdi mdi-account"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<h6 class="dropdown-header">Hello, Admin!</h6>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">
										<i class="mdi mdi-account mr-2"></i>
										Profil
									</a>
									<a class="dropdown-item" href="#">
										<i class="mdi mdi-email mr-2"></i>
										Kotak Masuk
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">
										<i class="mdi mdi-logout mr-2"></i>
										Keluar
									</a>
								</div>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>

		<!-- Sidebar -->
		<div class="quixnav">
			<div class="quixnav-scroll">
				<ul class="metismenu" id="menu">
					<li>
						<a href="index.html" aria-expanded="false">
							<i class="mdi mdi-home"></i>
							<span class="nav-text">Beranda</span>
						</a>
					</li>
					<li>
						<a href="javascript:void()" aria-expanded="false">
							<i class="mdi mdi-account-group"></i>
							<span class="nav-text">Kelola akun staff</span>
						</a>
					</li>
					<li>
						<a href="javascript:void()" aria-expanded="false">
							<i class="mdi mdi-book-open-page-variant"></i>
							<span class="nav-text">Subtes</span>
						</a>
					</li>
					<li>
						<a href="javascript:void()" aria-expanded="false">
							<i class="mdi mdi-cog"></i>
							<span class="nav-text">Pengaturan Akun</span>
						</a>
					</li>
					<li>
						<a href="javascript:void()" aria-expanded="false">
							<i class="mdi mdi-logout"></i>
							<span class="nav-text">Log out</span>
						</a>
					</li>
				</ul>
			</div>
		</div>

		<!-- Content body -->
		<div class="content-body">
			<div class="container-fluid">
				<!-- Staff Management Section -->
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header" style="border-bottom: 2px solid #FF0000; display: flex; justify-content: space-between; align-items: center;">
								<h5 style="margin: 0; color: #001D39;">Staff</h5>
								<button type="button" class="btn btn-light" data-toggle="modal" data-target="#addStaffModal" style="border: none; background-color: #f0f0f0; padding: 8px 12px; border-radius: 4px;">
									<i class="mdi mdi-plus" style="margin-right: 5px;"></i>Tambahkan staff
								</button>
							</div>
							<div class="card-body">
								<!-- Search Bar -->
								<div class="row mb-3">
									<div class="col-md-10">
										<div class="input-group">
											<input type="text" class="form-control" id="searchStaff" placeholder="Cari disini" style="background-color: #e8f0f7;">
											<div class="input-group-append">
												<span class="input-group-text" style="background-color: #003d6b; border: none; cursor: pointer;">
													<i class="mdi mdi-magnify" style="color: white;"></i>
												</span>
											</div>
										</div>
									</div>
								</div>

								<!-- Staff Table -->
								<div class="table-responsive">
									<table class="table table-hover" id="staffTable">
										<thead>
											<tr style="background-color: #f5f5f5;">
												<th>Nama lengkap</th>
												<th>Email</th>
												<th>Aksi</th>
											</tr>
										</thead>
										<tbody id="staffTableBody">
											<!-- Staff rows will be added here by JavaScript -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Content body end -->

		<!-- Add Staff Modal -->
		<div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content" style="border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.15);">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
						<span aria-hidden="true">&times;</span>
					</button>

					<div class="modal-body p-4" style="padding-top: 30px !important;">
						<h5 class="text-center mb-4" style="font-weight: 700; color: #001D39;">Tambahkan akun staff</h5>

						<!-- Form Fields -->
						<form id="addStaffForm">
							<div class="form-group mb-3">
								<label for="fullName" class="form-label" style="color: #001D39; font-weight: 600;">Nama lengkap</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="background-color: #f0f0f0; border: none;">
											<i class="mdi mdi-account" style="color: #999;"></i>
										</span>
									</div>
									<input type="text" class="form-control" id="fullName" placeholder="Nama lengkap" style="background-color: #f5f5f5; border: 1px solid #ddd; border-left: none;">
								</div>
							</div>

							<div class="form-group mb-3">
								<label for="email" class="form-label" style="color: #001D39; font-weight: 600;">Email</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="background-color: #f0f0f0; border: none;">
											<i class="mdi mdi-email" style="color: #999;"></i>
										</span>
									</div>
									<input type="email" class="form-control" id="email" placeholder="Email" style="background-color: #f5f5f5; border: 1px solid #ddd; border-left: none;">
								</div>
							</div>

							<div class="form-group mb-4">
								<label for="password" class="form-label" style="color: #001D39; font-weight: 600;">Kata sandi</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="background-color: #f0f0f0; border: none;">
											<i class="mdi mdi-lock" style="color: #999;"></i>
										</span>
									</div>
									<input type="password" class="form-control" id="password" placeholder="Kata sandi" style="background-color: #f5f5f5; border: 1px solid #ddd; border-left: none;">
								</div>
							</div>

							<button type="button" class="btn btn-block" id="daftarBtn" style="background-color: #001D39; color: white; padding: 10px; border-radius: 6px; font-weight: 600; border: none;">
								DAFTAR
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Add Staff Modal End -->

		<!-- Edit Staff Modal -->
		<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content" style="border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.15);">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
						<span aria-hidden="true">&times;</span>
					</button>

					<div class="modal-body p-4" style="padding-top: 30px !important;">
						<h5 class="text-center mb-4" style="font-weight: 700; color: #001D39;">Edit akun staff</h5>

						<!-- Form Fields -->
						<form id="editStaffForm">
							<input type="hidden" id="editStaffId">
							<div class="form-group mb-3">
								<label for="editFullName" class="form-label" style="color: #001D39; font-weight: 600;">Nama lengkap</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="background-color: #f0f0f0; border: none;">
											<i class="mdi mdi-account" style="color: #999;"></i>
										</span>
									</div>
									<input type="text" class="form-control" id="editFullName" placeholder="Nama lengkap" style="background-color: #f5f5f5; border: 1px solid #ddd; border-left: none;">
								</div>
							</div>

							<div class="form-group mb-3">
								<label for="editEmail" class="form-label" style="color: #001D39; font-weight: 600;">Email</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="background-color: #f0f0f0; border: none;">
											<i class="mdi mdi-email" style="color: #999;"></i>
										</span>
									</div>
									<input type="email" class="form-control" id="editEmail" placeholder="Email" style="background-color: #f5f5f5; border: 1px solid #ddd; border-left: none;">
								</div>
							</div>

							<div class="form-group mb-4">
								<label for="editPassword" class="form-label" style="color: #001D39; font-weight: 600;">Kata sandi (kosongkan jika tidak ingin mengubah)</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" style="background-color: #f0f0f0; border: none;">
											<i class="mdi mdi-lock" style="color: #999;"></i>
										</span>
									</div>
									<input type="password" class="form-control" id="editPassword" placeholder="Kata sandi baru (opsional)" style="background-color: #f5f5f5; border: 1px solid #ddd; border-left: none;">
								</div>
							</div>

							<button type="button" class="btn btn-block" id="simpanBtn" style="background-color: #001D39; color: white; padding: 10px; border-radius: 6px; font-weight: 600; border: none;">
								SIMPAN
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Edit Staff Modal End -->
	</div>

	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="{{ asset('vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('js/quixnav-init.js') }}"></script>
	<script src="{{ asset('js/custom.min.js') }}"></script>

	<script>
		$(document).ready(function() {
			// Initialize staff data (in-memory storage for this demo)
			let staffList = [
				{ id: 1, name: 'Alldreno Hasian', email: 'Alhasian@gmail.com' },
				{ id: 2, name: 'Naomi annisa alveric', email: 'NaomiAnAlveric@gmail.com' },
				{ id: 3, name: 'Kim Aidil soleh', email: 'Kimaidilsoleh@gmail.com' },
				{ id: 4, name: 'christian bieber', email: 'Christianbieber@gmail.com' }
			];
			let staffCounter = 5;

			// Function to attach event listeners
			function attachEventListeners() {
				// Attach delete event listeners
				$('.delete-staff').off('click').on('click', function() {
					const staffId = $(this).data('staff-id');
					if (confirm('Apakah Anda yakin ingin menghapus staff ini?')) {
						staffList = staffList.filter(s => s.id !== staffId);
						renderStaffTable(filterBySearch());
					}
				});

			// Attach edit event listeners
			$('.edit-staff').off('click').on('click', function() {
				const staffId = $(this).data('staff-id');
				const staff = staffList.find(s => s.id === staffId);
				
				if (staff) {
					$('#editStaffId').val(staff.id);
					$('#editFullName').val(staff.name);
					$('#editEmail').val(staff.email);
					$('#editPassword').val('');
					$('#editStaffModal').modal('show');
				}
			});
			}

			// Function to render staff table
			function renderStaffTable(dataToShow = staffList) {
				const tbody = $('#staffTableBody');
				tbody.empty();

				if (dataToShow.length === 0) {
					tbody.html('<tr><td colspan="3" class="text-center text-muted">Tidak ada data staff</td></tr>');
					attachEventListeners();
					return;
				}

				dataToShow.forEach(function(staff) {
					const row = `
						<tr>
							<td>
								<div style="display: flex; align-items: center; gap: 8px;">
									<i class="mdi mdi-account-circle" style="font-size: 28px; color: #003d6b;"></i>
									<span>${staff.name}</span>
								</div>
							</td>
							<td>${staff.email}</td>
							<td>
								<button class="btn btn-sm btn-danger delete-staff" data-staff-id="${staff.id}" style="margin-right: 5px; padding: 4px 12px; font-size: 14px;">
									<i class="mdi mdi-delete"></i>
								</button>
								<button class="btn btn-sm btn-primary edit-staff" data-staff-id="${staff.id}" style="padding: 4px 12px; font-size: 14px;">
									<i class="mdi mdi-pencil"></i>
								</button>
							</td>
						</tr>
					`;
					tbody.append(row);
				});

				attachEventListeners();
			}

			// Function to filter staff by search term
			function filterBySearch() {
				const searchTerm = $('#searchStaff').val().toLowerCase();
				return staffList.filter(staff =>
					staff.name.toLowerCase().includes(searchTerm) ||
					staff.email.toLowerCase().includes(searchTerm)
				);
			}

			// Search functionality
			$('#searchStaff').on('keyup', function() {
				const filtered = filterBySearch();
				renderStaffTable(filtered);
			});

			// SIMPAN Button - Edit Staff
			$('#simpanBtn').on('click', function() {
				const staffId = parseInt($('#editStaffId').val());
				const fullName = $('#editFullName').val().trim();
				const email = $('#editEmail').val().trim();
				const password = $('#editPassword').val().trim();

				// Validation
				if (!fullName) {
					alert('Nama lengkap tidak boleh kosong');
					return;
				}
				if (!email) {
					alert('Email tidak boleh kosong');
					return;
				}

				// Check if email already exists (excluding current staff)
				if (staffList.some(s => s.id !== staffId && s.email === email)) {
					alert('Email sudah terdaftar');
					return;
				}

				// Find and update staff
				const staffIndex = staffList.findIndex(s => s.id === staffId);
				if (staffIndex !== -1) {
					staffList[staffIndex].name = fullName;
					staffList[staffIndex].email = email;
					if (password) {
						staffList[staffIndex].password = password;
					}
				}

				// Close modal
				$('#editStaffModal').modal('hide');
				// Emergency cleanup: remove any leftover backdrop and restore body classes/styles
				setTimeout(function() {
					$('.modal-backdrop').remove();
					if ($('.modal.show').length === 0) {
						$('body').removeClass('modal-open');
						$('body').css('padding-right', '');
						$('body').css('overflow', 'auto');
					}
				}, 50);

				// Re-render table
				renderStaffTable(filterBySearch());

				// Show success message
				setTimeout(function() {
					alert('Staff berhasil diupdate!');
				}, 300);
			});

			// DAFTAR Button - Add New Staff
			$('#daftarBtn').on('click', function() {
				const fullName = $('#fullName').val().trim();
				const email = $('#email').val().trim();
				const password = $('#password').val().trim();

				// Validation
				if (!fullName) {
					alert('Nama lengkap tidak boleh kosong');
					return;
				}
				if (!email) {
					alert('Email tidak boleh kosong');
					return;
				}
				if (!password) {
					alert('Kata sandi tidak boleh kosong');
					return;
				}

				// Check if email already exists
				if (staffList.some(s => s.email === email)) {
					alert('Email sudah terdaftar');
					return;
				}

				// Add new staff to list
				staffList.push({
					id: staffCounter++,
					name: fullName,
					email: email
				});

				// Clear form fields
				$('#fullName').val('');
				$('#email').val('');
				$('#password').val('');

				// Close modal
				$('#addStaffModal').modal('hide');
				// Emergency cleanup: remove any leftover backdrop and restore body classes/styles
				setTimeout(function() {
					$('.modal-backdrop').remove();
					if ($('.modal.show').length === 0) {
						$('body').removeClass('modal-open');
						$('body').css('padding-right', '');
						$('body').css('overflow', 'auto');
					}
				}, 50);
				
				// Re-render table
				renderStaffTable(filterBySearch());

				// Show success message
				alert('Staff berhasil ditambahkan!');
			});

			// Initial render
			renderStaffTable();
		});
	</script>
</body>
</html>

