<li class="pc-item pc-caption">
    <label data-i18n="Halaman Utama">Halaman Utama </label>
    <i class="ph-duotone ph-gauge"></i>
</li>
<li class="pc-item">
    <a href="/" class="pc-link">
        <span class="pc-micon">
            <i class="ph-duotone ph-gauge"></i>
        </span>
        <span class="pc-mtext" data-i18n="Home">Home</span>
    </a>
</li>
<li class="pc-item pc-caption">
    <label data-i18n="Menu">Menu</label>
    <i class="ph-duotone ph-gauge"></i>
</li>

<li class="pc-item pc-hasmenu">
    <a href="#!" class="pc-link"><span class="pc-micon"> <i class="ph-duotone ph-layout"></i></span><span
            class="pc-mtext" data-i18n="PICS Pegawai Baru">PICS Pegawai Baru</span><span class="pc-arrow"><i
                data-feather="chevron-right"></i></span></a>
    <ul class="pc-submenu">
        @if (auth()->user()->role == 1 || auth()->user()->role == 2)
            <li class="pc-item"><a class="pc-link" href="/candidate/store" data-i18n="Tambah Kandidat">Tambah
                    Kandidat</a></li>
            <li class="pc-item"><a class="pc-link" href="/candidate/takephoto" data-i18n="Ambil Foto">Ambil Foto</a>
            </li>
        @endif
        @if (auth()->user()->role == 1 || auth()->user()->role == 3)
            <li class="pc-item"><a class="pc-link" href="/candidate/addNIK" data-i18n="Tambah NIK + Cetak">Tambah
                    NIK + Cetak</a></li>
        @endif
    </ul>
</li>


@if (auth()->user()->role == 1 || auth()->user()->role == 3)
    <li class="pc-item pc-hasmenu">
        <a href="#!" class="pc-link"><span class="pc-micon"> <i class="ph-duotone ph-layout"></i></span><span
                class="pc-mtext" data-i18n="PICS Cetak Ulang">PICS Cetak Ulang</span><span class="pc-arrow"><i
                    data-feather="chevron-right"></i></span></a>
        <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="/reprint" data-i18n="Cetak Ulang">Cetak
                    Ulang</a>
            </li>
        </ul>
    </li>
@endif

@if (auth()->user()->role == 1)
    <li class="pc-item pc-caption">
        <label data-i18n="Settings">Settings</label>
        <i class="ph-duotone ph-gauge"></i>
    </li>
    <li class="pc-item">
        <a href="/candidate/idcard" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-gauge"></i>
            </span>
            <span class="pc-mtext" data-i18n="Template ID Card">Template ID Card</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="/users" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-users"></i>
            </span>
            <span class="pc-mtext" data-i18n="Users">Users</span>
        </a>
    </li>
    <li class="pc-item">
        <a href="/print-history" class="pc-link">
            <span class="pc-micon">
                <i class="ph-duotone ph-files"></i>
            </span>
            <span class="pc-mtext" data-i18n="Riwayat Cetak">Riwayat Cetak</span>
        </a>
    </li>
@endif
