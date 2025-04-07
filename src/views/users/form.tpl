{extends file="layout.tpl"}
{block name=body}
    <form method="POST" action="index.php?page=users/{$scenario}{if $scenario == 'update'}&id={$user.id}{/if}">
        <div class="mb-3">
            <label for="email" class="form-label">Email cím</label>
            <input type="text" class="form-control" id="email" name="email" value="{$user ? $user.email : ''}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Jelszó</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="is_active" name="is_active" {!$user || $user.is_active ? 'checked' : ''}>
            <label class="form-check-label" for="is_active">
                Aktív?
            </label>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">{$scenario == 'create' ? 'Létrehozás' : 'Módosítás'}</button>
        </div>
    </form>
{/block}