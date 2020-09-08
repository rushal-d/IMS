<?php

namespace App\Http\Controllers;

use App\BusinessBook;
use App\FiscalYear;
use App\Helpers\BSDateHelper;
use App\OrganizationBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class BusinessBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $business_books = BusinessBook::query();
        $input = Input::all();
        $data['i'] = 1;
        if (!empty($input)) {
            $data['fiscal_year_id'] = $input['fiscal_year_id'] ?? null;
            $data['from_date_en'] = $input['from_date_en'] ?? null;
            $data['from_date'] = $input['from_date'] ?? null;
            $data['to_date_en'] = $input['to_date_en'] ?? null;
            $data['to_date'] = $input['to_date'] ?? null;
            $data['organization_branch_id'] = $input['organization_branch_id'] ?? null;
            if (isset($input['fiscal_year_id'])) {
                $business_books->where('fiscal_year_id', $input['fiscal_year_id']);
            }
            if (isset($input['from_date_en'])) {
                $business_books->where('date_en', '>', $input['from_date_en']);
            }

            if (isset($input['to_date_en'])) {
                $business_books->where('date_en', '<', $input['to_date_en']);
            }
            if (isset($input['organization_branch_id'])) {
                $business_books->where('organization_branch_id', $input['organization_branch_id']);
            }

        }
        $business_books=$business_books->paginate(20);
        $data['fiscal_years'] = FiscalYear::pluck('code', 'id');
        $data['organization_branches'] = OrganizationBranch::pluck('branch_name', 'id');
        $data['business_books'] = $business_books;
        return view('businessbook.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['organization_branches'] = OrganizationBranch::all();
        return view('businessbook.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::all();
        $input['fiscal_year_id'] = FiscalYear::where('start_date_en', '<=', $input['date_en'])->where('end_date_en', '>=', $input['date_en'])->first()->id;
        BusinessBook::create($input);
        return redirect()->route('businessbook.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BusinessBook $businessBook
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessBook $businessbook)
    {
        $data['business_book'] = $businessbook;
        $data['organization_branches'] = OrganizationBranch::all();
        return view('businessbook.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessBook $businessBook
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessBook $businessbook)
    {
        $data['business_book'] = $businessbook;
        $data['organization_branches'] = OrganizationBranch::all();
        return view('businessbook.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\BusinessBook $businessBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessBook $businessbook)
    {
        $input = Input::all();
        $input['fiscal_year_id'] = FiscalYear::where('start_date_en', '<=', $input['date_en'])->where('end_date_en', '>=', $input['date_en'])->first()->id;
        $businessbook->update($input);
        return redirect()->route('businessbook.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessBook $businessBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessBook $businessbook)
    {
        $status_mesg = $businessbook->delete();
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Deleted Successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('businessbook.index')->with($notification);
    }

    public function excel(Request $request)
    {
        $status_mesg = false;
        try {
            DB::beginTransaction();
            $path = $request->file('business_book')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->all();
            foreach ($data as $item => $value) {
                $detail['date_en'] = date('Y-m-d', strtotime($value['date']));
                $fiscal_year_id = FiscalYear::where('start_date_en', '<', $detail['date_en'])->where('end_date_en', '>', $detail['date_en'])->first()->id;
                $detail['fiscal_year_id'] = $fiscal_year_id;

                $detail['date'] = BSDateHelper::AdToBsEN('-', $detail['date_en']);
                $detail['notes'] = $value['notes'];
                $detail['amount'] = $value['amount'];
                $detail['organization_branch_id'] = $request->organization_branch_id;
                BusinessBook::create($detail);
                $status_mesg = true;
            }
        } catch (\Exception $e) {
            DB::rollBack();
        }
        $status = ($status_mesg) ? 'success' : 'error';
        $mesg = ($status_mesg) ? 'Imported Successfully' : 'Error Occured! Try Again!';
        $notification = array(
            'message' => $mesg,
            'alert-type' => $status,
        );
        return redirect()->route('businessbook.index')->with($notification);
    }
}
