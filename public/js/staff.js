    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const createStaffBtn = document.getElementById('create-staff');
    const staffTable = document.getElementById('staff-table');
    const staffTableBody = staffTable.querySelector('tbody');
    const createStaffModal = document.getElementById('create-staff-modal');
    const editStaffModal = document.getElementById('edit-staff-modal');
    const submitCreateStaffBtn = document.getElementById('submit-create-staff');
    const submitEditStaffBtn = document.getElementById('submit-edit-staff');

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Store all staffs for searching
    let allStaffs = [];

    // Load staffs from table
    function loadStaffs() {
        allStaffs = [];
        staffTableBody.querySelectorAll('tr').forEach(row => {
            if (row.dataset.staffId) {
                allStaffs.push({
                    id: row.dataset.staffId,
                    name: row.dataset.staffName,
                    email: row.dataset.staffEmail,
                    element: row
                });
            }
        });
    }

    // Show modal
    function showModal(modal) {
        modal.style.display = 'flex';
        modal.classList.add('show');
    }

    // Hide modal
    function hideModal(modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
    }

    // Modal close button
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.modal-subtes');
            hideModal(modal);
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal-subtes')) {
            hideModal(event.target);
        }
    });

    // Render table
    function renderTable(staffsToShow = allStaffs) {
        staffTableBody.innerHTML = '';
        
        if (staffsToShow.length === 0) {
            staffTableBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Tidak ada data staff</td></tr>';
            return;
        }

        staffsToShow.forEach(staff => {
            const row = document.createElement('tr');
            row.dataset.staffId = staff.id;
            row.dataset.staffName = staff.name;
            row.dataset.staffEmail = staff.email;
            row.innerHTML = `
                <td>${staff.name}</td>
                <td>${staff.email}</td>
                <td class="actions">
                    <button class="btn-delete bi bi-trash"></button>
                    <button class="btn-edit bi bi-pencil-square"></button>
                </td>
            `;
            staffTableBody.appendChild(row);
        });

        attachEventListeners();
    }

    // Attach event listeners to buttons
    function attachEventListeners() {
        staffTableBody.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const staffId = row.dataset.staffId;
                const staffName = row.dataset.staffName;

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus staff bernama ${staffName}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteStaff(staffId);
                    }
                });
            });
        });

        staffTableBody.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const staffId = row.dataset.staffId;
                const staffName = row.dataset.staffName;
                const staffEmail = row.dataset.staffEmail;

                openEditModal(staffId, staffName, staffEmail);
            });
        });
    }

    // Search functionality
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const filtered = allStaffs.filter(staff =>
            staff.name.toLowerCase().includes(searchTerm) ||
            staff.email.toLowerCase().includes(searchTerm)
        );
        renderTable(filtered);
    });

    // Open create modal
    createStaffBtn.addEventListener('click', function() {
        document.querySelector('input[name="create-staff-name"]').value = '';
        document.querySelector('input[name="create-staff-email"]').value = '';
        document.querySelector('input[name="create-staff-password"]').value = '';
        showModal(createStaffModal);
    });

    // Submit create staff
    submitCreateStaffBtn.addEventListener('click', async function() {
        const fullName = document.querySelector('input[name="create-staff-name"]').value.trim();
        const email = document.querySelector('input[name="create-staff-email"]').value.trim();
        const password = document.querySelector('input[name="create-staff-password"]').value.trim();

        // Validation
        if (!fullName) {
            Swal.fire('Error', 'Nama lengkap tidak boleh kosong', 'error');
            return;
        }
        if (!email) {
            Swal.fire('Error', 'Email tidak boleh kosong', 'error');
            return;
        }
        if (!password) {
            Swal.fire('Error', 'Password tidak boleh kosong', 'error');
            return;
        }
        if (password.length < 8) {
            Swal.fire('Error', 'Password minimal 8 karakter', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('full_name', fullName);
        formData.append('email', email);
        formData.append('password', password);

        try {
            const res = await fetch('/tambah-staff', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            if (!res.ok) {
                const err = await res.json().catch(() => null);
                const message = err?.errors ? Object.values(err.errors)[0][0] : 'Gagal menambahkan staff.';
                Swal.fire('Error', message, 'error');
                return;
            }

            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: data.message,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    hideModal(createStaffModal);
                    location.reload();
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Terjadi kesalahan saat menambahkan staff.', 'error');
        }
    });

    // Open edit modal
    function openEditModal(staffId, staffName, staffEmail) {
        document.querySelector('input[name="edit-staff-id"]').value = staffId;
        document.querySelector('input[name="edit-staff-name"]').value = staffName;
        document.querySelector('input[name="edit-staff-email"]').value = staffEmail;
        document.querySelector('input[name="edit-staff-password"]').value = '';
        showModal(editStaffModal);
    }

    // Submit edit staff
    submitEditStaffBtn.addEventListener('click', async function() {
        const staffId = document.querySelector('input[name="edit-staff-id"]').value;
        const fullName = document.querySelector('input[name="edit-staff-name"]').value.trim();
        const email = document.querySelector('input[name="edit-staff-email"]').value.trim();
        const password = document.querySelector('input[name="edit-staff-password"]').value.trim();

        // Validation
        if (!fullName) {
            Swal.fire('Error', 'Nama lengkap tidak boleh kosong', 'error');
            return;
        }
        if (!email) {
            Swal.fire('Error', 'Email tidak boleh kosong', 'error');
            return;
        }
        if (password && password.length < 8) {
            Swal.fire('Error', 'Password minimal 8 karakter', 'error');
            return;
        }

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('full_name', fullName);
        formData.append('email', email);
        if (password) {
            formData.append('password', password);
        }

        try {
            const res = await fetch(`/staff/${staffId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            if (!res.ok) {
                const err = await res.json().catch(() => null);
                const message = err?.errors ? Object.values(err.errors)[0][0] : 'Gagal mengupdate staff.';
                Swal.fire('Error', message, 'error');
                return;
            }

            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: data.message,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    hideModal(editStaffModal);
                    location.reload();
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Terjadi kesalahan saat mengupdate staff.', 'error');
        }
    });

    // Delete staff
    async function deleteStaff(staffId) {
        try {
            const res = await fetch(`/staff/${staffId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!res.ok) {
                const err = await res.json().catch(() => null);
                const message = err?.message || 'Gagal menghapus staff.';
                Swal.fire('Error', message, 'error');
                return;
            }

            const data = await res.json();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: data.message,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload();
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Terjadi kesalahan saat menghapus staff.', 'error');
        }
    }

    // Initialize
    loadStaffs();
    renderTable();
});
