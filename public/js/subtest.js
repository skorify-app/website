const el = (id) => document.getElementById(id);
const elName = (name) => document.getElementsByName(name)[0];

el('create-subtest').onclick = async() => {
    el('create-subtest-modal').style.display = 'flex';
}

el('close-modal').onclick = async() => {
    el('create-subtest-modal').style.display = 'none';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        el('create-subtest-modal').style.display = 'none';
    }
});

el('submit-create-subtest').onclick = async() => {
    const name = elName('subtest_name');
    if (!name.value.length) {
        return await Swal.fire({
            icon: "warning",
            title: "Mohon masukkan nama subtes",
            showConfirmButton: true,
        });
    }

    const createRes = await fetch('/subtest', {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: name.value }),
    });

    if (createRes.status === 204) {
        setTimeout(() => {
            location.reload();
        }, 1000);

        await Swal.fire({
            icon: "success",
            title: "Subtes berhasil ditambahkan",
            showConfirmButton: false,
        });
    } else {
        await Swal.fire({
            icon: "warning",
            title: "Subtes gagal dihapus",
            showConfirmButton: true,
        });
    }
}



document.addEventListener("click", async (e) => {
    if (e.target.classList.contains("btn-delete")) {
        const row = e.target.closest("tr");
        const subtestName = row.querySelector("td").textContent;

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
});
