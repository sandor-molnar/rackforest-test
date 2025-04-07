{extends file="layout.tpl"}
{block name=body}
    <article>
        <header class="mb-4">
            <h1 class="fw-bolder mb-1">{$post.title}</h1>
            <div class="text-muted fst-italic mb-2">Posztolva {$post.publish_at}, {$post.author_email} által</div>
        </header>
        <section class="mb-5">
            {$post.content}
        </section>
    </article>
{/block}