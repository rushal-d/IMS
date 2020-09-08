<?php

namespace App\Http\Controllers;

use App\BankMerger;
use App\Deposit;
use App\InvestmentInstitution;
use App\MergeBankList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankMergerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankMergers = BankMerger::with('mergeBankList')->latest()->paginate(50);
        $data['bankMergers'] = $bankMergers;
        return view('bankmerger.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutions = InvestmentInstitution::groupBy('institution_code')->where('invest_type_id', 2)->pluck('institution_name', 'institution_code');
        $data['institutions'] = $institutions;
        return view('bankmerger.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'bank_code_after_merger' => 'required',
            'merger_date' => 'required',
            'bank_code' => 'required',
        ],
            [
                'bank_code_after_merger.required' => 'After Merged Bank Code Is Required',
                'merger_date.required' => 'Merge Date is required',
                'bank_code.required' => 'Merged Bank List is required',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }
        try {
            $status = false;
            DB::beginTransaction();
            $allInstitutions = InvestmentInstitution::get();
            $institutions = InvestmentInstitution::groupBy('institution_code')->pluck('institution_name', 'institution_code')->toArray();
            $input['bank_name_after_merger'] = $institutions[$input['bank_code_after_merger']];
            $bankMerger = BankMerger::create($input);
            if (count(array_filter($input['bank_code'])) < 2) {
                $error[] = 'Atleast two bank are required for merger.';
                $notification = array(
                    'message' => 'error',
                    'alert-type' => 'Error Occured! Try Again!',
                );
                return redirect()->back()->withInput()->withErrors($error)->with($notification);
            }
            foreach ($input['bank_code'] as $bank_code) {
                $input['bank_merger_id'] = $bankMerger->id;
                $input['bank_code'] = $bank_code;
                $input['bank_name'] = $institutions[$bank_code];
                MergeBankList::create($input);
                //do not add mergerd flag if the institution is the acquirer
                if (strtolower($input['bank_code_after_merger']) != strtolower($bank_code)) {
                    $investmentInstitutionsMerged = $allInstitutions->where('institution_code', $bank_code);
                    foreach ($investmentInstitutionsMerged as $mergedInstitution) {
                        $after_merged_institution = $allInstitutions->where('invest_type_id', $mergedInstitution->invest_type_id)
                            ->where('institution_code', $input['bank_code_after_merger'])->first();
                        $mergedInstitution->is_merger = 1;
                        $mergedInstitution->merger_date = $input['merger_date'];
                        $mergedInstitution->merger_display_id = $after_merged_institution->id;
                        $mergedInstitution->bank_merger_id = $bankMerger->id;
                        $mergedInstitution->save();
                    }

                    $mergingInstitution = $allInstitutions->where('invest_type_id', 2)
                        ->where('institution_code', $bank_code)->first();
                    //set merger effect record flag on deposit
                    if (!empty($mergingInstitution)) {
                        Deposit::withoutGlobalScope('is_pending')->where('institution_id', $mergingInstitution->id)
                            ->whereDate('trans_date_en', '<=', $bankMerger->merger_date)->whereDate('mature_date_en', '>=', $bankMerger->merger_date)
                            ->update(['bank_merger_id' => $bankMerger->id]);
                    }

                }
                $status = true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $status = false;
        }
        DB::commit();
        $status = ($status) ? 'success' : 'error';
        $mesg = ($status) ? 'Added Successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('bank-merger.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\BankMerger $bankMerger
     * @return \Illuminate\Http\Response
     */
    public function show(BankMerger $bankMerger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\BankMerger $bankMerger
     * @return \Illuminate\Http\Response
     */
    public function edit(BankMerger $bankMerger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\BankMerger $bankMerger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankMerger $bankMerger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\BankMerger $bankMerger
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankMerger $bankMerger)
    {
        //
    }

    public function checkIfMergerBankExists(Request $request)
    {
        $acquiringBank = $request->acquiringBank;
        $mergingBanks = $request->mergingBanks;
        $mergerDate = $request->mergerDate;

        $allInstitutions = InvestmentInstitution::get();
        $merginBankBondExists = $merginBankDepositExists = $merginBankShareExists = 0;
        $bondOrganizationNotExisting = $depositOrganizationNotExisting = $shareOrganizationNotExisting = [];
        foreach ($mergingBanks as $mergingBank) {

            //counting bond organization if it exists
            if (!empty($allInstitutions->where('institution_code', $mergingBank)->where('invest_type_id', 1)->first())) {
                $merginBankBondExists++;
            } else {
                //if not found the merging organization then list it
                $bondOrganizationNotExisting[] = $mergingBank;
            }
            //counting deposit organization if it exists
            $depositInstitution = $allInstitutions->where('institution_code', $mergingBank)->where('invest_type_id', 2)->first();
            if (!empty($depositInstitution)) {
                $merginBankDepositExists++;
                //deposits which has transaction date greater than or equals to merger date
                $depositsAfterMerger = Deposit::where('institution_id', $depositInstitution->id)->whereDate('trans_date_en', '>=', $mergerDate)->get();
                foreach ($depositsAfterMerger as $depositAfterMerger) {
                    $error[] = $mergingBank . ' Bank has deposit at: ' . $depositAfterMerger->trans_date_en . ' which is after merger date.';

                }
            } else {
                //if not found the merging organization then list it
                $depositOrganizationNotExisting[] = $mergingBank;
            }

            //counting share organization if it exists
            if (!empty($allInstitutions->where('institution_code', $mergingBank)->where('invest_type_id', 3)->first())) {
                $merginBankShareExists++;
            } else {
                //if not found the merging organization then list it
                $shareOrganizationNotExisting[] = $mergingBank;
            }
        }
        $error = [];
        //if all merger banks are found then check the aquiring bank
        if ($merginBankBondExists == count($mergingBanks)) {
            if (empty($allInstitutions->where('institution_code', $acquiringBank)->where('invest_type_id', 1)->first())) {
                $error[] = 'Bond Organization with code ' . $acquiringBank . ' is not added yet.';
            }
        } elseif ($merginBankBondExists != 0) {
            //if the all the merging banks are not found but some are found then
            $error[] = 'Bond Organization with code ' . implode(',', $bondOrganizationNotExisting) . ' is not added yet';
        }
        //if all merger banks are found then check the aquiring bank
        if ($merginBankDepositExists == count($mergingBanks)) {
            if (empty($allInstitutions->where('institution_code', $acquiringBank)->where('invest_type_id', 2)->first())) {
                $error[] = 'Deposit Organization with code ' . $acquiringBank . ' is not added yet.';
            }
        } elseif ($merginBankDepositExists != 0) {
            //if the all the merging banks are not found but some are found then
            $error[] = 'Deposit Organization with code ' . implode(',', $depositOrganizationNotExisting) . ' is not added yet';
        }
        //if all merger banks are found then check the aquiring bank
        if ($merginBankShareExists == count($mergingBanks)) {
            if (empty($allInstitutions->where('institution_code', $acquiringBank)->where('invest_type_id', 3)->first())) {
                $error[] = 'Share Organization with code ' . $acquiringBank . ' is not added yet.';
            }
        } elseif ($merginBankShareExists != 0) {
            //if the all the merging banks are not found but some are found then
            $error[] = 'Share Organization with code ' . implode(',', $shareOrganizationNotExisting) . ' is not added yet';
        }

        return response()->json([
            'errors' => $error
        ]);
    }
}
