const el = (id) => document.getElementById(id);
const elName = (name) => document.getElementsByName(name)[0];
const CSRF_TOKEN = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

const toggleModal = (modalName, display) => el(`${modalName}-subtest-modal`).style.display = display;

// Prevent non-numeric entry and sanitize duration inputs (strip non-digits, enforce 0-59 for min/sec)
function setupDurationInputSanitizers() {
    document.querySelectorAll('.duration-input').forEach(input => {
        // Prevent characters like 'e', '+', '-' in number inputs
        input.addEventListener('keydown', (e) => {
            if (e.key === 'e' || e.key === 'E' || e.key === '+' || e.key === '-') {
                e.preventDefault();
            }
        });

        input.addEventListener('input', () => {
            // remove any non-digit characters
            let v = input.value.replace(/\D/g, '');
            // enforce max if provided (minutes/seconds)
            if (input.hasAttribute('max')) {
                const max = parseInt(input.getAttribute('max'), 10);
                if (!isNaN(max) && parseInt(v || '0', 10) > max) v = String(max);
            }
            // remove leading zeros except single zero
            if (v.length > 1) {
                v = v.replace(/^0+(?=\d)/, '');
            }
            input.value = v;
        });

        input.addEventListener('paste', () => {
            setTimeout(() => {
                input.value = input.value.replace(/\D/g, '');
            }, 0);
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupDurationInputSanitizers();
});

const showAlert = async(icon, title, text) => {
    await Swal.fire({
        icon,
        title,
        text,
        showConfirmButton: true,
    });
}

el('create-subtest').onclick = async() => {
    // set sensible defaults for duration inputs when creating
    try {
        elName('subtest-duration-hours').value = elName('subtest-duration-hours').value || '0';
        elName('subtest-duration-minutes').value = elName('subtest-duration-minutes').value || '0';
        elName('subtest-duration-seconds').value = elName('subtest-duration-seconds').value || '0';
    } catch (e) {
        // ignore if inputs not present
    }
    toggleModal('create', 'flex');
}

el('submit-create-subtest').onclick = async() => {
    await createSubtest();
}

el('submit-edit-subtest').onclick = async() => {
    return await editSubtest();
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        toggleModal('create', 'none');
        toggleModal('edit', 'none');
    }
});

document.addEventListener("click", async (e) => {
    const classes = e.target.classList;
    if (classes.contains("btn-delete")) {
        await deleteSubtest(e);
    } else if (classes.contains('btn-edit')) {
        toggleModal('edit', 'flex');
        await showEditSubtestModal(e);
    } else if (classes.contains('close-btn')) {
        toggleModal('create', 'none');
        toggleModal('edit', 'none');
    }
});

async function showEditSubtestModal(e) {
    const row = e.target.closest("tr");
    elName('edit-subtest-id').value = row.getAttribute('data-subtest-id');
    elName('edit-subtest-name').value = row.getAttribute('data-subtest-name');

    // populate hour/minute/second inputs
    const h = row.getAttribute('data-subtest-hours') ?? '0';
    const m = row.getAttribute('data-subtest-minutes') ?? '0';
    const s = row.getAttribute('data-subtest-seconds') ?? '0';

    elName('edit-subtest-duration-hours').value = h;
    elName('edit-subtest-duration-minutes').value = m;
    elName('edit-subtest-duration-seconds').value = s;
}

function formatSecondsToHms(sec) {
    const h = Math.floor(sec / 3600);
    const m = Math.floor((sec % 3600) / 60);
    const s = sec % 60;
    return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
}

async function editSubtest() {
    const id = elName('edit-subtest-id').value;
    const name = elName('edit-subtest-name').value;
    const icon = elName('edit-subtest-icon');

    // read hour/min/sec inputs
    const h = parseInt(elName('edit-subtest-duration-hours').value || '0', 10);
    const m = parseInt(elName('edit-subtest-duration-minutes').value || '0', 10);
    const s = parseInt(elName('edit-subtest-duration-seconds').value || '0', 10);

    if (!name.length) {
        return await showAlert('error' ,'Gagal' ,'Mohon masukkan nama subtes');
    }

    if (isNaN(h) || isNaN(m) || isNaN(s) || h < 0 || m < 0 || m > 59 || s < 0 || s > 59) {
        return await showAlert('error', 'Gagal', 'Mohon masukkan durasi yang valid (Jam>=0, 0<=Menit<60, 0<=Detik<60)');
    }

    const durationSeconds = h * 3600 + m * 60 + s;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);
    formData.append('duration_seconds', durationSeconds);
    formData.append('icon', icon.files[0] ?? null);

    try {
        const response = await fetch(`/subtest/update`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: formData
        });

        const status = response.status;
        if (status !== 204) {
            let message;
            switch (response.status) {
                case 404:
                    message = 'Maaf, subtes ini tidak terdaftar atau sudah dihapus.';
                    break;
                case 400:
                    message = 'Maaf, subtes dengan nama ini sudah terdaftar.';
                    break;
                case 500:
                    message = 'Maaf, terjadi kesalahan pada sistem.';
            }

            return await showAlert('error' ,'Gagal', message);
        }

                const row = document.querySelector(`tr[data-subtest-id="${id}"]`);
        const hadIcon = icon.files[0] ?? null;
        if (row) {
            row.children[1].textContent = name;
            row.children[2].textContent = formatSecondsToHms(durationSeconds);
            row.dataset.subtest_name = name;
            row.dataset.subtest_hours = h;
            row.dataset.subtest_minutes = m;
            row.dataset.subtest_seconds = s;
        }

        await showAlert(
            'success',
            'Data subtes telah diubah',
            'Halaman akan dimuat ulang untuk menerapkan perubahan'
        );

        // Reload so changes (including icons) are reflected
        setTimeout(() => location.reload(), 600);

        return;
    } catch(err) {
        return await showAlert('error' ,'Gagal', 'Terjadi kesalahan ketika ingin mengubah data subtes');
    }
}

