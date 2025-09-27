<?php

namespace App\Http\Controllers;

use App\Models\Contract;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::included()->filter()->sort()->getOrPaginate();
        return response()->json($contracts);
    }

    public function edit(Contract $contract)
    {
        //
    }

    public function show(Contract $contract)
    {
        return response()->json($contract);
    }

    public function update(Request $request, Contract $contract)
    {
        $contract->update($request->all());
        return response()->json($contract);
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return response()->json(['message' => 'Contrato eliminado con éxito']);
    }

}
