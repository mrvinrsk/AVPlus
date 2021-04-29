<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<style>
    .navbar {
        position: sticky;
        top: 0;

        z-index: 99;
    }
</style>

<base href="/">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-light bg-hover-primary borderradius-1" aria-current="page" href="#">Home</a>
                </li>

                <!-- Dienste Dropdown -->
                <!--<li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page" href="#">Umfragen</a>
                </li>-->

                <?php
                if (!isset($_SESSION['login'])) {
                    ?>
                    <li class="nav-item dropdown float-end">
                        <a class="nav-link dropdown-toggle text-light bg-hover-primary borderradius-1"
                           id="navbarDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item text-light" href="/cart/">Warenkorb</a></li>
                            <li><a class="dropdown-item text-light" href="/account/auth/login/">Einloggen</a></li>
                            <li><a class="dropdown-item text-light" href="/account/auth/register/">Registrieren</a></li>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item dropdown float-end">
                        <a class="nav-link dropdown-toggle text-light bg-hover-primary borderradius-1"
                           id="navbarDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            if (isset($_SESSION['login'])) {
                                echo $_SESSION['email'];
                            }
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item text-light" href="/cart/">Warenkorb</a></li>
                            <li><a class="dropdown-item text-light" href="/admin/">Abmelden</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
