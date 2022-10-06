<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accounts\ClientsController;
use App\Http\Controllers\Accounts\PurchaseController;
use App\Http\Controllers\Accounts\SaleController;
use App\Http\Controllers\Accounts\Builders;
use App\Http\Controllers\Accounts\BuilderController;
use App\Http\Controllers\Accounts\ProductsController;
use App\Http\Controllers\Accounts\StockController;
use App\Http\Controllers\Accounts\CategoryController;
use App\Http\Controllers\Accounts\VendorsController;
use App\Http\Controllers\Accounts\ReportsController;
use App\Http\Controllers\Accounts\PaymentsController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\COAController;
use App\Http\Controllers\Accounts\LedgersController;


use App\Http\Controllers\Accounts\AccountsController;
use App\Models\Account;

Route::get('report-attendence', [AccountsController::class, 'report']);

Route::group(['middleware' => ['auth', 'can:isAccountant']], function () {

    Route::get('accounts-dashboard', function () {
        return view('accounts.account-dashboard');
    });



    //vendro routes
    Route::any('vendors', [VendorsController::class, 'index']);
    Route::post('save-vendor', [VendorsController::class, 'saveVendor']);
    Route::get('vendor-detail/{id}', [VendorsController::class, 'vendorDetail']);
    Route::get('edit-vendor', [VendorsController::class, 'editVendor']);
    Route::post('update-vendor', [VendorsController::class, 'updateVendor']);
    Route::get('delete-vendor/{id}', [VendorsController::class, 'deleteVendor']);


    Route::get('getAccountsName', [VendorsController::class, 'getAccountsName']);


    //client routes
    Route::get('clients', [ClientsController::class, 'index']);
    Route::post('save-clients', [ClientsController::class, 'saveClients']);
    Route::get('client_detail/{id}', [ClientsController::class, 'clientDetail']);
    Route::get('edit-client', [ClientsController::class, 'editClient']);
    Route::post('update-client', [ClientsController::class, 'updateClient']);
    Route::get('delete-client/{id}', [ClientsController::class, 'deleteClient']);
    Route::get('getClientInfo', [ClientsController::class, 'getClientInfo']);



    //purchase routes
    Route::any('purchase', [PurchaseController::class, 'index']);
    Route::any('purchase-list', [PurchaseController::class, 'getPurchase']);
    Route::post('save-purchase', [PurchaseController::class, 'savePurchase']);
    Route::get('view-purchase/{id}', [PurchaseController::class, 'viewPurchase']);
    Route::get('view-purchase-edit', [PurchaseController::class, 'viewPurchaseEdit']);
    Route::get('view-purchase-update', [PurchaseController::class, 'viewPurchaseUpdate']);
    Route::get('view-purchase-delete/{id}', [PurchaseController::class, 'viewPurchaseDelete']);


    //sale routes
    Route::any('sale', [SaleController::class, 'index']);
    Route::any('bulk-sale', [SaleController::class, 'bulkSale']);
    Route::any('regular-sale', [SaleController::class, 'regularSale']);
    Route::any('getAvailStock', [SaleController::class, 'getAvailStock']);
    Route::any('getInventoryOntheBaseOfDealerGroup', [SaleController::class, 'getInventoryOntheBaseOfDealerGroup']);
    Route::any('getAvailStockAndSubTotal', [SaleController::class, 'getAvailStockAndSubTotal']);
    Route::any('get-leads-marketings', [SaleController::class, 'getLeadsMarketings']);

    //buildings
    Route::any('buildings', [BuilderController::class, 'index']);
    Route::get('buildings-list', [BuilderController::class, 'buildingsList']);
    Route::get('edit-buildings', [BuilderController::class, 'editBuildings']);
    Route::get('update-buildings', [BuilderController::class, 'updateBuildings']);
    Route::get('delete-buildings/{id}', [BuilderController::class, 'deleteBuildings']);
    Route::any('buildings-cost', [BuilderController::class, 'buildingsCost']);
    Route::any('/building-cost-detail/{building_id}', [BuilderController::class, 'buildingsCostDetail']);


    //Account Proudct Route
    Route::any('products', [ProductsController::class, 'index']);
    Route::get('products-list', [ProductsController::class, 'productsList']);
    Route::get('showProductsList', [ProductsController::class, 'showProductsList']);
    Route::get('edit-products/{id}', [ProductsController::class, 'editProducts']);
    Route::post('update-products/{id}', [ProductsController::class, 'updateProducts']);
    Route::get('delete-products/{id}', [ProductsController::class, 'deleteProducts']);
    Route::get('getProductInfo', [ProductsController::class, 'getProductInfo']);
    Route::get('getProductPriceAndInfo', [PurchaseController::class, 'getProductPriceAndInfo']);


    //stock route
    Route::get('stock', [StockController::class, 'index']);


    Route::get('stock-raw-material', [StockController::class, 'stockRawMaterial']);

    //category
    Route::get('category', [CategoryController::class, 'index']);
    Route::get('get-category', [CategoryController::class, 'getCategory']);
    Route::post('save-category', [CategoryController::class, 'saveCategory']);
    Route::get('edit-category', [CategoryController::class, 'editCategory']);
    Route::get('update-category', [CategoryController::class, 'updateCategory']);
    Route::get('delete-category/{id}', [CategoryController::class, 'deleteCategory']);


    //Reports
    Route::any('sale-report', [ReportsController::class, 'saleReport']);
    Route::get('purchase-report', [ReportsController::class, 'purchaseReport']);
    Route::get('invoice-details/{invoice_id}/{inv_type}', [ReportsController::class, 'invoiceDetails']);
    Route::get('delivery-note/{id}', [SaleController::class, 'deliveryNote']);
    Route::get('purchase-delivery-note/{id}', [SaleController::class, 'purchaseDeliveryNote']);
    Route::any('daily-summary', [ReportsController::class, 'dailySummary']);
    Route::any('today-summary', [ReportsController::class, 'todaySummary']);
    Route::any('loss-profit-report', [ReportsController::class, 'lossProfitReport']);
    Route::any('coa-report', [ReportsController::class, 'coaReport']);
    Route::any('monthly-profit-loss-report', [ReportsController::class, 'monthlyProfitLossReport']);

    Route::any('payments', [PaymentsController::class, 'payments']);
    Route::any('receipt', [PaymentsController::class, 'receipt']);
    Route::any('jv', [PaymentsController::class, 'jv']);
    Route::any('edit-jv/{id}', [PaymentsController::class, 'editJv']);
    Route::any('update-jv', [PaymentsController::class, 'updateJv']);
    Route::any('print-receipt/{id}', [PaymentsController::class, 'printReceipt']);
    Route::any('rv/{id}', [PaymentsController::class, 'rv']);
    Route::any('getClientsFiles', [PaymentsController::class, 'getClientsFiles']);


    Route::any('print', [PaymentsController::class, 'Print']);

    // Bank routes
    Route::any('bank', [BankController::class, 'index']);
    Route::any('bank-transaction', [BankController::class, 'bankTransaction']);
    Route::any('bank-summary', [BankController::class, 'bankSummary']);
    Route::any('manage-bank', [BankController::class, 'manageBank']);
    Route::any('delete-bank', [BankController::class, 'deleteBank']);

    Route::any('get-account-balance', [AccountsController::class, 'getAccountBalance']);
    Route::any('edit-voucher/{type}/{id}', [PaymentsController::class, 'editVoucher']);
    Route::any('update-voucher', [PaymentsController::class, 'updateVoucher']);

    Route::get('get-bank', [BankController::class, 'getBank']);
    Route::get('edit-bank', [BankController::class, 'editBank']);
    Route::get('udpate-bank', [BankController::class, 'udpateBank']);
    Route::get('getBankBranches', [BankController::class, 'getBankBranches']);


    Route::any('finance-expense', [ExpensesController::class, 'financeExpense']);
    Route::any('expense-list', [ExpensesController::class, 'expenseList']);
    Route::get('expense-head-edit', [ExpensesController::class, 'expenseHeadEdit']);
    Route::get('expense-head-update', [ExpensesController::class, 'expenseHeadUdpate']);
    Route::get('expense-head-delete/{id}', [ExpensesController::class, 'expenseHeadDelete']);


    Route::get('expense-head', [ExpensesController::class, 'financeExpense']);
    Route::get('finance-expense-list', [ExpensesController::class, 'financeExpenseList']);
    Route::any('manage-expense', [ExpensesController::class, 'manageExpense']);

    Route::any('expense-summary', [ExpensesController::class, 'expenseSummary']);
    Route::any('print-expense-summary/{formdate}/{todate}/{account_id}', [ExpensesController::class, 'printExpenseSummary']);
    Route::get('edit-expense-summary', [ExpensesController::class, 'editExpenseSummary']);
    Route::any('update-expense-summary', [ExpensesController::class, 'expenseSummaryUpdate']);
    Route::get('expense-summary-delete', [ExpensesController::class, 'expenseSummaryDelete']);

    //Account Type
    Route::any('coa', [COAController::class, 'index']);
    Route::any('coa-mapping', [COAController::class, 'coaMapping']);
    Route::any('get-coa-mapping-list', [COAController::class, 'getCoaMappingList']);
    Route::any('getCoaLevelBalance', [COAController::class, 'getCoaLevelBalance']);

    Route::any('getMainAcList', [COAController::class, 'getMainAcList']);
    // Route::get('getMainAcEdit', [COAController::class, 'getMainAcEdit']);

    Route::any('getMainAccountBaseOfCat', [COAController::class, 'getMainAccountBaseOfCat']);
    Route::any('getDetailAccountBaseOfSubAcc', [COAController::class, 'getDetailAccountBaseOfSubAcc']);
    Route::any('getSubAcList', [COAController::class, 'getSubAcList']);
    Route::any('getDetailAcList', [COAController::class, 'getDetailAcList']);
    Route::any('getHeadAcList', [COAController::class, 'getHeadAcList']);
    Route::any('getHeadIdBaseOfMainAccount', [COAController::class, 'getHeadIdBaseOfMainAccount']);
    Route::any('getSubABaseOfHeadId', [COAController::class, 'getSubABaseOfHeadId']);

    Route::any('ledgers', [LedgersController::class, 'index']);
    Route::any('account-history/{id}/{ac_type}', [LedgersController::class, 'accountHistory']);




    Route::post('save-accounttype', [BankController::class, 'saveAccountType']);
    Route::get('edit-accounttype', [BankController::class, 'editAccountType']);
    Route::get('update-accounttype', [BankController::class, 'updateAccountType']);
    Route::get('delete-accounttype/{id}', [BankController::class, 'deleteAccountType']);

    Route::get('chart-accounts', [ExpensesController::class, 'Chart']);

    //accounts
    Route::any('accounts', [AccountsController::class, 'index']);
    Route::any('create-vend-cus-account', [AccountsController::class, 'createVendCusAccount']);
    Route::get('accounts-list', [AccountsController::class, 'accountsList']);
    Route::get('edit-accounts', [AccountsController::class, 'editAccounts']);
    Route::any('update-accounts', [AccountsController::class, 'updateAccounts']);
    Route::any('delete-account', [AccountsController::class, 'deleteAccount']);
    Route::any('deposit', [AccountsController::class, 'deposit']);
    Route::any('transfer', [AccountsController::class, 'transfer']);
    Route::any('balance-sheet/{head_id}/{level}', [ReportsController::class, 'balanceSheet']);
    Route::any('commission-report', [ReportsController::class, 'commissionReport']);


    // level 1 routes
    Route::get('get_level_1', [COAController::class, 'getLevel1']);
    Route::post('store_level_1', [COAController::class, 'storeLevel1']);
    Route::get('edit_level_1', [COAController::class, 'editLevel1']);
    Route::post('update_level_1', [COAController::class, 'updateLevel1']);
    Route::get('delete_level_1', [COAController::class, 'deleteLevel1']);

    Route::get('get-l2heads-with-params', [COAController::class, 'getL2headsWithParams']);
    Route::get('get-l3heads-with-params', [COAController::class, 'getL3headsWithParams']);
    Route::get('get-l4heads-with-params', [COAController::class, 'getL4headsWithParams']);
    Route::get('get-l5heads-with-params', [COAController::class, 'getL5headsWithParams']);

    // level 2 routes
    Route::get('get-level-two', [COAController::class, 'getLevelTwo']);
    Route::post('store-level-two', [COAController::class, 'storeLevelTwo']);
    Route::get('edit-level-two', [COAController::class, 'editLevelTwo']);
    Route::post('update-level-two', [COAController::class, 'updateLevelTwo']);
    Route::get('delete-level-two', [COAController::class, 'deleteLevelTwo']);

    // level 3 routes
    Route::get('get-level-three', [COAController::class, 'getLevelThree']);
    Route::post('store-level-three', [COAController::class, 'storeLevelThree']);
    Route::get('edit-level-three', [COAController::class, 'editLevelThree']);
    Route::post('update-level-three', [COAController::class, 'updateLevelThree']);
    Route::get('delete-level-three', [COAController::class, 'deleteLevelThree']);

    // level 4 routes
    Route::get('get-level-four', [COAController::class, 'getLevelFour']);
    Route::post('store-level-four', [COAController::class, 'storeLevelFour']);
    Route::get('edit-level-four', [COAController::class, 'editLevelFour']);
    Route::post('update-level-four', [COAController::class, 'updateLevelFour']);
    Route::get('delete-level-four', [COAController::class, 'deleteLevelFour']);

    // level 5 routes
    Route::get('get-level-five', [COAController::class, 'getLevelFive']);
    Route::post('store-level-five', [COAController::class, 'storeLevelFive']);
    Route::get('edit-level-five', [COAController::class, 'editLevelFive']);
    Route::post('update-level-five', [COAController::class, 'updateLevelFive']);
    Route::get('delete-level-five', [COAController::class, 'deleteLevelFive']);


    Route::get('level-two-base-level-one', [COAController::class, 'LevelTwoBaseLevelOne']);
    Route::get('level-three-base-level-two', [COAController::class, 'LevelThreeBaseLevelTwo']);
    Route::get('level-four-base-level-three', [COAController::class, 'LevelFourBaseLevelThree']);
});
