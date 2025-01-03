<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\AllFunction;

class ProfileController extends Controller
{
    use AllFunction; //<= use traits    

    public function index(){
        $meta = [
            'title'=>'My Profile',
            'keywords'=>'',
            'description'=>'',
        ];

        $social_media = AllFunction::get_social_media(); //<= use traits function       

        $user_id = Auth::id();
        $user    = User::where('user_id','=',$user_id)->with('users_types')->first()->toArray(); 
        
        $return_social_media = [];
        $social_media_table  = (array) json_decode($user['social_media']);
        if($social_media_table){
            foreach($social_media_table as $key=>$val){
                $val = (array) $val;
                $return_social_media[$key] = $val;                
            }
        }  
        $user['social_media'] = $return_social_media;         

        $data    = compact('meta','user_id','user','social_media'); 
        return view('admin.profile.profile')->with($data);
    }

    public function update(Request $request){ 
        
        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){  
            
            $rules = [
                'name' => 'required',
                'about' => 'required', // 'required|min:50',
                'phone_number' => 'required'
            ];
        
            if ($request->input('are_you_visiting_director') == 1) {
                $rules['time_in_lieu'] = 'required|integer';
            }
        
            $messages = [
                'departure_date_check' => 'Departure date can\'t be smaller then Arrival date.Please check your dates.'
            ];

            $validation = Validator::make( 
                $request->toArray(), 
                $rules, 
                $messages
            );
            
            if($validation->fails()) {            
                return back()->withInput()->withErrors($validation->messages());            
            }
            else{

                $social_media        = $this->get_social_media(); 
                $return_social_media = [];
                $social_media_post   = $request['social_media'];
                if($social_media_post){
                    foreach($social_media_post as $key=>$val){
                        if($val){
                            $data = $social_media[$key];
                            $data['url'] = $val;
                            $return_social_media[$key] = $data;
                        }
                    }
                }  
                
                $file = $request->file('profile_image');
                if($file){
                    $array = [
                        'file'=>$file,
                        'destination_path'=>'uploads/profile'                  
                    ];
                    $profile_image = AllFunction::upload_image($array);
                }
                else{
                    $profile_image = $request['profile_image'];
                }

                $user_id = Auth::id();
                $user    = User::find($user_id);
                if($user){
                    $user->profile_image= $profile_image;
                    $user->name         = $request['name'];
                    $user->about        = $request['about'];
                    $user->company      = $request['company'];
                    $user->country      = $request['country'];
                    $user->address      = $request['address'];
                    $user->phone_number = $request['phone_number'];               
                    $user->social_media = json_encode($return_social_media);
                    $user->save();
                }            
                return redirect( route('profile') )->with(['message'=>'Profile updated successfully!']);
            }  
        }
        else{

            $meta = [
                'title'=>'Update Profile',
                'keywords'=>'',
                'description'=>'',
            ];
    
            $social_media = AllFunction::get_social_media(); //<= use traits function   
            $user_id = Auth::id();
            $user    = User::where('user_id','=',$user_id)->with('users_types')->first()->toArray(); 
            
            $return_social_media = [];
            $social_media_table  = (array) json_decode($user['social_media']);
            if($social_media_table){
                foreach($social_media_table as $key=>$val){
                    $val = (array) $val;
                    $return_social_media[$key] = $val;                
                }
            }  
            $user['social_media'] = $return_social_media;  

            $data = compact('meta','user_id','user','social_media'); 
            return view('admin.profile.edit_profile')->with($data);
        }    
        
    }

    public function change_password(Request $request){  

        $apply_action = $request['apply_action'] ?? '';
        if($apply_action){

            $user_id  = Auth::id();
            $user     = Auth::user();
            
            $rules = [
                'password' => ['required', function($attribute, $value, $fail) use($request,$user){               
                    $password = $user->password;               
                    if( !Hash::check($value, $password) ){                        
                        return $fail('The current password is incorrect.');
                    }
                }],
                'new_password'   => 'required|min:6',
                'renew_password' => 'required|same:new_password'		
            ];    
            $messages = [];         
            $validation = Validator::make( 
                $request->toArray(), 
                $rules, 
                $messages
            );
            if($validation->fails()) {            
                return back()->withInput()->withErrors($validation->messages());            
            }
            else{
                $user    = User::find($user_id);
                if($user){
                    $user->password = Hash::make($request['new_password']);               
                    $user->save();
                } 
                return redirect( route('profile') )->with(['message'=>'Password updated successfully!']);
            }
        }
        else{
            $meta = [
                'title'=>'change Profile Password',
                'keywords'=>'',
                'description'=>'',
            ];

            $data = compact('meta'); 
            return view('admin.profile.change_password')->with($data);
        }

    }
}
