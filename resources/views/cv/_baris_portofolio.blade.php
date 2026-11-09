<div class="baris">
    <div class="atas"><button type="button" class="btn kecil bahaya js-hapus">Hapus baris</button></div>
    <div class="kisi">
        <div>
            <label>Judul / Peran *</label>
            <input type="text" name="portofolio[{{ $i }}][judul]" value="{{ $row['judul'] ?? '' }}" placeholder="Magang">
        </div>
        <div>
            <label>Instansi / Tempat</label>
            <input type="text" name="portofolio[{{ $i }}][instansi]" value="{{ $row['instansi'] ?? '' }}" placeholder="Borcelle">
        </div>
        <div>
            <label>Kategori</label>
            <select name="portofolio[{{ $i }}][kategori_id]">
                <option value="">– Pilih kategori –</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" @selected((string) ($row['kategori_id'] ?? '') === (string) $k->id)>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>&nbsp;</label>
            <input type="hidden" name="portofolio[{{ $i }}][tampilkan]" value="0">
            <label class="cek">
                <input type="checkbox" name="portofolio[{{ $i }}][tampilkan]" value="1" @checked((bool) ($row['tampilkan'] ?? true))>
                Tampilkan di CV
            </label>
        </div>
        <div>
            <label>Periode Mulai *</label>
            <input type="month" name="portofolio[{{ $i }}][periode_mulai]" value="{{ $row['periode_mulai'] ?? '' }}">
        </div>
        <div>
            <label>Periode Selesai</label>
            <input type="month" name="portofolio[{{ $i }}][periode_selesai]" value="{{ $row['periode_selesai'] ?? '' }}">
            <div class="bantuan">Kosongkan jika masih berlangsung.</div>
        </div>
        <div class="penuh">
            <label>Deskripsi</label>
            <textarea name="portofolio[{{ $i }}][deskripsi]" placeholder="Jelaskan tugas dan pencapaian Anda">{{ $row['deskripsi'] ?? '' }}</textarea>
        </div>
    </div>
</div>
