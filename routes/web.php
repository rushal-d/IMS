<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::user()) {
        return redirect()->route('login');
    } else {
        return redirect()->route('dashboard');
    }
})->name('/');

Auth::routes();
/*to ban outside user from doing registration*/
Route::match(['get', 'post'], 'register', function () {
    return view('auth.login');
});

Route::get('/branchdata', function () {
    //get all branches by code
    for ($branch_code = 1; $branch_code <= 61; $branch_code++) {
        $branches = \App\organizationBranch::where('branch_code', $branch_code)->pluck('id');


        //$deposits = \App\Deposit::whereIn('organization_branch_id', $branches)->latest()->paginate(5);
        if (count($branches) > 1) { //only del if greater than 1 branch found
            $deposits = \App\Deposit::whereIn('organization_branch_id', $branches)->update(['organization_branch_id' => $branches[0]]);
            $delete_branch = \App\organizationBranch::where('branch_code', $branch_code)->whereNotIn('id', [$branches[0]])->delete();
            //dd($branches, $deposits, $delete_branch);
        }
    }
});

Route::get('/change-bank-code', 'HomeController@changeBankCode')->name('change-bank-oode');
Route::get('/check-status', 'HomeController@checkChild')->name('checkChild');
Route::get('/shareFiscalId', 'HomeController@shareFiscalId')->name('shareFiscalId');
Route::get('/trial-balance', 'HomeController@trialBalance')->name('trailbalance');
Route::get('/test', 'HomeController@test')->name('test');

Route::get('/merger-effected', 'TryController@mergerEffected')->name('merger-effected');
Route::get('/inter-class-bank-renew', 'TryController@interClassBankRenew')->name('inter-class-bank-renew');
Route::get('/renew-before-mature', 'TryController@renewBeforeMature')->name('renew-before-mature');
Route::get('/getBug', 'TryController@getBug')->name('getBug');
Route::get('/active-deposits', 'TryController@activeDeposits')->name('active-deposits');
Route::get('/acquisitionListTest', 'TryController@acquisitionListTest');
Route::get('/withdrawFYID', 'TryController@withdrawFYID');
Route::get('/remapReferenceNumber', 'TryController@remapReferenceNumber');


