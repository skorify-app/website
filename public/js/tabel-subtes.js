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
    document.getElementById("saveSubtest").onclick = function () {
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

      // Tambahkan ke tabel
      const newRow = table.insertRow();
      newRow.innerHTML = `
        <td>${name}</td>
        <td class="actions">
         <button class="btn-delete bi bi-trash3"></button>
          <button class="btn-edit bi bi-pencil-square"></button>
          <button class="btn-add bi bi-eye"></button>
        </td>
      `;

      // Reset form
      document.getElementById("subtestName").value = "";
      document.getElementById("subtestFile").value = "";

      Swal.fire({
        icon: "success",
        title: `Subtes "${name}" berhasil disimpan!`,
        text: `File: ${file.name}`,
        showConfirmButton: false,
        timer: 1800,
      });

      modal.style.display = "none";
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