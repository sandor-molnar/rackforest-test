<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Rackforest test app</title>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Rackforest test app</a>
        <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/index.php?page=site/index">Főoldal</a>
                </li>
                {if $loggedIn}
                    <li class="nav-item">
                        <a class="nav-link active" href="/index.php?page=users/index">Felhasználók</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/index.php?page=posts/index">Posztok</a>
                    </li>
                    <li class="nav-item">
                        <form method="post" action="index.php?page=site/logout">
                            <a class="nav-link active" href="javascript:void(0);" onclick="this.closest('form').submit();">Logout</a>
                        </form>
                    </li>
                {else}
                    <li class="nav-item">
                        <a class="nav-link active" href="/index.php?page=site/login">Login</a>
                    </li>
                {/if}
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    {if $alertMessage}
        <div class="alert alert-{$alertType}" role="alert">{$alertMessage}</div>
    {/if}
    {block name=body}{/block}
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>