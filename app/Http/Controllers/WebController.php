<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Users;
use App\Models\Provinsi;
use App\Models\KotaKab;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\IRS;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\KHS;
use Illuminate\Support\Carbon;

class WebController extends Controller
{
    function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $users = Users::all();

        foreach ($users as $user) {
            if ($user->user == $email && $user->password == $password && $user->peran == "mahasiswa") {
                if ($user->mahasiswa->email != NULL) {
                    // Authentication successful
                    Session::put("email", $email);
                    Session::keep("email"); // Memastikan data sesi "email" tetap ada
                    return redirect("/dashboard/mahasiswa/{$user->NIM}");
                } else {
                    return redirect("/dashboard/mahasiswa/{$user->NIM}/updateAcc");
                }
            } else if ($user->user == $email && $user->password == $password && $user->peran == "dosen") {
                // Authentication successful
                Session::put("email", $email);
                Session::keep("email"); // Memastikan data sesi "email" tetap ada
                return redirect("/dashboard/dosen/{$user->NIP}");
            } else if ($user->user == $email && $user->password == $password && $user->peran == "operator") {
                // Authentication successful
                Session::put("email", $email);
                Session::keep("email"); // Memastikan data sesi "email" tetap ada
                return redirect("/dashboard/operator/{$user->NIP}");
            } else if ($user->user == $email && $user->password == $password && $user->peran == "departemen") {
                // Authentication successful
                Session::put("email", $email);
                Session::keep("email"); // Memastikan data sesi "email" tetap ada
                return redirect("/dashboard/departemen/{$user->ID_dep}");
            }
        }

