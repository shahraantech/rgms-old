<?php

use App\Models\Account;
use App\Models\Attendance;
use App\Models\Company;
use App\Models\Employee_Allownce;
use App\Models\Expense;
use App\Models\Lead;
use App\Models\LeadsMarketing;
use App\Models\Notification;
use App\Models\Purchase;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Employee;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Transaction;
use App\Models\BankBranch;
use App\Models\BankSummry;
use App\Models\Client;
use App\Models\AccountSummary;
use App\Models\AssignedLeads;
use App\Models\ApprochedLeads;
use App\Models\Ledger;
use App\Models\SourceLeadsSettings;
use App\Models\TeamTarget;
use App\Models\Level_1;
use App\Models\Level_2;
use App\Models\Level_3;
use App\Models\Level_4;
use App\Models\Level_5;
use App\Models\CustomerServey;


function getEmployeeAcordigToDesignation($desig_id)
{
    return $res = Employee::where('desg_id', $desig_id)->get();
}


function updateEmployeeStatus($emp_id)
{


    $user = User::where('account_id', $emp_id)->first();
    $user->status = 0;
    $user->save();

    $emp = Employee::find($emp_id);
    $emp->status = 0;
    $emp->save();
}

//ajaxEmpAutoSearch

function ajaxEmpAutoSearch($request)
{

    $employees = [];

    if ($request->has('q')) {
        $search = $request->q;
        $employees = Employee::select("id", "name")
            ->where('name', 'LIKE', "%$search%")
            ->get();
    }
    return $employees;
}


function getVendorsNameForDropdown()
{


    return $vendor = Vendor::all();
}

function saveTransaction($inv_id, $trans_mode, $file_id, $against, $location_id, $amount, $desc, $trans_date, $trans_type,$bankPaymentMode=NULL,$attachement=NULL)
{

    $tran = new Transaction();
    $tran->inv_id = $inv_id;
    $tran->mode = $trans_mode;
    $tran->item_id = $file_id;
    $tran->via = $against;
    $tran->auth_id = \Illuminate\Support\Facades\Auth::id();
    $tran->location_id = $location_id;
    $tran->amount = $amount;
    $tran->desc = $desc;
    $tran->date = $trans_date;
    $tran->trans_type = $trans_type;
    $tran->bank_payment_mode = $bankPaymentMode;
    $tran->attachement = $attachement;
    if ($tran->save()) {
        return $tran;
    } else {
        return 0;
    }
}

//getClientsNameForDropdown

function getClientsNameForDropdown()
{


    return $vendor = \App\Models\Client::all();
}


// update stock
function updateStock($item_id, $qty, $action)
{

    $pur = Purchase::find($item_id);
    if ($action == 1) {
        $pur->qty = $pur->qty + $qty;
        $pur->avl_qty = $pur->avl_qty + $qty;
    } else {
        $pur->avl_qty = $pur->avl_qty - $qty;
    }
    $pur->save();
}

function updateCustomerVendorBalance($ac_id, $ac_type, $amount, $trans_type)
{

    if ($ac_type == 'vendors') {
        $res = Vendor::find($ac_id);
    } else {
        $res = Client::find($ac_id);
    }
    if ($trans_type == 'dr') {
        $res->open_bal = $res->open_bal - $amount;
    } else {
        $res->open_bal = $res->open_bal + $amount;
    }

    $res->save();
    return $res->open_bal;
}



function updateAccountHeadBalance($level_head_id, $amount, $trans_type, $coaLevel)
{


    if ($coaLevel == 1) {
        $res = Level_1::find($level_head_id);
    }
    if ($coaLevel == 2) {
        $res = Level_2::find($level_head_id);
    }
    if ($coaLevel == 3) {
        $res = Level_3::find($level_head_id);
    }
    if ($coaLevel == 4) {
        $res = Level_4::find($level_head_id);
    }
    if ($coaLevel == 5) {
        $res = Level_5::find($level_head_id);
    }

    if ($trans_type == 'dr') {
        $res->balance = $res->balance + $amount;
    } else {
        $res->balance = $res->balance - $amount;
    }

    $res->save();
    return $res->balance;
}




function updateBankBalance($trans_id, $bank_id, $payment_amount, $trans_type, $balance)
{

    $res = Bank::find($bank_id);
    if ($trans_type == 'db') {
        $res->balance = $res->balance + $payment_amount;
    } else {
        $res->balance = $res->balance - $payment_amount;
    }
    $res->save();


    $summary = new BankSummry();
    $summary->transaction_id = $trans_id;
    $summary->bank_id = $bank_id;
    $summary->amount = $payment_amount;
    $summary->transaction_type = $trans_type;
    $summary->balance = $res->balance;
    $summary->save();
}

