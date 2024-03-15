<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use Mail;

class ContactController extends Controller
{
    public function ContactusPost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);

        Contact::create($request->all());
        Mail::send(
            'emails/contact-email',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'user_message' => $request->get('message')
            ),
            function ($message) {
                $message->from('lokesh.kumar.wh@gmail.com');
                $message->to('lokesh@euronoxxgroup.com', 'Admin')->subject('Contact Us Message');
                return response()->json([
                    'success' => true,
                    'message' => 'Thanks for contacting us.',
                    $message,
                ], 200);
            }
        );


    }

    public function get_messages()
    {
        $check_authentication = Auth::user();
        if ($check_authentication && $check_authentication->hasRole('admin')) {
            $contacts = Contact::orderBy('id', 'desc')->paginate(10);
            return response()->json([
                'success' => true,
                'message' => $contacts,
            ], 200);
        } else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
        //return view("get_messages",['contacts'=>$contacts]);
    }

    public function destroy($id)
    {
        $check_authentication = Auth::user();
        if ($check_authentication && $check_authentication->hasRole('admin')) {
            Contact::destroy($id);
            // echo "deleted";
            return response()->json([
                'message' => 'Record Deleted.',
            ], 200);
        } else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
    }
}
