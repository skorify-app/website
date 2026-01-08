<div class="modal-subtes" id="edit-staff-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Edit Staff</h3>

        <input type="text" name="edit-staff-id" class="d-none" />

        <label>Nama Lengkap</label>
        <input type="text" name="edit-staff-name" />

        <label>Email</label>
        <input type="email" name="edit-staff-email" />

        <label>Kata Sandi (kosongkan jika tidak ingin mengubah)</label>
        <div style="position: relative;">
            <input type="password" name="edit-staff-password" id="edit-staff-password" placeholder="Minimal 16 karakter (huruf besar, kecil, angka, simbol)" style="width: 100%; padding-right: 45px;" />
            <button type="button" id="toggle-edit-password" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 8px; color: #666; font-size: 18px; line-height: 1; pointer-events: auto;">
                <i class="bi bi-eye" id="edit-eye-icon" style="pointer-events: none;"></i>
            </button>
        </div>
        <small style="color: #666; font-size: 0.85em; display: block; margin-top: 4px;">
            Contoh: MySecureP@ssw0rd2024!
        </small>

        <button id="submit-edit-staff">Edit</button>
    </div>
</div>