function getNumberOfDays($day, $date, $NameOfDay)
{




    $months = date('m', strtotime($date));
    $years = date('Y', strtotime($date));


    $monthName = date("F", mktime(0, 0, 0, $months));
    $fromdt = date('Y-m-' . $day, strtotime("First Day Of  $monthName $years"));
    $todt = date('Y-m-d ', strtotime("Last Day of $monthName $years"));

    $num_sundays = '';
    for ($i = 0; $i < ((strtotime($todt) - strtotime($fromdt)) / 86400); $i++) {
        if (date('l', strtotime($fromdt) + ($i * 86400)) == ucfirst($NameOfDay)) {
            $num_sundays++;
        }
    }
    return $num_sundays;
}


function getTotalDaysOfMonth($month = 06, $year = 2022)
{

    $a_date = $year . '-' . $month;
    $data['totalDaysOfThisMonth'] = date("t", strtotime($a_date));
    $data['todayOfThisMonth'] = date('d');
    return $data;
}


function getSundaysBetween2Dates($startDate, $endDate)
{



    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $days = $start->diff($end, true)->days;

    $sundays = intval($days / 7) + ($start->format('N') + $days % 7 >= 7);

    return $sundays;
}


function getEmployeesAcordingDept($dept_id)
{


    $res = Employee::with('getDesignation')->where('dept_id', $dept_id)->where('status',1)->get();
    return $res;
}
function getSundays($y,$m){
    $date = "$y-$m-01";
    $first_day = date('N',strtotime($date));
    $first_day = 7 - $first_day +1;
    $last_day =  date('t',strtotime($date));
    $days = array();
    for($i=$first_day; $i<=$last_day; $i=$i+7 ){
        $days[] = $i;
    }
    return  $days;
}


function countEmpSalaryForViews($empId, $month, $year)
{


    ($month) ? $month = $month : $month = date('m', strtotime(date('d-m-Y')));
    ($year) ? $year = $year : $year = date('Y', strtotime(date('d-m-Y')));


    $totalDaysOfThisMonth = getTotalDaysOfMonth();
    $totalSundaysOfThisMonth = getNumberOfDays($day = 1, $date = date('d-m-Y'), $NameOfDay = 'sunday');

    $emp = Employee::find($empId);
    $comapny = Company::where('id', $emp->company_id)->first();
    $empBasicSalary = $emp->gross_salary;

    $present = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->where('status', 1)->count();

    $att = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->orderBy('date', 'ASC')->first();
    $attLastDay = Attendance::where('emp_id', $empId)->where('attendance_month', $month)->where('attendance_year', $year)->orderBy('date', 'DESC')->first();


    $perDaySalary = round(($empBasicSalary) / $comapny->working_days, 2);



    if ($att) {


        $getSundayTodayYet = getSundaysBetween2Dates($startDate = date($att->date), $endDate = date($attLastDay->date));

        if ($att->attendance_date <= 10) {


            $totalWorkingDays = $present + $getSundayTodayYet;

            if ($totalWorkingDays >= $totalDaysOfThisMonth['totalDaysOfThisMonth']) {

                $totalWorkingDays = 30;
            }
        } else {
            //$SundaysAfterAtt = getNumberOfDays($day = $att->attendance_date, $date = date('d-m-Y'), $NameOfDay = 'sunday');
            $getSundayTodayYet = getSundaysBetween2Dates($startDate = date($att->date), $endDate = date($attLastDay->date));
            $totalWorkingDays = $present + $getSundayTodayYet;
        }



        //get emp allownce
        $totalAllow = countEmpAllownceForViews($empId);
        $calculateBasicSalary = $perDaySalary * $totalWorkingDays;

        // get expense
        $res = countEmpExpenseForViews($empId, $month, $year);
        $expense = $res['sumOfExpense'];


        $data['perDaySalary'] = $perDaySalary;
        $data['netSal'] = ($calculateBasicSalary + $expense + $totalAllow);
        $data['present'] = $present;
        $data['allowance'] = $totalAllow;
    } else {
        $data['perDaySalary'] = $perDaySalary;
        $data['netSal'] = 0;
        $data['present'] = 0;
        $data['allowance'] = 0;
    }

    return $data;
}


//countEmpExpsend
function  countEmpExpenseForViews($empId, $month, $year)
{
    $data['expense'] = Expense::where('emp_id', $empId)
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->where('status', 'approved')
        ->get();

    $data['sumOfExpense'] = Expense::where('emp_id', $empId)
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->where('status', 'approved')
        ->sum('expense_amount');
    return $data;
}

