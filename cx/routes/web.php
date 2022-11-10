<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerEmployeeController;
use App\Http\Controllers\CustomerPremiseController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PriceListExportController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\CanViewInvoice;
use App\Http\Middleware\HasFinancePermission;
use App\Http\Middleware\HasOrderPermission;
use App\Http\Middleware\IsCustomerAdmin;
use App\Http\Middleware\IsDev;
use App\Http\Middleware\IsRielActive;
use Illuminate\Support\Facades\Route;

// Főoldal=====================================================================================================
Route::get('/', HomeController::class)->name('hu.home');
Route::get('en', HomeController::class)->name('en.home');
Route::get('de', HomeController::class)->name('de.home');

// Üzletágak=====================================================================================================

Route::get('uzletagak', [PageController::class, 'divisions'])->name('hu.divisions');
Route::get('en/divisions', [PageController::class, 'divisions'])->name('en.divisions');
Route::get('de/abteilungen', [PageController::class, 'divisions'])->name('de.divisions');

// Kapcsolat=====================================================================================================

Route::get('kapcsolat', [ContactController::class, 'index'])->name('hu.contact');
Route::get('en/contact', [ContactController::class, 'index'])->name('en.contact');
Route::get('de/beziehung', [ContactController::class, 'index'])->name('de.contact');

Route::post('{locale}/contact/post', [ContactController::class, 'send'])->name('contact.post');

// Karrier=====================================================================================================

Route::get('karrier', [PageController::class, 'career'])->name('hu.career');
Route::get('en/career', [PageController::class, 'career'])->name('en.career');
Route::get('de/kerrier', [PageController::class, 'career'])->name('de.career');

// ASZF=====================================================================================================

Route::get('aszf', [PageController::class, 'terms'])->name('hu.terms');
Route::get('en/terms', [PageController::class, 'terms'])->name('en.terms');
Route::get('de/geschaftsbedingungen', [PageController::class, 'terms'])->name('de.terms');

// Adatvédelem=====================================================================================================

Route::get('adatkezelesi-tajekoztato', [PageController::class, 'privacy'])->name('hu.privacy');
Route::get('en/privacy', [PageController::class, 'privacy'])->name('en.privacy');
Route::get('de/datenschutzhinweis', [PageController::class, 'privacy'])->name('de.privacy');

// Összehasonlítás=====================================================================================================

Route::get('termekek/osszehasonlitas', [ComparisonController::class, 'index'])->name('hu.comparison.index');
Route::get('en/products/comparison', [ComparisonController::class, 'index'])->name('en.comparison.index');
Route::get('de/produkte/vergleich', [ComparisonController::class, 'index'])->name('de.comparison.index');

Route::post('{locale}/comparison/set/{Termek_ID}', [ComparisonController::class, 'set'])->name('comparison.set');
Route::post('{locale}/comparison/delete/{Termek_ID}', [ComparisonController::class, 'delete'])->name('comparison.delete');
Route::post('{locale}/comparison/clear', [ComparisonController::class, 'clear'])->name('comparison.clear');

// Fő termékategória=====================================================================================================

Route::get('termekek', [ProductCategoryController::class, 'show'])->name('hu.product.category.main');
Route::post('termekek', [ProductCategoryController::class, 'refresh']);

Route::get('en/products', [ProductCategoryController::class, 'show'])->name('en.product.category.main');
Route::post('en/products', [ProductCategoryController::class, 'refresh']);

Route::get('de/produkte', [ProductCategoryController::class, 'show'])->name('de.product.category.main');
Route::post('de/produkte', [ProductCategoryController::class, 'refresh']);

// Termékategória=====================================================================================================

Route::get('termekek/{Eleres}', [ProductCategoryController::class, 'show'])->name('hu.product.category.show');
Route::post('termekek/{Eleres}', [ProductCategoryController::class, 'refresh']);

Route::get('en/products/{Eleres}', [ProductCategoryController::class, 'show'])->name('en.product.category.show');
Route::post('en/products/{Eleres}', [ProductCategoryController::class, 'refresh']);

Route::get('de/produkte/{Eleres}', [ProductCategoryController::class, 'show'])->name('de.product.category.show');
Route::post('de/produkte/{Eleres}', [ProductCategoryController::class, 'refresh']);

// Termék adatlap=====================================================================================================