Route::middleware(['auth', 'web', 'permissionmiddleware'])->group(function () {

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/home', 'HomeController@index')->name('home-dashbaord');
    Route::get('artisan/{command}', 'HomeController@artisanCall')->name('artisan.call');
    /*Deposit next status update ajax call*/
    Route::patch('/deposit/next-status-ajaxupdate', 'DepositController@nextStatusAjax')->name('deposit.next-status-ajax');
    //this is main module of the application

    Route::post('upload-ckeditor', 'HomeController@uploadCkEditor')->name('upload-ckeditor');

    Route::get('/bond/downloadExcel', 'BondController@downloadExcel')->name('bond.excel');
    Route::resource('bond', 'BondController');
    Route::resource('deposit', 'DepositController');
    Route::get('/deposit/renew/{id}', 'DepositController@renew')->name('deposit.renew');
    Route::get('/deposit/withdraw/{id}', 'DepositController@withdraw')->name('deposit.withdraw');
    Route::post('deposit/withdraw', 'DepositController@savewithdraw')->name('deposit.savewithdraw');
    Route::post('deposit/approve/{id}', 'DepositController@approveDeposit')->name('deposit.approve');
    Route::post('deposit/withdraw/approve/{id}', 'DepositController@approveDepositWithdraw')->name('deposit.withdraw.approve');

    /*pending deposits to edit*/
    Route::get('pending-deposit', 'PendingDepositController@index')->name('pending-deposit');
    Route::get('pending-deposit/create', 'PendingDepositController@create')->name('pending-deposit-create');
    Route::post('pending-deposit/store', 'PendingDepositController@store')->name('pending-deposit-store');
    Route::get('pending-deposit/edit/{id}', 'PendingDepositController@edit')->name('pending-deposit-edit');
    Route::patch('pending-deposit/update/{id}', 'PendingDepositController@update')->name('pending-deposit-update');
    Route::get('pending-deposit/excel-ownload', 'PendingDepositController@excelDownload')->name('pending-deposit-excel-download');
    /*deposit excel import*/
    Route::post('deposit/importExcel', 'DepositController@importExcel')->name('deposit.import');
    /*share excel import*/
    Route::post('share/importExcel', 'ShareController@importExcel')->name('share.import');

    Route::get('/tds-cert-letter', 'TdsCertificationController@index')->name('tds-cert-letter');
    Route::post('/tds-cert-letter/store', 'TdsCertificationController@store')->name('tds-save');
    Route::get('/tds-cert-letter/search', 'TdsCertificationController@searchTds')->name('tds-search');
    Route::patch('/tds-cert-letter/update/{id}', 'TdsCertificationController@update')->name('tds-update');

    /*withdraw edit*/
    Route::get('/deposit/withdraw/edit/{id}', 'DepositController@withdraw_edit')->name('deposit.withdrawedit');
    Route::patch('/deposit/withdraw/update/{id}', 'DepositController@withdraw_update')->name('deposit.withdrawupdate');
    Route::delete('/deposit/withdraw/delete/{id}', 'DepositController@withdraw_delete')->name('deposit.withdrawdelete');

    Route::get('/deposit/placement-letter/{id}', 'DepositController@placementLetter')->name('deposit.placement');
    Route::get('/deposit/renew-letter/{id}', 'DepositController@renewLetter')->name('deposit.renew-letter');
    Route::get('/deposit/withdraw-letter/{id}', 'DepositController@withdrawLetter')->name('deposit.withdraw-letter');
    Route::get('/deposit/placement-letter2/{id}', 'DepositController@placementLetter2')->name('deposit.placement2');
    Route::patch('/deposit/placement-letter1-update/{id}', 'DepositController@placementLetter1Update')->name('placement-letter1.update');
    Route::patch('/deposit/placement-letter2-update/{id}', 'DepositController@placementLetter2Update')->name('placement-letter2.update');
    Route::patch('/deposit/renew-letter-update/{id}', 'DepositController@renewLetterUpdate')->name('renew-letter.update');
    Route::patch('/deposit/withdraw-letter-update/{id}', 'DepositController@withdrawLetterUpdate')->name('withdraw-letter.update');
    Route::patch('pending-deposit/placement-letter1-update/{id}', 'DepositController@pendingPlacementLetter1Update')->name('pending-placement-letter-update');
    Route::get('/deposit/complete-letter/{id}', 'DepositController@completeLetter')->name('letter-complete');

    Route::get('/share/downloadExcel', 'ShareController@downloadExcel')->name('share.excel');
    Route::resource('share', 'ShareController');
    Route::resource('dividend', 'DividendController');
    Route::get('sharetableupdate', 'InvestmentInstitutionController@updatesharetable')->name('update.sharetable');
    Route::get('update-promoter-share', 'InvestmentInstitutionController@updatePromoterShare')->name('update.promoter.share');
    Route::get('get-share-records', 'ShareController@getShareRecords')->name('get.share.records');

    Route::resource('agri-tour-water-investments', 'AgriTourWaterInvestmentController');
    Route::resource('land-building-investments', 'LandBuildingInvestmentController');

    Route::get('report/share-summary', 'ReportController@share_summary')->name('report-share-summary');
    Route::get('report/share-summary/export', 'ReportController@share_summary_export')->name('report-share-summary-export');

    Route::get('share-history', 'ReportController@shareHistory')->name('share-history');
    Route::get('share-price-at-date', 'ReportController@sharePriceAtDate')->name('share-price-at-date');
    /*Filters Routes*/
    Route::post('/deposit/filter', 'DepositController@filter')->name('deposit.filter');
    Route::get('/print', 'DepositController@print')->name('deposit.print');
    Route::post('/report/filter', 'ReportController@filter')->name('report.filter');

    Route::post('/share/filter', 'ShareController@filter')->name('share.filter');
    Route::get('report/interest-calculation', 'ReportController@interest_caluculation')->name('report-interest-calc');
    Route::get('report/interest-calculation/excel', 'ReportController@interest_caluculation_excel')->name('report-interest-calc-excel');
    Route::get('report/interest-calculation/print', 'ReportController@interest_caluculation_print')->name('report-interest-calc-print');

    /*Summary Report by deposit type*/
    Route::get('report/summaryreport', 'ReportController@summary_report')->name('report-summary-report');
    Route::get('report/summaryreport/excel', 'ReportController@summary_report_excel')->name('report-summary-report-excel');

    /*Summary report by banks*/
    Route::get('report/totaldepositreport', 'ReportController@total_deposit_report')->name('report-total-deposit-report');
    Route::get('fresh-deposit', 'ReportController@freshDeposit')->name('fresh-deposit');
    Route::get('deposit-bank-wise-summary', 'ReportController@depositBankWiseSummary')->name('deposit-bank-wise-summary');

    Route::get('mature-track','ReportController@matureTrack')->name('mature-track');

    Route::get('active-deposit-at-date', 'ReportController@activeDepositAtDate')->name('active-deposit-at-date');
    Route::get('active-deposit-at-date/download-excel', 'ReportController@activeDepositAtDateDownloadExcel')->name('active-deposit-at-date-excel');

    /*Ajax call to add days*/
    Route::post('/adddays', 'BondController@adddays')->name('adddays');

    /*Routes to show alerts*/
    Route::get('/bonds/alerts', 'BondController@index')->name('bond.alerts');
    Route::get('/deposits/alerts', 'DepositController@index')->name('deposit.alerts');
    //Route::get('/shares/alerts','ShareController@showalerts')->name('share.alerts');

    //Routes for excel download
    Route::get('deposit-downloadExcel', 'DepositController@premierExcelDownload')->name('deposit.excel');
    Route::get('deposit-nlgExcel', 'DepositController@nlgExport')->name('deposit.excel.nlg');
    Route::get('deposit-ledgerExport', 'DepositController@ledgerExport')->name('deposit.ledger.excel');
    Route::get('/investment-request/downloadExcel', 'InvestmentRequestController@downloadExcel')->name('investment-request.excel');
    Route::get('totaldepositreport', 'ReportController@total_deposit_report_excel')->name('total-deposit-report-excel');

    Route::get('/today/share/market', 'ShareController@todaysharemarket')->name('share.market');
    Route::get('/askclosevalue/ajax/{organization_code}/{date}', 'ShareController@askclosevalue')->name('share.askclose');

    /*Business Book*/
    Route::resource('businessbook', 'BusinessBookController');
    Route::post('businessbook/excel', 'BusinessBookController@excel')->name('business-book-excel');

    /*Investment Request*/
    Route::patch('investment-request/ajaxUpdate/', 'InvestmentRequestController@ajaxUpdate')->name('investment-request.ajaxUpdate');
    Route::resource('investment-request', 'InvestmentRequestController');
    Route::get('investment-request/transfer-to-deposits/{id}', 'InvestmentRequestController@transferToDeposits')->name('investment.request.to.deposits');

    /*Actual Interest Earning History*/
    Route::resource('interestearnedentry', 'InterestEarnedEntryController', ['except' => ['index']]);
    /*Bonus Share History*/
    Route::resource('bonussharehistory', 'BonusShareHistoryController', ['except' => ['index']]);

    Route::resource('report', 'ReportController');

    /*deposit percentage*/
    Route::get('institution-deposit-percentage', 'ReportController@institutionDepositPercentage')->name('institution.deposit.percentage');
    Route::get('investment-sector-percentage', 'ReportController@investmentSectorPercentage')->name('investment.sector.percentage');

    /*Bima samit report*/
    Route::get('bimasamiti/report', 'BimasamitiReportController@index')->name('bimasamiti.report');
    Route::get('bimasamiti/filter', 'BimasamitiReportController@filter')->name('bimasamiti-filter');
    Route::get('bimasamiti/excel', 'BimasamitiReportController@excel')->name('bimasamiti.excel');

    Route::get('yearlyreport', 'YearlyReportController@index')->name('yearly-report');
    Route::get('investment-report', 'ReportController@investment_report')->name('investment-report');
    Route::get('agri-tour-water-report', 'ReportController@agriTourWaterReport')->name('agri-tour-water-report');
    Route::get('land-building-report', 'ReportController@landBuildingReport')->name('land-building-report');

    Route::get('deposit-at-org-branch', 'ReportController@depositOrgBranch')->name('deposit-org-branch');


    //this is the master setup of application
    Route::resource('fiscalyear', 'FiscalYearController', ['except' => ['show', 'create']]);
    Route::resource('technicalReserve', 'TechnicalReserveController', ['except' => ['show', 'create']]);
    Route::resource('userorganization', 'UserOrganizationController', ['except' => ['show', 'create']]);
    Route::resource('emailsetup', 'EmailSetupController', ['except' => ['show', 'create']]);
    Route::resource('sms-setup', 'SmsSetupController', ['except' => ['show', 'edit', 'update', 'delete']]);
    Route::post('sms-setup/test', 'SmsSetupController@test')->name('sms-setup.test');
    Route::resource('organizationbranch', 'OrganizationBranchController', ['except' => ['show', 'create']]);
    Route::resource('investmenttype', 'InvestmentTypeController', ['except' => ['show', 'create']]);
    Route::resource('investmentsubtype', 'InvestmentSubTypeController', ['except' => ['show', 'create']]);
    Route::resource('investmentgroup', 'InvestmentGroupController', ['except' => ['show', 'create']]);
    Route::resource('investmentinstitution', 'InvestmentInstitutionController', ['except' => ['show', 'create', 'index']]);
    Route::resource('bankbranch', 'BankBranchController', ['except' => ['show', 'create']]);
    Route::resource('staff', 'StaffController', ['except' => ['create']]);
    Route::resource('bank-merger', 'BankMergerController');
    Route::post('check-if-merger-bank-exists','BankMergerController@checkIfMergerBankExists')->name('check-if-merger-bank-exists');

    /*deposit excel column list*/
    Route::get('depsit-excel-export-column', 'UserOrganizationController@depositExcelExportColumn')->name('depsit-excel-export-column');
    Route::post('depsit-excel-export-column', 'UserOrganizationController@depositExcelExportColumnSave')->name('depsit-excel-export-column-save');

    /*bank branch ajax entry*/
    Route::post('bankbranch/ajaxEntry', 'BankBranchController@ajaxEntry')->name('bankbranch-ajaxEntry');
    Route::post('organizationbranch/ajaxEntry', 'OrganizationBranchController@ajaxEntry')->name('organization_branch-ajaxEntry');
    Route::post('staff/ajaxEntry', 'StaffController@ajaxEntry')->name('staff-ajaxEntry');

    //excel organization branch import
    Route::post('organizationbranch/excel', 'OrganizationBranchController@excelImport')->name('organizationbranch.import');
    //excel bank branch import
    Route::post('bankbranch/excel', 'BankBranchController@excelImport')->name('bankbranch.import');

    /*Routes for Institutes Investment ---Custom Routes*/
    Route::get('bsetup/index', 'InvestmentInstitutionController@bond')->name('bonds.index');
    Route::get('dsetup/index', 'InvestmentInstitutionController@deposit')->name('deposits.index');
    Route::get('ssetup/index', 'InvestmentInstitutionController@share')->name('shares.index');

    Route::resource('documentation', 'DocumentationController');
    Route::resource('version-change-log', 'VersionChangeLogController');

    /*Email alert*/
    Route::resource('alertEmails', 'AlertEmailController');
    /*User management roles------ENTRUST*/
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::post('/permission/add', 'PermissionController@add')->name('permission.add');
    Route::post('/permission/addmenu', 'PermissionController@displayNameStore')->name('permission.addmenu');
    Route::get('send-permission-to-kb', 'PermissionController@sendPermissionToKB')->name('send-permission-to-kb');
    Route::get('get-permission-from-kb', 'PermissionController@getPermission')->name('get-permission-from-kb');
    Route::resource('user', 'UserController');
    Route::resource('assignrole', 'AssignRoleController');

    Route::get('menu', 'MenuController@index')->name('menu.index');
    Route::get('menu/search', 'MenuController@search')->name('menu.search');
    Route::post('menu/delete', 'MenuController@destroy')->name('menu.delete');
    Route::post('menu/store', 'MenuController@store')->name('menu.store');
    Route::post('menu/build', 'MenuController@buildMenu')->name('menu.build');
    Route::post('menu/displayNameStore', 'MenuController@displayNameStore')->name('display-name-store');
    Route::get('send-menu-to-kb', 'MenuController@sendMenuToKB')->name('send-menu-to-kb');
    Route::get('get-menu-from-kb', 'MenuController@getMenu')->name('get-menu-from-kb');
});