<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function Login()
    {
        return view('Admin.Login');
    }

    public function Index(Request $req)
    {
        $visitor = DB::table('visitor')->insert(['ip' => $req->getClientIp()]);
        $data = DB::table('blogs')->get();
        return view('Index', ["data" => $data]);
    }


    public function LoginUser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_email' => 'required|email',
            'user_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }
        $user = DB::table('users')
            ->where(["user_email" => $req->input('user_email')])
            ->first();
        if (!$user) {
            return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }
        session_start();
        if (Hash::check($req->input('user_password'), $user->user_password)) {
            $_SESSION["user_id"] = $user->user_id;
            $_SESSION["user_name"] = $user->user_name;
            return response()->json(["success" => true, "message" => "Login Successfull"]);
        } else {
            return response()->json(["success" => false, "message" => "Invalid Credential"]);
        }
    }

    public function Dashboard()
    {
        // $data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        // $year = date('Y');
        // $result = DB::table('visitor')->select(DB::raw('YEAR(datetime) AS year, MONTH(datetime) AS month, COUNT(*) AS count'))->whereRaw('YEAR(datetime) = ?', [$year])->groupBy(DB::raw('YEAR(datetime), MONTH(datetime)'))->get();
        // for ($i = 1; $i <= count($result); $i++) {$data[$i - 1] = $result[$i - 1]->count;}
        return view('Admin.Dashboard');
    }




    ///Contac Admin


    public function Contact()
    {
        return view('Admin.Contact');
    }

    public function ContactCreate(Request $req)
    {
        $data = $req->input();
        unset($data['contact_id']);
        $data['tag']= str_replace(' ', '', $data['tag']);
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'gender' => 'required',
            'capacity' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'experties' => 'required',
            'address' => 'required',
            'tag' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(["validate" => true, "message" => $validator->errors()->all()[0]]);
        }


    // ---------------------- check if contact and email alredy registered ------------------
    $input = $req->only(['phone', 'email']);
    if(!$req->input('contact_id')){
        $input = $req->only(['phone', 'email']);

        $existingContact = DB::table('contact')
            ->where(function ($query) use ($input) {
                $query->where('phone', $input['phone'])
                      ->orWhere('email', $input['email']);
            })
            ->first();

        if ($existingContact) {
            $message = '';
            if ($existingContact->phone == $input['phone']) {
                $message = $input['phone'] . ' is already registered.';
            } elseif ($existingContact->email == $input['email']) {
                $message = $input['email'] . ' is already registered.';
            }
            return response()->json(['success' => false, 'message' => $message]);
        }

    }





  // ---------------------- check if contact and email alredy registered ------------------


        if ($req->input('contact_id')) {
            DB::table('contact')
            ->where('contact_id', $req->input('contact_id'))
            ->update($data);
            return response()->json(["success" => true, "message" => "Contact Updated Successfully"]);
        }else{
             DB::table('contact')->insert($data);
             return response()->json(["success" => true, "message" => "Contact Created Successfully"]);
        }
    }
    public function ContactFetch(Request $req)
    {

        // Start with a base query for contacts
        $query = DB::table('contact');

        // Filter by contact_id if provided
        if ($req->input('contact_id')) {
            $query->where("contact_id", $req->input('contact_id'));
        }


        // Filter by multiple tags if provided
        if ($req->input('tags')) {
            $tags = $req->input('tags');

            // Filter contacts that have any of the tags
            $query->where(function ($subQuery) use ($tags) {
                foreach ($tags as $tag) {
                    $subQuery->where('tag', 'LIKE', '%' . $tag . '%');
                }
            });
        }

        // Fetch the results
        $contacts = $query->get();

        // Return the results as JSON
        return response()->json($contacts);
    }

//     public function ContactFetch(Request $req)
// {
//     if ($req->input('contact_id')) {
//         // Fetch by contact_id
//         $data = DB::table('contact')->where("contact_id", $req->input('contact_id'))->get();
//     }
//     else if ($req->input('tag')) {
//         // Fetch contacts by tag
//         $data = DB::table('contact')->where('tag', 'LIKE', '%' . $req->input('tag') . '%')->get();
//     }
//     else {
//         // Fetch all contacts
//         $data = DB::table('contact')->get();
//     }

//     return $data;
// }


    public function ContactDelete(Request $req)
    {
        if ($req->input('contact_id')) {
            DB::table('contact')->where("contact_id", $req->input('contact_id'))->delete();
        }
        return response()->json(["success" => true, "message" => "Contact deleted successfully"]);
    }


}
