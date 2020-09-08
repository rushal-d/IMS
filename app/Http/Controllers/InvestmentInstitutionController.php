<?php

namespace App\Http\Controllers;

use App\InvestmentInstitution;
use App\InvestmentSubType;
use App\InvestmentType;
use Illuminate\Http\Request;
use App\InvestmentGroup;
use Goutte\Client;
use Illuminate\Support\Facades\DB;

class InvestmentInstitutionController extends Controller
{
    /**
     *
     */
    public function _construct()
    {

    }

    public function bond()
    {
        $type_id = InvestmentType::InvestmenttypeBond();
        $all_groups = InvestmentType::findorFail($type_id)->investment_group;
        $all_sectors = InvestmentSubType::all();
        $invest_type = "Bond";
        $investmentinstitutes = InvestmentInstitution::where('invest_type_id', $type_id)->get();
        return view('investmentinstitute.index', compact('type_id', 'all_groups', 'investmentinstitutes', 'invest_type', 'all_sectors'));

    }

    /**
     *
     */
    public function deposit()
    {
        $type_id = InvestmentType::InvestmenttypeDeposit();
//        $all_groups = InvestmentType::findorFail($type_id)->investment_group;
        $all_groups = InvestmentGroup::all();
        $all_sectors = InvestmentSubType::all();
        $invest_type = "Deposit";
        $investmentinstitutes = InvestmentInstitution::where('invest_type_id', $type_id)->get();
        return view('investmentinstitute.index', compact('type_id', 'all_groups', 'investmentinstitutes', 'invest_type', 'all_sectors'));
    }

    /**
     *
     */
    public function share()
    {
        $type_id = InvestmentType::InvestmenttypeShare();
        $all_groups = InvestmentGroup::all();
        $all_sectors = InvestmentSubType::all();
        $invest_type = "Share";
        $investmentinstitutes = InvestmentInstitution::with('invest_group')->where('invest_type_id', $type_id)->get();
        return view('investmentinstitute.index', compact('type_id', 'all_groups', 'investmentinstitutes', 'invest_type', 'all_sectors'));
    }

    /**
     *
     */
    public function updatesharetable()
    {
        $ga1 = InvestmentGroup::isGA_1();
        $ga2 = InvestmentGroup::isGA_2();
        $ga3 = InvestmentGroup::isGA_3();
        $ga4 = InvestmentGroup::isGA_4();
        $ga5 = InvestmentGroup::isGA_5();
        $share_id = InvestmentType::InvestmenttypeShare();
        $all_groups = InvestmentGroup::all();
        $type_id = $share_id;

        $client = new Client();
        $crawler = $client->request('GET', 'http://www.nepalstock.com/company?_limit=500');

        $nodeValues = $crawler->filter('table tr')->each(function ($node) {
            return $node->text();
        });
        $investment_institutions = InvestmentInstitution::where('invest_type_id', 3)->get();

        $arrayoflists = [];

        foreach ($nodeValues as $nodeValue) {
            $arrayoflists[] = $nodeValue;
        }

        $mainarray = [];

        foreach ($arrayoflists as $arrayoflist) {
            $childarray = [];
            $main = explode("\n", $arrayoflist);
            foreach ($main as $m) {
                $m = trim($m, ' ');
                if (!empty($m)) {
                    if (strpos($m, 'Stock Name') !== false) {
                        continue;
                    }
                    $childarray[] = $m;
                }
            }
            if (count($childarray) == 5 or count($childarray) == 6) {
                $mainarray[] = $childarray;
            }
        }

        $array_order = array();
        foreach ($mainarray as $child) {
            $childarrayone = [];
            if (count($child) == 5) {
                $childarrayone['institution_name'] = $child[1];
                $childarrayone['institution_code'] = $child[2];
                $childarrayone['description'] = $child[3];

            } else {
                $childarrayone['institution_name'] = $child[2];
                $childarrayone['institution_code'] = $child[3];
                $childarrayone['description'] = $child[4];
            }

            /*for ga-1*/
            if (
                strpos($childarrayone['description'], 'Commercial Banks') !== false or
                strpos($childarrayone['description'], 'Finance') !== false or
                strpos($childarrayone['description'], 'Development Bank') !== false or
                strpos($childarrayone['description'], 'Microfinance') !== false
            ) {
                $childarrayone['invest_group_id'] = 9;
            }
            /*for ga-3*/
            if (
                strpos($childarrayone['description'], 'Hotels') !== false or
                strpos($childarrayone['description'], 'Others') !== false or
                strpos($childarrayone['description'], 'Insurance') !== false or
                strpos($childarrayone['description'], 'Preferred Stock') !== false or
                strpos($childarrayone['description'], 'Manufacturing And Processing') !== false or
                strpos($childarrayone['description'], 'Trading') !== false
            ) {
                $childarrayone['invest_group_id'] = 9;
            }
            /*for ga-4*/
            if (
                strpos($childarrayone['description'], 'Corporate Debenture') !== false
            ) {
                $childarrayone['invest_group_id'] = 15;
            }

            if (
                strpos($childarrayone['description'], 'Hydro Power') !== false
            ) {
                $childarrayone['invest_group_id'] = 12;
            }

            /*for ga-5*/
            if (
                strpos($childarrayone['description'], 'Others') !== false or
                strpos($childarrayone['description'], 'Mutual Fund') !== false
            ) {
                $childarrayone['invest_group_id'] = 13;
            }

            $childarrayone['invest_type_id'] = $share_id;
            $array_order[] = $childarrayone;
        }

        foreach ($array_order as $item) {
            $check_if_institution = $investment_institutions->where('institution_code', $item['institution_code'])->first();
            if (empty($check_if_institution)) {
                InvestmentInstitution::insert($item);
            }
        }

        $invest_type = "Share";
        $investmentinstitutes = InvestmentInstitution::where('invest_type_id', $type_id)->get();
        return view('investmentinstitute.index', compact('type_id', 'all_groups', 'investmentinstitutes', 'invest_type'));
    }

