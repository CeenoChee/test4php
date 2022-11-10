<?php

use App\Libs\LUrl;

return [
    'repair' => 'Repair Center',
    'repair_meta_description' => 'Our brand-independent repair center carries out repairs on all brands distributed by us as well as any other brand.',

    'main_text' => 'Our brand independent Repair Center carries out tests and repairs on products we sell as well as on other electronic devices. We do repairs for products purchased from us and are under warranty as well as, products of most CCTV manufacturers beyond the warranty period.',
    'main_text_bottom' => 'Failure reporting and service process for warranty and non-warranty devices:',

    'box_title_1' => 'Service Form, Failure Reporting',
    'box_text_1' => 'To use our repair service, fill out the <a class="text-riel-light" target="_blank" href="' . route('media.get', 'rma-hibabejelento2021en-60cb933070ed8.pdf') . '">RMA form</a> and include it with the returned device.<br />
                        <br />
                        It is important to complete a separate <a class="text-riel-light" target="_blank" href="' . route('media.get', 'rma-hibabejelento2021en-60cb933070ed8.pdf') . '">RMA form</a> for each case!',

    'box_title_2' => 'Device Status Check',
    'box_text_2' => 'Before sending your faulty device, please evaluate its condition.<br />
                        <br/>
                        In case you have used your device outdoors, please clean it before handing over, otherwise we will charge a cleaning fee of 2.400 HUF + VAT',

    'box_title_3' => 'Handover of a Faulty Device',
    'box_text_3' => 'You can take your device personally<br/>
                        to the <b>RIEL store</b> <a class="text-riel-light" target="_blank" href="https://www.google.hu/maps/dir//Budapest,+Frangepán+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangepán+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025">1139 Budapest, Röppentyű utca 24.</a><br/>
                        or to the <b>RIEL warehouse</b> <a class="text-riel-light" target="_blank" href="https://www.google.com/maps/place/RIEL+Raktár/@47.6132529,19.1175825,18z/data=!3m1!4b1!4m5!3m4!1s0x4741d10208909c6d:0xf2172a125d60d5a4!8m2!3d47.6132529!4d19.118218">2120 Dunakeszi, Pallag u. 31. D1-D2 kapu</a><br/>
                        or you can ship it by post or any courier service (at your own expense).<br/>
                        <br/>
                        Don\'t forget to include the filled and printed <a class="text-riel-light" target="_blank" href="' . route('media.get', 'rma-hibabejelento2021en-60cb933070ed8.pdf') . '">RMA form</a> for every case.
                    ',
    'box_title_4' => 'Warranty Repair Process',
    'box_text_4' => 'We do RMA (warranty) repairs just for products purchased from RIEL, according to the terms defined in <a class="text-riel-light" target="_blank" href="' . LUrl::route('warranty') . '">the warranty conditions</a>.',
    'box_text_4_2' => 'Accordingly, it might:
                        <ul class="left">
                            <li>be replaced immediately,</li>
                            <li>be inspected and repaired by the manufacturer (in this case, the warranty repair period may exceed 30 days),</li>
                            <li>be repaired by RIEL Service,</li>
                            <li>be credited (if there is no way to replace it or the device cannot be repaired).</li>
                        </ul>',

    'box_title_5' => 'Out-of-Warranty Repair Process',
    'box_text_5' => ' We do the repair of non-warranty devices on fixed fees, regardless of whether the product has been purchased from us or not. Repair conditions are automatically considered as accepted upon the handover of the product.<br/>
                        <br/>
                        You can find more information about inspection and repair fees on the <a class="text-riel-light" target="_blank" href="' . route('media.get', 'rma-hibabejelento2021en-60cb933070ed8.pdf') . '">RMA form</a><br/>
                        <br/>
                        After a completed repair process you will be notified via e-mail.',

    'box_title_6' => 'Handover of a Repaired Device',
    'box_text_6' => ' We will send you an e-mail as soon as your device had been repaired and it is ready for delivery. You can take your device personally<br/>
                        from the <b>RIEL Store</b> <a class="text-riel-light" target="_blank" href="https://www.google.hu/maps/dir//Budapest,+Frangepán+u.+23,+1139/@47.5353025,19.0723343,17z/data=!4m16!1m7!3m6!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2sBudapest,+Frangepán+u.+23,+1139!3b1!8m2!3d47.5353025!4d19.074523!4m7!1m0!1m5!1m1!1s0x4741dbea983608cb:0x300ef2876bbfc29f!2m2!1d19.074523!2d47.5353025">1139 Budapest, Röppentyű utca 24.</a><br/>
                        during opening hours: <br/>
                        on weekdays from 8 am to 4 pm.',
    'box_text_6_2' => ' You can also request shipping for extra fee depending on your location.
                        You can indicate the requested delivery method already on the <a class="text-riel-light" target="_blank" href="' . route('media.get', 'rma-hibabejelento2021en-60cb933070ed8.pdf') . '">RMA form</a>.',
];
