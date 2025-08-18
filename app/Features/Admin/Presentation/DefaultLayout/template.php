<?php
/** @var Features\Admin\Presentation\DefaultLayout\DefaultLayout $this */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $this->title ?></title>
        <style>
            * {
                all: unset;
            }

            :root {
                --b03: #002d38;
                --b02: #093946;
                --b01: #5b7279;
                --b00: #657377;
                --b0: #98a8a8;
                --b1: #9faaab;
                --b2: #f1e9d2;
                --b3: #fbf7ef;
                --yellow: #ac8300;
                --orange: #d56500;
                --red: #f23749;
                --magenta: #dd459d;
                --violet: #7d80d1;
                --blue: #2b90d8;
                --cyan: #259d94;
                --green: #819500;
            }

            @media screen and (prefers-color-scheme: light) {
                :root {
                    --s03: var(--b03);
                    --s02: var(--b02);
                    --s01: var(--b01);
                    --s00: var(--b00);
                    --s0: var(--b0);
                    --s1: var(--b1);
                    --s2: var(--b2);
                    --s3: var(--b3);
                }
            }

            @media screen and (prefers-color-scheme: dark) {
                :root {
                    --s03: var(--b3);
                    --s02: var(--b2);
                    --s01: var(--b1);
                    --s00: var(--b0);
                    --s0: var(--b00);
                    --s1: var(--b01);
                    --s2: var(--b02);
                    --s3: var(--b03);
                }
            }

            html {
                font-family: monospace;
                font-size: 16px;
                display: block;
                line-height: 1.5rem;
                color: var(--s00);
                background-color: var(--s2);
            }

            head, style, script {
                display: none;
            }

            body {
                display: block;
                max-width: 50rem;
                margin: auto;
                padding: 1rem;
            }

            button {
                cursor: pointer;
            }

            button:focus,
            button:hover {
                text-decoration: underline;
            }

            a {
                cursor: pointer;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <?= $this->contents ?>
    </body>
</html>
