<?php

namespace App\Http\Controllers;

use App\BankMerger;
use App\Deposit;
use App\DepositWithdraw;
use App\FiscalYear;
use App\Traits\DepositTrait;
use Illuminate\Http\Request;

class TryController extends Controller
{
    use DepositTrait;

    public function interClassBankRenew()
    {
        $deposits = Deposit::withoutGlobalScope('is_pending')
            ->whereHas('child', function ($query) {
                $query->withoutGlobalScope('is_pending');
            })->with(['child' => function ($query) {
                $query->withoutGlobalScope('is_pending');
                $query->with('institute', 'deposit_type');
            }, 'institute', 'deposit_type', 'branch'])->get();
        $Allrecords = [];
        foreach ($deposits as $deposit) {
            if ($deposit->institution_id != $deposit->child->institution_id) {

                $records['parent_id'] = $deposit->id;
                $records['parent_bank'] = $deposit->institute->institution_name;
                $records['parent_class'] = $deposit->deposit_type->name;
                $records['parent_branch'] = $deposit->branch->branch_name;
                $records['parent_amount'] = $deposit->deposit_amount;

                $records['child_id'] = $deposit->child->id;
                $records['child_bank'] = $deposit->child->institute->institution_name;
                $records['child_class'] = $deposit->child->deposit_type->name;
                $records['child_branch'] = $deposit->child->branch->branch_name;
                $records['child_amount'] = $deposit->child->deposit_amount;
                $Allrecords[] = $records;
            }
        }
        echo '<table>
<tr>
<td>Parent ID</td>
<td>Parent Bank Name</td>
<td>Parent Class</td>
<td>Parent Branch</td>
<td>Parent Amount</td>

<td>Child ID</td>
<td>Child Bank Name</td>
<td>Child Class</td>
<td>Child Branch</td>
<td>Child Amount</td>
</tr>
';
        foreach ($Allrecords as $record) {

            echo '<tr>
<td>' . $record['parent_id'] . '</td>
<td>' . $record['parent_bank'] . '</td>
<td>' . $record['parent_class'] . '</td>
<td>' . $record['parent_branch'] . '</td>
<td>' . $record['parent_amount'] . '</td>

<td>' . $record['child_id'] . '</td>
<td>' . $record['child_bank'] . '</td>
<td>' . $record['child_class'] . '</td>
<td>' . $record['child_branch'] . '</td>
<td>' . $record['child_amount'] . '</td>

</tr>';
        }
        echo '</table>';
    }

    public function renewBeforeMature()
    {
        $deposits = Deposit::withoutGlobalScope('is_pending')
            ->whereHas('child', function ($query) {
                $query->withoutGlobalScope('is_pending');
            })->with(['child' => function ($query) {
                $query->withoutGlobalScope('is_pending');
                $query->with('institute', 'deposit_type');
            }, 'institute', 'deposit_type', 'branch'])->get();
        $Allrecords = [];
        foreach ($deposits as $deposit) {
            if (strtotime($deposit->mature_date_en) > strtotime($deposit->child->trans_date_en)) {

                $records['parent_id'] = $deposit->id;
                $records['parent_bank'] = $deposit->institute->institution_name;
                $records['parent_class'] = $deposit->deposit_type->name;
                $records['parent_branch'] = $deposit->branch->branch_name;
                $records['parent_amount'] = $deposit->deposit_amount;
                $records['mature_date'] = $deposit->mature_date_en;

                $records['child_id'] = $deposit->child->id;
                $records['child_bank'] = $deposit->child->institute->institution_name;
                $records['child_class'] = $deposit->child->deposit_type->name;
                $records['child_branch'] = $deposit->child->branch->branch_name;
                $records['child_amount'] = $deposit->child->deposit_amount;
                $records['trans_date'] = $deposit->child->trans_date_en;
                $Allrecords[] = $records;
            }
        }
        echo '<table>
<tr>
<td>Parent ID</td>
<td>Parent Bank Name</td>
<td>Parent Class</td>
<td>Parent Branch</td>
<td>Parent Amount</td>
<td>Mature Date</td>

<td>Child ID</td>
<td>Child Bank Name</td>
<td>Child Class</td>
<td>Child Branch</td>
<td>Child Amount</td>
<td>Transaction Date</td>
</tr>
';
        foreach ($Allrecords as $record) {

            echo '<tr>
<td>' . $record['parent_id'] . '</td>
<td>' . $record['parent_bank'] . '</td>
<td>' . $record['parent_class'] . '</td>
<td>' . $record['parent_branch'] . '</td>
<td>' . $record['parent_amount'] . '</td>
<td>' . $record['mature_date'] . '</td>

<td>' . $record['child_id'] . '</td>
<td>' . $record['child_bank'] . '</td>
<td>' . $record['child_class'] . '</td>
<td>' . $record['child_branch'] . '</td>
<td>' . $record['child_amount'] . '</td>
<td>' . $record['trans_date'] . '</td>

</tr>';
        }
        echo '</table>';
    }

