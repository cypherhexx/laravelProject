<?php 
namespace App\Services\PaymentGateway;

use App\Services\PaymentGateway\Contracts\GatewayContract;
use App\Invoice;
use Illuminate\Http\Request;
use App\Services\PaymentGateway\Contracts\PaymentBean;

class PayMe implements GatewayContract {

	
	function unique_identifier_id() : string
	{
		return 'payme';
	}

	function display_name() : string
	{
		return __('form.payme');
	}

	public function view_file_for_settings_page() : string 
	{

		return 'payment.modes.online.payme';
	}
	
	
	function validation_rules() : array
	{
		return [
            'settings.payme_label'                 => 'required',
            'settings.payme_username'              => 'required',
            'settings.payme_password'              => 'required',
            'settings.payme_signature'             => 'required',
        ];
	}


	function validation_messages() : array
	{
		return [
            'settings.payme_label.required'         => sprintf(__('form.field_is_required'), __('form.label')),
            'settings.payme_username.required'      => sprintf(__('form.field_is_required'), __('form.payme_username')),
            'settings.payme_password.required'      => sprintf(__('form.field_is_required'), __('form.payme_password')),
            'settings.payme_signature.required'     => sprintf(__('form.field_is_required'), __('form.payme_signature')),
        ];
	}


	public function form_input_field_name_gateway_name() : string 
	{
		return 'payme_label';
	}

	public function form_input_field_name_gateway_status() : string 
	{
		return 'payme_active';
	}

	
	function process_payment(Invoice $invoice, $data)
	{
		//return redirect()->away('https://www.sandbox.payme.com');
		return view('payment.modes.online.checkout.payme', compact('data'))->with('invoice', $invoice);
	}


	 function charge(Invoice $invoice, $amount)
    {
    	$paymentBean = new PaymentBean();
    	$api_credentials = get_payment_gateway_info('payme') ;
    	error_log(json_encode($api_credentials));
    	error_log("credentialss");
    	$note = "";
    	$api_response 		= [ 'email' => $api_credentials->payme_username ,'response' => "" ];
    	$reference = NULL;
        $paymentBean->date(date("Y-m-d"))
                    ->amount($amount)
                    ->payment_mode_id($api_credentials->payment_mode_id)
                    ->reference($reference)
                    ->note($note);
                   

        $payment = $invoice->payment_received($paymentBean);  

        return TRUE;
    }
       
}