//   count allownce

function  countEmpAllownceForViews($empId, $month = Null, $year = Null)
{

    $emp = Employee::find($empId);
    $allownce = Employee_Allownce::where('emp_id', $empId)->get();
    $totalAllow = 0;
    foreach ($allownce as $allownce) {

        $allow_ids = (explode(",", $allownce->allowance_id));
        foreach ($allow_ids as $k => $val) {

            $getAllow = $allownce->amount; // $emp->gross_salary * ($allownce->amount / 100);
            $totalAllow = $totalAllow + $getAllow;
        }
    }
    return $totalAllow;
}

function updateBranchBalance($branch_id, $trans_type, $amount)
{

    $res = BankBranch::find($branch_id);

    if ($trans_type == 'cr') {
        $res->balance = $res->balance - $amount;
    } else {
        $res->balance = $res->balance + $amount;
    }
    $res->save();
    return $res->balance;
}

function updateAccountSummary($trans_id, $ac_id, $amount, $trans_type, $balance, $ac_type)
{

    ($ac_type == 'company') ? $ac_id = $ac_id : $branch_id = $ac_id;

    $summary = new AccountSummary();
    $summary->transaction_id = $trans_id;
    $summary->bank_branch_id = ($ac_type == 'bank') ? $ac_id : '';
    $summary->account_id = ($ac_type == 'company') ? $ac_id : '';
    $summary->amount = $amount;
    $summary->transaction_type = $trans_type;
    $summary->balance = $balance;
    $summary->auth_id = \Illuminate\Support\Facades\Auth::id();
    $summary->save();
}

function updateCompanyAccount($ac_id, $transType, $amount)
{

    $account = Account::find($ac_id);
    if ($transType == 'dr') {
        $account->balance = $account->balance + $amount;
    }
    if ($transType == 'cr') {
        $account->balance = $account->balance - $amount;
    }
    $account->save();
    return $account;
}

function saveNotification($sender_id, $receiver_id, $path, $message = NULL)
{

    $notification = new Notification();
    $notification->sender_id = $sender_id;
    $notification->receiver_id = $receiver_id;
    $notification->message = $message;
    $notification->is_read = 0;
    $notification->path = $path;
    $notification->save();
}


function readNotification($receiver_id, $path)
{

    //    $notification= Notification::where('receiver_id',$receiver_id)
    //        ->where('path',$path)
    //        ->update('is_read	' => 1]);

    $notification = DB::table('notifications')
        ->where('receiver_id', $receiver_id)
        ->where('path', $path)
        ->update(['is_read' => '1']);
}


function saveLeadClient($lead_id)
{
    $lead = LeadsMarketing::find(decrypt($lead_id));

    if (!$res = Client::where('email', $lead->email)->orWhere('contact', $lead->contact)->first()) {
        $client = new Client();

        $client->name = $lead->name;
        $client->email = $lead->email;
        $client->cnic = '';
        $client->contact = $lead->contact;
        $client->city = $lead->city_id;
        $client->image = '';
        $client->address = $lead->address;
        $client->open_bal = 0;
        $client->save();

        $client_id = $client->id;
    } else {
        $client_id = $res->id;
    }
    return $client_id;
}

function getTodayLeads($sender)
{
    $qry = ApprochedLeads::with('leads');
    ($sender != 'admin') ? $qry = $qry->where('agent_id', Auth::user()->account_id) : '';
    $qry = $qry->whereDate('followup_date', Carbon::now());
    $qry = $qry->where('status', 0);
    $qry = $qry->orderBy('id', 'DESC')->paginate(10);
    return $qry;
}

//getNewLeads
function getNewLeads()
{
    return $res = AssignedLeads::with('leads')->where('agent_id', Auth::user()->account_id)
        ->where('status', 0)
        ->where('type', 'lead')
        ->whereDate('created_at', Carbon::now())->orderBy('id', 'DESC')->paginate(10);
}

function getTomorrowLeads($sender)
{
    $qry = ApprochedLeads::with('leads');
    ($sender != 'admin') ? $qry = $qry->where('agent_id', Auth::user()->account_id) : '';
    $qry = $qry->where('status', 0)->where('lead_type', 0);
    $qry = $qry->whereDate('followup_date', Carbon::tomorrow());
    $qry = $qry->orderBy('id', 'DESC')->paginate(10);
    return $qry;
}

//getNotApproachedLeads

