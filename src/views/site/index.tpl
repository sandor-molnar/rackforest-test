{extends file="layout.tpl"}
{block name=body}
    {foreach from=$posts item=post}
        <div class="card mb-4">
            <div class="card-body">
                <div class="small text-muted">Posztolva {$post.publish_at}, {$post.author_email} által</div>
                <h2 class="card-title">{$post.title}</h2>
                <p class="card-text">{$post.short_content}...</p>
                <a class="btn btn-primary" href="index.php?page=site/post&id={$post.id}">Poszt olvasása</a>
            </div>
        </div>
    {/foreach}
{/block}