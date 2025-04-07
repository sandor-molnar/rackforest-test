{extends file="layout.tpl"}
{block name=body}
    <form method="POST" action="index.php?page=posts/{$scenario}{if $scenario == 'update'}&id={$post.id}{/if}">
        <div class="mb-3">
            <label for="email" class="form-label">Cím</label>
            <input type="text" class="form-control" id="title" name="title" value="{$post ? $post.title : ''}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Tartalom</label>
            <textarea class="form-control" id="content" name="content">{$post ? $post.content : ''}</textarea>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">{$scenario == 'create' ? 'Létrehozás' : 'Módosítás'}</button>
        </div>
    </form>
{/block}