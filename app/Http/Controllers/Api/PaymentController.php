<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function initialize(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'email' => 'required|email',
                'domain' => 'required|string',
                'amount' => 'required|numeric|min:1',
            ]);

            // Generate a unique reference
            $reference = Paystack::genTranxRef();

            // Create a new transaction record
            $transaction = Transaction::create([
                'email' => $validatedData['email'],
                'domain' => $validatedData['domain'],
                'amount' => $validatedData['amount'],
                'reference' => $reference,
            ]);

            $data = [
                'amount' => $validatedData['amount'] * 100, // amount in kobo
                'email' => $validatedData['email'],
                'reference' => $reference,
            ];

            Log::info(config('app.frontend_url'));

            // Generate the Paystack authorization URL with the transaction reference
            $authorizationUrl = Paystack::getAuthorizationUrl($data);

            return response()->json([
                'authorization_url' => $authorizationUrl,
            ]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Payment initialization error: ', ['error' => $e->getMessage()]);
            // Return a response indicating failure
            return response()->json(['error' => 'Payment initialization failed.'], 500);
        }
    }


    public function callback(Request $request)
    {
        try {
            $paymentDetails = Paystack::getPaymentData();

            $transaction = Transaction::where('reference', $paymentDetails['data']['reference'])->first();

            if ($paymentDetails['data']['status'] === 'success') {
                $transaction->status = 'success';
            } else {
                $transaction->status = 'failed';
            }

            $transaction->save();

            $frontendUrl = config('app.frontend_url') . '/payment-status';
            return Redirect::to("{$frontendUrl}?status={$transaction->status}&reference={$transaction->reference}");
        } catch (\Exception $e) {
            Log::error('Payment callback error: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Payment verification failed.'], 500);
        }
    }
}
