<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // $payments = Payment::included()->get();
        // return response()->json($payments);

        $payments = Payment::included()->filter()->get();
        return response()->json($payments);
    }

    public function show(Payment $payment)
    {
        //
    }

    public function edit(Payment $payment)
    {
        //
    }

    public function update(Request $request, Payment $payment)
    {
        //
    }

    public function destroy(Payment $payment)
    {
        //
    }
}
