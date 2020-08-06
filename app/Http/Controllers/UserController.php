<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        /* $users = User::latest()->paginate(5);
        
        return view('users.index',compact('users'))
        ->with('i', (request()->input('page', 1) - 1) * 5); */
        
        $users = User::all();
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required|unique:users',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        
        $users = User::create($request->all());
        return Response::json($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $request)
    {
        //
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return Response::json($user);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required|unique:users,email,'.$user->id,
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        
        $user->save();
        return Response::json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::destroy($id);
        return Response::json($user);
    }
    
    public function downloadExcel($type)
	{
		$data = User::get()->toArray();
		return Excel::create('excel', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
	public function importExcel()
	{
		if(Input::hasFile('import_file')){
			$path = Input::file('import_file')->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
				    $insert[] = ['name' => $value->name, 'email' => $value->email, 'phone' => $value->phone, 'city' => $value->city];
				}
				if(!empty($insert)){
				    try {
				        DB::table('users')->insert($insert);
				    } catch(\Illuminate\Database\QueryException $e){
				        $errorCode = $e->errorInfo[1];
				        if($errorCode == '1062'){				            
				            DB::table('users')->where('email', $value->email)->update(['name' => $value->name, 'phone' => $value->phone, 'city' => $value->city]);
				        }
				    }
				    $users = User::all();
				    return view('users.index')->with('users', $users);
				}
			}
		}
		return back();
	}
}
