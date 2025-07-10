<?php

namespace App\Http\Controllers;

use App\Models\Contract;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {

        // $contracts = Contract::included()->get();
        // return response()->json($contracts);

        $contracts = Contract::included()->filter()->get();
        return response()->json($contracts);
    }

    public function show(Contract $contract)
    {
        //
    }

    public function edit(Contract $contract)
    {
        //
    }

    public function update(Request $request, Contract $contract)
    {
        //
    }

    public function destroy(Contract $contract)
    {
        //
    }
}
