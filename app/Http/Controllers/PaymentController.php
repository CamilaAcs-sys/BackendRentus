<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::included()->filter()->sort()->getOrPaginate();
        return response()->json($payments);
    }

    public function edit(Payment $payment)
    {
        //
    }
    public function show(Payment $payment)
    {
         return response()->json($payment);
    }

    public function update(Request $request, Payment $payment)
    {
          $payment->update($request->all());
          return response()->json($payment);
    }

    public function destroy(Payment $payment)
    {
          $payment->delete();
         return response()->json(['message' => 'Pago eliminado con éxito']);
    }

}
