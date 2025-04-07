{extends file="layout.tpl"}
{block name=body}
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h2>Bejelentkezés</h2>
            <form method="POST" action="index.php?page=site/login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email cím</label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Jelszó</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Bejelentkezés</button>
            </form>
        </div>
    </div>
{/block}