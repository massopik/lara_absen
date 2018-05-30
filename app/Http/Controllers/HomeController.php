<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Absen;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function zona_waktu($lokasi){
		return date_default_timezone_set($lokasi);
	}
    public function index()
    {
        $this->zona_waktu('Asia/Jakarta');
    	$user_id 		= Auth::user()->id;			 //ambil id dari user yg sedang login
    	$tanggal 		= date('Y-m-d');				// 2018-12-30
    	$list_absen = Absen::where('user_id', $user_id)->orderBy('jam_masuk','DESC')->paginate(10);
    	$cek_absen 	= Absen::where(['user_id' => $user_id, 'tanggal' => $tanggal])->get()->first();
    	if (is_null($cek_absen)) {
    		$info = [
    			'status' 	=> 'anda belum mengisi absen hari ini',
    			'btnIn'		=> '',
    			'btnOut'	=> 'disabled',
    		];
    	}elseif($cek_absen->jam_keluar == NULL){
    		$info = [
    			'status' 	=> 'Jangan lupa mengisi absen keluar',
    			'btnIn'		=> 'disabled',
    			'btnOut'	=> '',
    		];
    	}else{
    		$info = [
    			'status' 	=> 'Absen hari ini telah selesai',
    			'btnIn'		=> 'disabled',
    			'btnOut'	=> 'disabled',
    		];
    	}
    	$data = ['list_absen' => $list_absen, 'info' => $info];
      return view('home',$data);
    }

    public function store(Request $request){
        // return $request->all();
        $this->zona_waktu('Asia/Jakarta');
    	$user_id 		= Auth::user()->id;		//ambil id dari user yg sedang login
    	$tanggal 		= date('Y-m-d');		// 2018-12-30
    	$jam 				= date('H:i:s');	// 18.00:00:00
    	$keterangan = $request->keterangan;	    // inputan dari form input name=keterangan

    	$absen = NEW Absen; //mendefinisikan $absen dengan memanggil model Absen
    	//buat kondisi
  		//jika user menekan tombol name=btnIn
    	if (isset($request->btnIn)) 
    	{
    		
    		//buat proses insert ke database
    		$absen->create([
    			'user_id'	 => $user_id,
    			'tanggal'	 => $tanggal,
    			'jam_masuk'	 => $jam,
    			'jam_keluar' => NULL,
    			'keterangan' => $keterangan
    		]);
    		return redirect()->back()->with(['success' => 'Terimakasih! Anda Sudah Mengisi Absen Masuk Hari ini']);
    		// return redirect('/absen')->with(['success' => 'Terimakasih! Anda Sudah Mengisi Absen Masuk Hari ini']);
    	}
    	//jika user menekan tombol name=btnOut
    	elseif (isset($request->btnOut)) {
    		
    		$absen->where(['tanggal' => $tanggal, 'user_id' => $user_id])
    		->update([
    			'jam_keluar'	=> $jam,
    			'keterangan'=> $keterangan
    		]);
    		return redirect()->back()->with(['success' => 'Terimakasih! Anda Sudah Mengisi Absen Keluar Hari ini']);
    	}

    	//cara melihat data
    	// dd($request->all());
        // return $request->all();
    }
}