        // Authentication failed
        return "Username atau password salah";
    }


    function masukMahasiswa($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $khs = KHS::all();

        if ($user) {
            return view("dashboard.mahasiswa")->with("user", $user)->with("khs", $khs);
        } else {
            return view('updateAcc')->with("user", $user); // You can change this message as needed
        }
    }

    function masukKaryawan($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();

        if ($user->peran == 'dosen') {
            return view("dashboard.dosen")->with("user", $user)->with("mahasiswa", $mahasiswa);
        } else if ($user->peran == 'operator') {
            return view("dashboard.operator")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function masukDepartemen()
    {
        $user = Users::where('peran', 'departemen')->first();
        return view("dashboard.departemen")->with("user", $user);
    }

    function profile($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $provinsi = Provinsi::all();
        $kota = KotaKab::all();

        if ($user) {
            return view("profile.mahasiswa")->with("user", $user)->with("provinsi", $provinsi)->with("kota", $kota);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function profileDos($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $provinsi = Provinsi::all();
        $kota = KotaKab::all();

        if ($user) {
            return view("profile.dosen")->with("user", $user)->with("provinsi", $provinsi)->with("kota", $kota);
        } else {
            return "User not found";
        }
    }

    function profileOperator($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $provinsi = Provinsi::all();
        $kota = KotaKab::all();

        if ($user) {
            return view("profile.operator")->with("user", $user)->with("provinsi", $provinsi)->with("kota", $kota);
        } else {
            return "User not found";
        }
    }

    function profileDep($ID_dep)
    {
        $user = Users::where('ID_dep', $ID_dep)->first();
        $provinsi = Provinsi::all();
        $kota = KotaKab::all();

        if ($user) {
            return view("profile.departemen")->with("user", $user)->with("provinsi", $provinsi)->with("kota", $kota);
        } else {
            return "User not found";
        }
    }

    function edit(Request $request, $nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $user->mahasiswa->nama = $request->input("nama");
        $user->mahasiswa->email = $request->input("email");
        $phone_number = $request->input("hp");
        $user->mahasiswa->no_HP = $phone_number;
        $user->mahasiswa->alamat = $request->input("alamat");
        $user->mahasiswa->jalur_masuk = $request->input("jalur_masuk");
        $user->mahasiswa->status = $request->input("status");
        $user->mahasiswa->kode_kota_kab = $request->input("kotakab");
        $user->mahasiswa->save(); // Use "->save()" to save the changes to the database

        return redirect()->back()->with("user", $user)->with('success', 'Profil berhasil diedit');
    }

    function editStudent(Request $request, $nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $phone_number = $request->input("hp");
        $user->mahasiswa->no_HP = $phone_number;
        $user->mahasiswa->save(); // Use "->save"

        return redirect()->back()->with("user", $user)->with('success', 'Profil berhasil diedit');
    }

    function register()
    {
        $prov = Provinsi::all();
        $kotaKabData = DB::table('kota_kab')
            ->join('provinsi', 'kota_kab.kode_prov', '=', 'provinsi.kode_prov')
            ->select('kota_kab.kode_kota_kab', 'kota_kab.nama_kota_kab', 'provinsi.kode_prov')
            ->get()
            ->groupBy('kode_prov')
            ->map(function ($kotaKab) {
                return $kotaKab->pluck('nama_kota_kab', 'kode_kota_kab');
            });
        return view('updateAcc')->with("prov", $prov)->with("kotaKabData", $kotaKabData);
    }

    function addMahasiswa(Request $request)
    {
        $doswal = Dosen::all();
        $randomDosen = $doswal->random();
        $mahasiswa = new Mahasiswa();
        $user = new Users();
        $randomNumber = str_pad(mt_rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);
        $mahasiswa->NIM = $randomNumber;
        $user->NIM = $randomNumber;
        $user->password = $request->input('password');
        $user->peran = "mahasiswa";
        $mahasiswa->nama = $request->input('nama');
        $mahasiswa->email = $request->input('email');
        $user->email = $request->input('email');
        $mahasiswa->kode_kota_kab = $request->input('kotakab');
        $mahasiswa->alamat = $request->input('alamat');
        $mahasiswa->no_HP = $request->input('noHP');
        $mahasiswa->jalur_masuk = $request->input('jalur_masuk');
        $mahasiswa->nama_doswal = $randomDosen->nama_doswal;
        $mahasiswa->persetujuan = "Belum Disetujui";
        $mahasiswa->status = "AKTIF";
        $mahasiswa->foto = "";
        $mahasiswa->save();
        $user->save();
        return redirect('/')->with('success', 'Data Mahasiswa Berhasil Diregister');
    }

    function akademik($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $irs = IRS::all();
        $khs = KHS::all();

        if ($user) {
            return view("academic")->with("user", $user)->with("irs", $irs)->with("khs", $khs);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function addIRS($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $khs = KHS::all();

        if ($user) {
            return view("entry.irs")->with("user", $user)->with("khs", $khs);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function validasi($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();
        $irs = IRS::all();
        $khs = KHS::all();
        $pkl = PKL::all();
        $skripsi = Skripsi::all();

        if ($user->peran == 'dosen') {
            return view("validation")->with("user", $user)->with("mahasiswa", $mahasiswa)->with("irs", $irs)->with("khs", $khs)->with("pkl", $pkl)->with("skripsi", $skripsi);
        } else if ($user->peran == 'operator') {
            return view("dashboard.operator")->with("user", $user);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function getMahasiswa($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();
        $dosen = Dosen::all();

        return view("operation.operation")->with("user", $user)->with("mahasiswa", $mahasiswa)->with("dosen", $dosen);
    }

    function detailMahasiswa($nip, $nim)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $khs = KHS::where('NIM', $nim);
        $irs = IRS::where('NIM', $nim);
        $pkl = PKL::where('NIM', $nim);
        $skripsi = Skripsi::where('NIM', $nim);
        $provinsi = Provinsi::all();
        $kota = KotaKab::all();

        return view("operation.details")->with("user", $user)->with("mahasiswa", $mahasiswa)->with("khs", $khs)->with("irs", $irs)->with("pkl", $pkl)->with("skripsi", $skripsi)->with("provinsi", $provinsi)->with("kota", $kota);
    }

    function addAccount()
    {
        $lectures = Dosen::all();
        $prov = Provinsi::all();
        $kotaKabData = DB::table('kota_kab')
            ->join('provinsi', 'kota_kab.kode_prov', '=', 'provinsi.kode_prov')
            ->select('kota_kab.kode_kota_kab', 'kota_kab.nama_kota_kab', 'provinsi.kode_prov')
            ->get()
            ->groupBy('kode_prov')
            ->map(function ($kotaKab) {
                return $kotaKab->pluck('nama_kota_kab', 'kode_kota_kab');
            });
        return view("operation.addAccount")->with('prov', $prov)->with('kotaKabData', $kotaKabData)->with('lectures', $lectures);
    }

    function confirmAddAccount(Request $request)
    {
        $user = new Users();
        $mahasiswa = new Mahasiswa();
        $mahasiswa->nama = $request->nama;
        $mahasiswa->NIM = $request->nim;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->status = $request->status;
        $mahasiswa->NIP = $request->doswal;
        $mahasiswa->save();

        $user->NIM = $mahasiswa->NIM;
        $user->peran = 'mahasiswa';
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        $user->password = $password;
        $nama = $request->nama;
        $nim = $request->nim;

        // Ambil first name dari nama
        $namaParts = explode(' ', $nama);
        $firstName = $namaParts[0];

        // Ambil 5 angka terakhir dari NIM
        $nimLast5 = substr($nim, -5);

        // Gabungkan first name dan 5 angka terakhir dari NIM
        $username = $firstName . $nimLast5;
        $user->user = $username;
        $user->save();

        return redirect()->back();
    }

    function updatePage($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $prov = Provinsi::all();
        $kotaKabData = DB::table('kota_kab')
            ->join('provinsi', 'kota_kab.kode_prov', '=', 'provinsi.kode_prov')
            ->select('kota_kab.kode_kota_kab', 'kota_kab.nama_kota_kab', 'provinsi.kode_prov')
            ->get()
            ->groupBy('kode_prov')
            ->map(function ($kotaKab) {
                return $kotaKab->pluck('nama_kota_kab', 'kode_kota_kab');
            });
        return view('updateAcc')->with("prov", $prov)->with("kotaKabData", $kotaKabData)->with("user", $user);
    }

    function updateAcc(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $user = Users::where('NIM', $nim)->first();
        $pkl = new PKL();
        $skripsi = new Skripsi();
        $username = $request->input('username');
        $mahasiswa->email = $username . '@students.undip.ac.id';
        $mahasiswa->alamat = $request->input('alamat');
        $mahasiswa->no_HP = $request->input('noHP');
        $mahasiswa->jalur_masuk = $request->input('jalur_masuk');
        $mahasiswa->kode_kota_kab = $request->input('kotakab');
        $user->password = $request->input('password');
        $user->user = $request->input('username');
        $pkl->NIM = $nim;
        $pkl->status_pkl = 'belum ambil';
        $skripsi->NIM = $nim;
        $skripsi->status_skripsi = 'belum ambil';
        $mahasiswa->save();
        $user->save();
        $pkl->save();
        $skripsi->save();
        return redirect("/dashboard/mahasiswa/{$user->NIM}");
    }

    public function confirmAddIRS(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $irs = new IRS();
        $irs->NIM = $nim;
        $irs->smst_aktif = $request->input('smst_aktif');
        $irs->jumlah_sks = $request->input('jumlah_sks');
        $irs->status = 0;

        $filename = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_irs', $filename);

            // Simpan path file dalam database
            $irs->berkas_irs = $filename;
        }

        $this->copyFileIRS($filename);

        if ($request->hasFile('file-pkl')) {
            $pkl = PKL::where('NIM', $nim)->first();
            $file = $request->file('file-pkl');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_pkl', $filename);

            // Simpan path file dalam database
            $pkl->status_pkl = 'sedang ambil';
            $pkl->berkas = $filename;
            $pkl->nilai_pkl = $request->input('nilai_pkl');
            $pkl->save();

            $this->copyFilePKL($filename);
        }

        if ($request->hasFile('file-skripsi')) {
            $skripsi = Skripsi::where('NIM', $nim)->first();
            $file = $request->file('file-skripsi');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_skripsi', $filename);

            // Simpan path file dalam database
            $skripsi->status_skripsi = 'sedang ambil';
            $skripsi->berkas_skripsi = $filename;
            $skripsi->nilai_skripsi = $request->input('nilai_skripsi');
            $skripsi->save();

            $this->copyFileSkripsi($filename);
        }


        $angkatan = substr($mahasiswa->angkatan, -2);
        $semester = $request->input('smst_aktif');
        $formattedSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);
        $last5nim = substr($nim, -4);
        $irs->id_irs = 'IRS' . $angkatan . $last5nim . $formattedSemester;
        $irs->save();



        return redirect("/dashboard/mahasiswa/{$mahasiswa->NIM}");
    }

    function validasiIRS($nip, $id_irs)
    {
        $irs = IRS::find($id_irs);
        $irs->status = 1;
        $irs->save();
        return redirect("/dashboard/dosen/{$nip}");
    }

    public function copyFileIRS($filename)
    {
        $sourcePath = storage_path('app/berkas_irs/' . $filename);
        $destinationPath = public_path('assets/berkas_irs/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function addKHS($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $khs = KHS::all();

        if ($user) {
            return view("entry.khs")->with("user", $user)->with("khs", $khs);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    public function confirmAddKHS(Request $request, $nim)
    {
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $smt_terakhir = $request->input('smst_aktif') - 1;
        if ($smt_terakhir == 0) {
            $smt_terakhir = 1;
        }
        if ($smt_terakhir == 1) {
            $sks_terakhir = 0;
            $ipk_terakhir = 0;
        } else {
            $sks_terakhir = KHS::where('NIM', $nim)->where('smt_aktif', $smt_terakhir)->first()->SKS_kumulatif;
            $ipk_terakhir = KHS::where('NIM', $nim)->where('smt_aktif', $smt_terakhir)->first()->IP_Kumulatif;
        }
        $khs = new KHS();
        $khs->NIM = $nim;
        $khs->smt_aktif = $request->input('smst_aktif');
        $khs->SKS_semester = $request->input('jumlah_sks');
        $khs->SKS_kumulatif = $sks_terakhir + $khs->SKS_semester;
        $khs->IP_smt = $request->input('ips');
        $khs->IP_Kumulatif = number_format(($ipk_terakhir + $khs->IP_smt) / 2, 2, '.', '');
        $khs->status = 0;

        $filename = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_khs', $filename);

            // Simpan path file dalam database
            $khs->berkas_khs = $filename;
        }

        $angkatan = substr($mahasiswa->angkatan, -2);
        $semester = $request->input('smst_aktif');
        $formattedSemester = str_pad($semester, 2, '0', STR_PAD_LEFT);
        $last5nim = substr($nim, -4);
        $khs->id_khs = 'KHS' . $angkatan . $last5nim . $formattedSemester;
        $khs->save();

        $this->copyFileKHS($filename);

        return redirect("/dashboard/mahasiswa/{$mahasiswa->NIM}");
    }

    public function copyFileKHS($filename)
    {
        $sourcePath = storage_path('app/berkas_khs/' . $filename);
        $destinationPath = public_path('assets/berkas_khs/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function addPKL($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $pkl = PKL::where('NIM', $nim)->first();

        if ($user) {
            return view("entry.pkl")->with("user", $user)->with("pkl", $pkl);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function confirmAddPKL(Request $request, $nim)
    {
        $pkl = PKL::where('NIM', $nim)->first();
        $pkl->status_pkl = 'sedang ambil';
        $pkl->nilai_pkl = $request->input('nilai_pkl');

        $filename = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_pkl', $filename);

            // Simpan path file dalam database
            $pkl->berkas = $filename;
        }
        $pkl->save();
        $this->copyFilePKL($filename);
        return redirect("/dashboard/mahasiswa/{$pkl->NIM}");
    }

    function editPKL(Request $request, $nim)
    {
        $pkl = PKL::where('NIM', $nim)->first();
        $pkl->nilai_pkl = $request->input('nilai_pkl');

        $filename = '';

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_pkl', $filename);

            // Simpan path file dalam database
            $pkl->berkas = $filename;
            $this->copyFilePKL($filename);
        }
        $pkl->save();
        return redirect("/dashboard/mahasiswa/{$pkl->NIM}");
    }

    function editSkripsi(Request $request, $nim){
        $skripsi = Skripsi::where('NIM', $nim)->first();
        $skripsi->nilai_skripsi = $request->input('nilai_skripsi');

        $filename = '';

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_skripsi', $filename);

            // Simpan path file dalam database
            $skripsi->berkas_skripsi = $filename;
            $this->copyFileSkripsi($filename);
        }

        $skripsi->save();
        return redirect("/dashboard/mahasiswa/{$skripsi->NIM}");
    }

    function tolakPKL($nip, $nim)
    {
        $pkl = PKL::where('NIM', $nim)->first();
        $pkl->status_pkl = 'SEGERA DIREVISI';
        $pkl->save();
        return redirect("/dashboard/dosen/{$nip}");
    }

    function tolakSkripsi($nip, $nim){
        $skripsi = Skripsi::where('NIM', $nim)->first();
        $skripsi->status_skripsi = 'SEGERA DIREVISI';
        $skripsi->save();
        return redirect("/dashboard/dosen/{$nip}");
    }

    public function copyFilePKL($filename)
    {
        $sourcePath = storage_path('app/berkas_pkl/' . $filename);
        $destinationPath = public_path('assets/berkas_pkl/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function addSkripsi($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $skripsi = Skripsi::where('NIM', $nim)->first();

        if ($user) {
            return view("entry.skripsi")->with("user", $user)->with("skripsi", $skripsi);
        } else {
            return "User not found"; // You can change this message as needed
        }
    }

    function confirmAddSkripsi(Request $request, $nim)
    {
        $skripsi = Skripsi::where('NIM', $nim)->first();
        $skripsi->status_skripsi = 'sedang ambil';
        $skripsi->nilai_skripsi = $request->input('nilai_skripsi');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); // Mengisi $filename dengan nama file yang diunggah

            // Simpan file sementara di direktori penyimpanan
            $file->storeAs('berkas_skripsi', $filename);

            // Simpan path file dalam database
            $skripsi->berkas_skripsi = $filename;
        }
        $skripsi->save();
        $this->copyFileSkripsi($filename);
        return redirect("/dashboard/mahasiswa/{$skripsi->NIM}");
    }

    function copyFileSkripsi($filename)
    {
        $sourcePath = storage_path('app/berkas_skripsi/' . $filename);
        $destinationPath = public_path('assets/berkas_skripsi/' . $filename);
        File::copy($sourcePath, $destinationPath);
    }

    function validasiKHS($nip, $id_khs)
    {
        $khs = KHS::find($id_khs);
        $khs->status = 1;
        $khs->save();
        return redirect("/dashboard/dosen/{$nip}");
    }


    function validasiPKL($nip, $nim)
    {
        $pkl = PKL::find($nim);
        $smt_terakhir = KHS::where('NIM', $nim)
            ->orderBy('smst_aktif', 'desc')
            ->first()
            ->smst_aktif;
        $pkl->status_pkl = 'lulus';
        $pkl->smt_lulus = $smt_terakhir;
        $pkl->save();
        return redirect("/dashboard/dosen/{$nip}");
    }

    function validasiSkripsi($nip, $nim)
    {
        $skripsi = Skripsi::find($nim);
        $smtr_terakhir = IRS::where('NIM', $nim)
            ->orderBy('smst_aktif', 'desc')
            ->first()
            ->smst_aktif;
        $skripsi->status_skripsi = 'lulus';
        $skripsi->smt_lulus = $smtr_terakhir;
        $skripsi->tanggal_sidang = Carbon::now();
        $skripsi->save();
        return redirect("/dashboard/dosen/{$nip}");
    }
    function progress($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();
        return view("progress")->with("user", $user)->with("mahasiswa", $mahasiswa);
    }

    function progressDep($ID_dep)
    {
        $user = Users::where('ID_dep', $ID_dep)->first();
        $mahasiswa = Mahasiswa::all();
        return view("progress.departemen")->with("user", $user)->with("mahasiswa", $mahasiswa);
    }

    function viewProgressMHS($nim)
    {
        $user = Users::where('NIM', $nim)->first();
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $pkl = PKL::where('NIM', $nim)->first();
        $skripsi = Skripsi::where('NIM', $nim)->first();
        $irs = IRS::all();
        $khseach = KHS::where('NIM', $nim);
        $khs = KHS::all();
        return view("progress.mahasiswa")->with("user", $user)->with("mahasiswa", $mahasiswa)->with("pkl", $pkl)->with("skripsi", $skripsi)->with("irs", $irs)->with("khs", $khs)->with("khseach", $khseach);
    }

    function progressMahasiswa($nip, $nim)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $pkl = PKL::where('NIM', $nim)->first();
        $skripsi = Skripsi::where('NIM', $nim)->first();
        $irs = IRS::all();
        $khs = KHS::all();
        return view("details.student")->with("user", $user)->with("mahasiswa", $mahasiswa)->with("pkl", $pkl)->with("skripsi", $skripsi)->with("irs", $irs)->with("khs", $khs);
    }

    function progressMHSDep($ID_dep, $nim)
    {
        $user = Users::where('ID_dep', $ID_dep)->first();
        $mahasiswa = Mahasiswa::where('NIM', $nim)->first();
        $pkl = PKL::where('NIM', $nim)->first();
        $skripsi = Skripsi::where('NIM', $nim)->first();
        $irs = IRS::all();
        $khs = KHS::all();
        return view("details.student")->with("user", $user)->with("mahasiswa", $mahasiswa)->with("pkl", $pkl)->with("skripsi", $skripsi)->with("irs", $irs)->with("khs", $khs);
    }

    function editIRS($nim, $id_irs)
    {
        $user = Users::where('NIM', $nim)->first();
        $irs = IRS::where('id_irs', $id_irs)->first();
        return view("edit.irs")->with("user", $user)->with("irs", $irs);
    }

    function confirmEditIRS($nim, $id_irs)
    {
        $irs = IRS::where('id_irs', $id_irs)->first();
        $irs->jumlah_sks = request('jumlah_sks');

        // Check if a file is provided
        if (request()->hasFile('file')) {
            $irs->berkas_irs = request('file');
        }

        $irs->save();

        return redirect("/dashboard/mahasiswa/{$nim}");
    }


    function editKHS($nim, $id_khs)
    {
        $user = Users::where('NIM', $nim)->first();
        $khs = KHS::where('id_khs', $id_khs)->first();
        return view("edit.khs")->with("user", $user)->with("khs", $khs);
    }

    function recapDosen($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();
        return view("recap.recapDos")->with("user", $user)->with("mahasiswa", $mahasiswa);
    }

    function recapOperator($nip)
    {
        $user = Users::where('NIP', $nip)->first();
        $mahasiswa = Mahasiswa::all();
        return view("recap")->with("user", $user)->with("mahasiswa", $mahasiswa);
    }

    function recapDepartemen()
    {
        $user = Users::where("peran", 'departemen')->first();
        $mahasiswa = Mahasiswa::all();
        return view("recap")->with("user", $user)->with("mahasiswa", $mahasiswa);
    }

    function listRecapDepartemen($ID_dep, $angkatan, $jenis, $status)
    {
        if (Users::where("peran", 'departemen')) {
        }
        $user = Users::where("ID_dep", $ID_dep)->first();
        $mahasiswa = Mahasiswa::all();
        return view('list.recap')->with('user', $user)->with('mahasiswa', $mahasiswa)->with('angkatan', $angkatan)->with('status', $status)->with('jenis', $jenis);
    }

    function listRecapSkripsiDep($ID_dep, $angkatan, $jenis, $status){
        $user = Users::where("ID_dep", $ID_dep)->first();
        $mahasiswa = Mahasiswa::all();
        return view('list.recapSkripsi')->with('user', $user)->with('mahasiswa', $mahasiswa)->with('angkatan', $angkatan)->with('status', $status)->with('jenis', $jenis);
    }

    function listStatus($ID_dep, $angkatan, $status)
    {
        $user = Users::where("ID_dep", $ID_dep)->first();
        $mahasiswa = Mahasiswa::all();
        return view('list.status')->with('user', $user)->with('mahasiswa', $mahasiswa)->with('angkatan', $angkatan)->with('status', $status);
    }

    public function search(Request $request, $nip)
    {
        $keywords = $request->input('keywords');

        // Perform a search query
        $results = Mahasiswa::where('nama', 'like', '%' . $keywords . '%')
            ->where('NIP', $nip) // Assuming you have authentication
            ->get();

        return response()->json($results);
    }
}
