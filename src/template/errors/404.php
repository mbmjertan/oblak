<!DOCTYPE html>
<html>
<head>
    <title>Stranica nije pronađena</title>
    <style>
        .dialog-box {
            width: 35%;
            position: relative;
            bottom: 5%;
            left: 20%;
            background-color: #BDBDBD;
            font-family: 'Vedrana Bold', sans-serif;
            font-size: 18px;
            line-height: 1.5em;
            -webkit-font-smoothing: none;
            font-smoothing: none;

        }

        .title-bar {
            background-color: #001B76;
            color: #fff;
            padding: 4px;
        }

        .dialog-button-selected {
            font-size: 18px;
            border: 2px solid #000;
            color: #000 !important;
            text-decoration: none !important;
        }

        .button-inner {
            border-radius: 3px;
            margin: 5px;
            margin-top: 5px !important;
            margin-bottom: 5px !important;
            border: 2px dotted;
            color: #000 !important;
            text-decoration: none !important;
        }

        a:visited, a {
            color: #000 !important;
            text-decoration: none !important;
        }

        .explanation {
            font-family: 'Helvetica Neue', 'Arial', sans-serif;
        }

    </style>
</head>
<body>
<div class="explanation">
    <h3>Pogreška 404</h3>
    <p>Stranica koju ste tražili je nestala. Moguće je da nikada nije postojala, da je premještena ili da se dogodila
        greška u sustavu. Ispričavamo se radi neugodnosti.</p>
</div>

<div class="container">
    <div class="dialog-box">
        <div class="title-bar">
            <span class="title">Greška 404</span>
        </div>
        <div class="dialog-body">
            <span class="content">Dogodila se greška. Moguće je da stranica koju ste tražili nije pronađena ili da je jednostavno riječ o sistemskoj pogrešci. O čemu god da je bilo, obavijestili smo administratora stranice, a dok se to ne popravi, možete...<br><br></span>
			<span class="buttons">
				<button class="dialog-button-selected"><a href="<?php echo domainpath; ?>"><span class="button-inner">Vratite se na naslovnicu</span></a>
        </button>
			</span>
        </div>
    </div>

</body>
</html>