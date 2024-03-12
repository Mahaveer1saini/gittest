<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\jods;
use App\Models\jodtype;
use App\Models\categories;

use Illuminate\Support\Facades\Hash;
class AcconutController extends Controller
{
    public function login()
    {
        
        return view('front\layouts\acconut\login');
      
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->passes()){
           

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
                return redirect()->route('account.profile');
            }else{
                return redirect()->route('frontLogin') ->with('error','Either Email/password is incorrect');
            }
        }
        else{
            return redirect()->route('frontLogin')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

   

    public function register()
    {
        
        return view('front\layouts\acconut\register');
      
    }

    public function processRegister(Request $request)
   {
    // dd($request); // Remove this line

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:4',
       
    ]);

    if ($validator->passes()) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        // Assuming you have a 'phone' column in your 'users' table
        $user->save();

        session()->flash('success', 'You have been registered successfully.');

        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    } else {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }
   }

   public function profile()
   {
        $id = Auth::user()->id;

        $user = User::where('id',$id)->first();

        return view('front\layouts\acconut\profile',[
          'user' => $user,
        ]);
    
   }

   public function updateProfile(Request $request)
   {
    $id = Auth::user()->id;
    $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|unique:users,email,'.$id.',id',
       
    ]);
    if ($validator->passes()) {
        
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->designation = $request->designation;
        $user->save();
        
        session()->flash('success', 'Profile Updated Successfully');


    }else {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

   }
   

   public function updatePic(Request $request)
   {
       $id = Auth::user()->id;
       $oldImageName = User::where('id', $id)->value('image');
       $validator = Validator::make($request->all(), [
           'image' => 'required|image',
       ]);
   
       if ($validator->passes()) {
           $image = $request->file('image');
           $ext = $image->getClientOriginalExtension();
           $imageName = $id . '-' . time() . '.' . $ext;
   
           // Move the image to the public profile-pic directory
           $image->move(public_path('profile-pic'), $imageName);
   
           // Update the user's image field in the database
           User::where('id', $id)->update(['image' => $imageName]);
   
           // Delete the old image from the folder if it exists
           if ($oldImageName && file_exists(public_path('profile-pic/' . $oldImageName))) {
               unlink(public_path('profile-pic/' . $oldImageName));
           }
   
           session()->flash('success', 'Profile Updated Successfully');
   
           return response()->json([
               'status' => true,
               'message' => 'Profile Updated Successfully',
           ]);
       } else {
           return response()->json([
               'status' => false,
               'errors' => $validator->errors(),
           ]);
       }
   }

    public function createJod()
    {
        $user = Auth::user();

        $categories = Categories::orderBy('name', 'ASC')->where('status', 1)->get();

        $jodtype = jodtype::orderBy('name', 'ASC')->where('status', 1)->get();
        
        return view('front.layouts.acconut.Jod.create', compact('user', 'categories','jodtype'));
    }



    public function SaveJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
           
            'title' => 'required',
            'category' => 'required',
            'jodtype' => 'required',
            'vacancy' => 'required',
            'location' => 'required',
            'description' => 'required',
            'company_name' => 'required',
            'company_website' => 'required'

        
        ]);
    
        if ($validator->passes()) {

            $jod = new jods();
            $jod->title = $request->title;
            $jod->categories_id = $request->category;
            $jod->jobtype_id = $request->jodtype;
            $jod->user_id = Auth::user()->id;
            $jod->vacancy = $request->vacancy;
            $jod->salary = $request->salary;
            $jod->location = $request->location;
            $jod->description = $request->description;
            $jod->benefits = $request->benefits;
            $jod->responsibility = $request->responsibility;
            $jod->qualifications = $request->qualifications;
            $jod->experience = $request->experience;
            $jod->keywords = $request->keywords;
            $jod->company_name = $request->company_name;
            $jod->company_location = $request->company_location;
            $jod->company_website = $request->company_website;
            $jod->save();

            // Process the form data and save the job details
            session()->flash('success', 'Jod Successfully');
   
           return response()->json([
               'status' => true,
               'message' => 'Profile Jod Successfully',
           ]);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    }
    

    public function myJod()
    {
        $user = Auth::user();
        $jods = jods::where('user_id', Auth::user()->id)->with('jodtype')->paginate(10);
    
        return view('front.layouts.acconut.Jod.myjod', compact('user', 'jods'));
    }

    public function editJod(Request $request, $id)
   {
    $user = Auth::user();
    $categories = Categories::orderBy('name', 'ASC')->where('status', 1)->get();
    $jodtype = jodtype::orderBy('name', 'ASC')->where('status', 1)->get();
     
    $jods = jods::where([
        'user_id' => Auth::user()->id,
        'id' => $id
    ])->first();
    
    if ($jods == null) {
        abort(400);
    }
    
    return view('front.layouts.acconut.Jod.edit', compact('categories', 'jodtype', 'user', 'jods'));
   }

 
    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontLogin')->with('success', 'You successfully logged out!');
    }


    public function updateJob(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
           
            'title' => 'required',
            'category' => 'required',
            'jodtype' => 'required',
            'vacancy' => 'required',
            'location' => 'required',
            'description' => 'required',
            'company_name' => 'required',
            'company_website' => 'required'

        
        ]);
    
        if ($validator->passes()) {

            $jod =  jods::find($id);
            $jod->title = $request->title;
            $jod->categories_id = $request->category;
            $jod->jobtype_id = $request->jodtype;
            $jod->user_id = Auth::user()->id;
            $jod->vacancy = $request->vacancy;
            $jod->salary = $request->salary;
            $jod->location = $request->location;
            $jod->description = $request->description;
            $jod->benefits = $request->benefits;
            $jod->responsibility = $request->responsibility;
            $jod->qualifications = $request->qualifications;
            $jod->experience = $request->experience;
            $jod->keywords = $request->keywords;
            $jod->company_name = $request->company_name;
            $jod->company_location = $request->company_location;
            $jod->company_website = $request->company_website;
            $jod->save();

            // Process the form data and save the job details
            session()->flash('success', 'update Successfully');
   
           return response()->json([
               'status' => true,
               'message' => 'Profile update Successfully',
           ]);
        } else {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
    } 
    
   // AcconutController.php

  // YourController.php



  public function deleteJob(Request $request, $id)
{
    $jod = jods::where([
        'user_id' => auth()->id(),
        'id' => $id,
    ])->first();

    if ($jod) {
        // Delete the job
        $jod->delete();

        return response()->json([
            'status' => true,
            'message' => 'Job deleted successfully',
        ]);
    } else {
        // Job not found or doesn't belong to the authenticated user
        return response()->json([
            'status' => false,
            'message' => 'Job not found or unauthorized',
        ], 404);
    }
}

   



   

}
