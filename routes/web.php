<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\ChinaOfficeController;

// ============================================================
// Admin
// ============================================================
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\UserPackageController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Admin\SectorController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\GeographicZoneController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\OfficeZoneController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\OrderStatusController;

// ============================================================
// Dashboards
// ============================================================
use App\Http\Controllers\Client\DashboardController    as ClientDashboard;
use App\Http\Controllers\Company\DashboardController   as CompanyDashboard;
use App\Http\Controllers\Factory\DashboardController   as FactoryDashboard;
use App\Http\Controllers\Regional\DashboardController  as RegionalDashboard;
use App\Http\Controllers\China\DashboardController     as ChinaDashboard;
use App\Http\Controllers\GlobalForwarding\DashboardController as GlobalForwardingDashboard;

// ============================================================
// الصفحة الرئيسية
// ============================================================
Route::get('/', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicProducts'])->name('welcome');

Route::get('/home/products', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicProducts'])->name('home.products');
Route::get('/home/products/{id}', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicShow'])->name('home.products.show');
Route::get('/home/all-products', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicAllProducts'])->name('home.all-products');
Route::get('/home/ngis-products', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicNgisProducts'])->name('home.ngis-products');
Route::get('/home/factory-products', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicFactoryProducts'])->name('home.factory-products');
Route::get('/home/supplier-products', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicSupplierProducts'])->name('home.supplier-products');
Route::get('/home/contact', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicContact'])->name('home.contact');
Route::get('/home/shipping', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicShipping'])->name('home.shipping');
Route::get('/home/profile/{id}', [\App\Http\Controllers\Client\ProductSearchController::class, 'publicProfile'])->name('home.profile');
Route::get('/home/profile/{id}/edit', [\App\Http\Controllers\Client\ProductSearchController::class, 'editProfile'])->name('home.profile.edit')->middleware('auth');
Route::post('/home/profile/{id}/update', [\App\Http\Controllers\Client\ProductSearchController::class, 'updateProfile'])->name('home.profile.update')->middleware('auth');

// ============================================================
// CBM Print Preview
// ============================================================
Route::get('/cbm-preview/print', function () {
    return view('client.cbm_print_preview');
})->middleware(['auth'])->name('cbm.print.preview');

Route::get('/dashboard', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============================================================
// الملف الشخصي
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================================
// لوحة الأدمن
// ============================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('order-statuses', OrderStatusController::class);
    Route::resource('sectors', SectorController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('geographic-zones', GeographicZoneController::class);
    Route::get('office-zones', [OfficeZoneController::class, 'index'])->name('office-zones.index');
    Route::get('office-zones/{user}/assign', [OfficeZoneController::class, 'assign'])->name('office-zones.assign');
    Route::post('office-zones/{user}/assign', [OfficeZoneController::class, 'update'])->name('office-zones.update');
    Route::get('office-zones/{user}/show', [OfficeZoneController::class, 'show'])->name('office-zones.show');
    Route::resource('countries', CountryController::class);
    Route::resource('currencies', CurrencyController::class)->except(['show']);
    Route::resource('user-packages', UserPackageController::class)
        ->parameters(['user-packages' => 'user'])
        ->only(['index', 'edit', 'update']);
    Route::resource('verifications', VerificationController::class);
    Route::resource('user-verifications', UserVerificationController::class)->only(['index', 'edit', 'update'])->parameters(['user-verifications' => 'user']);
    
    // Financial Operations
    Route::resource('wallets', WalletController::class)
        ->parameters(['wallets' => 'user'])
        ->only(['index', 'edit', 'update']);
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'store'])->name('settings.store');

    // Management Sections
    Route::get('factories', [ManagementController::class, 'factories'])->name('factories.index');
    Route::get('factories/products', [ManagementController::class, 'productsByRole'])->defaults('type', 'factory')->name('factories.products');
    
    Route::get('companies', [ManagementController::class, 'companies'])->name('companies.index');
    Route::get('companies/products', [ManagementController::class, 'productsByRole'])->defaults('type', 'company')->name('companies.products');
    
    Route::get('clients', [ManagementController::class, 'clients'])->name('clients.index');
    Route::get('clients/orders', [ManagementController::class, 'clientOrders'])->name('clients.orders');
    Route::get('clients/orders/{order}/send-to-regional', [ManagementController::class, 'sendToRegional'])->name('clients.orders.send-to-regional');
    Route::get('clients/orders/{order}', [ManagementController::class, 'showOrder'])->name('clients.orders.show');
    Route::delete('clients/orders/{order}', [ManagementController::class, 'deleteOrder'])->name('clients.orders.destroy');
    
    Route::get('regional', [ManagementController::class, 'regional'])->name('regional.index');
    Route::get('china', [ManagementController::class, 'china'])->name('china.index');

    // Financial Operations - Admin view for all regional data
    Route::get('invoices', [ManagementController::class, 'invoices'])->name('invoices.index');
    Route::get('invoices/paid', [ManagementController::class, 'paidInvoices'])->name('invoices.paid');
    Route::get('invoices/payment-status', [ManagementController::class, 'paymentStatus'])->name('invoices.payment_status');
    Route::get('invoices/{order}', [ManagementController::class, 'invoiceDetails'])->name('invoices.show');
    Route::get('invoices/{order}/edit', [ManagementController::class, 'editInvoice'])->name('invoices.edit');
    Route::patch('invoices/{order}', [ManagementController::class, 'updateInvoice'])->name('invoices.update');
    Route::post('invoices/{order}/forward', [ManagementController::class, 'forwardToChina'])->name('invoices.forward');


    // Business logic for redirection or admin overview can stay here if needed
    // But the China dashboard specific routes should move.
});

Route::post('language/set', [SettingController::class, 'setLanguage'])->name('language.set')->middleware('auth');

// ============================================================
// لوحات التحكم — كل نوع مستخدم
// ============================================================

// عميل
Route::prefix('client')->name('client.')->middleware(['auth', 'dashboard.type:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/my-wallet', [WalletController::class, 'myWallet'])->name('wallet');

    // مراسلة المكتب - المحادثة
    Route::get('/chat', [\App\Http\Controllers\Client\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [\App\Http\Controllers\Client\ChatController::class, 'sendMessage'])->name('chat.send');

    // الإدارات الجديدة
    Route::get('/auctions', [\App\Http\Controllers\Client\ManagementController::class, 'auctions'])->name('auctions.index');
    Route::get('/risk-management', [\App\Http\Controllers\Client\ManagementController::class, 'riskManagement'])->name('risk_management.index');
    Route::get('/supplier-evaluation', [\App\Http\Controllers\Client\ManagementController::class, 'supplierEvaluation'])->name('supplier_evaluation.index');
    
    // طلب خاص
    Route::get('/special-order', [ClientDashboard::class, 'specialOrder'])->name('special_order');
    Route::post('/special-order', [ClientDashboard::class, 'storeSpecialOrder'])->name('special_order.store');
    Route::get('/special-orders', [ClientDashboard::class, 'mySpecialOrders'])->name('special_orders.index');
    Route::get('/special-orders/{id}/edit', [ClientDashboard::class, 'editSpecialOrder'])->name('special_orders.edit');
    Route::patch('/special-orders/{id}', [ClientDashboard::class, 'updateSpecialOrder'])->name('special_orders.update');
    Route::delete('/special-orders/{id}', [ClientDashboard::class, 'deleteSpecialOrder'])->name('special_orders.delete');

    // اشتراكات الحسابات
    Route::get('/subscription-plans', [ClientDashboard::class, 'subscriptionPlans'])->name('subscription.plans');
});

// شركة
Route::prefix('company')->name('company.')->middleware(['auth', 'dashboard.type:company'])->group(function () {
    Route::get('/dashboard', [CompanyDashboard::class, 'index'])->name('dashboard');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/my-wallet', [WalletController::class, 'myWallet'])->name('wallet');

    // الإدارات الجديدة للشركة
    Route::get('/auctions', [\App\Http\Controllers\Company\ManagementController::class, 'auctions'])->name('auctions.index');
    Route::get('/commercial-products', [\App\Http\Controllers\Company\ManagementController::class, 'commercialProducts'])->name('commercial_products.index');
    Route::get('/inventory', [\App\Http\Controllers\Company\ManagementController::class, 'inventory'])->name('inventory.index');
    Route::get('/operational-reports', [\App\Http\Controllers\Company\ManagementController::class, 'operationalReports'])->name('reports.index');
    Route::get('/contracts-management', [\App\Http\Controllers\Company\ManagementController::class, 'contracts'])->name('contracts.management');
    Route::get('/supplier-evaluation', [\App\Http\Controllers\Company\ManagementController::class, 'supplierEvaluation'])->name('supplier_evaluation.index');
    Route::get('/risk-management', [\App\Http\Controllers\Company\ManagementController::class, 'riskManagement'])->name('risk_management.index');
    Route::get('/support-and-followup', [\App\Http\Controllers\Company\ManagementController::class, 'support'])->name('support.index');
});

// مصنع
Route::prefix('factory')->name('factory.')->middleware(['auth', 'dashboard.type:factory'])->group(function () {
    Route::get('/dashboard', [FactoryDashboard::class, 'index'])->name('dashboard');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/my-wallet', [WalletController::class, 'myWallet'])->name('wallet');

    // الإدارات الجديدة للمصنع
    Route::get('/management/inventory', [\App\Http\Controllers\Factory\ManagementController::class, 'inventory'])->name('management.inventory');
    Route::get('/management/production-supply-reports', [\App\Http\Controllers\Factory\ManagementController::class, 'productionSupplyReports'])->name('management.production_supply_reports');
    Route::get('/management/performance-kpi', [\App\Http\Controllers\Factory\ManagementController::class, 'performanceKpi'])->name('management.performance_kpi');
    Route::get('/management/risk-management', [\App\Http\Controllers\Factory\ManagementController::class, 'riskManagement'])->name('management.risk_management');
    Route::get('/management/support', [\App\Http\Controllers\Factory\ManagementController::class, 'support'])->name('management.support');
});

// مكاتب الأقاليم
Route::prefix('regional')->name('regional.')->middleware(['auth', 'dashboard.type:regional_office'])->group(function () {
    Route::get('/dashboard', [RegionalDashboard::class, 'index'])->name('dashboard');
    Route::get('/details', [RegionalDashboard::class, 'showDetails'])->name('details');
    Route::get('/clients', [RegionalDashboard::class, 'clients'])->name('clients.index');
    Route::get('/clients/{order}', [RegionalDashboard::class, 'showOrder'])->name('clients.show');
    Route::get('/clients/{order}/contract', [RegionalDashboard::class, 'createContract'])->name('clients.contract');
    Route::post('/clients/{order}/contract', [RegionalDashboard::class, 'storeContract'])->name('clients.contract.store');
    Route::get('/invoices', [RegionalDashboard::class, 'invoices'])->name('invoices.index');
    Route::get('/invoices/payment-status', [RegionalDashboard::class, 'paymentStatus'])->name('invoices.payment_status');
    Route::get('/invoices/{order}/edit-payment', [RegionalDashboard::class, 'editPayment'])->name('invoices.edit_payment');
    Route::post('/invoices/{order}/store-payment', [RegionalDashboard::class, 'storePayment'])->name('invoices.store_payment');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/my-wallet', [WalletController::class, 'myWallet'])->name('wallet');

    // خدمة العملاء - المحادثة
    Route::get('/chat', [\App\Http\Controllers\Regional\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [\App\Http\Controllers\Regional\ChatController::class, 'sendMessage'])->name('chat.send');

    // الإدارات الجديدة للمكتب الإقليمي
    Route::get('/management/assigned-orders', [\App\Http\Controllers\Regional\ManagementController::class, 'assignedOrders'])->name('management.assigned_orders');
    Route::get('/management/financial-treasury', [\App\Http\Controllers\Regional\ManagementController::class, 'financialTreasury'])->name('management.financial_treasury');
    Route::get('/management/shipping', [\App\Http\Controllers\Regional\ManagementController::class, 'shippingManagement'])->name('management.shipping');
    Route::get('/management/operational-status', [\App\Http\Controllers\Regional\ManagementController::class, 'operationalStatus'])->name('management.operational_status');
    Route::get('/management/linked-clients', [\App\Http\Controllers\Regional\ManagementController::class, 'linkedClients'])->name('management.linked_clients');
    Route::get('/management/campaigns', [\App\Http\Controllers\Regional\ManagementController::class, 'operationalCampaigns'])->name('management.campaigns');
    Route::get('/management/reports', [\App\Http\Controllers\Regional\ManagementController::class, 'operationalReports'])->name('management.reports');
    Route::get('/management/documentation', [\App\Http\Controllers\Regional\ManagementController::class, 'documentation'])->name('management.documentation');
    Route::get('/management/logistics-risk', [\App\Http\Controllers\Regional\ManagementController::class, 'logisticsRisk'])->name('management.logistics_risk');
    Route::get('/management/sla', [\App\Http\Controllers\Regional\ManagementController::class, 'slaManagement'])->name('management.sla');
    Route::get('/management/performance-kpi', [\App\Http\Controllers\Regional\ManagementController::class, 'performanceKpi'])->name('performance_kpi.index');
});

// مكتب NGIS
Route::prefix('ngis')->name('ngis.')->middleware(['auth', 'dashboard.type:ngis'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Ngis\DashboardController::class, 'index'])->name('dashboard');

    // قسم الأول (مكتب إقليمي داخلي)
    Route::prefix('internal')->name('internal.')->group(function () {
        Route::get('/clients', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalClients'])->name('clients');
        Route::get('/orders', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalOrders'])->name('orders');
        Route::get('/auctions', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalAuctions'])->name('auctions');
        Route::get('/treasury', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalTreasury'])->name('treasury');
        Route::get('/campaigns', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalCampaigns'])->name('campaigns');
        Route::get('/shipping', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalShipping'])->name('shipping');
        Route::get('/suppliers', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalSuppliers'])->name('suppliers');
        Route::get('/bi', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalBi'])->name('bi');
        Route::get('/client-auth', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalClientAuth'])->name('client_auth');
        Route::get('/contracts', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalContracts'])->name('contracts');
        Route::get('/risk', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalRisk'])->name('risk');
        Route::get('/compliance', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalCompliance'])->name('compliance');
        Route::get('/support', [\App\Http\Controllers\Ngis\DashboardController::class, 'internalSupport'])->name('support');
    });

    // قسم الثاني (مكتب توريد دولي)
    Route::prefix('international')->name('international.')->group(function () {
        Route::get('/contracts', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalContracts'])->name('contracts');
        Route::get('/factories', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalFactories'])->name('factories');
        Route::get('/orders', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalOrders'])->name('orders');
        Route::get('/treasury', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalTreasury'])->name('treasury');
        Route::get('/shipping', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalShipping'])->name('shipping');
        Route::get('/investments', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalInvestments'])->name('investments');
        Route::get('/auctions', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalAuctions'])->name('auctions');
        Route::get('/legal-risk', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalLegalRisk'])->name('legal_risk');
        Route::get('/supply-chain', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalSupplyChain'])->name('supply_chain');
        Route::get('/compliance', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalCompliance'])->name('compliance');
        Route::get('/support', [\App\Http\Controllers\Ngis\DashboardController::class, 'internationalSupport'])->name('support');
    });
});

// الصين
Route::prefix('china')->name('china.')->middleware(['auth', 'dashboard.type:china'])->group(function () {
    Route::get('/dashboard', [ChinaDashboard::class, 'index'])->name('dashboard');
    Route::get('/details', [ChinaDashboard::class, 'showDetails'])->name('details');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/my-wallet', [WalletController::class, 'myWallet'])->name('wallet');

    Route::get('/invoices', [ChinaOfficeController::class, 'invoices'])->name('invoices');
    Route::get('/invoices/{order}', [ChinaOfficeController::class, 'showInvoice'])->name('invoices.show');
    Route::get('/regional-offices', [ChinaOfficeController::class, 'regionalOffices'])->name('regional_offices');
    Route::get('/regional-offices/{user}', [ChinaOfficeController::class, 'showRegionalOffice'])->name('regional_offices.show');
    Route::get('/customers', [ChinaOfficeController::class, 'customers'])->name('customers');
    Route::get('/customers/{user}', [ChinaOfficeController::class, 'showCustomer'])->name('customers.show');
    Route::get('/product-status', [ChinaOfficeController::class, 'productStatus'])->name('product_status');
    Route::get('/product-status/{order}', [ChinaOfficeController::class, 'showProduct'])->name('product_status.show');
});
// شركة الشحن الدولية
Route::prefix('global-forwarding')->name('global_forwarding.')->middleware(['auth', 'dashboard.type:global_forwarding'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\GlobalForwarding\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/my-wallet', [\App\Http\Controllers\Admin\WalletController::class, 'myWallet'])->name('wallet');

    // مسارات الطلبات
    Route::get('/orders/standard', [\App\Http\Controllers\GlobalForwarding\DashboardController::class, 'standardOrders'])->name('orders.standard');
    Route::get('/orders/custom', [GlobalForwardingDashboard::class, 'customOrders'])->name('orders.custom');
    Route::get('/orders/matched-products', [GlobalForwardingDashboard::class, 'matchedProducts'])->name('orders.matched_products');
    Route::get('/orders/custom/{id}', [GlobalForwardingDashboard::class, 'showCustomOrder'])->name('orders.custom.show');
    Route::get('/orders/custom/{id}/upload-match', [GlobalForwardingDashboard::class, 'showUploadMatch'])->name('orders.custom.upload_match');
    
    // مسارات الرفع المتخصصة للمطابقة
    Route::get('/orders/custom/{id}/upload-match/carton', [GlobalForwardingDashboard::class, 'uploadCarton'])->name('orders.custom.upload.carton');
    Route::get('/orders/custom/{id}/upload-match/special', [GlobalForwardingDashboard::class, 'uploadSpecial'])->name('orders.custom.upload.special');
    Route::get('/orders/custom/{id}/upload-match/car-light', [GlobalForwardingDashboard::class, 'uploadCarLight'])->name('orders.custom.upload.car_light');
    Route::get('/orders/custom/{id}/upload-match/car-heavy', [GlobalForwardingDashboard::class, 'uploadCarHeavy'])->name('orders.custom.upload.car_heavy');
    Route::patch('/orders/custom/{id}', [GlobalForwardingDashboard::class, 'updateCustomOrder'])->name('orders.custom.update');
    Route::delete('/orders/custom/{id}', [GlobalForwardingDashboard::class, 'deleteCustomOrder'])->name('orders.custom.delete');

    // التوثيق الرقمي والوسم
    Route::get('/qr-passport', [\App\Http\Controllers\GlobalForwarding\DashboardController::class, 'qrPassport'])->name('qr_passport');

    // التأمين والامتثال
    Route::get('/insurance', [\App\Http\Controllers\GlobalForwarding\DashboardController::class, 'insurance'])->name('insurance');

    // المسؤولية وإدارة المخاطر
    Route::get('/liability-risk', [\App\Http\Controllers\GlobalForwarding\DashboardController::class, 'liabilityRisk'])->name('liability_risk');

    // الربط اللوجستي الإقليمي
    Route::get('/regional-integration', [\App\Http\Controllers\GlobalForwarding\DashboardController::class, 'regionalIntegration'])->name('regional_integration');
});

// ============================================================
// المنتجات (للمصانع والشركات)
// ============================================================
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserSectorController;

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/create/carton', [ProductController::class, 'createCarton'])->name('products.create.carton');
    Route::get('/products/create/special', [ProductController::class, 'createSpecial'])->name('products.create.special');
    Route::get('/cars/create', [ProductController::class, 'carCreate'])->name('cars.create');
    Route::get('/cars/create/light', [ProductController::class, 'carCreateLight'])->name('cars.create.light');
    Route::get('/cars/create/heavy', [ProductController::class, 'carCreateHeavy'])->name('cars.create.heavy');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // AJAX for dropdowns
    Route::get('/api/branches/{sector_id}', [ProductController::class, 'getBranches'])->name('products.get-branches');
    Route::get('/api/categories/{branch_id}', [ProductController::class, 'getCategories'])->name('products.get-categories');
    Route::post('/api/quick-sector', [ProductController::class, 'quickStoreSector'])->name('api.quick-sector');
    Route::post('/api/quick-branch', [ProductController::class, 'quickStoreBranch'])->name('api.quick-branch');
    Route::post('/api/quick-category', [ProductController::class, 'quickStoreCategory'])->name('api.quick-category');
    Route::post('/vehicles', [ProductController::class, 'storeVehicle'])->name('products.store-vehicle');

    // Manage User Sectors
    Route::get('/user-sectors', [UserSectorController::class, 'index'])->name('user-sectors.index');
    Route::get('/user-sectors/create', [UserSectorController::class, 'create'])->name('user-sectors.create');
    Route::post('/user-sectors', [UserSectorController::class, 'store'])->name('user-sectors.store');
    Route::delete('/user-sectors/{sector}', [UserSectorController::class, 'destroy'])->name('user-sectors.destroy');
    // Order Management
    Route::middleware('auth')->group(function () {
        Route::get('/my-orders', [OrderController::class, 'index'])->name('client.orders.index');
        
        // Site Products Search and Filtering
        Route::get('/site-products', [\App\Http\Controllers\Client\ProductSearchController::class, 'index'])->name('site.products.index');
        Route::get('/site-products/{id}', [\App\Http\Controllers\Client\ProductSearchController::class, 'show'])->name('site.products.show');
        Route::get('/api/branches/{sector_id}', [\App\Http\Controllers\Client\ProductSearchController::class, 'getBranches']);
        Route::get('/api/categories/{branch_id}', [\App\Http\Controllers\Client\ProductSearchController::class, 'getCategories']);

        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('/received-orders', [OrderController::class, 'receivedOrders'])->name('orders.received');
        Route::get('/received-orders/{order}', [OrderController::class, 'showReceivedOrder'])->name('orders.received.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('/orders/bulk', [OrderController::class, 'bulkStore'])->name('orders.bulk-store');
    });
});

require __DIR__.'/auth.php';
