<div class="modal-subtes" id="create-staff-modal">
    <div class="modal-contentSubtes text-dark">
        <span class="close-btn">&times;</span>
        <h3>Tambah Staff</h3>

        <label>Nama Lengkap</label>
        <input type="text" name="create-staff-name" placeholder="Masukkan nama lengkap" />

        <label>Email</label>
        <input type="email" name="create-staff-email" placeholder="Masukkan email" />

        <label>Kata Sandi</label>
        <div style="position: relative;">
            <input type="password" name="create-staff-password" id="create-staff-password" placeholder="Minimal 16 karakter (huruf besar, kecil, angka, simbol)" style="width: 100%; padding-right: 45px;" />
            <button type="button" id="toggle-create-password" style="width:10%;position: absolute; right: 8px; top: 37%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 8px; color: #666; font-size: 18px; line-height: 1; pointer-events: auto;">
                <i class="bi bi-eye" id="create-eye-icon" style="pointer-events: none;"></i>
            </button>
        </div>
        <small style="color: #666; font-size: 0.85em; display: block; margin-top: 4px;">
            Contoh: AlldrenogantengP@ssw0rd2025!
        </small>

        <button id="submit-create-staff">Tambah</button>
    </div>
</div>
