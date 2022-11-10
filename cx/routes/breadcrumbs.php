<?php

use App\Libs\LUrl;
use Diglactic\Breadcrumbs\Breadcrumbs;

// Főoldal
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(__('pages/home.home'), LUrl::route('home'));
});

// Termekkategoria
Breadcrumbs::register('product_category', function ($breadcrumbs, $productCategory = null) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/products.products'), LUrl::routeCategory());

    if ($productCategory !== null) {
        foreach (app('Category')->getParents($productCategory->TermekfaLevel_ID) as $parent) {
            $breadcrumbs->push($parent->trans->Nev, LUrl::routeCategory($parent));
        }
        $breadcrumbs->push($productCategory->trans->Nev, LUrl::routeCategory($productCategory));
    }
});

// Termék
Breadcrumbs::register('product', function ($breadcrumbs, $product) {
    $primaryCategory = $product->getPrimaryCategory();

    if ($primaryCategory) {
        if ($primaryCategory->productCategory->count() > 0) {
            $breadcrumbs->parent('product_category', $primaryCategory->productCategory);
        } else {
            $breadcrumbs->parent('home');
        }
    } else {
        $breadcrumbs->parent('home');
    }

    $breadcrumbs->push($product->Kod, LUrl::routeProduct($product));
});

// Akadémia
Breadcrumbs::register('academy', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/academy.academy'), LUrl::route('academy'));
});

// Termék összehasonlítás
Breadcrumbs::register('comparison', function ($breadcrumbs) {
    $breadcrumbs->parent('product_category');
    $breadcrumbs->push(__('pages/comparison.compare'), LUrl::route('comparison.index'));
});

// Üzletágak
Breadcrumbs::register('divisions', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/divisions.title'), LUrl::route('divisions'));
});

// Kapcsolat
Breadcrumbs::register('contact', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/contact.contact'), LUrl::route('contact'));
});

// Adatkezelés
Breadcrumbs::register('privacy', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/privacy.title'), LUrl::route('privacy'));
});

// Ászf
Breadcrumbs::register('terms', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/terms.terms'), LUrl::route('terms'));
});

// Karrier
Breadcrumbs::register('career', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/career.career'), LUrl::route('career'));
});

// Media
Breadcrumbs::register('media', function ($breadcrumbs, $media) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/media.download'), route('media.get', $media));
});

// Támogatás
Breadcrumbs::register('support', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/supports.support'), LUrl::route('support'));
});

// Letöltések
Breadcrumbs::register('downloads', function ($breadcrumbs) {
    $breadcrumbs->parent('support');
    $breadcrumbs->push(__('pages/downloads.downloads'), LUrl::route('download.categories.index'));
});

// Letöltés
Breadcrumbs::register('download', function ($breadcrumbs, App\Models\Download $download) {
    $breadcrumbs->parent('downloads');
    $breadcrumbs->push($download->trans()->name, LUrl::route('download.show', $download));
});

// Letöltés csoport
Breadcrumbs::register('download.categories.show', function ($breadcrumbs, $downloadCategory) {
    $breadcrumbs->parent('downloads');
    $breadcrumbs->push($downloadCategory->translation->name, LUrl::route('download.categories.show', ['downloadCategorySlug' => $downloadCategory->translation->slug]));
});

// Tudástár
Breadcrumbs::register('knowledge', function ($breadcrumbs) {
    $breadcrumbs->parent('support');
    $breadcrumbs->push(__('pages/knowledge.knowledge'), LUrl::route('knowledge.index'));
});

// Kompatibilitás
Breadcrumbs::register('knowledge.compatibility', function ($breadcrumbs) {
    $breadcrumbs->parent('knowledge');
    $breadcrumbs->push(__('pages/knowledge.compatibility'), LUrl::route('knowledge.compatibility'));
});

// Tudástár kategória
Breadcrumbs::register('knowledge.category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('knowledge');
    $breadcrumbs->push($category->translation->name, LUrl::route('knowledge.category', ['slug' => $category->translation->slug]));
});

// Tudástár cikk
Breadcrumbs::register('knowledge.article', function ($breadcrumbs, $knowledge) {
    $breadcrumbs->parent('knowledge');
    $breadcrumbs->push($knowledge->translation->title, LUrl::routeKnowledge($knowledge));
});

// Hibajegyek
Breadcrumbs::register('ticket', function ($breadcrumbs) {
    $breadcrumbs->parent('support');
    $breadcrumbs->push(__('pages/tickets.tickets'), LUrl::route('ticket'));
});

// Videók
Breadcrumbs::register('videos.index', function ($breadcrumbs) {
    $breadcrumbs->parent('support');
    $breadcrumbs->push(__('pages/videos.videos'), LUrl::route('videos.index'));
});

// Videó listák
Breadcrumbs::register('videos.categories.show', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('videos.index');
    $breadcrumbs->push($category->name, LUrl::route('videos.categories.show', $category->slug));
});