async function createSubtest() {
    const name = elName('name')?.value;
    if (!name) {
        return await showAlert('error', 'Gagal', 'Mohon masukkan nama subtes');
    }

    const h = parseInt(elName('duration_hours')?.value || '0', 10);
    const m = parseInt(elName('duration_minutes')?.value || '0', 10);
    const s = parseInt(elName('duration_seconds_input')?.value || '0', 10);

    if (isNaN(h) || isNaN(m) || isNaN(s) || m > 59 || s > 59) {
        return await showAlert(
            'error',
            'Gagal',
            'Mohon masukkan durasi yang valid'
        );
    }

    const formData = new FormData();
    formData.append('name', name);
    formData.append('duration_hours', h);
    formData.append('duration_minutes', m);
    formData.append('duration_seconds_input', s);

    const iconFile = document.querySelector('input[name="icon_file"]');
    const questionsFile = document.querySelector('input[name="questions_file"]');
    const imagesZip = document.querySelector('input[name="images_zip"]');

    if (iconFile?.files[0]) formData.append('icon_file', iconFile.files[0]);
    if (questionsFile?.files[0]) formData.append('questions_file', questionsFile.files[0]);
    if (imagesZip?.files[0]) formData.append('images_zip', imagesZip.files[0]);

    try {
        const res = await fetch('/subtest', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
            },
            body: formData
        });

        if (!res.ok) {
            await showAlert('error', 'Gagal', 'Terjadi kesalahan');
            return;
        }

        await showAlert('success', 'Berhasil', 'Data berhasil disimpan');

        setTimeout(() => {
            window.location.href = '/subtest'; // tujuan redirect
        }, 800);

    } catch (e) {
        await showAlert('error', 'Gagal', 'Tidak dapat terhubung ke server');
    }
}
async function deleteSubtest(e) {
    const row = e.target.closest("tr");
    const subtestName = row.getAttribute('data-subtest-name');

    const result = await Swal.fire({
        title: `Hapus subtes ${subtestName}?`,
        text: "Semua soal akan dihapus juga dari daftar!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    });

    if (result.isConfirmed) {
        const subtestId = row.getAttribute('data-subtest-id');

        const deleteRes = await fetch(`/subtest/${subtestId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            }
        });

        console.log(deleteRes)
        if (deleteRes.status !== 204) {
            await Swal.fire({
                icon: "warning",
                title: "Subtes gagal dihapus",
                showConfirmButton: true,
            });
        } else {
            row.remove();
            await Swal.fire({
                icon: "success",
                title: "Subtes berhasil dihapus",
                showConfirmButton: true,
            });
        }
    }
}