    public function updatePromoterShare()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://www.nepalstock.com/promoter-share?_limit=500');
        $nodeValues = $crawler->filter('table tr')->each(function ($node) {
            return $node->text();
        });
        $investment_institutions = InvestmentInstitution::where('invest_type_id', 3)->get();
        foreach ($nodeValues as $nodeValue) {
            //creating an array of the node record
            $record = explode("\n", $nodeValue);
            //trim the white space and removing empty values using array_filter
            $record = array_filter(array_map('trim', $record));
            if (count($record) == 5) {
                //since the investment group is not found on the list of promoter share we cheched it from institution name of listed comapnay to find group
                //idea flopped
                /*$bank_name_to_be_matched=trim($record[5],'Promoter Share');
               $matched_institution=$investment_institutions->where('institution_name',$bank_name_to_be_matched)->first();*/
                $input = array();
                //check if institution with code already exists
                $record = array_values($record);
                if (isset($record[3])) {
                    $check_if_institution = $investment_institutions->where('institution_code', $record[3])->first();
                    if (empty($check_if_institution)) {
                        $input['institution_name'] = $record[2];
                        $input['institution_code'] = $record[3];
                        $input['invest_type_id'] = 3;
                        $input['invest_group_id'] = 10;
                        InvestmentInstitution::create($input);
                    }
                }

            }
        }

        return redirect()->route('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$all_groups = InvestmentType::findorFail($investmentinstitution->invest_type_id)->investment_group;
        $investmentinstitutes = InvestmentInstitution::where('invest_type_id', $investmentinstitution->invest_type_id)->get();
        return view('investmentinstitute.edit',compact('all_groups','investmentinstitutes','investmentinstitution'));.
        */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
//            'institution_code' => 'required | unique:investment_institutions',
            'invest_group_id' => 'required',
        ]);

        $input = $request->all();
        $investment_institution_exists = InvestmentInstitution::where('institution_code', $input['institution_code'])->where('invest_type_id', $input['invest_type_id'])->exists();
        if (!$investment_institution_exists) {
            InvestmentInstitution::create($input);
            $notification = array(
                'message' => 'Data Added Successfully',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Institution Code Already Exist',
                'alert-type' => 'error'
            );
        }
        $bond_id = InvestmentType::InvestmenttypeBond();
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $share_id = InvestmentType::InvestmenttypeShare();
        if ($input['invest_type_id'] == $bond_id) {
            $route = "bonds.index";
        } elseif ($input['invest_type_id'] == $deposit_id) {
            $route = "deposits.index";
        } elseif ($input['invest_type_id'] == $share_id) {
            $route = "shares.index";
        }
        return redirect()->route($route)->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\InvestmentInstitution $investmentInstitution
     * @return \Illuminate\Http\Response
     */
    public function show(InvestmentInstitution $investmentInstitution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param InvestmentInstitution $investmentinstitution
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestmentInstitution $investmentinstitution)
    {
        $all_groups = InvestmentType::findorFail($investmentinstitution->invest_type_id)->investment_group;
        $all_sectors = InvestmentSubType::all();
//        dd($all_sectors);
        $investmentinstitutes = InvestmentInstitution::where('invest_type_id', $investmentinstitution->invest_type_id)->get();
        return view('investmentinstitute.edit', compact('all_groups', 'investmentinstitutes', 'investmentinstitution', 'all_sectors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param InvestmentInstitution $investmentinstitution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestmentInstitution $investmentinstitution)
    {
        $this->validate($request, [
            'institution_code' => 'required',
            'invest_group_id' => 'required',
        ]);

        $bond_id = InvestmentType::InvestmenttypeBond();
        $deposit_id = InvestmentType::InvestmenttypeDeposit();
        $share_id = InvestmentType::InvestmenttypeShare();
        $input = $request->all();

        $check_if_code_exists = InvestmentInstitution::where('institution_code', $input['institution_code'])->where('id', '<>', $investmentinstitution->id)->where('invest_type_id', $input['invest_type_id'])->exists();
        if ($check_if_code_exists) {
            $notification = array(
                'message' => 'Code Already exists',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }


        $status_mesg = $investmentinstitution->update($input);

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Data updated Successfully' : 'Error Occured! Try Again!';

        if ($input['invest_type_id'] == $bond_id) {
            $route = "bonds.index";
        } elseif ($input['invest_type_id'] == $deposit_id) {
            $route = "deposits.index";
        } elseif ($input['invest_type_id'] == $share_id) {
            $route = "shares.index";
        }

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route($route)->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InvestmentInstitution $investmentinstitution
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(InvestmentInstitution $investmentinstitution)
    {
        $status_mesg = $investmentinstitution->delete();

        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';

        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->back()->with($notification);
    }
}
