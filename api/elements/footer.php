<style>
    main {
        min-height: 85vh;
    }

    footer {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    footer p {
        margin-bottom: .25rem;
    }

    .copyright_note {
        font-size: 12px;
        line-height: 14px;
    }
</style>

<div class="bg-dark">
    <footer class="pt-4 pt-md-5 border-top container-lg text-light">
        <base href="/AVPlus"/>

        <div class="container">
            <div class="col-md">
                <h4>AVPlus</h4>
                <p>
                    Dieser Webshop ist ein Schulprojekt von Marvin Roßkothen.<br/>
                    Sämtliche Artikel dienen nur der demonstration der Funktionen und werden nicht wirklich zum Verkauf
                    angeboten.
                </p>
            </div>

            <div class="col-md">
                <ul class="list-unstyled">
                    <li><a href="rechtliches/impressum">Impressum</a></li>
                    <li><a href="rechtliches/datenschutz">Datenschutz</a></li>
                </ul>
            </div>
        </div>
        <div class="row text-center text-muted mt-3 mt-lg-5 copyright_note">
            <p id="copyright"></p>
            <script>
                function updateCopyright() {
                    let date = new Date();
                    let startYear = 2021;
                    let copyright = document.getElementById('copyright');
                    if (date.getFullYear() !== startYear) {
                        copyright.innerText = "© " + startYear + "-" + date.getFullYear() + " Marvin Roßkothen";
                    } else {
                        copyright.innerText = "© " + startYear + " Marvin Roßkothen";
                    }
                }

                updateCopyright();
            </script>
        </div>
    </footer>
</div>
