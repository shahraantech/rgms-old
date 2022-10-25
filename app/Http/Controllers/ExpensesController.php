<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountHead;
use App\Models\Applicant;
use App\Models\BankBranch;
use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Employee;
use App\Models\ExpenseHead;
use App\Models\Ledger;
use App\Models\Level_1;
use App\Models\Level_4;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Expense_head;
use Google\Service\CloudSourceRepositories\Repo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Validator;
use Redirect;

class ExpensesController extends Controller
{

    protected $userId;

    public function __construct()
    {

        $this->middleware(function (Request $request, $next) {
            if (!\Auth::check()) {
                return redirect('/login');
            }
            $this->userId = \Auth::user()->account_id; // you can access user id here

            return $next($request);
        });
    }


    //index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $qry = Expense::join('employees', 'employees.id', '=', 'expenses.emp_id')
                ->join('designations', 'designations.id', '=', 'employees.desg_id')
                ->select('employees.name', 'employees.image', 'designations.desig_name', 'expenses.*')
                ->orderBy('expenses.id', 'DESC');

            $qry->when($request->company_id, function ($query, $company_id) {
                return $query->where('employees.company_id', $company_id);
            });

            $qry->when($request->name, function ($query, $name) {
                return $query->where('employees.name', $name);
            });

