<?php

use App\Libs\LUrl;

return [
    'warranty' => 'Warranty',
    'warranty_meta_description' => 'You can find the warranty conditions of our manufacturers here.',
    'main_text' => 'Generally, we sell our products with a 1 year warranty, which you can avail of in our repair center. In
                many cases we provide exchange products. You can use the replacement warranty in the RIEL shop. Certain
                manufacturers and in certain cases RIEL also provide longer warranty periods. Below you can find a
                detailed description of each manufacturer.',
    'general_warranty' => 'General warranty',
    'replacement_warranty' => 'Replacement warranty',

    'hikvision_general_text' => 'The devices come with a 2 or a 3 year warranty period depending on the product type. For solution line products this can be extended by an additional 1 or 2 years.',
    'hikvision_replacement_text' => 'In certain cases RIEL provides exchange products. This means that you will get a brand new device
                                within a few days while the product is within its warranty period. If we can\'t provide an identical
                                device, we will give you a credit note for the value of your faulty device.<br />
                                <br />
                                The warranty periods of the various products are specified below:',

    'hikvision_table' => '<table>
                                <thead>
                                <tr>
                                    <td></td>
                                    <td>Replacement warranty</td>
                                    <td>Repair</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="vcell">
                                        <div class="vertical">Cameras</div>
                                    </td>
                                    <td label="Cameras warranty">
                                        <p>every fix analogue camera</p>
                                        <p>every fix THD camera</p>
                                        <p>DS-2CD1xxx fix IP cameras</p>
                                        <p>DS-2CD2xxx fix IP cameras</p>
                                    </td>
                                    <td label="Camera repair">
                                        <p>every PTZ</p>
                                        <p>Hi-watch PTZ cameras: HWP-xxx (warranty period: 1 year)</p>
                                        <p>DS-2T thermal cameras (except for thermal sensor)</p>
                                        <p>iDS-xxxx intelligent IP cameras and recorders</p>
                                        <p>DS-2DPXXX PanoVu cameras</p>
                                        <p>DS-2CD4/5/6/7 series IP cameras</p>
                                        <p>DS-2XM mobile cameras</p>
                                        <p>analóg mobile cameras</p>
                                        <p>DS-2CD3 series</p>
                                        <p>DS-2XC stainless cameras</p>
                                        <p>DS-2XE explosion proof cameras</p>
                                        <p>DS-2Z zoom cameras</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vcell">
                                        <div class="vertical">Recorders</div>
                                    </td>
                                    <td label="Replacement warranty">
                                        <p>DS-71xx, DS-72xx, DS-76xx, DS-77xx Recorders</p>
                                        <p>(DS-77xx recorders RIEL accepts warranty replacement and the repair center repairs
                                            the device)</p>
                                    </td>
                                    <td label="Recorder repair">
                                        <p>DVR/NVR: DS-5/6/73/8/ 9XXX series</p>
                                        <p>Blazer series recorder (warranty period: 2 years)</p>
                                        <p>DS-TXXX series</p>
                                        <p>DS-M mobile recorders</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vcell">
                                        <div class="vertical">Other</div>
                                    </td>
                                    <td label="Other replacement warranty">
                                        <p>DS-KA, DS-KB, DS-KD, DS-KH, DS-KI, DS-KM, DS-KV intercoms</p>
                                        <p>DS-A power supplies (warranty period: 1 year)</p>
                                        <p>DS-P alarm system</p>
                                        <p>cables (warranty period: 1 year)</p>
                                        <p>lenses</p>
                                    </td>
                                    <td label="Other repairs">
                                        <p>Access control system devices (DS-K card readers, terminals, door controls,
                                            accessories)</p>
                                        <p>DS-3V and DS-3W network devices</p>
                                        <p>all control units</p>
                                        <p>DDS-D5xxx (screens)</p>
                                        <p>MCU-xxx</p>
                                        <p>consoles</p>
                                        <p>DS-6 encoders and decoders</p>
                                        <p>DS-D2 monitors</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>',

    'satel_general_text' => ' Satel devices come with a warranty period of 2 or 3 years, depending on the model. Whenever possible, we replace the faulty inner parts of the device, in order to reduce repair time.',
    'satel_table' => '<table>
                                <thead>
                                <tr>
                                    <td></td>
                                    <td>3 years</td>
                                    <td>2 years</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="vcell"></td>
                                    <td label="3 years">
                                        <p>Alarm central units</p>
                                        <p>Alarm central units with GSM commuicators</p>
                                        <p>Wired LED and LCD control panlels and partition managers</p>
                                        <p>Expansion modules and BUS converters</p>
                                        <p>ABAX and MICRA (except for outdoor units and remote controls)</p>
                                        <p>Wired motion sensors (except for outdoor) and door contacts</p>
                                        <p>Wired indoor sirens</p>
                                        <p>Older communication modules (e.g. DT-1, IDN, MDM modems)</p>
                                        <p>Radio controls, power supplies, boxes, ACCO indoor units</p>
                                        <p>Monitoring stations (e.g. STAM-2 and expansions; STAM-BOX)</p>
                                        <p>Other devices (e.g. ETHM-2, SM-2, SZW-02, PK-01, ZB-…, MP-1, MZ-…)</p>
                                    </td>
                                    <td label="2 years">
                                        <p>Outdoor sensors (e.g. INT-SCR-BL)</p>
                                        <p>Touch panels (e.g. INT-TSI, INT-TSH, INT-TSG)</p>
                                        <p>ABAX and MICRA (outdoor units) (e.g. ASP-100, ASP-105, AOD-200, APT-100, MSP-300,
                                            MPT-300)</p>
                                        <p>Wired outdoor sensors (e.g. ACTIVA, OPAL), gas sensors, wired outdoor sirens</p>
                                        <p>GSM/GPRS communication moduls, remote controls, ACCO outdoor devices, STAM-IRS</p>
                                        <p>Other accessories (e.g. PNK-1, cables, other accessories, SPL-TO, SX6-TO)</p>
                                        <p>Devices from third parties: antennas, DALLAS reader, transformers</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>',

    'vanderbilt_general_text' => 'Vanderbilt products come with a warranty period of 3 years (except for third party units, such as batteries, HDDs).',
    'dallmeier_general_text' => 'Dallmeier products come with a warranty period of 2 years.',
    'siemens_general_text' => ' Siemens FC360 Cerberus FIT units come with a warranty period of 3 years. All other products come with a warranty period of 1 year.',
    'wd_general_text' => 'WD Purple (PURX, PZX) units: 3 years WD GOLD (KRYZ, FRYZ), Ultrastar (WUH) units: 5 years',
    'comunello_general_text' => 'Comunello products come with a warranty period of 4 years.',

    'procedure_title' => 'Warranty procedure',
    'procedure_text' => 'You can avail of warranty by personally bringing your device to our center or by shipping it in. Please
                refer to the instructions on our <a href="' . LUrl::route('repair') . '">Repair Center page</a>.',

    'not_under_warranty' => 'What is excluded from warranty?',
    'not_under_warranty_text' => 'In certain cases we can\'t fix your device under warranty. The following cases exclude warranty repairs.',
    'not_under_warranty_list' => '<li>Incorrect operating temperature</li>
                <li>Incorrect installation</li>
                <li>Misuse</li>
                <li>Ignoring instructions laid out in the manual</li>
                <li>Incorrect storage, handling or deliberate damage</li>
                <li>Water damage</li>
                <li>Damage resulting from Acts of God.</li>',
];
