<?php namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\User; //loads the User model
use Illuminate\Http\Request; //loads the Request class for retrieving inputs
use Illuminate\Support\Facades\Hash; //load this to use the Hash::make method

class UserController extends BaseController
{
	  public function index(){ //Get all records from users table
		return User::all();
		}

	public function show($id){ //Get a single record by ID
			return User::find($id); 
		}
    
	public function store(Request $request){ //Insert new record to users table
		$this->validate($request, [
			'id'  => 'required|unique:users',
			'name' => 'sometimes',
			'alamat'  => 'required',
			'kategori'  => 'kategori',
			'latittude' => 'required',
			'longitude'  => 'required'
		]); 
		$user   = new User;
		$user->name  = $request->input('name');
		$user->alamat  = $request->input('alamat');
		$user->kategori  = $request->input('kategori');
		$user->latittude  = $request->input('latittude');
		$user->longitude  = $request->input('longitude');
		$user->save();
	}
    
	public function update(Request $request, $id){ //Update a record
			$this->validate($request, [
			'id'  => 'required|unique:users',
			'name' => 'sometimes',
			'alamat'  => 'required',
			'kategori'  => 'kategori',
			'latittude' => 'required',
			'longitude'  => 'required'
			]); 
			$user    = User::find($id);
			$user->name  = $request->input('name');
			$user->alamat  = $request->input('alaman');
			$user->kategori  = $request->input('kategori');
			$user->latittude  = $request->input('latittude');
			$user->longitude  = $request->input('longitude');
			$user->save();
		}
    
			public function destroy(Request $request){
			$this->validate($request, [
				'id' => 'required|exists:users'
			]);
			$user = User::find($request->input('id'));
			$user->delete();
		}
}