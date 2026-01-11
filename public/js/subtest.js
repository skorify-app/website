const el = (id) => document.getElementById(id);
const elName = (name) => document.getElementsByName(name)[0];
const CSRF_TOKEN = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

const toggleModal = (modalName, display) =>
    (el(`${modalName}-subtest-modal`).style.display = display);

// Prevent non-numeric entry and sanitize duration inputs (strip non-digits, enforce 0-59 for min/sec)
function setupDurationInputSanitizers() {
    document.querySelectorAll(".duration-input").forEach((input) => {
        // Prevent characters like 'e', '+', '-' in number inputs
        input.addEventListener("keydown", (e) => {
            if (
                e.key === "e" ||
                e.key === "E" ||
                e.key === "+" ||
                e.key === "-"
            ) {
                e.preventDefault();
            }
        });

        input.addEventListener("input", () => {
            // remove any non-digit characters
            let v = input.value.replace(/\D/g, "");
            // enforce max if provided (minutes/seconds)
            if (input.hasAttribute("max")) {
                const max = parseInt(input.getAttribute("max"), 10);
                if (!isNaN(max) && parseInt(v || "0", 10) > max)
                    v = String(max);
            }
            // remove leading zeros except single zero
            if (v.length > 1) {
                v = v.replace(/^0+(?=\d)/, "");
            }
            input.value = v;
        });

        input.addEventListener("paste", () => {
            setTimeout(() => {
                input.value = input.value.replace(/\D/g, "");
            }, 0);
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    setupDurationInputSanitizers();

    // Client-side search for subtests by name
    const searchInput = document.getElementById("search");
    const tbody = document.querySelector("#subtests-table tbody");
    const NO_RESULTS_ID = "no-results-row";

    function filterSubtests() {
        const q = (searchInput.value || "").trim().toLowerCase();
        let anyVisible = false;

        tbody.querySelectorAll("tr").forEach((tr) => {
            const id = tr.getAttribute("data-subtest-id");
            // skip rows that are not data rows
            if (!id) return;
            const name = (
                tr.getAttribute("data-subtest-name") || ""
            ).toLowerCase();
            if (q === "" || name.includes(q)) {
                tr.style.display = "";
                anyVisible = true;
            } else {
                tr.style.display = "none";
            }
        });

        const existing = document.getElementById(NO_RESULTS_ID);
        if (!anyVisible) {
            if (!existing) {
                const r = document.createElement("tr");
                r.id = NO_RESULTS_ID;
                r.innerHTML =
                    '<td colspan="4" class="text-center text-muted">Tidak ada subtes yang cocok</td>';
                tbody.appendChild(r);
            }
        } else if (existing) {
            existing.remove();
        }
    }

    if (searchInput) {
        searchInput.addEventListener("input", filterSubtests);
        // run once on load to apply empty filter or prefilled value
        if (searchInput.value) filterSubtests();
    }
});

const showAlert = async (icon, title, text) => {
    await Swal.fire({
        icon,
        title,
        text,
        showConfirmButton: true,
    });
};

el("create-subtest").onclick = async () => {
    // set sensible defaults for duration inputs when creating
    try {
        elName("subtest-duration-hours").value =
            elName("subtest-duration-hours").value || "0";
        elName("subtest-duration-minutes").value =
            elName("subtest-duration-minutes").value || "0";
        elName("subtest-duration-seconds").value =
            elName("subtest-duration-seconds").value || "0";
    } catch (e) {
        // ignore if inputs not present
    }
    toggleModal("create", "flex");
};

el("submit-create-subtest").onclick = async () => {
    await createSubtest();
};

el("submit-edit-subtest").onclick = async () => {
    return await editSubtest();
};

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        toggleModal("create", "none");
        toggleModal("edit", "none");
    }
});

