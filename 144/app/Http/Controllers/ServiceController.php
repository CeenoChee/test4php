<?php

namespace App\Http\Controllers;

use App\Models\ServiceCertificate;

class ServiceController extends Controller
{
    public function index()
    {
        $serviceCertificates = ServiceCertificate::where('Ugyfel_ID', app('User')->getCustomer()->Ugyfel_ID)
            ->with('serviceCertificateEvent')
            ->paginate();

        return view('pages.services.index', [
            'serviceCertificates' => $serviceCertificates,
        ]);
    }

    public function show($id)
    {
        $serviceCertificate = ServiceCertificate::findOrfail($id);

        if ($serviceCertificate->Ugyfel_ID !== app('User')->getCustomer()->Ugyfel_ID) {
            abort(404);
        }

        $serviceCertificateEvent = $serviceCertificate->serviceCertificateEvent()->orderBy('Datum', 'DESC')->first();

        return view('pages.services.show', [
            'serviceCertificate' => $serviceCertificate,
            'serviceCertificateEvent' => $serviceCertificateEvent,
        ]);
    }
}
