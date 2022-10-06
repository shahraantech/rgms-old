<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\PaymentExecution;
use DB;

class PaypalController extends Controller
{

    public function index(Request $request){

        $totalAmount=50;


        $apiContext = new \PayPal\Rest\ApiContext(

            new \PayPal\Auth\OAuthTokenCredential(
                //Client Id ClientSecret sandbox
    'ATwpoligwr1OWsH9E9Q7wrO8Wo3-lGjaqNbYLlaCQj7q7bABZID0nL1Hu6sM2yiAHjuRPOrAvTWetRmg',
    'EDC5OQaKGThjcROu6R_qR3s1mZJ3CKfgeoQnFi_EaNGvFY8wBDzpMwIXHnLTYYxyqwABCtVAVy0OjD8I'

               //Client Id ClientSecret Live
//'AeqBv42p1Kw8G51D1D3SWmCc_NrpQG_HYn9Peo3sEBpIgvyVCOOkFqvMefKv8oAJ9n674vb12v8ZfltT',
//'EGwF4y_Kb0s5M_RcZcJalizLLgQ04uioznCz1oyaty-LOMUIxN_x2Pf4QMSh4AnssoD2D6XngVDu_NaY'
            )
        );

        $apiContext->setConfig([
         'mode' => 'sandbox',
        ]);
        // After Step 2
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($totalAmount);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal_return'))
            ->setCancelUrl(route('paypal_cancel'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        // After Step 3
        try {
            $payment->create($apiContext);
            echo $payment;
            echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
            return redirect($payment->getApprovalLink());
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData();
        }
    }

    //paypal

    public function paypal(Request $request){

      return view('paypal');
    }

    public function paypalReturn(Request $request){

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(

     //  ClientID ClientSecret Sandbox
    'ATwpoligwr1OWsH9E9Q7wrO8Wo3-lGjaqNbYLlaCQj7q7bABZID0nL1Hu6sM2yiAHjuRPOrAvTWetRmg',
    'EDC5OQaKGThjcROu6R_qR3s1mZJ3CKfgeoQnFi_EaNGvFY8wBDzpMwIXHnLTYYxyqwABCtVAVy0OjD8I'

               //  ClientID ClientSecret Live
//'AeqBv42p1Kw8G51D1D3SWmCc_NrpQG_HYn9Peo3sEBpIgvyVCOOkFqvMefKv8oAJ9n674vb12v8ZfltT',
//'EGwF4y_Kb0s5M_RcZcJalizLLgQ04uioznCz1oyaty-LOMUIxN_x2Pf4QMSh4AnssoD2D6XngVDu_NaY'
            )
        );

        $apiContext->setConfig([
         'mode' => 'sandbox',
        ]);
//        dd(\request()->all());
        // Get payment object by passing paymentId
        $paymentId = $_GET['paymentId'];
        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
        $payerId = $_GET['PayerID'];

// Execute payment with payer ID
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            // Execute payment
            $result = $payment->execute($execution, $apiContext);
            dd($result);

            $student_id = session()->get('student_id');
            $course_packege_id = session()->get('course_packege_id');

          $res=DB::table('users')->where('id',$student_id)->first();
          $country=$res->country;
            $f=DB::table('course_packege')->where('id',$course_packege_id)->first();
       $fee=$f->fee;
            $vat=0;
            $vat_amount=0;
            if($country=='uk'){
                $vat=20;
                 $vat_amount=number_format(($fee /120*20),2);
            }

             $data=array(
                 'user_id'=>$student_id,
                 'package_id'=>$course_packege_id,
                 'txn_id'=>$result->id,
                 'payment_method'=>'paypal',
                 'status'=>'paid',
                 'vat'=>$vat,
                 'vat_amount'=>$vat_amount
             );

            $res=DB::table('payments')->InsertGetId($data);
            if($res){

            DB::table('users')->where('id',$student_id)->update(['status'=>'active']);
        // $request->session()->forget('student_id');
        //$request->session()->forget('course_packege_id');

              $request->session()->flush();

                return redirect('invoice/'.md5($student_id));
            }
            else{
                return "amount not  paid ";
            }

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        }
    }
    public function paypalCancel(){
        return "order canceled";
    }

}