Route::middleware('old-slug')->group(function () {
    Route::get('termekek/{GyartoEleres}/{Eleres}', [ProductController::class, 'show'])->name('hu.product.show');
    Route::get('en/products/{GyartoEleres}/{Eleres}', [ProductController::class, 'show'])->name('en.product.show');
    Route::get('de/produkte/{GyartoEleres}/{Eleres}', [ProductController::class, 'show'])->name('de.product.show');
});

// Akciók=====================================================================================================

Route::get('akcio', [SaleController::class, 'index'])->name('hu.page.promotion');
Route::get('en/promotion', [SaleController::class, 'index'])->name('en.page.promotion');
Route::get('de/promotionen', [SaleController::class, 'index'])->name('de.page.promotion');

// Fileok kiszoltálása=====================================================================================================

Route::get('media/{slug}', [MediaController::class, 'getMedia'])->name('media.get');
Route::get('media/{size}/{slug}', [MediaController::class, 'getImage'])->name('file.download.image');

Route::get('en/media/{slug}', [MediaController::class, 'getMedia'])->name('en.media.get');
Route::get('en/media/{size}/{slug}', [MediaController::class, 'getImage'])->name('en.file.download.image');

// Termékkategória navigáció=====================================================================================================

// Route::post('{locale}/product-category/navigator', 'ProductCategoryController@navigator')->name('product_category_navigator');

// Kijelentkezés=====================================================================================================

Route::get('kijelentkezes', [AuthController::class, 'logout'])->name('hu.logout');
Route::get('en/logout', [AuthController::class, 'logout'])->name('en.logout');
Route::get('de/aus', [AuthController::class, 'logout'])->name('de.logout');

// Keresés=====================================================================================================

Route::get('{locale}/search/data', [SearchController::class, 'data'])->name('search.data');

Route::get('{locale}/search/category/{TermekfaLevel_ID}', [SearchController::class, 'category'])->name('search.category');
Route::get('{locale}/search/knowledge/{Tudastar_ID}', [SearchController::class, 'knowledge'])->name('search.knowledge');
Route::get('{locale}/search/download/{Letoltes_ID}', [SearchController::class, 'download'])->name('search.download');
Route::get('{locale}/search/product/{Termek_ID}', [SearchController::class, 'product'])->name('search.product');
Route::get('{locale}/search/all/product', [SearchController::class, 'allProduct'])->name('search.all.product');

Route::middleware('auth')->group(function () {
    Route::get('fiok', [AccountController::class, 'index'])->name('hu.account.index');
    Route::get('en/account', [AccountController::class, 'index'])->name('en.account.index');
    Route::get('de/konto', [AccountController::class, 'index'])->name('de.account.index');

    // Profil=====================================================================================================

    Route::get('fiok/cimek', [AddressController::class, 'index'])->name('hu.account.addresses');
    Route::get('en/addresses', [AddressController::class, 'index'])->name('en.account.addresses');
    Route::get('de/addressen', [AddressController::class, 'index'])->name('de.account.addresses');

    Route::post('fiok/telephelyek', [CustomerPremiseController::class, 'store'])->name('account.customer-premise.store');
    Route::patch('fiok/telephelyek/{customerPremiseId}', [CustomerPremiseController::class, 'update'])->name('account.customer-premise.update');

    Route::post('fiok/telephelyek/check-sync-status', [CustomerPremiseController::class, 'checkSyncStatus'])->name('account.customer-premise.check-sync-status');
    Route::patch('fiok/telephelyek/{customerPremise}/set-activity', [CustomerPremiseController::class, 'setActivity'])->name('account.customer-premise.set-activity');

    // Email hitelesítés=====================================================================================================

    Route::get('{locale}/auth/send-verification', [AuthController::class, 'sendVerification'])->name('auth.send.verification');
});

Route::get('fiok/email-hitelesites/{token}', [AuthController::class, 'verify'])->name('hu.auth.verity');
Route::get('en/account/email-verify/{token}', [AuthController::class, 'verify'])->name('en.auth.verity');
Route::get('de/konto/email-bestatigung/{token}', [AuthController::class, 'verify'])->name('de.auth.verity');

// =====================================================================================================

