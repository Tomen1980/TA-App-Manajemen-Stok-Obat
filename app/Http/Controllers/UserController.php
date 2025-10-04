<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;
use App\Services\UserService;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;



class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //
    public function index(){
        $users = $this->userService->getAllUsers();
        return view('users.index', compact('users'));
    }

    public function create(Request $request){
        return view("users.create");
    }

    public function store(Request $request)
{
    try {
        // Hanya validasi
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        
        // Ambil password plain text
        $plainPassword = $request->input('password'); 

        // ✅ HANYA BUAT USER SATU KALI DENGAN SEMUA LOGIKA YANG BENAR
        $user = User::create([
            'name' => $data['name'], // Gunakan data yang sudah divalidasi
            'email' => $data['email'], // Gunakan data yang sudah divalidasi
            
            // 🔒 Simpan versi HASH
            'password' => Hash::make($plainPassword), 
            
            // ✅ Simpan versi PLAIN TEXT
            'temporary_password' => $plainPassword, 
        ]);

        // Opsional: Anda bisa memanggil service jika itu melakukan tugas tambahan
        // $this->userService->logCreation($user); 

        return redirect("/manager/users/create")->with('success', 'User created successfully. User ID: ' . $user->id);
        
    } catch (Exception $e) {
        return redirect("/manager/users/create")->with('error', 'Gagal membuat user: ' . $e->getMessage());
    }
}



    public function destroy($id){
        try{
            $this->userService->deleteUser($id);
            return redirect("/manager/users")->with('success', 'User deleted successfully.');
        }catch(Exception $e){
            return redirect("/manager/users")->with('error', $e->getMessage());
        }
    }
    public function edit($id)
{
    $user = $this->userService->getUserbyId($id);
    return view("users.update", compact('user'));
}

    
    public function update($id, Request $request){
        try{
            $data =  $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            $this->userService->updateUser($id, $data);
            return redirect("/manager/users")->with('success', 'User updated successfully.');
        }catch(Exception $e){
            return redirect("/manager/users")->with('error', $e->getMessage());
        }
    }

    public function sendPasswordEmail(Request $request, $id) // Atau sendWelcomeEmail
   {
       try {
           $user = User::findOrFail($id);
           
           Log::info('Mulai kirim email ke user ID: ' . $id . ', email: ' . $user->email); // Log awal
           
           if (!$user->temporary_password) {
               throw new Exception('Password sementara tidak tersedia.');
           }
           
           // Buat mailable instance dulu untuk test
           $mailable = new Email($user, $user->temporary_password);
           Log::info('Mailable dibuat: ' . get_class($mailable)); // Cek mailable OK
           
           // Kirim email
           Mail::to($user->email)->send($mailable);
           
           Log::info('Email berhasil dikirim ke: ' . $user->email); // Log sukses
           
           $user->temporary_password = null;
           $user->save();
           
           return back()->with('success', 'Email password berhasil dikirim ke ' . $user->email);
           
       } catch (Exception $e) {
           Log::error('Gagal kirim email: ' . $e->getMessage(), [
               'user_id' => $id,
               'trace' => $e->getTraceAsString()
           ]);
           return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
       }
   }

// public function sendPasswordEmail(Request $request, $id)
// {
//     try {
//         $user = User::findOrFail($id);
        
//         Log::info('Mulai kirim email ke user ID: ' . $id . ', email: ' . $user->email);

//         // 🚨 KOREKSI: Selalu buat password sementara baru saat fungsi ini dipanggil
//         $newPassword = Str::random(10); // Membuat string acak 10 karakter
//         $user->temporary_password = $newPassword; 
        
//         // Simpan password ke database agar data Mailable bisa membacanya.
//         // Anda juga harus MENG-HASH password ini jika user akan login menggunakan temporary_password ini.
//         // Jika password ini hanya untuk dikirim via email dan user akan menggantinya, tidak perlu di hash saat ini.
//         $user->save(); 
        
//         // Verifikasi keberadaan password (walaupun sudah dibuat, cek ini untuk kepastian)
//         if (!$user->temporary_password) {
//              throw new Exception('Gagal menyimpan password baru.');
//         }
        
//         // Buat mailable instance menggunakan password yang BARU DIBUAT
//         $mailable = new Email($user, $user->temporary_password);
//         Log::info('Mailable dibuat: ' . get_class($mailable));
        
//         // Kirim email
//         Mail::to($user->email)->send($mailable);
        
//         Log::info('Email berhasil dikirim ke: ' . $user->email);
        
//         // ⚠️ HAPUS password setelah berhasil dikirim
//         $user->temporary_password = null;
//         $user->save();
        
//         return back()->with('success', 'Email password berhasil dikirim ke ' . $user->email);
        
//     } catch (Exception $e) {
//         Log::error('Gagal kirim email: ' . $e->getMessage(), [
//             'user_id' => $id,
//             'trace' => $e->getTraceAsString()
//         ]);
//         return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
//     }
// }

//     public function sendPasswordEmail(Request $request, $id)
// {
//     try {
//         $user = User::findOrFail($id);
        
//         Log::info('Mulai kirim email ke user ID: ' . $id . ', email: ' . $user->email);
        
//         // ✅ Cek apakah password plain text yang dibuat ada
//         if (!$user->temporary_password) {
//             // Jika kosong, ini berarti password sudah terkirim sebelumnya atau belum pernah dibuat.
//             // Anda harus menginstruksikan admin untuk meregenerasi (jika ini disengaja)
//             throw new Exception('Password sementara tidak tersedia di database. Mungkin sudah pernah dikirim.');
//         }
        
//         // Dapatkan password yang sudah tersimpan
//         $passwordToSend = $user->temporary_password;

//         // Buat mailable instance menggunakan PLAIN TEXT password yang diambil dari DB
//         $mailable = new Email($user, $passwordToSend);
//         Log::info('Mailable dibuat: ' . get_class($mailable));
        
//         // Kirim email
//         Mail::to($user->email)->send($mailable);
        
//         Log::info('Email berhasil dikirim ke: ' . $user->email);
        
//         // ⚠️ Hapus password setelah berhasil dikirim untuk keamanan
//         $user->temporary_password = null;
//         $user->save();
        
//         return back()->with('success', 'Email password berhasil dikirim ke ' . $user->email);
        
//     } catch (Exception $e) {
//         // ... (Log error)
//         return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
//     }
// }

}