            $data = $qry->get();
            return response()->json($data);
        }

        $data['company'] = Company::all();
        return view('expenses.index', compact('data'));
    }

    //myExpenses

    public function myExpenses()
    {
        return view('expenses.my-expences');
    }


    //saveMyExpenses
    public function saveMyExpenses(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'exp_type' => 'required',
            'cost' => 'required',
            'period' => 'required',
            'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000'

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }


        if ($request->hasFile('file')) {
            $uniqueid = uniqid();
            $original_name = $request->file('file')->getClientOriginalName();
            $size = $request->file('file')->getSize();
            $extension = $request->file('file')->getClientOriginalExtension();
            $name = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
            $imagepath = url('/storage/uploads/expense-bills/' . $name);
            $path = $request->file('file')->storeAs('public/uploads/expense-bills/', $name);

            $exp = new Expense();

            $exp->emp_id = $this->userId;
            $exp->expense_type = $request->exp_type;
            $exp->expense_amount = $request->cost;
            $exp->expense_bill = $name;
            $exp->expense_period = $request->period;
            $exp->expense_desc = $request->desc;
            $exp->status = 'pending';

            $exp->save();


            return response()->json(['success' => 'Record save successfully'], 200);
        }
    }

    //getMyExpenseList
    public function getMyExpenseList()
    {
        echo json_encode(Expense::where('emp_id', $this->userId)->orderBy('id', 'DESC')->get());
    }

    public function editExpense(Request $request)
    {
        $exp = Expense::find($request->id);
        return $exp;
    }


    //update expense
    public function updateExpense(Request $request)
    {
        $exp = Expense::find($request->expense_id);
        $exp->expense_type = $request->exp_type;
        $exp->expense_amount = $request->cost;
        $exp->expense_period = $request->period;
        $exp->expense_desc = $request->desc;

        if ($request->hasFile('file')) {

            $path = 'storage/app/public/uploads/expense-bills/' . $exp->expense_bill;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('storage/app/public/uploads/expense-bills/', $filename);
            $exp->expense_bill = $filename;
        }

        $exp->update();
        return response()->json([
            'status' => 200,
            'message' => 'expnse updated successfully'
        ]);
    }

    //delete expense
    public function deleteExpense(Request $request)
    {
        $exp = Expense::find($request->id);
        if ($exp) {
            $path = 'storage/app/public/uploads/expense-bills/' . $exp->expense_bill;
            if (File::exists($path)) {
                File::delete($path);
            }
            $exp->delete();
            return response()->json([
                'status' => 200,
                'message' => 'expanese deleted Successfully',
            ]);
        }
    }

    //updateExpenseStatus
    public  function updateExpenseStatus(Request $request)
    {

        $data = $request->all();
        $rules = array(
            'id' => 'required',
            'status' => 'required',

        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {

            return response()->json(['errors' => $validator->errors()]);
        }


        $exp = Expense::find($request->id);
        $exp->status = $request->status;

        if ($exp->save()) {
            return response()->json(['success' => 'Record updated successfully'], 200);
        }
    }


    //financeExpense

    public function financeExpense(Request $request)
    {
        if ($request->isMethod('post')) {
            $exp_head = new Expense_head();
            $exp_head->exp_head = $request->exp_head;
            if ($exp_head->save()) {
                return response()->json(['success' => 'expense head added successfully'], 200);
            }
        }


        return view('accounts.expense.finance-expense');
    }


    //financeExpenseList

    public  function financeExpenseList(Request $request)
    {
        return view('accounts.expense.finance-expense-list');
    }
    //manageExpense
    public  function manageExpense(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->all();
            $input = $request->all();
            $rules = array(
                'remarks' => 'required',
                'amount' => 'required',
            );

            $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

            $comAcId = $request->company_account_id;
            $exp_date = $request->exp_date;

            if ($request->trans_mode == 'cash') {
                $availBalance = Ledger::countAccountsBalance('company-account', $comAcId);
                if ($availBalance < $request->grand_total) {
                    return response()->json(['error' => 'Insufficient Balance'], 200);
                }
            }
            if ($request->trans_mode == 'bank') {
                $availBalance = Ledger::countAccountsBalance('bank', $request->bank_id);
                if ($availBalance < $request->grand_total) {
                    return response()->json(['error' => 'Insufficient Balance'], 200);
                }
            }
            $attachement = '';
            if ($request->hasFile('file')) {
                $attachement = base64_encode(file_get_contents($request->file('file')));
            }
            $res = '';
            if ($input['remarks'] != '') {
                for ($c = 0; $c < count($input['remarks']); $c++) {
                    if ($input['amount'][$c]) {
                        $location_id = Employee::getEmpBranchId();
                        $trans_id = saveTransaction(0, $mode = 'expense', $file_id = NULL, $against = NULL, $location_id, $input['amount'][$c], $input['remarks'][$c], $exp_date, $trans_type = 'expense', '', $attachement);
                        if ($request->trans_mode == 'cash') {
                            // save ledger for credits company ac
                            $acHead = Account::getAccountHeadId($comAcId);
                            saveLedger($trans_id->id, $acHead['lHeadId'], $comAcId, $ac_type = 'company-account', $ledger_type = 'cr', $input['amount'][$c], 0, $acHead['coa_level']);
                        }
                        if ($request->trans_mode == 'bank') {
                            // save ledger for credits Banks
                            $data = Account::getBankHeadId($request->bank_id);
                            saveLedger($trans_id->id, $data['lHeadId'], $request->bank_id, $ac_type = 'bank', $ledger_type = 'cr', $input['amount'][$c], 0, $data['coa_level']);
                        }
                        // save ledger for debits
                        $res = saveLedger($trans_id->id, $input['exp_head_id'][$c], $companyAcId = NULL, $ac_type = 'company-head', $ledger_type = 'dr', $input['amount'][$c], 0, 4);
                    }
                }
            }
            if ($res) {
                return response()->json(['success' => 'Expense Added Successfully'], 200);
            }
        }
        $data['l1Head'] = Level_1::getLevel1();
        $data['level4'] = Level_1::getLevel4();
        $data['accounts'] = Account::getAccounts();
        $data['banks'] = BankBranch::getBankBranches();

        return view('accounts.expense.manage-expense')->with(compact('data'));
    }
    //expenseSummary
    public  function expenseSummary(Request $request)
    {
        $fromDate = date('Y-m-d');
        $toDate = date('Y-m-d');

        if ($request->isMethod('post')) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;
        }

        $data['exp'] = Transaction::getExpenseTransaction($fromDate, $toDate);
        $data['from_date'] = $fromDate;
        $data['to_date'] = $toDate;
        return view('accounts.expense.expense-summary')->with(compact('data'));
    }
    //printExpenseSummary
    public  function printExpenseSummary($fromDate, $toDate, $account_id)
    {
        $data['balance'] = Ledger::countAccountsBalance('company-account', $account_id);
        $data['exp'] = Transaction::getExpenseTransaction($fromDate, $toDate);
        $data['account_id'] = $account_id;
        $data['from'] = $fromDate;
        $data['to'] = $toDate;
        return view('accounts.printer.print-expense-summary')->with(compact('data'));
    }
    public  function editExpenseSummary(Request $request)
    {

        $trans_id = $request->id;
        $qry = Transaction::query();
        $qry = $qry->join('ledgers', 'transactions.id', 'ledgers.transaction_id');
        $qry = $qry->select('ledgers.amount', 'transactions.desc', 'transactions.date', 'ledgers.coa_level', 'coa_head_id', 'transactions.id');
        $qry = $qry->where('transactions.id', $trans_id);
        $qry = $qry->where('ledgers.ac_type', 'company-head');
        $data['exp'] = $qry->first();

        $data['exp_head'] = Level_4::all();
        return $data;
    }
    //expnse head list
    public function expenseList(Request $request)
    {
        if ($request->ajax()) {
            $exp = Expense_head::all();
            return response()->json($exp);
        }
        return view('accounts.expense.expense-list');
    }
    //expnse head edit
    public function expenseHeadEdit(Request $request)
    {
        $exp_head = Expense_head::find($request->id);
        return response()->json($exp_head);
    }
    //expnse head update
    public function expenseHeadUdpate(Request $request)
    {
        $exp_head = Expense_head::find($request->expense_head_id);
        $exp_head->exp_head = $request->exp_head;
        if ($exp_head->save()) {
            return response()->json(['success' => 'expense head udpated successfully'], 200);
        }
    }
    //expnse head delete
    public function expenseHeadDelete(Request $request)
    {
        $exp_head = Expense_head::find($request->id);
        if ($exp_head->delete()) {
            return response()->json(['success' => 'expense head udpated successfully'], 200);
        }
    }

    //expnse summary delete
    public function expenseSummaryDelete(Request $request)
    {
        $exp_head = Expense::find($request->id);
        if ($exp_head->delete()) {
            return response()->json(['success' => 'expense summary deleted successfully'], 200);
        }
    }


    //expnse summary update
    public function expenseSummaryUpdate(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'edit_exp_head_id' => 'required',
            'edit_date' => 'required',
            'edit_amount' => 'required',
            'edit_remarks' => 'required',
        );
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $transId = $request->hidden_trans_id;
        $amount = $request->edit_amount;
        $tran = Transaction::find($transId);
        $tran->amount = $amount;
        $tran->desc = $request->edit_remarks;
        $tran->date = $request->edit_date;
        if ($request->hasFile('file')) {
            $tran->attachement = base64_encode(file_get_contents($request->file('file')));
        }

        if ($tran->save()) {
            $led = Ledger::where('transaction_id', $transId)->where('ac_type', 'company-account')->orWhere('ac_type', 'bank')->first();
            $led->amount = $amount;
            $led->save();

            $le = Ledger::where('transaction_id', $transId)->where('ac_type', 'company-head')->first();
            $le->amount = $amount;
            $le->coa_head_id = $request->edit_exp_head_id;
            $le->save();

            return response()->json(['success' => 'Record updated successfully'], 200);
        }
    }

    public function Chart()
    {
        return view('accounts.expense.chart');
    }
}
