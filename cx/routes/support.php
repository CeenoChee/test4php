<?php

use App\Http\Controllers\DownloadCategoryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\KnowledgeCategoryController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Támogatás=====================================================================================================

Route::get('tamogatas', [SupportController::class, 'index'])->name('hu.support');
Route::get('en/support', [SupportController::class, 'index'])->name('en.support');
Route::get('de/unterstutzung', [SupportController::class, 'index'])->name('de.support');

// Támogatás találatok=====================================================================================================

Route::get('tamogatas/talalatok', [SupportController::class, 'results'])->name('hu.support.results');
Route::get('en/support/results', [SupportController::class, 'results'])->name('en.support.results');
Route::get('de/unterstutzung/ergebnisse', [SupportController::class, 'results'])->name('de.support.results');

// Letöltések=====================================================================================================

Route::get('tamogatas/letoltesek', [DownloadCategoryController::class, 'index'])->name('hu.download.categories.index');
Route::get('en/support/downloads', [DownloadCategoryController::class, 'index'])->name('en.download.categories.index');
Route::get('de/unterstutzung/downloads', [DownloadCategoryController::class, 'index'])->name('de.download.categories.index');

// Letöltés találatok=====================================================================================================

Route::get('tamogatas/letoltesek/talalatok', [DownloadController::class, 'results'])->name('hu.download.results');
Route::get('en/support/downloads/results', [DownloadController::class, 'results'])->name('en.download.results');
Route::get('de/unterstutzung/downloads/ergebnisse', [DownloadController::class, 'results'])->name('de.download.results');

// Letöltés kategória=====================================================================================================

Route::get('tamogatas/letoltesek/kategóriak/{downloadCategorySlug}', [DownloadCategoryController::class, 'show'])->name('hu.download.categories.show');
Route::get('en/support/downloads/categories/{downloadCategorySlug}', [DownloadCategoryController::class, 'show'])->name('en.download.categories.show');
Route::get('de/unterstutzung/downloads/gruppen/{downloadCategorySlug}', [DownloadCategoryController::class, 'show'])->name('de.download.categories.show');

// Letöltés=====================================================================================================

Route::get('tamogatas/letoltesek/letoltes/{download}', [DownloadController::class, 'show'])->name('hu.download.show');
Route::get('en/support/downloads/download/{download}', [DownloadController::class, 'show'])->name('en.download.show');
Route::get('de/unterstutzung/downloads/download/{download}', [DownloadController::class, 'show'])->name('de.download.show');

// Tudástár=====================================================================================================

Route::get('tamogatas/tudastar', [KnowledgeController::class, 'index'])->name('hu.knowledge.index');
Route::get('en/support/knowledge', [KnowledgeController::class, 'index'])->name('en.knowledge.index');
Route::get('de/unterstutzung/wissen', [KnowledgeController::class, 'index'])->name('de.knowledge.index');

Route::post('/knowledge/ajax/view', [KnowledgeController::class, 'ajaxIncreaseViews'])->name('knowledge.view');

// Tudástár kompatibilitás=====================================================================================================

Route::get('tamogatas/tudastar/kompatibilitas/hikvision-ip-es-ketvezetekes-kaputelefon-kompatibilitasi-tablazat', [KnowledgeController::class, 'compatibility_intercom'])->name('hu.knowledge.compatibility');
Route::get('en/support/knowledge/compatibility/hikvision-ip-and-two-wired-intercom-compatibility-table', [KnowledgeController::class, 'compatibility_intercom'])->name('en.knowledge.compatibility');
Route::get('de/unterstutzung/wissen/kompatibilitat/hikvision-ip-und-zweidraht-intercom-kompatibilitat-tafel', [KnowledgeController::class, 'compatibility_intercom'])->name('de.knowledge.compatibility');

// Tudástár találatok=====================================================================================================

Route::get('tamogatas/tudastar/talalatok', [KnowledgeController::class, 'results'])->name('hu.knowledge.results');
Route::get('en/support/knowledge/results', [KnowledgeController::class, 'results'])->name('en.knowledge.results');
Route::get('de/unterstutzung/wissen/ergebnisse', [KnowledgeController::class, 'results'])->name('de.knowledge.results');

// Tudástár kategória=====================================================================================================

Route::get('tamogatas/tudastar/{slug}', [KnowledgeCategoryController::class, 'show'])->name('hu.knowledge.category');
Route::get('en/support/knowledge/{slug}', [KnowledgeCategoryController::class, 'show'])->name('en.knowledge.category');
Route::get('de/unterstutzung/wissen/{slug}', [KnowledgeCategoryController::class, 'show'])->name('de.knowledge.category');

// Tudástár cikk=====================================================================================================

Route::get('tamogatas/tudastar/{categorySlug}/{slug}', [KnowledgeController::class, 'show'])->name('hu.knowledge.article');
Route::get('en/support/knowledge/{categorySlug}/{slug}', [KnowledgeController::class, 'show'])->name('en.knowledge.article');
Route::get('de/unterstutzung/wissen/{categorySlug}/{slug}', [KnowledgeController::class, 'show'])->name('de.knowledge.article');

// Hibajegyek=====================================================================================================

Route::get('tamogatas/hibajegyek', [TicketController::class, 'ticket'])->name('hu.ticket');
Route::get('en/support/tickets', [TicketController::class, 'ticket'])->name('en.ticket');
Route::get('de/unterstutzung/tickets', [TicketController::class, 'ticket'])->name('de.ticket');

Route::post('{locale}/tickets/post', [TicketController::class, 'ticketPost'])->name('ticket.post');

// Videók=====================================================================================================

Route::get('tamogatas/videok', [VideoController::class, 'index'])->name('hu.videos.index');
Route::get('en/support/videos', [VideoController::class, 'index'])->name('en.videos.index');
Route::get('de/unterstutzung/videos', [VideoController::class, 'index'])->name('de.videos.index');

// Videók találatok=====================================================================================================

Route::get('tamogatas/videok/talalatok', [VideoController::class, 'search'])->name('hu.videos.search');
Route::get('en/support/videos/results', [VideoController::class, 'search'])->name('en.videos.search');
Route::get('de/unterstutzung/videos/ergebnisse', [VideoController::class, 'search'])->name('de.videos.search');

// Videó listák=====================================================================================================

Route::get('tamogatas/videok/{slug}', [VideoController::class, 'showCategory'])->name('hu.videos.categories.show');
Route::get('en/support/videos/{slug}', [VideoController::class, 'showCategory'])->name('en.videos.categories.show');
Route::get('de/unterstutzung/videos/{slug}', [VideoController::class, 'showCategory'])->name('de.videos.categories.show');

// Gyik=====================================================================================================

Route::get('tamogatas/gyik', [PageController::class, 'faq'])->name('hu.faq');
Route::get('en/support/faq', [PageController::class, 'faq'])->name('en.faq');
Route::get('de/unterstutzung/faq', [PageController::class, 'faq'])->name('de.faq');

// Garancia=====================================================================================================

Route::get('tamogatas/garancia', [PageController::class, 'warranty'])->name('hu.warranty');
Route::get('en/support/warranty', [PageController::class, 'warranty'])->name('en.warranty');
Route::get('de/unterstutzung/garantie', [PageController::class, 'warranty'])->name('de.warranty');

// Szerviz=====================================================================================================

Route::get('tamogatas/szerviz', [PageController::class, 'repair'])->name('hu.repair');
Route::get('en/support/repair', [PageController::class, 'repair'])->name('en.repair');
Route::get('de/unterstutzung/reparatur', [PageController::class, 'repair'])->name('de.repair');
