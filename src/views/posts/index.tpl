{extends file="layout.tpl"}
{block name=body}
    <p>
        <a href="index.php?page=posts/create" class="btn btn-success">Új poszt</a>
    </p>
    <table class="table table-bordered table-hover table-condensed">
        <thead>
        <tr>
            <th scope="col">Azonosító</th>
            <th scope="col">Cím</th>
            <th scope="col">Publikálva</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$posts item=post}
            <tr>
                <td>{$post.id}</td>
                <td>{$post.title}</td>
                <td>{$post.publish_at ? $post.publish_at : 'Még nincs'}</td>
                <td>
                    {if !$post.publish_at}
                        <a href="index.php?page=posts/publish&id={$post.id}" class="btn btn-success">Publikálás</a>
                    {/if}
                    <a href="index.php?page=posts/view&id={$post.id}" class="btn btn-primary">Megtekintés</a>
                    <a href="index.php?page=posts/update&id={$post.id}" class="btn btn-primary">Szerkesztés</a>
                    <a href="index.php?page=posts/delete&id={$post.id}" class="btn btn-danger">Törlés</a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{/block}