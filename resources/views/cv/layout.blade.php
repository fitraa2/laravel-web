<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul') – CV Builder</title>
    <style>
        :root { --ink:#111; --muted:#6b7280; --line:#e5e7eb; --bg:#f3f4f6; --aksen:#111827; --bahaya:#b91c1c; }
        * { box-sizing: border-box; }
        body { margin:0; background:var(--bg); color:var(--ink); font-family: Arial, Helvetica, sans-serif; line-height:1.5; }
        .wadah { max-width: 920px; margin: 0 auto; padding: 24px 16px 64px; }
        .bar { display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:20px; }
        .bar h1 { margin:0; font-size:24px; }
        .kartu { background:#fff; border:1px solid var(--line); border-radius:10px; padding:20px; margin-bottom:18px; }
        .kartu h2 { margin:0 0 14px; font-size:17px; }
        .kisi { display:grid; grid-template-columns: repeat(2, 1fr); gap:14px; }
        .kisi .penuh { grid-column: 1 / -1; }
        label { display:block; font-size:13px; font-weight:bold; margin-bottom:4px; }
        input[type=text], input[type=email], input[type=month], input[type=file], select, textarea {
            width:100%; padding:9px 10px; border:1px solid #cbd5e1; border-radius:6px; font:inherit; background:#fff;
        }
        textarea { min-height: 90px; resize: vertical; }
        .cek { display:flex; align-items:center; gap:8px; font-weight:normal; font-size:14px; }
        .cek input { width:auto; }
        .btn { display:inline-block; padding:9px 16px; border-radius:6px; border:1px solid var(--aksen); background:var(--aksen); color:#fff; font:inherit; font-size:14px; cursor:pointer; text-decoration:none; }
        .btn.garis { background:#fff; color:var(--aksen); }
        .btn.bahaya { background:#fff; color:var(--bahaya); border-color:var(--bahaya); }
        .btn.kecil { padding:5px 10px; font-size:12px; }
        .baris { border:1px dashed #cbd5e1; border-radius:8px; padding:14px; margin-bottom:12px; background:#fafafa; }
        .baris .atas { display:flex; justify-content:flex-end; margin-bottom:6px; }
        .bantuan { font-size:12px; color:var(--muted); margin-top:4px; }
        .galat { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:8px; padding:12px 16px; margin-bottom:18px; font-size:14px; }
        .galat ul { margin:6px 0 0; padding-left:18px; }
        .sukses { background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; border-radius:8px; padding:12px 16px; margin-bottom:18px; font-size:14px; }
        table { width:100%; border-collapse:collapse; font-size:14px; }
        th, td { text-align:left; padding:10px 8px; border-bottom:1px solid var(--line); }
        th { font-size:12px; text-transform:uppercase; color:var(--muted); }
        .aksi { display:flex; gap:6px; flex-wrap:wrap; }
        .aksi form { margin:0; }
        .pratinjau { width:96px; height:128px; object-fit:cover; border-radius:6px; border:1px solid var(--line); display:block; margin-bottom:8px; }
        @media (max-width:640px){ .kisi { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="wadah">
    @if (session('sukses'))
        <div class="sukses">{{ session('sukses') }}</div>
    @endif
    @yield('isi')
</div>
@stack('skrip')
</body>
</html>
