<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class HelpDeskController extends Controller
{


    protected $userId;

    public function __construct() {

        $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                return redirect('/login');
            }
            $this->userId = \Auth::user()->account_id; // you can access user id here

            return $next($request);
        });
    }
    public function index(){

        $data['pendingTickets']=Ticket::where('status','pending')->where('emp_id',$this->userId)->count();
        $data['completeTickets']=Ticket::where('status','complete')->where('emp_id',$this->userId)->count();
        $data['declineTickets']=Ticket::where('status','decline')->where('emp_id',$this->userId)->count();
        $data['totalTickets']=Ticket::where('emp_id',$this->userId)->count();

        $data['newTickets']=Ticket::whereDay('created_at', '=', date('d'))->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->where('emp_id',$this->userId)->count();

        return view('help-desk.index')->with(compact('data'));
    }

    //saveTicket
    public function saveTicket(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'subject' => 'required',
            'priority' => 'required',
            'desc' => 'required',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }

        $ticket = new Ticket();
        $ticket->emp_id = Auth::user()->account_id;
        $ticket->assigned_id = 0;
        $ticket->subject = $request->subject;
        $ticket->periorty = $request->priority;
        $ticket->desc = $request->desc;;
        $ticket->status ='pending';

        if ($ticket->save()) {
            return response()->json(['success' => 'Record save successfully'], 200);
        }
    }


    //editDesignation
    public function editTicket(Request $request)
    {

        $ticket = Ticket::find($request->id);
        return $ticket;

    }

    public function upateTicket(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        $ticket->subject = $request->subject;
        $ticket->periorty = $request->priority;
        $ticket->desc = $request->desc;
        if($ticket->update())
        {
            return response()->json([
                'status' => 200,
                'message' => 'ticket updated successfully'
            ]);
        }
    }


    public function deleteTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        if($ticket->delete())
        {
            return response()->json([
                'status' => 200,
                'message' => 'ticket deleted successfully'
            ]);
        }
    }

    //myTicket
    public function myTicket()
    {

        $data=Ticket::where('emp_id',Auth::user()->account_id)->get();

        echo json_encode($data);
    }

    //ticket

    public function ticket(Request $request)
    {
        if($request->isMethod('post')){

            $qry=Ticket::join('employees','employees.id','tickets.emp_id')
                ->join('designations','designations.id','employees.desg_id');

            $qry->when($request->company_id, function($query, $company_id) {
                return $query->where('employees.company_id', $company_id);
            });

            $qry->when($request->emp_id, function ($query, $emp_id) {
                return $query->where('tickets.emp_id', $emp_id);
            });
            $qry-> when($request->status, function ($query, $status) {
                return $query->where('tickets.status',$status);
            });
            $qry-> when($request->periorty, function ($query, $periorty) {
                return $query->where('tickets.periorty',$periorty);
            });

           $res= $qry->select('tickets.*','employees.name','employees.image','designations.desig_name')
                ->orderBy('tickets.id','desc')->get();
           return $res;
        }
        $data['pendingTickets']=Ticket::where('status','pending')->count();
        $data['completeTickets']=Ticket::where('status','complete')->count();
         $data['declineTickets']=Ticket::where('status','decline')->count();
        $data['totalTickets']=Ticket::count();

        $data['newTickets']=Ticket::whereDay('created_at', '=', date('d'))->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();
        $data['company'] = Company::all();
        return view('help-desk.tickets')->with(compact('data'));
    }

    
    //updateTicketStatus
    public  function updateTicketStatus(Request $request){

        $tic = Ticket::find($request->id);
        $tic->status =$request->status;
        if($tic->save())
        {
            return response()->json(['success'=>'Record updated successfully'],200);
        }

    }



    public function ticketList()
    {

        return $data=Ticket::join('employees','employees.id','tickets.emp_id')
           -> join('designations','designations.id','employees.desg_id')
            ->select('tickets.*','employees.name','employees.image','designations.desig_name')
        ->orderBy('tickets.id','desc')->get();

    }
}