Route::middleware(IsRielActive::class)->group(function () {
    Route::middleware(HasOrderPermission::class)->group(function () {
        // Kosár=====================================================================================================
        Route::get('kosar', [CartController::class, 'index'])->name('hu.cart');
        Route::get('en/cart', [CartController::class, 'index'])->name('en.cart');
        Route::get('de/korb', [CartController::class, 'index'])->name('de.cart');

        Route::post('{locale}/cart/add/{Termek_ID}', [CartController::class, 'add'])->name('cart.add');
        Route::post('{locale}/cart/set/{Termek_ID}', [CartController::class, 'set'])->name('cart.set');
        Route::post('{locale}/cart/delete/{Termek_ID}', [CartController::class, 'delete'])->name('cart.delete');

        // Szállítás=====================================================================================================

        Route::get('szallitas', [ShippingController::class, 'index'])->name('hu.shipping');
        Route::get('en/shipping', [ShippingController::class, 'index'])->name('en.shipping');
        Route::get('de/transport', [ShippingController::class, 'index'])->name('de.shipping');
        Route::post('{locale}/order/shipping-save', [ShippingController::class, 'store'])->name('shipping.save');

        Route::post('{locale}/order/prices', [OrderController::class, 'prices'])->name('order.prices');

        Route::post('addresses', [ShippingController::class, 'storeShippingAddress'])->name('shipping.store.address');
        Route::patch('addresses/{UgyfelCim_ID}', [ShippingController::class, 'update'])->name('shipping.update.address');
        Route::delete('addresses/{UgyfelCim_ID}', [ShippingController::class, 'delete'])->name('shipping.delete.address');

        // Számlázás =====================================================================================================

        Route::get('szamlazas', [BillingController::class, 'index'])->name('hu.billing');
        Route::get('en/billing', [BillingController::class, 'index'])->name('en.billing');
        Route::get('de/abrechnung', [BillingController::class, 'index'])->name('de.billing');

        Route::post('{locale}/billing-save', [BillingController::class, 'store'])->name('billing.save');

        // Rendelés véglegesítése=====================================================================================================

        Route::get('veglegesites', [OrderController::class, 'checkout'])->name('hu.checkout');
        Route::get('en/checkout', [OrderController::class, 'checkout'])->name('en.checkout');
        Route::get('de/kasse', [OrderController::class, 'checkout'])->name('de.checkout');

        Route::post('{locale}/checkout', [OrderController::class, 'checkoutSave'])->name('checkout.save');

        // Köszönjük a rendelést=====================================================================================================

        Route::get('koszonjuk/{Ev}-{Sorozat}/{Sorszam}', [OrderController::class, 'thankYou'])->name('hu.order.thank.you');
        Route::get('en/thank-you/{Ev}-{Sorozat}/{Sorszam}', [OrderController::class, 'thankYou'])->name('en.order.thank.you');
        Route::get('de/danke/{Ev}-{Sorozat}/{Sorszam}', [OrderController::class, 'thankYou'])->name('de.order.thank.you');

        // Rendelések listája=====================================================================================================

        Route::get('fiok/rendelesek', [OrderController::class, 'myOrders'])->name('hu.account.my.orders');
        Route::get('en/account/orders', [OrderController::class, 'myOrders'])->name('en.account.my.orders');
        Route::get('de/konto/angebote', [OrderController::class, 'myOrders'])->name('de.account.my.orders');

        // Rendelés=====================================================================================================

        Route::get('fiok/rendelesek/{Ev}-{Sorozat}/{Sorszam}', [OrderController::class, 'show'])->name('hu.account.order.show');
        Route::get('en/account/orders/{Ev}-{Sorozat}/{Sorszam}', [OrderController::class, 'show'])->name('en.account.order.show');
        Route::get('de/konto/angebote/{Ev}-{Sorozat}/{Sorszam}', [OrderController::class, 'show'])->name('de.account.order.show');
    });

    // Profil=====================================================================================================

    Route::post('{locale}/account/installer-price-save', [AccountController::class, 'installerPriceSave'])->name('installer.price.save');

    // Szervíz listám=====================================================================================================

    Route::get('fiok/szerviz', [ServiceController::class, 'index'])->name('hu.service.list');
    Route::get('en/account/service', [ServiceController::class, 'index'])->name('en.service.list');
    Route::get('de/konto/bedienung', [ServiceController::class, 'index'])->name('de.service.list');

    // Szervíz lap megtekintáse=====================================================================================================

    Route::get('fiok/szerviz/{id}', [ServiceController::class, 'show'])->name('hu.service.show');
    Route::get('en/account/service/{id}', [ServiceController::class, 'show'])->name('en.service.show');
    Route::get('de/konto/bedienung/{id}', [ServiceController::class, 'show'])->name('de.service.show');

    // Számla listám=====================================================================================================

    Route::middleware(HasFinancePermission::class)->group(function () {
        Route::get('fiok/szamlak', [InvoiceController::class, 'index'])->name('hu.invoices.index');
        Route::get('en/account/invoices', [InvoiceController::class, 'index'])->name('en.invoices.index');
        Route::get('de/konto/rechnungen', [InvoiceController::class, 'index'])->name('de.invoices.index');

        // Számla megtekintáse=====================================================================================================

        Route::middleware(CanViewInvoice::class)->group(function () {
            Route::get('fiok/szamlak/{Ev}-{Sorozat}/{Sorszam}', [InvoiceController::class, 'show'])->name('hu.invoices.show');
            Route::get('en/account/invoices/{Ev}-{Sorozat}/{Sorszam}', [InvoiceController::class, 'show'])->name('en.invoices.show');
            Route::get('de/konto/rechnungen/{Ev}-{Sorozat}/{Sorszam}', [InvoiceController::class, 'show'])->name('de.invoices.show');
            Route::get('fiok/szamlak/{Ev}-{Sorozat}/{Sorszam}/pdf', [InvoiceController::class, 'getPdf'])->name('hu.invoices.pdf');
            Route::get('en/account/invoices/{Ev}-{Sorozat}/{Sorszam}/pdf', [InvoiceController::class, 'getPdf'])->name('en.invoices.pdf');
            Route::get('de/konto/rechnungen/{Ev}-{Sorozat}/{Sorszam}/pdf', [InvoiceController::class, 'getPdf'])->name('de.invoices.pdf');
        });
    });

    // Export=====================================================================================================

    Route::middleware(['competitor'])->group(function () {
        Route::get('fiok/arlista', [PriceListExportController::class, 'index'])->name('hu.export.index');
        Route::get('en/account/price-list', [PriceListExportController::class, 'index'])->name('en.export.index');
        Route::get('de/konto/preisliste', [PriceListExportController::class, 'index'])->name('de.export.index');

        Route::get('fiok/arlista/termekek.{type}', [PriceListExportController::class, 'download'])->name('hu.export.download');
        Route::get('en/account/price-list/products.{type}', [PriceListExportController::class, 'download'])->name('en.export.download');
        Route::get('de/konto/preisliste/produkte.{type}', [PriceListExportController::class, 'download'])->name('de.export.download');
    });

    // Beállítások=====================================================================================================

    Route::get('fiok/beallitasok', [SettingController::class, 'index'])->name('hu.settings.index');
    Route::get('en/account/properties', [SettingController::class, 'index'])->name('en.settings.index');
    Route::get('de/konto/einstellungen', [SettingController::class, 'index'])->name('de.settings.index');

    Route::post('{locale}/newsletter/update', [NewsletterController::class, 'update'])->name('newsletter.update');

    // Szállítási idő=====================================================================================================

    Route::post('{locale}/product/delivery-time/{Termek_ID}', [ProductController::class, 'deliveryTime'])->name('product.delivery.time');
    Route::post('{locale}/product/delivery-time-info/{Termek_ID}/{Mennyiseg}', [ProductController::class, 'deliveryTimeInfo'])->name('product.delivery.time.info');
});

