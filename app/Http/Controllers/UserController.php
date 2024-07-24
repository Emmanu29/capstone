<?php

namespace App\Http\Controllers;
use App\Http\Controllers\DateTime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB; // Import the DB facade
use Illuminate\Support\Facades\Hash;
use App\Rules\FutureDateTime;


class UserController extends Controller
{

    public function show(string $id){
         $data = User::findOrFail($id);

         return view('users.edit', ['user' => $data]);
    }

    public function index(){
        $data = [
            "users" => DB::table('users')->where('isDeleted', false)->orderBy('created_at', 'desc')->simplePaginate(10)
        ];

        return view('users.index', $data);

    }

    public function login(){
        if(View::exists('users.login')){
            return view('users.login');
        }else{
            return abort(404);
            //return response()->view('errors.404'); //customize 404 not found
        }
    }

    public function process(Request $request){
        $validated = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required'
        ]);
        
        if(auth()->attempt($validated)){
            $user = auth()->user();
    
            // Check if the user is marked as deleted
            if ($user->isDeleted == 1) {
                auth()->logout(); // Log out the user
                return back()->withErrors(['email' => 'Your account has been deleted. Please contact support for assistance.'])->onlyInput('email');
            }
    
            // Check if the user's category is "Temporary User"
            if ($user->category == 'Temporary User') {
                return redirect('/monitoring'); // Redirect temporary users to monitoring
            }
    
            $request->session()->regenerate();
    
            return redirect('/')->with('message', 'Welcome Back!');
        }
    
        return back()->withErrors(['email' => 'Login failed'])->onlyInput('email');
    }
    

    public function store(Request $request){
        $validated = $request->validate([
             "username" => ['required', 'min:4'],
             "firstName" => ['required'],
             "lastName" => ['required'],
             "category" => ['required'],
             "dateTime" => ['nullable', 'date_format:Y-m-d\TH:i'], // Add validation for dateTime
             "email" => ['required', 'email', Rule::unique('users', 'email')],
             "password" => 'required|confirmed|min:8'
        ]);
        $validated['password'] = bcrypt($validated['password']);

        if ($request->input('category') === 'Admin User') {
            $validated['dateTime'] = null;
            } else if($request->has('dateTime')) {
                $validated['dateTime'] = $request->input('dateTime');
            }
        
        // If dateTime is provided, assign it to the validated data
        
        
        $user = User::create($validated);
        //auth()->login($user, true); // Remember the user's login session - inalis ko to dahil kapag nagcreate yung admin ng bagong temporary user yun ang nalologin

        return back()->with('message', 'Congratulation, your account has been successfully created');
     }

     public function register(){
        return view('users.register');
            }
 
     public function logout(Request $request){
         auth()->logout();
 
         $request->session()->invalidate();
         $request->session()->regenerateToken();
 
         return redirect('/login')->with('message', 'Logout Successful');
 
     }

     public function update(Request $request, User $user){
        // Validate the incoming request data
        $validated = $request->validate([
            "username" => ['required', 'min:4'],
            "firstName" => ['required'],
            "lastName" => ['required'],
            "category" => ['required'],
            "dateTime" => ['nullable', 'date_format:Y-m-d\TH:i'],
            "email" => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            "password" => 'required|confirmed|min:8'
        ]);

        if ($validated['category'] === 'Admin User') {
            $validated['dateTime'] = null;
        }
    
        // Update the user record with validated data
        $user->update([
            'username' => $validated['username'],
            'firstName' => $validated['firstName'],
            'lastName' => $validated['lastName'],
            'category' => $validated['category'],
            'dateTime' => $validated['dateTime'] ?? null, // Use null coalescing operator to handle optional dateTime
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']), // Encrypt password directly
        ]);
    
        // Redirect back with a success message
        return back()->with('message', 'User information updated successfully');
    }
    
    public function destroy(User $user){
        $user->isDeleted = true;
        $user->save();
    
        return redirect('/users')->with('message', 'Data was successfully deleted');
    }
    
    public function search(Request $request){
        //return Animal::where('name', 'like', '%'.$name.'%')->get();

        $searchName = $request->input('name');
        $users = User::where('username', 'like', '%' . $searchName . '%')->where('isDeleted', false)->paginate(10); ;
        
        return view('users.index', ['users' => $users]);
    }


    // // Method to delete expired temporary users
    // public function deleteExpiredTemporaryUsers(Request $request)
    // {
    //     User::where('category', 'Temporary User')
    //         ->where('dateTime', '<=', now())
    //         ->delete();

    //     return response()->json(['message' => 'Expired temporary users deleted successfully.']);
    // }
}
