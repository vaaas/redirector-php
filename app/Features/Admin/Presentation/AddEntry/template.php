<tr>
    <td>
        <input form="add" name="from" type="text" placeholder="From" />
    </td>
    <td>
        <input form="add" name="to" type="text" placeholder="To (url)" />
    </td>
    <td>
        <button form="add" class="add" type="submit">
            Add
        </button>
    </td>
</tr>

<style>
input[type="text"] {
    background-color: var(--s2);
    border-bottom: 1px solid var(--s1);
}

input[type="text"]:focus {
    background-color: var(--s3);
}

button.add {
    font-weight: bold;
    color: var(--blue);
}
</style>