Route::middleware('auth')->group(function () {
    Route::get('fiok/jogosultsagok', [CustomerEmployeeController::class, 'index'])->name('hu.employees.index');
    Route::get('en/account/permissions', [CustomerEmployeeController::class, 'index'])->name('en.employees.index');
    Route::get('de/konto/rechte', [CustomerEmployeeController::class, 'index'])->name('de.employees.index');
});

Route::middleware(IsCustomerAdmin::class)->group(function () {
    // Munkatársak=====================================================================================================

    Route::get('fiok/munkatarsak/felhasznalo-meghivasa', [CustomerEmployeeController::class, 'inviteUserForm'])->name('hu.employee.invite.user.form');
    Route::get('en/employees/invite-user', [CustomerEmployeeController::class, 'inviteUserForm'])->name('en.employee.invite.user.form');
    Route::get('de/angestellte/benutzer-einladen', [CustomerEmployeeController::class, 'inviteUserForm'])->name('de.employee.invite.user.form');

    Route::post('{locale}/employees/invite-user', [CustomerEmployeeController::class, 'inviteUser'])->name('employee.invite.user');
    Route::get('{locale}/employees/delete-invitation/{user}', [CustomerEmployeeController::class, 'deleteInvitation'])->name('employee.deleteInvitation');

    // Munkatárs meghívása
    Route::get('fiok/munkatarsak/meghivo/{customerId}/{customerEmployeeId}', [CustomerEmployeeController::class, 'inviteEmployeeForm'])->name('hu.employee.invite.form');
    Route::get('en/employees/invite/{customerId}/{customerEmployeeId}', [CustomerEmployeeController::class, 'inviteEmployeeForm'])->name('en.employee.invite.form');
    Route::get('de/angestellte/einladen/{customerId}/{customerEmployeeId}', [CustomerEmployeeController::class, 'inviteEmployeeForm'])->name('de.employee.invite.form');

    Route::post('{locale}/employees/invite/{customerId}/{customerEmployeeId}', [CustomerEmployeeController::class, 'inviteEmployee'])->name('employee.invite');

    Route::get('fiok/munkatarsak/beallitas/{userId}', [CustomerEmployeeController::class, 'settings'])->name('hu.employee.settings');
    Route::get('en/employees/settings/{userId}', [CustomerEmployeeController::class, 'settings'])->name('en.employee.settings');
    Route::get('de/angestellte/einstellungen/{userId}', [CustomerEmployeeController::class, 'settings'])->name('de.employee.settings');

    Route::post('{locale}/employees/settings/{userId}', [CustomerEmployeeController::class, 'settingsSave'])->name('employee.settings.save');
});

