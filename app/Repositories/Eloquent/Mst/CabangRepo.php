<?php 

namespace App\Repositories\Eloquent\Mst;

use App\Models\Mst\Cabang as Model;
use App\Repositories\Contracts\Mst\CabangRepoInterface;
use App\Repositories\Eloquent\defaultRepoTrait;
use App\Repositories\Eloquent\dropdownableRepoTrait;

class CabangRepo implements CabangRepoInterface {

	// CRUD default
	use defaultRepoTrait, dropdownableRepoTrait;


	protected $model;

	public function __construct(Model $model){
		$this->model = $model;
	}






}