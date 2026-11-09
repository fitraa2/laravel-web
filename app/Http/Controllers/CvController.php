<?php

namespace App\Http\Controllers;

use App\Models\Biodata1104;
use App\Models\KategoriPortofolio1104;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CvController extends Controller
{
    /** Daftar CV yang sudah tersimpan */
    public function index()
    {
        $daftarCv = Biodata1104::withCount('portofolio')->latest()->get();

        return view('cv.index', compact('daftarCv'));
    }

    /** Halaman form isi biodata (halaman "cv") */
    public function create()
    {
        return view('cv.form', [
            'biodata'  => new Biodata1104(['tampilkan_foto' => true]),
            'kategori' => KategoriPortofolio1104::orderBy('nama_kategori')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data    = $this->validasi($request);
        $biodata = new Biodata1104();

        $this->simpan($request, $data, $biodata);

        return redirect()->route('cv.show', $biodata)->with('sukses', 'CV berhasil dibuat.');
    }

    /** Output akhir: CV siap cetak, isinya dari database */
    public function show(Request $request, Biodata1104 $biodata)
    {
        $biodata->load(['pendidikan', 'portofolio.kategori', 'kemampuan']);

        // ?foto=1 / ?foto=0 menimpa pilihan yang tersimpan (include / exclude gambar)
        $tampilkanFoto = $request->has('foto')
            ? $request->boolean('foto')
            : $biodata->tampilkan_foto;

        return view('cv.output', [
            'biodata'       => $biodata,
            'tampilkanFoto' => $tampilkanFoto && $biodata->foto,
            'portofolio'    => $biodata->portofolio->where('tampilkan', true),
            'teknis'        => $biodata->kemampuan->where('jenis', 'teknis'),
            'nonTeknis'     => $biodata->kemampuan->where('jenis', 'non_teknis'),
        ]);
    }

    public function edit(Biodata1104 $biodata)
    {
        $biodata->load(['pendidikan', 'portofolio', 'kemampuan']);

        return view('cv.form', [
            'biodata'  => $biodata,
            'kategori' => KategoriPortofolio1104::orderBy('nama_kategori')->get(),
        ]);
    }

    public function update(Request $request, Biodata1104 $biodata): RedirectResponse
    {
        $data = $this->validasi($request);

        $this->simpan($request, $data, $biodata);

        return redirect()->route('cv.show', $biodata)->with('sukses', 'CV berhasil diperbarui.');
    }

    public function destroy(Biodata1104 $biodata): RedirectResponse
    {
        if ($biodata->foto) {
            File::delete(public_path('uploads/cv/' . $biodata->foto));
        }
        $biodata->delete(); // data anak ikut terhapus (cascade)

        return redirect()->route('cv.index')->with('sukses', 'CV berhasil dihapus.');
    }

    // ------------------------------------------------------------------

    private function validasi(Request $request): array
    {
        // Buang baris dinamis yang dibiarkan kosong
        $request->merge([
            'pendidikan' => $this->bersihkanBaris($request->input('pendidikan', []), 'institusi'),
            'portofolio' => $this->bersihkanBaris($request->input('portofolio', []), 'judul'),
        ]);

        return $request->validate([
            'nama_lengkap'         => 'required|string|max:100',
            'posisi'               => 'nullable|string|max:100',
            'email'                => 'required|email|max:100',
            'telepon'              => 'required|string|max:30',
            'alamat'               => 'required|string|max:255',
            'tentang_saya'         => 'required|string',
            'kemampuan_teknis'     => 'nullable|string',
            'kemampuan_non_teknis' => 'nullable|string',
            'foto'                 => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tampilkan_foto'       => 'nullable|boolean',

            'pendidikan'                 => 'nullable|array',
            'pendidikan.*.institusi'     => 'required|string|max:150',
            'pendidikan.*.jurusan'       => 'nullable|string|max:150',
            'pendidikan.*.tahun_mulai'   => 'required|digits:4',
            'pendidikan.*.tahun_selesai' => 'nullable|digits:4',

            'portofolio'                   => 'nullable|array',
            'portofolio.*.kategori_id'     => 'nullable|exists:kategori_portofolio_1104,id',
            'portofolio.*.judul'           => 'required|string|max:150',
            'portofolio.*.instansi'        => 'nullable|string|max:150',
            'portofolio.*.periode_mulai'   => 'required|date_format:Y-m',
            'portofolio.*.periode_selesai' => 'nullable|date_format:Y-m',
            'portofolio.*.deskripsi'       => 'nullable|string',
            'portofolio.*.tampilkan'       => 'nullable|boolean',
        ], [], [
            'nama_lengkap'                 => 'nama lengkap',
            'tentang_saya'                 => 'tentang saya',
            'pendidikan.*.institusi'       => 'institusi pendidikan',
            'pendidikan.*.tahun_mulai'     => 'tahun mulai pendidikan',
            'pendidikan.*.tahun_selesai'   => 'tahun selesai pendidikan',
            'portofolio.*.judul'           => 'judul portofolio',
            'portofolio.*.periode_mulai'   => 'periode mulai portofolio',
            'portofolio.*.periode_selesai' => 'periode selesai portofolio',
        ]);
    }

    private function bersihkanBaris($baris, string $kunciWajib): array
    {
        return collect($baris)
            ->filter(fn ($b) => is_array($b) && filled($b[$kunciWajib] ?? null))
            ->values()
            ->all();
    }

    private function simpan(Request $request, array $data, Biodata1104 $biodata): void
    {
        $foto = $this->simpanFoto($request, $biodata->foto);

        DB::transaction(function () use ($request, $data, $biodata, $foto) {
            $biodata->fill([
                'nama_lengkap'   => $data['nama_lengkap'],
                'posisi'         => $data['posisi'] ?? null,
                'email'          => $data['email'],
                'telepon'        => $data['telepon'],
                'alamat'         => $data['alamat'],
                'tentang_saya'   => $data['tentang_saya'],
                'foto'           => $foto,
                'tampilkan_foto' => $request->boolean('tampilkan_foto'),
            ])->save();

            // Data anak ditulis ulang agar form edit tinggal "simpan"
            $biodata->pendidikan()->delete();
            $biodata->portofolio()->delete();
            $biodata->kemampuan()->delete();

            foreach ($data['pendidikan'] ?? [] as $p) {
                $biodata->pendidikan()->create([
                    'institusi'     => $p['institusi'],
                    'jurusan'       => $p['jurusan'] ?? null,
                    'tahun_mulai'   => $p['tahun_mulai'],
                    'tahun_selesai' => $p['tahun_selesai'] ?? null,
                ]);
            }

            foreach ($data['portofolio'] ?? [] as $p) {
                $biodata->portofolio()->create([
                    'kategori_id'     => $p['kategori_id'] ?? null,
                    'judul'           => $p['judul'],
                    'instansi'        => $p['instansi'] ?? null,
                    'periode_mulai'   => $p['periode_mulai'] . '-01',
                    'periode_selesai' => filled($p['periode_selesai'] ?? null) ? $p['periode_selesai'] . '-01' : null,
                    'deskripsi'       => $p['deskripsi'] ?? null,
                    'tampilkan'       => (bool) ($p['tampilkan'] ?? true),
                ]);
            }

            foreach ($this->pecahBaris($data['kemampuan_teknis'] ?? '') as $nama) {
                $biodata->kemampuan()->create(['nama_kemampuan' => $nama, 'jenis' => 'teknis']);
            }
            foreach ($this->pecahBaris($data['kemampuan_non_teknis'] ?? '') as $nama) {
                $biodata->kemampuan()->create(['nama_kemampuan' => $nama, 'jenis' => 'non_teknis']);
            }
        });
    }

    private function simpanFoto(Request $request, ?string $fotoLama): ?string
    {
        if (! $request->hasFile('foto')) {
            return $fotoLama;
        }

        $folder = public_path('uploads/cv');
        File::ensureDirectoryExists($folder);

        $berkas = $request->file('foto');
        $nama   = Str::uuid() . '.' . $berkas->extension();
        $berkas->move($folder, $nama);

        if ($fotoLama) {
            File::delete($folder . '/' . $fotoLama);
        }

        return $nama;
    }

    /** Satu baris textarea = satu item kemampuan */
    private function pecahBaris(?string $teks): array
    {
        return collect(preg_split('/\R/', (string) $teks))
            ->map(fn ($t) => trim(preg_replace('/^\s*[-*•]\s*/u', '', $t)))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
