 const modal = document.getElementById("subtestModal");
    const addBtn = document.getElementById("addSubtestBtn");
    const closeModal = document.getElementById("closeModal");
    const table = document
      .getElementById("subtestTable")
      .getElementsByTagName("tbody")[0];

    // Buka & tutup modal
    addBtn.onclick = () => (modal.style.display = "flex");
    closeModal.onclick = () => (modal.style.display = "none");
    window.onclick = (e) => {
      if (e.target === modal) modal.style.display = "none";
    };

    // Tombol "Unduh Template"
    document.getElementById("downloadTemplate").onclick = () => {
      const link = document.createElement("a");
      link.href = "http://127.0.0.1:8000/Template_Soal_Subtest.xltx"; // ganti dengan path file kamu
      link.download = "Template_Soal_Subtest.xltx";
      link.click();
    };

    // Simpan subtest (nama + file)
   document.getElementById("saveSubtest").onclick = async function (e) {
  e.preventDefault();

  const name = document.getElementById("subtestName").value.trim();
  const file = document.getElementById("subtestFile").files[0];

  if (name === "" || !file) {
    Swal.fire({
      icon: "warning",
      title: "Harap isi nama subtest dan upload file soal!",
      confirmButtonColor: "#003366",
    });
    return;
  }

  const formData = new FormData();
  formData.append("nama_subtes", name);
  formData.append("file_soal", file);

  // Get CSRF token from meta tag
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  try {
    const response = await fetch("/subtes", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": csrfToken,
      },
      body: formData,
    });

    const data = await response.json();

    if (response.ok) {
      // Tambahkan ke tabel UI
      const newRow = table.insertRow();
      newRow.innerHTML = `
        <td>${data.subtes.nama_subtes}</td>
        <td class="actions">
          <button class="btn-delete bi bi-trash3"></button>
          <button class="btn-edit bi bi-pencil-square"></button>
          <button class="btn-add bi bi-eye"></button>
        </td>
      `;

      Swal.fire({
        icon: "success",
        title: `Subtes "${name}" berhasil disimpan!`,
        text: `File soal berhasil diimport ke database.`,
        showConfirmButton: false,
        timer: 1800,
      });

      // Reset form dan tutup modal
      document.getElementById("subtestName").value = "";
      document.getElementById("subtestFile").value = "";
      modal.style.display = "none";
    } else {
      Swal.fire({
        icon: "error",
        title: "Gagal menyimpan subtes!",
        text: data.message || "Periksa kembali file Excel kamu.",
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Terjadi kesalahan!",
      text: "Coba ulangi beberapa saat lagi.",
    });
  }
};

// Hapus subtest pakai SweetAlert2
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("btn-delete")) {
    const row = e.target.closest("tr");
    const subtestName = row.querySelector("td").textContent;

    Swal.fire({
      title: `Hapus subtes "${subtestName}"?`,
      text: "Data ini akan dihapus dari daftar!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        row.remove();
        Swal.fire({
          icon: "success",
          title: "Subtes berhasil dihapus!",
          showConfirmButton: false,
          timer: 1500,
        });
      }
    });
  }
});