// GYIK
Breadcrumbs::register('faq', function ($breadcrumbs) {
    $breadcrumbs->parent('support');
    $breadcrumbs->push(__('pages/faq.faq'), LUrl::route('faq'));
});

// Garancia
Breadcrumbs::register('warranty', function ($breadcrumbs) {
    $breadcrumbs->parent('support');
    $breadcrumbs->push(__('pages/warranties.warranty'), LUrl::route('warranty'));
});

// Szerviz
Breadcrumbs::register('repair', function ($breadcrumbs) {
    $breadcrumbs->parent('support');
    $breadcrumbs->push(__('pages/repair.repair'), LUrl::route('repair'));
});

// Kosár
Breadcrumbs::register('cart', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/orders.cart'), LUrl::route('cart'));
});

// Számlázás
Breadcrumbs::register('billing', function ($breadcrumbs) {
    $breadcrumbs->parent('cart');
    $breadcrumbs->push(__('pages/orders.billing'), LUrl::route('billing'));
});

// Szállítás
Breadcrumbs::register('shipping', function ($breadcrumbs) {
    $breadcrumbs->parent('billing');
    $breadcrumbs->push(__('pages/orders.shipping'), LUrl::route('shipping'));
});

// Rendelés véglegesítése
Breadcrumbs::register('checkout', function ($breadcrumbs) {
    $breadcrumbs->parent('shipping');
    $breadcrumbs->push(__('pages/orders.checkout'), LUrl::route('checkout'));
});

// Keresés
Breadcrumbs::register('search', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('global.search'), LUrl::route('search'));
});

// Fiók
Breadcrumbs::register('account', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/account.account'), LUrl::route('account.index'));
});

// Jelszó módosítás
Breadcrumbs::register('update-password', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/auth.update_password'), LUrl::route('password.update'));
});

// Profil
Breadcrumbs::register('profile', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/account.profile'), LUrl::route('account.index'));
});

// Címek
Breadcrumbs::register('addresses', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/account.addresses'), LUrl::route('account.addresses'));
});

// Export
Breadcrumbs::register('export', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/export.price_list'), LUrl::route('export.index'));
});

// Jogosultságok
Breadcrumbs::register('permissions', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/account.permissions'), LUrl::route('employees.index'));
});

// Felhasználó meghívása
Breadcrumbs::register('permissions.invite_user', function ($breadcrumbs) {
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push(__('pages/account.invite_employee'), LUrl::route('employee.invite.user.form'));
});

// Munkatárs meghívása
Breadcrumbs::register('permissions.invite_employee', function ($breadcrumbs, App\Models\CustomerEmployee $customerEmployee) {
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push(__('pages/account.invite_employee'), LUrl::route('employee.invite.form', ['customerId' => $customerEmployee->Ugyfel_ID, 'customerEmployeeId' => $customerEmployee->UgyfelDolgozo_ID]));
});

// Felhsználó jogosultságainak beállítása
Breadcrumbs::register('permissions.settings', function ($breadcrumbs, App\Models\User $user) {
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push(__('pages/account.settings'), LUrl::route('employee.settings', ['userId' => $user->id]));
});

// Rendeléseim
Breadcrumbs::register('my_orders', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/orders.orders'), LUrl::route('account.my.orders'));
});

// Rendelés
Breadcrumbs::register('order_show', function ($breadcrumbs, $order) {
    $breadcrumbs->parent('my_orders');
    $breadcrumbs->push($order->getNumber(), LUrl::route('order.thank.you', [
        'Ev' => $order->getYear(),
        'Sorozat' => $order->getSerial(),
        'Sorszam' => str_pad($order->getSerialNumber(), 6, '0', STR_PAD_LEFT),
    ]));
});

// Rendelés megköszönése
Breadcrumbs::register('thank_you', function ($breadcrumbs) {
    $breadcrumbs->parent('my_orders');
    $breadcrumbs->push(__('pages/orders.thank_you'));
});

// Szervizeléseim
Breadcrumbs::register('services', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/services.repairs'), LUrl::route('service.list'));
});

// Szerviz
Breadcrumbs::register('service', function ($breadcrumbs, $serviceCertificate) {
    $breadcrumbs->parent('services');
    $breadcrumbs->push($serviceCertificate->getNumber(), LUrl::route('service.show', ['id' => $serviceCertificate->SzervizBiz_ID]));
});

// Promóció
Breadcrumbs::register('promotion', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push(__('pages/products.promotion'), LUrl::route('page.promotion'));
});

// Számláim
Breadcrumbs::register('invoices', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/invoices.invoices'), LUrl::route('invoices.index'));
});

// Számla
Breadcrumbs::register('invoice', function ($breadcrumbs, $invoice) {
    $breadcrumbs->parent('invoices');
    $breadcrumbs->push($invoice->getNumber(), $invoice->getShowRoute());
});

// Beállítások
Breadcrumbs::register('settings', function ($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push(__('pages/account.settings'), LUrl::route('settings.index'));
});
