<div class="baris">
    <div class="atas"><button type="button" class="btn kecil bahaya js-hapus">Hapus baris</button></div>
    <div class="kisi">
        <div>
            <label>Institusi *</label>
            <input type="text" name="pendidikan[{{ $i }}][institusi]" value="{{ $row['institusi'] ?? '' }}" placeholder="Universitas Borcelle">
        </div>
        <div>
            <label>Jurusan / Program</label>
            <input type="text" name="pendidikan[{{ $i }}][jurusan]" value="{{ $row['jurusan'] ?? '' }}" placeholder="S1 Akuntansi">
        </div>
        <div>
            <label>Tahun Mulai *</label>
            <input type="text" name="pendidikan[{{ $i }}][tahun_mulai]" value="{{ $row['tahun_mulai'] ?? '' }}" maxlength="4" placeholder="2019">
        </div>
        <div>
            <label>Tahun Selesai</label>
            <input type="text" name="pendidikan[{{ $i }}][tahun_selesai]" value="{{ $row['tahun_selesai'] ?? '' }}" maxlength="4" placeholder="2023 (kosong = sekarang)">
        </div>
    </div>
</div>
