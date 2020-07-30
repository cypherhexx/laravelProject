<?php

namespace App\Http\Controllers\Auth;

use App\CustomerRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Customer;
use App\Ticket;
use App\Comment;
use App\Project;
use App\ProjectPreview;
use App\NumberGenerator;
use App\CustomerContact;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Facades\DB;
use App\Rules\ValidRecaptcha;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/client';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    public function showRegistrationForm()
    {
        $rec = [];
        $data1 = Project::dropdown();
        $data   = Customer::dropdowns();

        return view('auth.register', compact('data','data1'))->with('rec', $rec);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'contact_first_name'    => 'required|string|max:255',
            'contact_last_name'     => 'required|string|max:255',

            'name' => 'required|string|max:255',
            'contact_email' => 'required|string|email|max:255|unique:customer_contacts,email|unique:customer_registrations',
            'contact_password' => 'required|string|min:6',
            'repeat_password' => 'required|same:contact_password',
            'project_name' => 'required|string|max:255'
        ];


        if(is_recaptcha_enable())
        {
            $rules['g-recaptcha-response'] = ['required', new ValidRecaptcha];
        }
        
        return Validator::make($data, $rules);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        return view('auth.verify');
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {    

     
        $dateToday = date('Y-m-d');
        error_log("dateTime");
        error_log(json_encode($dateToday));

        $userData = array('name' => $data['name'], 'billing_type_id' => 1, 'status_id' => 1,'customer_name' => $data['contact_email'], 'registration_id' => 1,'start_date' => $dateToday);
        error_log(json_encode($userData));

        ProjectPreview::create($userData);

        $data['verification_token'] = substr(md5(uniqid(rand(), true)), 16, 16); // 16 characters long
        $data['contact_password']   = Hash::make($data['contact_password']);
        $user = CustomerRegistration::create($data);

        // Send Email Verification Link to the user
        Mail::to($user->contact_email)->send(new ConfirmEmail($user));       
       

        return $user;

    }


    function verify_email($code)
    {
        $customer = CustomerRegistration::where('verification_token', $code)->get();

        if(count($customer) > 0)
        {
            $customer = $customer->first();

            $validator = Validator::make(['contact_email' => $customer->contact_email ], [
                'contact_email' => 'required|string|email|max:255|unique:customer_contacts,email',           

            ]);

            if ($validator->fails()) 
            {
                // The customer has already been created in the mean time
                abort(404);
            }
            else
            {
                DB::beginTransaction();
                $success = false;

                try {

                    $data = $customer->toArray();

                    $data['number']                 = NumberGenerator::gen(COMPONENT_TYPE_CUSTOMER);
                    $data['currency_id']            = config('constants.default_currency_id') ;


                    $obj  = Customer::create($data);  

                    // Customer's Primary Contact                
                    $primary_contact    = new CustomerContact();

                    $primary_contact->customer_id                               = $obj->id;
                    $primary_contact->first_name                                = $customer->contact_first_name;
                    $primary_contact->last_name                                 = $customer->contact_last_name ;
                    $primary_contact->email                                     = $customer->contact_email;
                    $primary_contact->phone                                     = $customer->contact_phone;
                    $primary_contact->position                                  = $customer->contact_position;
                    $primary_contact->is_primary_contact                        = TRUE;
                    $primary_contact->password                                  = $customer->contact_password;  
                    $primary_contact->save();

                    // Delete the record from customer_registrations table
                    $customer->delete();

                    DB::commit();
                    $success = true;


                } catch (\Exception  $e) {
                    $success = false;
                    DB::rollback();

                }

                if ($success) 
                {

                    $project_pre = ProjectPreview::where('customer_name',$customer->contact_email)->first();
                    $customer_select = CustomerContact::where('email',$customer->contact_email)->value('id');
                    $customer_first = CustomerContact::where('email',$customer->contact_email)->value('first_name');
                    $customer_last = CustomerContact::where('email',$customer->contact_email)->value('last_name');
                    error_log("id");
                    error_log($customer_select);
                    error_log('start projectpreview');
                    error_log(json_encode($project_pre));

                    //modify the project part
                

                DB::beginTransaction();
                $success = false;



                //ticket create

                 try {
                $request = new Request();

   

                $request['subject'] = "VIP TICKET";
                $request['department_id'] = 1;
                $request['details'] = "details";
                $request['ticket_priority_id'] = 1;

                $request['number']                   = NumberGenerator::gen(COMPONENT_TYPE_TICKET);
                $request['created_by']               = $customer_select;
                $request['user_type']                = USER_TYPE_CUSTOMER;

                $request['customer_contact_id']     = $customer_select;
                $request['name']                    = $customer_first . " " . $customer_last;
                $request['email']                   = $customer->contact_email;
                $request['ticket_status_id']        = TICKET_STATUS_OPEN ;

                // Saving Data        
                $ticket  = Ticket::create($request->all());     

                $comment            = new Comment();
                $comment->body      = "VIP ticket";
                $comment->user_id   = $customer_select;
                $comment->user_type = USER_TYPE_CUSTOMER;
                $ticket->comments()->save($comment);

               

                // Save the attachments (If exists)
                // $files             = $request->attachment;
           
                // if(!empty($files))
                // {
                //     $attachment = new Attachment();
                //     $attachment->add($files, $comment);       
                
                // }


                // Log Actitivy
                // $description    = __('form.new_ticket_opened');
                // $details        = anchor_link($ticket->number, route('show_ticket_page', $ticket->id ) );            
                // log_activity($ticket, $description , $details); 


                // // Send Notification to all Members of the department
                // $ticket->notify_new_ticket_created_by_customer();
            


                DB::commit();
                $success = true;
            } 
            catch (\Exception  $e) {
                
                $success = false;
                DB::rollback();

                
            }


                //ticket create end

                try {



                    // Saving Data
                    error_log("projecting");
                    error_log($project_pre['name']);
                    $obj = new Project();
                    $obj->number                            = NumberGenerator::gen(COMPONENT_TYPE_PROJECT);
                    $obj->name                              = $project_pre['name'];
                
                    $obj->customer_id                       = $customer_select;        
                    $obj->calculate_progress_through_tasks  = null;
                    $obj->progress                          = null;
                    $obj->billing_type_id                   = $project_pre['billing_type_id'];
                    $obj->billing_rate                      = null;
                    $obj->start_date                        = $project_pre['start_date'];
                    $obj->dead_line                         = null;
                    $obj->description                       = null;
                    $obj->status_id                         = $project_pre['status_id'];
                    $obj->settings                          = '{"tabs":{"tasks":"on","timesheets":"on","files":"on","milestones":"on","gantt_view":"on","invoices":"on","estimates":"on"},"permissions":{"view_tasks":"on","create_tasks":"on","edit_tasks":"on","comment_on_tasks":"on","view_task_comments":"on","view_task_attachments":"on","upload_on_tasks":"on","view_task_total_logged_time":"on","view_finance_overview":"on","view_milestones":"on","view_gantt":"on","view_timesheets":"on","view_team_members":"on","upload_files":"on"}}';
                    $obj->created_by                        = 1 ;
                    $obj->save();


                    // Attaching Members of the Project
                    // $member_ids                             = $request->user_id;

                    // if($member_ids)
                    // {
                    //     if(!in_array(auth()->user()->id, $member_ids ))
                    //     {
                    //         array_push($member_ids, auth()->user()->id );      
                    //     }
                    // }
                    // else
                    // {
                    //     $member_ids = [auth()->user()->id];
                    // }          

                    // $obj->members()->attach($member_ids);


                    // // Attaching Tags            
                    // if(isset($request->tag_id) && $request->tag_id)
                    // {
                    //     $obj->tag_attach($request->tag_id);
                    // }



                    // Log Activity   
                    $description = sprintf(__('form.act_has_created_a_new_project'), anchor_link($obj->name, route('cp_show_project_page', $obj->id ) ));
                    log_activity($obj, trim($description));


                    DB::commit();
                    $success = true;
                } catch (\Exception  $e) {
                    $success = false;

                    DB::rollback();

                }

                if ($success) {
                    // the transaction worked ...
                    return view('auth.verified');
                } else {
                   abort(404);
                }
                    //end the create project part


                    return view('auth.verified');

                } 
                else 
                {
                    abort(404);
                }

            }

        }
        else
        {
            abort(404);
        }

    }

    function resend_verification_link_page()
    {
        return view('auth.resend_email_verfification_link');
    }

    function resend_verification_link(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'email'             => 'required|email|exists:customer_registrations,contact_email',
            

        ]);

        if ($validator->fails()) 
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = CustomerRegistration::where('contact_email', $request->email)->get()->first();
        $user->verification_token = substr(md5(uniqid(rand(), true)), 16, 16); // 16 characters long
        $user->save();

        // Send Email Verification Link to the user
        Mail::to($user->contact_email)->send(new ConfirmEmail($user));

        $request->session()->flash('resent', 'Task was successful!');

        return view('auth.verify');

    }
}
