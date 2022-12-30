<?= self::html() ?>

<?= self::body() ?>


<div class="centered-column padd4">

    <h2> <?= GENERAL['sitename'] ?> <i class="fa-solid fa-dungeon"></i></h2>


    <div class="card padd2 st-classic gap top2 shadow">
        <form id='formLogin' autocomplete="off">

            <div class="card__section">
                <div class="separated gap">
                    <div>Acceso de usuarios</div>
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>

            <div class="card__section">

                <div class="card__item--label">Usuario:</div>
                <input type="text" id='user'>

                <div class="card__item--label top">Clave:</div>
                <input type="password" id="password" class='card__item'>
            </div>

            <div class="card__section">
                <input type="submit" value="Ingresar" class='card__item'>
            </div>
        </form>
    </div>


</div>

<script src="<?= asset('js/acm/login.js') ?>"></script>
<?= self::end() ?>