document.addEventListener("click", async (e) => {
    const classes = e.target.classList;
    if (classes.contains("btn-delete")) {
        await deleteSubtest(e);
    } else if (classes.contains("btn-edit")) {
        toggleModal("edit", "flex");
        await showEditSubtestModal(e);
    } else if (classes.contains('close-btn')) {
        // Reset file inputs when closing edit modal
        const iconInput = elName('edit-subtest-icon');
        const questionsInput = elName('edit-subtest-questions-file');
        const imagesInput = elName('edit-subtest-images-zip');
        
        if (iconInput) iconInput.value = '';
        if (questionsInput) questionsInput.value = '';
        if (imagesInput) imagesInput.value = '';
        
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
    
    // Store original values for change detection
    window.originalEditValues = {
        name: row.getAttribute('data-subtest-name'),
        hours: h,
        minutes: m,
        seconds: s
    };
    
    // Disable save button initially (no changes yet)
    const saveButton = el('submit-edit-subtest');
    saveButton.disabled = true;
    saveButton.style.opacity = '0.5';
    saveButton.style.cursor = 'not-allowed';
    
    // Add change detection listeners
    setupEditChangeDetection();
}

function setupEditChangeDetection() {
    const saveButton = el('submit-edit-subtest');
    
    function checkForChanges() {
        const currentName = elName('edit-subtest-name').value;
        const currentHours = elName('edit-subtest-duration-hours').value;
        const currentMinutes = elName('edit-subtest-duration-minutes').value;
        const currentSeconds = elName('edit-subtest-duration-seconds').value;
        
        const iconFile = elName('edit-subtest-icon').files[0];
        const questionsFile = elName('edit-subtest-questions-file').files[0];
        const imagesFile = elName('edit-subtest-images-zip').files[0];
        
        const hasFileChanges = iconFile || questionsFile || imagesFile;
        
        const hasChanges = 
            currentName !== window.originalEditValues.name ||
            currentHours !== window.originalEditValues.hours ||
            currentMinutes !== window.originalEditValues.minutes ||
            currentSeconds !== window.originalEditValues.seconds ||
            hasFileChanges;
        
        if (hasChanges) {
            saveButton.disabled = false;
            saveButton.style.opacity = '1';
            saveButton.style.cursor = 'pointer';
        } else {
            saveButton.disabled = true;
            saveButton.style.opacity = '0.5';
            saveButton.style.cursor = 'not-allowed';
        }
    }
    
    // Remove old listeners if any
    const nameInput = elName('edit-subtest-name');
    const hoursInput = elName('edit-subtest-duration-hours');
    const minutesInput = elName('edit-subtest-duration-minutes');
    const secondsInput = elName('edit-subtest-duration-seconds');
    const iconInput = elName('edit-subtest-icon');
    const questionsInput = elName('edit-subtest-questions-file');
    const imagesInput = elName('edit-subtest-images-zip');
    
    // Add event listeners
    nameInput.addEventListener('input', checkForChanges);
    hoursInput.addEventListener('input', checkForChanges);
    minutesInput.addEventListener('input', checkForChanges);
    secondsInput.addEventListener('input', checkForChanges);
    iconInput.addEventListener('change', checkForChanges);
    questionsInput.addEventListener('change', checkForChanges);
    imagesInput.addEventListener('change', checkForChanges);
}

function formatSecondsToHms(sec) {
    const h = Math.floor(sec / 3600);
    const m = Math.floor((sec % 3600) / 60);
    const s = sec % 60;
    return (
        String(h).padStart(2, "0") +
        ":" +
        String(m).padStart(2, "0") +
        ":" +
        String(s).padStart(2, "0")
    );
}

async function editSubtest() {
    const id = elName("edit-subtest-id").value;
    const name = elName("edit-subtest-name").value;
    const icon = elName("edit-subtest-icon");

    // read hour/min/sec inputs
    const h = parseInt(elName("edit-subtest-duration-hours").value || "0", 10);
    const m = parseInt(
        elName("edit-subtest-duration-minutes").value || "0",
        10
    );
    const s = parseInt(
        elName("edit-subtest-duration-seconds").value || "0",
        10
    );

    if (!name.length) {
        return await showAlert("error", "Gagal", "Mohon masukkan nama subtes");
    }

    if (
        isNaN(h) ||
        isNaN(m) ||
        isNaN(s) ||
        h < 0 ||
        m < 0 ||
        m > 59 ||
        s < 0 ||
        s > 59
    ) {
        return await showAlert(
            "error",
            "Gagal",
            "Mohon masukkan durasi yang valid (Jam>=0, 0<=Menit<60, 0<=Detik<60)"
        );
    }

    const durationSeconds = h * 3600 + m * 60 + s;

    const formData = new FormData();
    formData.append("id", id);
    formData.append("name", name);
    formData.append("duration_hours", h);
    formData.append("duration_minutes", m);
    formData.append("duration_seconds_input", s);
    formData.append("icon", icon.files[0] ?? null);

    // Add new file uploads (optional)
    const questionsFile = elName("edit-subtest-questions-file");
    const imagesZip = elName("edit-subtest-images-zip");

    if (questionsFile.files[0]) {
        formData.append("questions_file", questionsFile.files[0]);
    }

    if (imagesZip.files[0]) {
        formData.append("images_zip", imagesZip.files[0]);
    }

    try {
        const response = await fetch(`/subtest/update`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": CSRF_TOKEN,
            },
            body: formData,
        });

        const status = response.status;

        // Handle JSON response for no changes
        if (status === 200) {
            const data = await response.json();
            if (data.success === false) {
                return await showAlert(
                    "info",
                    "Tidak Ada Perubahan",
                    data.message || "Tidak ada perubahan yang dilakukan."
                );
            }
        }

        if (status !== 204) {
            let message;
            switch (response.status) {
                case 404:
                    message =
                        "Maaf, subtes ini tidak terdaftar atau sudah dihapus.";
                    break;
                case 400:
                    message = "Maaf, subtes dengan nama ini sudah terdaftar.";
                    break;
                case 500:
                    message = "Maaf, terjadi kesalahan pada sistem.";
            }

            return await showAlert("error", "Gagal", message);
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
            "success",
            "Data subtes telah diubah",
            "Halaman akan dimuat ulang untuk menerapkan perubahan"
        );

        // Reload so changes (including icons) are reflected
        setTimeout(() => location.reload(), 600);

        return;
    } catch (err) {
        return await showAlert(
            "error",
            "Gagal",
            "Terjadi kesalahan ketika ingin mengubah data subtes"
        );
    }
}