function getNotApproachedLeads($sender)
{
    $qry = AssignedLeads::with('leads');
    ($sender != 'admin') ? $qry = $qry->where('agent_id', Auth::user()->account_id) : '';
    $qry = $qry->where('status', 0);
    $qry = $qry->where('type', 'lead');
    $qry = $qry->orderBy('id', 'DESC');
    $qry = $qry->get();
    return $qry;
}

//getOverDueLeads

function getOverDueLeads($sender)
{

    $qry = ApprochedLeads::with('leads', 'leads.cityname');
    ($sender != 'admin') ? $qry = $qry->where('agent_id', Auth::user()->account_id) : '';
    $qry = $qry->whereDate('followup_date', '<', Carbon::today());
    $qry = $qry->where('status', 0);
    $qry = $qry->where('lead_type', 0);
    $qry = $qry->paginate(10);
    return  $qry;
}

function saveLedger($transaction_id, $coaHeadId, $account_id, $ac_type, $ledger_type, $amount, $current_balance=NULL, $coaLevel,$date=NULL)
{

    $ledger = new Ledger();
    $ledger->transaction_id = $transaction_id;
    $ledger->coa_head_id = $coaHeadId;
    $ledger->coa_level = $coaLevel;
    $ledger->account_id = $account_id;
    $ledger->ac_type = $ac_type;
    $ledger->ledger_type = $ledger_type;
    $ledger->amount = $amount;
    $ledger->current_balance = $current_balance;
    $ledger->date = $date;
    $ledger->save();
}


function createAPIResponce($is_error, $code, $message, $content)
{


    $result = [];
    if ($is_error) {

        $result['success'] = false;
        $result['code'] = $code;
        $result['message'] = $message;
    } else {

        $result['success'] = true;
        $result['code'] = $code;

        if ($content == null) {

            $result['message'] = $message;
        } else {
            $result['data'] = $content;
        }
    }

    return $result;
}

function getLeadAgent($lead_id)
{
    $lead = AssignedLeads::where('lead_id', $lead_id)->latest('id')->first();
    return $lead->agent_id;
}


function getTeamMember($manager_id)
{

    $member = Lead::where('leads.leader_id', $manager_id)->where('status', 1)->first();
    $member_ids = (explode(",", $member->member_id));

    $data['member'] = collect([]);
    foreach ($member_ids as $k => $val) {
        $empData = Employee::find($val);
        if ($empData) {
            $array = array(
                'id' => $empData->id,
                'name' => $empData->name,

            );
            $data['member']->push($array);
        }
    }
    return $data['member'];
}

function autoAssignLeads($lead_id)
{

    $source = SourceLeadsSettings::where('auto_save', 1)->where('is_turn', 1)->first();
    if ($source) {
        $agent_id = $source->agent_id;
        $source->is_turn = 0;
        $source_id = $source->id;

        if (!AssignedLeads::where('lead_id', $lead_id)->where('agent_id', $agent_id)->first()) {


            $lead = new AssignedLeads();
            $lead->lead_id = $lead_id;
            $lead->agent_id = $agent_id;
            $lead->type = 'lead';
            $lead->allocate_by = 'auto'; //o mean lead assign auto
            $lead->save();
            //
            $nextSource = SourceLeadsSettings::where('auto_save', 1)->where('id', '>', $source_id)->min('id');
            if ($nextSource) {
                $source->save();
                $data = SourceLeadsSettings::find($nextSource);
            } else {
                if (SourceLeadsSettings::count() > 1) {
                    $source->save();
                }
                $data = SourceLeadsSettings::where('auto_save', 1)->first();
            }
            $data->is_turn = 1;
            $data->save();
        }
    }
}


function autoAssignSurvey($servey_id)
{

    $source = SourceLeadsSettings::where('auto_save', 1)->where('is_turn', 1)->first();
    if ($source) {
        $agent_id = $source->agent_id;
        $source->is_turn = 0;
        $source_id = $source->id;

        if (!CustomerServey::where('id', $servey_id)->where('agent_id', $agent_id)->first()) {
            $survey = CustomerServey::find($servey_id);
            $survey->agent_id = $agent_id;
            $survey->save();


            $nextSource = SourceLeadsSettings::where('auto_save', 1)->where('id', '>', $source_id)->min('id');
            if ($nextSource) {
                $source->save();
                $data = SourceLeadsSettings::find($nextSource);
            } else {
                if (SourceLeadsSettings::count() > 1) {
                    $source->save();
                }
                $data = SourceLeadsSettings::where('auto_save', 1)->first();
            }
            $data->is_turn = 1;
            $data->save();
        }
    }
}