    public function getBug()
    {
        $deposits = Deposit::whereHas('child', function ($query) {
            $query->withoutGlobalScope('is_pending');
        })->with(['child' => function ($query) {
            $query->withoutGlobalScope('is_pending');
        }])->get();
        foreach ($deposits as $deposit) {
            if ($deposit->deposit_amount != $deposit->child->deposit_amount) {
                dd($deposit);
            }
        }

//        $deposits = Deposit::where('deposit_amount', 0)->withoutGlobalScope('is_pending')->get();
        dd($deposits);

    }

    public function mergerEffected()
    {
        $bankMerger = BankMerger::with('mergeBankList')->get();
        echo '<table>
<tr>
<td>ID</td>
<td>Bank Name</td>
<td>Bank Branch</td>
<td>Tranx Date</td>
<td>Mature Date</td>
<td>Amount</td>
<td>Merged Date</td>
<td>Merged To</td>

</tr>
';
        foreach ($bankMerger as $merger) {
            $mergedBank = $merger->mergeBankList->where('bank_code', '<>', $merger->bank_code_after_merger);
            foreach ($mergedBank as $bank) {
//                echo $bank->bank_name.' '.$merger->merger_date.'<br>';
                $deposits = Deposit::withoutGlobalScope('is_pending')->whereHas('institute', function ($query) use ($bank) {
                    $query->where('institution_code', $bank->bank_code);
                })->whereDate('trans_date_en', '<=', $merger->merger_date)->whereDate('mature_date_en', '>=', $merger->merger_date)->with('institute', 'branch')->get();

                /*Deposit::withoutGlobalScope('is_pending')->whereHas('institute', function ($query) use ($bank) {
                    $query->where('institution_code', $bank->bank_code);
                })
                    ->whereDate('trans_date_en', '<=', $merger->merger_date)->whereDate('mature_date_en', '>=', $merger->merger_date)->with('institute', 'branch')
                    ->update(['bank_merger_id' => $merger->id]);*/


                foreach ($deposits as $deposit) {

                    echo '<tr>
<td>' . $deposit->id . '</td>
<td>' . $deposit->institute->institution_name . '</td>
<td>' . $deposit->branch->branch_name . '</td>
<td>' . $deposit->trans_date_en . '</td>
<td>' . $deposit->mature_date_en . '</td>
<td>' . $deposit->deposit_amount . '</td>
<td>' . $merger->merger_date . '</td>
<td>' . $merger->bank_name_after_merger . '</td>


</tr>';
                }
            }
        }
        echo '</table>';
    }

    public function activeDeposits()
    {
        $deposits = Deposit::withoutGlobalScope('is_pending')->whereDoesntHave('child', function ($query) {
            $query->withoutGlobalScope('is_pending');
        })->whereDoesntHave('withdraw')->with('institute', 'branch', 'deposit_type')->get();
        $null = '';
        echo '<table>
<tr>
<td>ID</td>
<td>Bank Name</td>
<td>Bank Branch</td>
<td>Tranx Date</td>
<td>Mature Date</td>
<td>Amount</td>
<td>Class</td>

</tr>
';
        foreach ($deposits as $deposit) {

            echo "<tr>
<td>" . $deposit->id . "</td>
<td>" . $deposit->institute->institution_name . "</td>
<td>" . $deposit->branch_id . "</td>
<td>" . $deposit->trans_date_en . "</td>
<td>" . $deposit->mature_date_en . "</td>
<td>" . $deposit->deposit_amount . "</td>
<td>" . $deposit->deposit_type->name . "</td>


</tr>";
        }
        echo '</table>';
    }

    public function acquisitionListTest()
    {
        /*DepositTrait::getAcquiredDepositsAfterMerger(null, null, null, null, null, null, null
            , null, null, null, null, null,null,null);*/
        $deposit = $this->getDepositRecord(null, 4, null, null, [], null, null,
            null, null, null, null, true, null, null)['deposits'];
        return json_encode(true);
    }

    public function withdrawFYID()
    {
        $fiscal_years = FiscalYear::get();
        $withdraws = DepositWithdraw::get();
        foreach ($withdraws as $withdraw) {
            $fiscal_year = $fiscal_years->where('start_date_en', '<=', $withdraw->withdrawdate_en)->where('end_date_en', '>=', $withdraw->withdrawdate_en)->first();
            if (!empty($fiscal_year)) {
                $withdraw->fiscal_year_id = $fiscal_year->id;
                $withdraw->save();
            }
        }
    }

    public function remapReferenceNumber()
    {
        $deposits = Deposit::where('reference_number', '<>', null)->withoutGlobalScope('is_pending')->whereHas('parent', function ($query) {
            $query->where('reference_number', null)->withoutGlobalScope('is_pending');
        })->with('parent')->get();
        foreach ($deposits as $deposit) {
            $parent = $deposit->parent;
            $parent->reference_number = $deposit->reference_number;
            $parent->save();
        }
    }
}
