@extends('layouts.app')

@section('title')
    @lang('pages/knowledge.compatibility') -
    @lang('pages/knowledge.hikvision_compatibility')
@endsection

@section('content_title')
    @lang('pages/knowledge.compatibility')
@endsection

@section('meta_description')
    @lang('pages/knowledge.compatibility') - @lang('pages/knowledge.hikvision_compatibility')
@endsection

@section('breadcrumb')
    {{ Breadcrumbs::render('knowledge.compatibility') }}
@endsection

@section('main')
    <h2>
        @lang('pages/knowledge.hikvision_compatibility')
    </h2>
    <div class="scrolling-box">
        <table class="matrix">
            <thead>
            <tr>
                <th>
                </td>
                <th><a href="https://files.riel.hu/adatlap/11615-1-1/DS-KH6210-L_adatlap_ENG.pdf">(DS-KH6210-L)</th>
                <!-- orig: DS-KH6320-TE1 -->
                <th><a href="https://files.riel.hu/adatlap/10890-2-1/DS-KH6310_adatlap_ENG.pdf">(DS-KH6310)</th>
                <!-- orig:DS-KH6320-WTE1  -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh8300-t">(DS-KH8300-T)</th>
                <!-- orig: DS-KH6320-WTE1-W -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh8301-wt">(DS-KH8301-WT)</th>
                <!-- orig: DS-KH8300-T -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-km8301">(DS-KM8301)</th>
                <!-- orig:DS-KH8301-WT -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh6320-te1">DS-KH6320-TE1</th>
                <!-- orig: DS-KH8350-TE1 -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh6320-wte1">DS-KH6320-WTE1</th>
                <!-- orig:DS-KH8350-WTE1-Gold -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh6320-wte1-w">DS-KH6320-WTE1-W</th>
                <!-- orig: DS-KH8350-WTE1-Grey -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh8350-te1">DS-KH8350-TE1</th>
                <!-- orig: DS-KH8520-WTE1 (Eu) -->
                <th><a href="https://www.riel.hu/termekek/hikvision/DS-KH8350-WTE1-Gold">DS-KH8350-WTE1-Gold</th>
                <!-- orig:DS-KM8301 -->
                <th><a href="https://www.riel.hu/termekek/hikvision/DS-KH8350-WTE1-Grey">DS-KH8350-WTE1-Grey</th>
                <!-- orig:DS-KH6320-WTE2 (Eu) -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh8520-wte1-europe-bv">DS-KH8520-WTE1 (Eu)</th>
                <!-- orig: DS-KH6320-WTE2-W -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh8340-tce2-b">(DS-KH8340-TCE2-B)</th>
                <!-- orig DS-KH8340-TCE2-B -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kh6320-wte2-europe-bv">DS-KH6320-WTE2 (Eu)</th>
                <!-- orig:DS-KAD706 -->
                <th><a href="https://www.riel.hu/termekek/hikvision/DS-KH6320-WTE2-W">DS-KH6320-WTE2-W</th>
                <!-- orig:DS-KAD706-S -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kad606">DS-KAD606</th> <!-- orig: DS-KAD709 -->
                <th><a href="https://files.riel.hu/adatlap/11616-1-1/DS-KAD606-N_adatlap_ENG.pdf">(DS-KAD606-N)</th>
                <!-- orig: DS-KH6210-L -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kad606-p">DS-KAD606-P</th>
                <!-- orig: DS-KH6310 -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kad612">DS-KAD612</th> <!-- orig: DS-KAD606 -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kad706">DS-KAD706</th>
                <!-- orig: (DS-KAD606-N) -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kad706-s">DS-KAD706-S</th>
                <!-- orig: DS-KAD606-P -->
                <th><a href="https://www.riel.hu/termekek/hikvision/ds-kad709">DS-KAD709</th> <!-- orig: DS-KAD612 -->
                <th><a href="https://www.riel.hu/tamogatas/tudastar/video/hikvision-android-alkalmazasok-telepitese">HIK-CONNECT
                </th> <!-- orig: HIK-CONNECT -->
            </tr>
            </thead>
            <tbody>
            <tr>
                <td></td>
                <td colspan="23" class="title">
                    @lang('pages/knowledge.bells')
                </td>
            </tr>
            <tr>
                <td><a href="https://files.riel.hu/adatlap/11972-1-1/DS-KB6003-WIP_Adatlap_ENG.pdf">(DS-KB6003-WIP)</a>
                </td>
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: HIK-CONNECT -->

            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kb6403-wip">(DS-KB6403-WIP)</td>
                <td><i class="fal fa-check"></i><span class="comment">*</span></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i><span class="comment">*</span></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i><span class="comment">*</span></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i><span class="comment">*</span></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i><span class="comment">*</span></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kb8112-im">(DS-KB8112-IM)</a></td>
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td>
                <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td>
                <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td>
                <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td>
                <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i><span class="comment">**</span></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td></td>
                <td colspan="23" class="title">
                    @lang('pages/knowledge.ip_outdoor')
                </td>
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kd3002-vm">(DS-KD3002-VM)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://files.riel.hu/adatlap/11612-1-1/DS-KD6002-VM_adatlap_ENG.pdf">(DS-KD6002-VM)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kd8002-vm">(DS-KD8002-VM)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kd8003-ime1">DS-KD8003-IME1</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kd8102-v">(DS-KD8102-V)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kv6113-pe1">DS-KV6113-PE1</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kv6113-wpe1">DS-KV6113-WPE1</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kv8113-wme1">DS-KV8113-WME1</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kv8213-wme1">DS-KV8213-WME1</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kv8413-wme1">DS-KV8413-WME1</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://files.riel.hu/adatlap/10886-2-1/DS-KV8X02-IM_adatlap_ENG.pdf">(DS-KV8102-IM)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kv8202-im">DS-KV8202-IM</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kv8402-im">(DS-KV8402-IM)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://files.riel.hu/adatlap/10888-2-1/DS-KV8102-IP(VP)_adatlap_ENG.pdf">(DS-KV8102-V)
                </td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://files.riel.hu/adatlap/10888-2-1/DS-KV8102-IP(VP)_adatlap_ENG.pdf">(DS-KV8102-VP)
                </td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td></td>
                <td colspan="23" class="title">
                    @lang('pages/knowledge.two_wired_outdoor')
                </td>
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kd8003-ime2">DS-KD8003-IME2</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kis701-w">(DS-KV8103-IME2)</td>
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KAD606-N) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD606-P -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD709 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td></td>
                <td colspan="23" class="title">
                    @lang('pages/knowledge.distributor_units')
                </td>
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kad606">(DS-KAD606)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td>-</td> <!-- beltéri: DS-KAD706 -->
                <td>-</td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://files.riel.hu/adatlap/11616-1-1/DS-KAD606-N_adatlap_ENG.pdf">(DS-KAD606-N)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td>-</td> <!-- beltéri: DS-KAD706 -->
                <td>-</td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kad606-p">(DS-KAD606-P)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td>-</td> <!-- beltéri: DS-KAD706 -->
                <td>-</td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kad612">(DS-KAD612)</td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td>-</td> <!-- beltéri: DS-KAD706 -->
                <td>-</td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kad612">DS-KAD706</td>
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td>-</td> <!-- beltéri: DS-KAD706 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kad612">DS-KAD706-S</td>
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KAD706 -->
                <td>-</td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/termekek/hikvision/ds-kad612">(DS-KAD709)</td>
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td>-</td> <!-- beltéri: DS-KAD706 -->
                <td>-</td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td></td>
                <td colspan="23" class="title">
                    @lang('pages/knowledge.other')
                </td>
            </tr>
            <tr>
                <td><a href="https://www.riel.hu/tamogatas/tudastar/video/hikvision-android-alkalmazasok-telepitese">HIK-CONNECT
                </td>
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6210-L) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: (DS-KH6310) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8300-T -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8301-WT -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KM8301 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE1-W -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-TE1 -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Gold -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8350-WTE1-Grey -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH8520-WTE1 (Eu) -->
                <td><i class="fal fa-times"></i></td> <!-- beltéri: DS-KH8340-TCE2-B -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2 (Eu) -->
                <td><i class="fal fa-check"></i></td> <!-- beltéri: DS-KH6320-WTE2-W -->
                <td>-</td> <!-- beltéri: DS-KAD606 -->
                <td>-</td> <!-- beltéri: (DS-KAD606-N) -->
                <td>-</td> <!-- beltéri: DS-KAD606-P -->
                <td>-</td> <!-- beltéri: DS-KAD612 -->
                <td>-</td> <!-- beltéri: DS-KAD706 -->
                <td>-</td> <!-- beltéri: DS-KAD706-S -->
                <td>-</td> <!-- beltéri: DS-KAD709 -->
                <td>-</td> <!-- beltéri: HIK-CONNECT -->
            </tr>
            <tr>
                <td></td>
                <td colspan="23" class="legend">
                    @lang('pages/knowledge.compatibility_text')
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