function getTargetmanager($manager_id, $target_type)
{
    $qry = Target::join('employees', 'employees.id', 'targets.manager_id');
    ($manager_id) ? $qry = $qry->where('manager_id', $manager_id) : '';
    $qry = $qry->where('manager_id', '!=', 0);
    $qry = $qry->where('target_type', $target_type);
    $qry = $qry->where('targets.created_at', '>=', Carbon::today()->subDays(30));
    $qry = $qry->select('employees.id', 'employees.name', 'targets.target_in_numbers')->get();
    return $qry;
}

function getManagerTeamAcheivements($manager_id, $target_type)
{
    ($target_type == 'sale') ? $temp_id = 9 : $temp_id = 6;
    $teamTarget = TeamTarget::where('manager_id', $manager_id)->get();
    $totalAcheive = 0;
    foreach ($teamTarget as $salesman_id) {
        $salesman_acheivements = getSalesManTargetAcheive($salesman_id->agent_id, $temp_id);
        $totalAcheive = $totalAcheive + $salesman_acheivements;
    }
    return $totalAcheive;
}
function getSalesManTargetAcheive($saleman_id, $target_type)
{
    ($target_type == 'sale') ? $temp_id = 9 : $temp_id = 6;
    $qry = ApprochedLeads::Query();
    ($temp_id == 6) ? $qry = $qry->where('agent_id', $saleman_id) : $qry = $qry->where('salesman_id', $saleman_id);
    $qry = $qry->where('temp_id', $temp_id)->count();
    return $qry;
}


function getIndividualSaleTeam($target_type)
{
    return $res = TeamTarget::join('employees', 'employees.id', 'team_targets.agent_id')
        ->where('target_type', $target_type)
        ->where('team_targets.created_at', '>=', Carbon::today()->subDays(30))
        ->select('employees.id', 'employees.name', 'team_targets.target_in_numbers')->get();
}

function todayFollowupLeads($sender, $purpose, $agent_id)
{

    $qry = ApprochedLeads::with('leads','leads.cityname')->whereDate('followup_date', date('Y-m-d'));
    $qry = $qry->where('status', 0);
    $qry = $qry->where('lead_type', 0);
    ($sender != 'admin') ? $qry = $qry->where('agent_id', $agent_id) : '';
    ($purpose == 'count') ? $qry = $qry->count() : $qry = $qry->paginate(20);
    return $qry;
}

function tommrowFollowupLeads($agent_id,$purpose)
{
    $qry = ApprochedLeads::Query();
    ($agent_id) ? $qry = $qry->where('agent_id', $agent_id) : '';
    $qry = $qry->where('status', 0)->where('lead_type', 0);
    $qry = $qry->whereDate('followup_date', Carbon::tomorrow());
    $qry = $qry->with('leads','leads.cityname');
    ($purpose=='counting')?$qry = $qry->count():$qry = $qry->paginate(50);
    return $qry;
}

//responsed leads
function responsedLeads($start_date, $end_date)
{

    $qry = LeadsMarketing::Query();
    if (($start_date and $end_date)) {
        $qry = $qry->whereDate('created_at', '>=', $start_date);
        $qry = $qry->whereDate('created_at', '<=', $end_date);
    } else {
        $qry = $qry->where('created_at', '>=', Carbon::today()->subDays(30));
    }
    $qry = $qry->select('id', 'created_at');
    $qry = $qry->orderBy('id', 'DESC')->get();
    return $qry;
}

//get csr
function getCSR()
{


    $res = User::select('account_id as id', 'name')
        ->where('status', 1)
        ->where('role_id', 4)
        ->orWhere('role_id', 7)
        ->orderBy('id', 'DESC')->get();
    return $res;
}

function saveTransLedgerUpDateBalnc($coa_head_id,$coa_level,$amount,$inv_id,$narration,$date,$customerVendorId,$ac_type,$transType,$mode){

    //update updateCustomerVendorBalance
    if($mode!='open balance') {
        $current_balance = updateCustomerVendorBalance($customerVendorId, $ac_type, $amount, $transType);
    }

    //updateHeadBalance
    $head_balance = updateAccountHeadBalance($coa_head_id, $amount,   'cr',$coa_level);

    //save transaction
    $trans_id=saveTransaction($inv_id,$mode,$file_id=NULL,$against=NULL,$location_id=1,$amount,$narration,$date,$trans_type='open balance');

    // save ledger for credits for client
    saveLedger($trans_id->id,NULL,$customerVendorId,$ac_type,$ledger_type='dr',-abs($amount),$current_balance,NULL);
    // save ledger for debits
    saveLedger($trans_id->id,$data['lHeadId'],$account_id=NULL,$ac_type='company-head',$ledger_type='cr',$amount,$head_balance,$data['coa_level']);
}
