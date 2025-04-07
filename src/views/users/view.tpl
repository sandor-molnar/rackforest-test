{extends file="layout.tpl"}
{block name=body}
    <p>
        <a href="index.php?page=users/update&id={$user.id}" class="btn btn-primary">Szerkesztés</a>
        <a href="index.php?page=users/delete&id={$user.id}" class="btn btn-danger">Törlés</a>
    </p>
    <table class="table table-bordered">
        <tr>
            <th>E-mail cím</th>
            <td>{$user.email}</td>
        </tr>
        <tr>
            <th>Aktív</th>
            <td>{$user.is_active ? 'Igen' : 'Nem'}</td>
        </tr>
    </table>
{/block}