{extends file="layout.tpl"}
{block name=body}
    <p>
        {if !$post.publish_at}
            <a href="index.php?page=posts/publish&id={$post.id}" class="btn btn-success">Publikálás</a>
        {/if}
        <a href="index.php?page=posts/update&id={$post.id}" class="btn btn-primary">Szerkesztés</a>
        <a href="index.php?page=posts/delete&id={$post.id}" class="btn btn-danger">Törlés</a>
    </p>
    <table class="table table-bordered">
        <tr>
            <th>Cím</th>
            <td>{$post.title}</td>
        </tr>
        <tr>
            <th>Tartalom</th>
            <td>{$post.content}</td>
        </tr>
        <tr>
            <th>Létrehozva</th>
            <td>{$post.created_at}</td>
        </tr>
        <tr>
            <th>Módosítva</th>
            <td>{$post.update_at}</td>
        </tr>
        <tr>
            <th>Publikálva</th>
            <td>{$post.publish_at ? $post.publish_at : 'Még nincs'}</td>
        </tr>
    </table>
{/block}