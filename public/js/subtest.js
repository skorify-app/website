const el = (id) => document.getElementById(id);
const elName = (name) => document.getElementsByName(name)[0];
const CSRF_TOKEN = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

const toggleModal = (modalName, display) => el(`${modalName}-subtest-modal`).style.display = display;

const showAlert = async(icon, title, text) => {
    await Swal.fire({
        icon,
        title,
        text,
        showConfirmButton: true,
    });
}

el('create-subtest').onclick = async() => {
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
}

async function editSubtest() {
    const id = elName('edit-subtest-id').value;
    const name = elName('edit-subtest-name').value;
    const icon = elName('edit-subtest-icon');

    if (!name.length) {
        return await showAlert('error' ,'Gagal' ,'Mohon masukkan nama subtes');
    }

    const formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);
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
        if (row) {
            row.children[1].textContent = name;
            row.dataset.subtest_name = name;
        }

        return await showAlert(
            'success',
            'Data subtes telah diubah',
            'Muat ulang halaman jika kamu merubah ikon subtes'
        );
    } catch(err) {
        return await showAlert('error' ,'Gagal', 'Terjadi kesalahan ketika ingin mengubah data subtes');
    }
}

async function createSubtest() {
    const name = elName('subtest-name').value;
    if (!name.length) return await showAlert('error', 'Gagal', 'Mohon masukkan nama subtes');

    const iconFile = elName('subtest-icon');
    const questionsFile = elName('subtest-questions');
    const formData = new FormData();

    formData.append('name', name);
    formData.append('icon_file', iconFile.files[0] ?? null);
    formData.append('questions_file', questionsFile.files[0] ?? null);

    const response = await fetch('/subtest', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: formData
    });

    if (response.status === 201) {
        setTimeout(() => {
            location.reload();
        }, 1000);

        return await showAlert('success' ,'Berhasil', 'Halaman akan diperbarui');
    }

    await showAlert('error' ,'Gagal', 'Terjadi kesalahan ketika ingin membuat subtes');
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
