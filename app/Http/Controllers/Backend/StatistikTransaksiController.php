<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Contracts\Mst\CabangRepoInterface;
use App\Repositories\Contracts\Mst\PengeluaranRepoInterface;
use App\Repositories\Contracts\Mst\PenjualanRepoInterface;
use App\Repositories\Contracts\Mst\TransaksiRepoInterface;
use Illuminate\Http\Request;

class StatistikTransaksiController extends Controller
{
    private $base_view = 'konten.backend.statistik_transaksi.';
    protected $transaksi;
    protected $cabang;
    protected $penjualan;
    protected $pengeluaran;

    public function __construct(TransaksiRepoInterface $transaksi, 
    							CabangRepoInterface $cabang,
    							PenjualanRepoInterface $penjualan,
                                PengeluaranRepoInterface $pengeluaran
    						){
        $this->pengeluaran = $pengeluaran;
    	$this->penjualan = $penjualan;
    	$this->cabang = $cabang;
    	$this->transaksi = $transaksi;
        view()->share('backend_statistik', true);
    	view()->share('base_view', $this->base_view);
    	view()->share('backend_statistik_transaksi', true);
    }

    /**
     * menampilkan halaman statistik transaksi beserta filter by tahun+bulan
     * @param  Request $request 
     * @return view           
     */
    public function index(Request $request)
    {	
    	$cabang = $this->cabang->getAllDropdown('cabang');
        $cabang = array_add($cabang, 'all', 'semua cabang');
    	$r_c = $request->get('mst_cabang_id');
    	$r_b = $request->get('bln');
    	$r_t = $request->get('thn');
    	if($r_c != null && $r_b != null && $r_t != null){
            $pengeluaran = $this->pengeluaran->getJmlPengeluaranBulanan($r_c, $r_b, $r_t);
            $transaksi_tunai = $this->transaksi->getNominalTransaksiHarian($r_c, $r_b, $r_t);
   			$transaksi = $this->transaksi->getJmlTransaksiPerBln($r_c, $r_b, $r_t);
   			$nominal_transaksi = $this->transaksi->getNominalTransaksiBulanan($r_c, $r_b, $r_t);
   			$nominal_harga_beli = $this->penjualan->getNominalHargaJualBulanan($r_c, $r_b, $r_t);
    		$vars = compact(
                    'transaksi', 'cabang', 'nominal_transaksi', 
                    'nominal_harga_beli', 'transaksi_tunai',
                    'pengeluaran'
                );
    	}else{
	    	$vars = compact('cabang');    		
    	}

    	return view($this->base_view.'index', $vars);
    }


}