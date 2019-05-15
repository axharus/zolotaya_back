<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class Product extends BaseModel {
	protected $table = 'product';
	protected $fillable = [
		'name_ru',
		'name_ua',
		'section',
		'insection',
		'cat',
		'price',
		'bprice',
		'color',
		'gallery_color',
		'size',
		'gallery',
		'gallery_hover',
		'data_ru',
		'data_ua',
		'vendor',
		'related',
		'to_buy',
		'keywords',
		'description',
		'stock'
	];
	public $choosen = ['size', 'color', 'insection', 'related', 'to_buy'];
	protected $casts = [
		'size'      => 'array',
		'color'     => 'array',
		'insection' => 'array',
		'related'   => 'array',
		'to_buy'    => 'array',
	];
	protected $dateFormat = 'U';

	public static function getSingle($id, $with, $select = ['*']) {
		try {
			return self::where('id', $id)->select($select)->with($with)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}
	}

	public static function updateRecord($id, $input) {
		if (isset($input['bprice']) && $input['bprice'] == '') {
			unset($input['bprice']);
		}
		try {
			if (isset($input['section'])) {
				$input['section'] = intval($input['section']);
			}
			if (isset($input['cat'])) {
				$input['cat'] = intval($input['cat']);
			}
			if ( ! $id) {
				$input          = self::fFilter($input);
				$input['color'] = json_decode($input['color']);
				$input['size']  = json_decode($input['size']);
				self::create($input);
			} else {
				self::where('id', $id)->update(self::fFilter($input));
			}
		} catch (\Exception $e) {
			dd($e);

			return $e;
		}
	}

	public static function catalogSearch($filter, $select = ['*']) {
		$query = self::query();
		//dd($filter);
		Paginator::currentPageResolver(function() use ($filter) {
			return $filter['page'];
		});

		if (isset($filter['liked'])) {
			$query = $query->whereIn('id', $filter['liked']);
		}

		if (isset($filter['catalog'])) {
			$query = self::filterCatalog($filter['catalog'], $query);
		}

		if (isset($filter['color'])) {
			$query = $query->where('color', 'LIKE', '%'.$filter['color'].'%');
		}

		if (isset($filter['size'])) {
			$query = $query->where('size', 'LIKE', '%'.$filter['size'].'%');
		}

		if (isset($filter['minCost'])) {
			$query = $query->where('price', '>', \H::revert_price(intval($filter['minCost'])));
		}

		if (isset($filter['maxCost'])) {
			$query = $query->where('price', '<', \H::revert_price(intval($filter['maxCost'])));
		}

		if (isset($filter['search'])) {
			$query = self::filterSearch($query, $filter['search']);
		}

		if (isset($filter['search_cat']) && $filter['search_cat'] != "0") {
			$query = $query->where('cat', $filter['search_cat']);
		}

		if (isset($filter['search_query'])) {
			//dd($filter);
			$query = self::filterSearch($query, $filter['search_query']);
		}

		$query = $query->select($select)->with(['stars']);

		$query->orderBy('stock', 'desc');

		if (isset($filter['sort'])) {
			$query = self::filterOrder($query, $filter['sort']);
		}

		return $query->paginate(24);
	}

	public static function filterOrder($query, $type) {
		switch ($type) {
			case 1:
				return $query->withCount('order_likes')->orderBy('order_likes_count', 'desc');
			case 3:
				return $query->orderBy('price');
			case 4:
				return $query->orderBy('price', 'desc');
			case 2:
				return $query->orderBy('created_at', 'desc');
		}
	}

	public static function filterSearch($query, $search) {
		$s = explode(' ', $search);

		return $query->where(function($query) use ($s) {
			foreach ($s as $item) {
				$item = '%'.$item.'%';
				$query->where(function($query) use ($item) {
					$query->where('name_ua', 'LIKE', $item);
					$query->orWhere('name_ru', 'LIKE', $item);
				});

			}
		});

	}

	public static function filterCatalog($filter, $query) {
		$fc = count($filter);
		if ($fc > 0) {
			$query = $query->where(function($query) use ($filter, $fc) {
				$query->where([
					['section', $filter[ $fc - 1 ][0]],
					['cat', $filter[ $fc - 1 ][1]]
				]);
				for ($i = $fc - 1; $i --;) {
					$query = $query->orWhere([
						['section', $filter[ $i ][0]],
						['cat', $filter[ $i ][1]]
					]);
				}
			});
		}

		return $query;
	}

	public static function getInArray($array, $select = ['*'], $with = [], $offset = 0, $limit = 0) {
		$query = self::whereIn('id', $array)->select($select)->with($with);
		if ($offset) {
			$query->offset($offset);
		}
		if ($limit) {
			$query->limit($limit);
		}

		return $query->get();
	}

	public static function getInSection($section, $select = ['*'], $with = [], $offset = 0, $limit = 0) {

		$query = self::where(function($query) use ($section) {
			$query->where('insection', "LIKE", '%"'.$section.'"%');
			if ($section == 1) {
				$query->orWhere('created_at', '>=', Carbon::now()->timestamp - 2592000);
			}
		})
		             ->select($select)
		             ->with($with)
		             ->offset($offset);
		if ($limit) {
			$query->limit($limit);
		}

		return $query->get();
	}


	public static function prices() {
		return [
			self::orderBy('price')->select('price')->first()->price,
			self::orderBy('price', 'desc')->select('price')->first()->price,
		];
	}

	public static function orderStock($id, $count) {
		$data        = self::where('id', $id)->first();
		$data->stock -= intval($count);
		$data->save();
	}

	public function category() {
		return $this->hasOne('\App\Model\Meta', 'id', 'cat');
	}

	public function sec() {
		return $this->hasOne('\App\Model\Meta', 'id', 'section');
	}

	public function stars() {
		return $this->hasMany('\App\Model\Stars', 'product', 'id');
	}

	public function order_likes() {
		return $this->hasMany('App\Model\ProductLike', 'product', 'id');
	}
}