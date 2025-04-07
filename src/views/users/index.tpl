{extends file="layout.tpl"}
{block name=body}
    <p>
        <a href="index.php?page=users/create" class="btn btn-success">Új felhasználó</a>
    </p>
    <table class="table table-bordered table-hover table-condensed">
        <thead>
        <tr>
            <th scope="col">Azonosító</th>
            <th scope="col">E-mail cím</th>
            <th scope="col">Aktív?</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$users item=user}
            <tr>
                <td>{$user.id}</td>
                <td>{$user.email}</td>
                <td>{$user.is_active ? 'Igen' : 'Nem'}</td>
                <td>
                    <a href="index.php?page=users/view&id={$user.id}" class="btn btn-primary">Megtekintés</a>
                    <a href="index.php?page=users/update&id={$user.id}" class="btn btn-primary">Szerkesztés</a>
                    <a href="index.php?page=users/delete&id={$user.id}" class="btn btn-danger">Törlés</a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{/block}