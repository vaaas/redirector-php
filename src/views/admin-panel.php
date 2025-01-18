<!DOCTYPE html>
<html>
    <head>
        <style>
            html {
                font-family: sans-serif;
                line-height: 1.5em;
            }

            h1 {
                line-height: 1.5em;
            }

            body {
                max-width: 700px;
                margin: auto;
            }

            body > section + section {
                border-top: 1px solid black;
            }

            form > .main {
                display: flex;
                justify-content: space-between;
                gap: 1em;
            }

            label {
                display: flex;
                gap: 1em;
            }

            form > footer {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <h1>Redirector-php admin panel</h1>

        <section>
            <h2>Redirects</h2>
            <?php if (count($this->links)): ?>
                <table>
                    <tr>
                        <th>Resource</th>
                        <th>Destination</th>
                    </tr>

                    <?php foreach ($this->links as $k => $v): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($k) ?>
                            </td>
                            <td>
                                <a href="<?= htmlspecialchars(
                                    $v
                                ) ?>"><?= htmlspecialchars($v) ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No redirects. Add some!</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Add redirect</h2>
            <form action="/" method="post">
                <div class='main'>
                    <label>
                        <span>From</span>
                        <input name="from" type="text"/>
                    </label>
                    <label>
                        <span>To</span>
                        <input name="to" type="text"/>
                    </label>
                </div>
                <footer>
                    <button type="submit">Submit</button>
                </footer>
            </form>
        </section>
    </body>
</html>