async function createSubtest() {
    const name = elName("name")?.value;
    if (!name) {
        return await showAlert("error", "Gagal", "Mohon masukkan nama subtes");
    }

    const h = parseInt(elName("duration_hours")?.value || "0", 10);
    const m = parseInt(elName("duration_minutes")?.value || "0", 10);
    const s = parseInt(elName("duration_seconds_input")?.value || "0", 10);

    if (isNaN(h) || isNaN(m) || isNaN(s) || m > 59 || s > 59) {
        return await showAlert(
            "error",
            "Gagal",
            "Mohon masukkan durasi yang valid"
        );
    }

    const formData = new FormData();
    formData.append("name", name);
    formData.append("duration_hours", h);
    formData.append("duration_minutes", m);
    formData.append("duration_seconds_input", s);

    const iconFile = document.querySelector('input[name="icon_file"]');
    const questionsFile = document.querySelector(
        'input[name="questions_file"]'
    );
    const imagesZip = document.querySelector('input[name="images_zip"]');

    if (iconFile?.files[0]) formData.append("icon_file", iconFile.files[0]);
    if (questionsFile?.files[0])
        formData.append("questions_file", questionsFile.files[0]);
    if (imagesZip?.files[0]) formData.append("images_zip", imagesZip.files[0]);

    try {
        const res = await fetch("/subtest", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": CSRF_TOKEN,
            },
            body: formData,
        });

        if (!res.ok) {
            await showAlert("error", "Gagal", "Terjadi kesalahan");
            return;
        }

        await showAlert("success", "Berhasil", "Data berhasil disimpan");

        setTimeout(() => {
            window.location.href = "/subtest"; // tujuan redirect
        }, 800);
    } catch (e) {
        await showAlert("error", "Gagal", "Tidak dapat terhubung ke server");
    }
}
async function deleteSubtest(e) {
    const row = e.target.closest("tr");
    const subtestName = row.getAttribute("data-subtest-name");

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
        const subtestId = row.getAttribute("data-subtest-id");

        const deleteRes = await fetch(`/subtest/${subtestId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });

        console.log(deleteRes);
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