Route::get('fiok/munkatarsak/{customerId}/{customerEmployeeId}', [CustomerEmployeeController::class, 'show'])->name('hu.employee.show');
Route::get('en/employees/{customerId}/{customerEmployeeId}', [CustomerEmployeeController::class, 'show'])->name('en.employee.show');
Route::get('de/angestellte/{customerId}/{customerEmployeeId}', [CustomerEmployeeController::class, 'show'])->name('de.employee.show');

Route::get('{locale}/employees/invite/confirmation/{token}', [CustomerEmployeeController::class, 'confirmation'])->name('employee.invite.confirmation');

// Hírlevél beállítások=====================================================================================================

Route::get('newsletter/{id}/{hash}', [NewsletterController::class, 'editSubscriptions'])->name('newsletter.subscriptions.edit');
Route::post('newsletter/{id}/{hash}', [NewsletterController::class, 'updateSubscriptions'])->name('newsletter.subscriptions.update');

// Masquerade=====================================================================================================

Route::middleware(IsDev::class)->group(function () {
    Route::get('masquerade', [DevController::class, 'masquerade'])->name('masquerade');
    Route::post('masquerade/set', [DevController::class, 'masqueradeSet'])->name('masquerade.set');
});

// simple-pay=====================================================================================================

Route::get('order/simple-pay/back', [OrderController::class, 'simplePayBack'])->name('hu.order.simple.pay.back');
Route::get('en/order/simple-pay/back', [OrderController::class, 'simplePayBack'])->name('en.order.simple.pay.back');
Route::get('de/order/simple-pay/back', [OrderController::class, 'simplePayBack'])->name('de.order.simple.pay.back');

Route::post('simple-pay/ipn/{currency_code}', [OrderController::class, 'simplePayIpn']);

// API=====================================================================================================

Route::get('csv/v3.0/{api_key}', [ApiController::class, 'csv'])->name('api.csv');
Route::get('xml/v3.0/{api_key}', [ApiController::class, 'xml'])->name('api.xml');

// Sitemap=====================================================================================================

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('{locale}/sitemap/{type}.xml', [SitemapController::class, 'type'])->name('sitemap.type');

Route::post('/close-site-message', [PageController::class, 'closeSiteMessage']);
Route::post('/check-company', [AuthController::class, 'getCompanyDetailsByTaxNumber']);
