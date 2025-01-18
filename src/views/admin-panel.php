<!DOCTYPE html>
<html>
    <head>
        <style>
            html {
                font-family: monospace;
                font-size: 16px;
            }

            * { line-height: 1.5em; }

            h1 {
                margin: 0;
                padding-bottom: 1em;
                font-size: 1em;
            }

            body {
                padding: 1em;
                max-width: 50em;
                margin: auto;
            }

            input {
                border: none;
                border-bottom: 1px solid #aaa;
                font-size: 1em;
                width: 100%;
            }

            input:focus {
                outline: none;
                background-color: #eef;
                border-bottom-color: #88f;
            }

            button {
                border: none;
                background: none;
                padding: 0;
                font-weight: bold;
                cursor: pointer;
                font-size: 1em;
            }

            button.add {
                color: #44f;
            }

            button.delete {
                color: #f44;
            }

            table {
                width: 100%;
            }

            a {
                color: #44f;
            }

            th {
                font-weight: normal;
                color: #484;
            }

            td + td {
                padding-left: 1em;
            }

            tr + tr td {
                padding-top: 1em;
            }
        </style>
    </head>
    <body>
        <h1>Redirector-php admin panel</h1>

        <table>
            <tr>
                <th>Resource</th>
                <th>Destination</th>
            </tr>

            <tr>
                <form action="/?add" method="post">
                    <td>
                        <input name="from" type="text" placeholder="From"/>
                    </td>
                    <td>
                        <input name="to" type="text" placeholder="To (url)"/>
                    </td>
                    <td>
                        <button class="add" type="submit" name="action" value="add">
                            Add
                        </button>
                    </td>
                </form>
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
                    <td>
                        <form action="/?delete" method="post">
                            <button class="delete" name="action" value="delete">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>
