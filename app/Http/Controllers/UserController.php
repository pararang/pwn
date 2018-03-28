<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
		public function test()
		{
				return response()->json(['Test', 'API']);
		}

		public function remove($id)
		{
				$user = User::findOrFail($id);
				$user->deleted_at = date('Y-m-d H:i:s');
				if ($user->save()) {
						$data = [];
						$resp = ['meta' => $this->metaSuccess(), 'data' => $data];
						return response()->json($resp);

				} else {
						$data = [];
						$resp = ['meta' => $this->metaFailed(), 'data' => $data];
						return response()->json($resp);
				}
		}


		public function edit($id, Request $req)
		{
				$user = User::findOrFail($id);

				if (null !== $req->input('name')) {
						$name = $req->input('name');
						if ($this->nameIsExist($name)) {
								$data = [];
								$resp = ['meta' => $this->metaFailed("Data already used"), 'data' => $data];
								return response()->json($resp);
						}
						$user->name = $name;
				}

				if (null !== $req->input('alamat')) {
						$user->alamat = $req->input('alamat');
				}

				if ($user->save()) {
						$data['user']['id'] = $user->id;
						$data['user']['name'] = $user->name;
						$data['user']['alamat'] = $user->alamat;

						$resp = ['meta' => $this->metaSuccess(), 'data' => $data];
						return response()->json($resp);

				} else {
						$data = [];
						$resp = ['meta' => $this->metaFailed(), 'data' => $data];
						return response()->json($resp);
				}
		}

		public function show($id)
		{
				$user = User::findOrFail($id);
//				if($user->trashed()){
//						$data['user'] = [];
//						$resp=['meta'=>$this->metaFailed("Data Deleted"),'data'=>$data];
//						return response()->json($resp);
//				}
				$data['user'] = $user;
				$resp = ['meta' => $this->metaSuccess(), 'data' => $data];
				return response()->json($resp);
		}

		public function create(Request $req)
		{
				//TODO validate input
				$name = $req->input('name');
				if ($this->nameIsExist($name)) {
						$data = [];
						$resp = ['meta' => $this->metaFailed("Data already used"), 'data' => $data];
				} else {

						$user = new User;
						$user->uuid = Uuid::uuid1();
						$user->name = $name;
						$user->alamat = $req->input('alamat');
						if ($user->save()) {
								$data['user']['id'] = $user->id;
								$data['user']['name'] = $user->name;
								$data['user']['alamat'] = $user->alamat;

								$resp = ['meta' => $this->metaSuccess(), 'data' => $data];

						} else {
								$data = [];
								$resp = ['meta' => $this->metaFailed(), 'data' => $data];
						}
				}
				return response()->json($resp);
		}

		private function nameIsExist($name)
		{
				return DB::table('users')->where('name', $name)->first() ? true : false;
		}
		//
}
