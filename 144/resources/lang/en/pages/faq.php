<?php

use App\Libs\LUrl;

return [
    'faq' => 'FAQ',
    'faq_meta_description' => 'We have collected the most frequently asked questions.',

    'intro' => 'We have collected and answered the most frequently asked questions that our customers ask us regarding purchase, shipping, returns or technical support.',

    'question_1' => 'I ordered the wrong item',
    'answer_1' => 'If you ordered the wrong product by mistake and it wasn\'t a special solution product for your project, you can return it within 30 days of your purchase if it is in unopened, mint condition. You can find the necessary steps <a href="https://files.riel.hu/kolcsonvisszarutermekek-2020-02-eng.pdf">here</a>.',

    'question_2' => 'I\'m unable to log in',
    'answer_2' => 'After an unsuccessful log in attempt the site displays the reason why you couldn\'t log in. If neither of the solutions fixes the issue, please contact our colleagues.
                        <ul>
                            <li>
                            <span class="font-semibold">Wrong password</span>
                                <div>
                                    Try logging in again with the correct password or reset your <a href="' . LUrl::route('password.request') . '">password</a> here.
                                </div>
                            </li>
                            <li>
                            <span class="font-semibold">User doesn\'t exist</span>
                                <div>
                                    You registered with the wrong email address. <a href="' . LUrl::route('register') . '">Register</a> agin with the correct one.
                                </div>
                            </li>
                        </ul>',

    'question_3' => 'I can\'t see prices or stock availability',
    'answer_3' => 'If you are able to log in, but you can\'t see prices or stock, it means that your account isn\'t
                        active yet. In this case, you can check your account status in your <a href="' . LUrl::route('account.index') . '">Account Settings</a> menu. One
                        of the following may be the case.
                        <ul>
                            <li>
                            <span class="font-semibold">You haven\'t confirmed your email address</span>
                                <div>Ask for another email confirmation link to confirm your password. After confirming
                                    we will double check your account, and activate it if you fulfil our customer
                                    requirements.
                                </div>
                            </li>
                            <li>
                            <span class="font-semibold">Account inactive</span>
                                    <div>
                                    You have confirmed your email address, but we haven\'t activated your account.
                                    Please bear with patience. If you fulfil our customer requirements we will activate
                                    your account shortly.
                                </div>
                            </li>
                        </ul>',

    'question_4' => 'How can I see the recommended installer prices',
    'answer_4' => 'If you are one of our retail partners, you can see them by ticking the box in the <a href="' . LUrl::route('account.index') . '">Account Settings</a> menu. We recommend that you keep this box checked, and you will see the installer prices displayed next to your prices.',

    'question_5' => 'How can I make a purchase',
    'answer_5' => 'If your company complies with our <a href="' . LUrl::route('terms') . '">Terms</a> of Service, <a href="' . LUrl::route('register') . '">register</a> on our website. You need to select a password and we will approve your account. After the process you are going to see your prices, stock level, and you\'re going to have access to basket and order functions as well.',
];
