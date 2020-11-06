<?php
include_once "../api/sql/sql_account.php";
include_once "../api/sql/mysql_api.php";
$sql = new MySQLAPI($pdo);


$sql->execute("
create table if not exists Kunde
(
	Kundennummer int auto_increment primary key,
	Vorname varchar(32) not null,
	Nachname varchar(32) not null,
	Geburtstag date not null,
	Registrierung datetime not null,
	Rang int not null
);
");

$sql->execute("
create table if not exists Zahlungsmethode
(
	Kundennummer int not null,
	IBAN int not null,
	constraint Zahlungsmethode_pk
		primary key (Kundennummer),
	constraint Zahlungsmethode_Kunde_Kundennummer_fk
		foreign key (Kundennummer) references Kunde (Kundennummer)
);
");

$sql->execute("
create table if not exists Login
(
	Kundennummer int not null primary key,
	Mail varchar(128) not null,
	Passwort varchar(128) not null,
	constraint Login_Kunde_Kundennummer_fk
		foreign key (Kundennummer) references Kunde (Kundennummer)
			on update cascade on delete cascade
);
");

$sql->execute("
create table if not exists Artikelkategorie
(
	KategorieID int auto_increment,
	Bezeichnung varchar(32) not null,
	constraint Artikelkategorie_pk
		primary key (KategorieID)
);
");

$sql->execute("
create table if not exists Artikel
(
	Artikelnummer int auto_increment,
	Verkaeufer int not null,
	Titel varchar(64) not null,
	Beschreibung varchar(256) null,
	Preis float not null,
	Kategorie int null,
	constraint Artikel_pk
		primary key (Artikelnummer),
	constraint Artikel_Artikelkategorie_KategorieID_fk
		foreign key (Kategorie) references Artikelkategorie (KategorieID)
			on update cascade on delete set null,
	constraint Artikel_Kunde_Kundennummer_fk
		foreign key (Verkaeufer) references Kunde (Kundennummer)
			on update cascade on delete cascade
);
");

$sql->execute("
create table if not exists Rang
(
	RangID int auto_increment,
	Bezeichnung varchar(24) not null,
	IsDefault boolean not null,
	constraint Rang_pk
		primary key (RangID)
);
");

// STANDARD RÄNGE HINZUFÜGEN (INSERT)



header_remove();
header('Location: ./success/');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<p>Wird eingerichtet...</p>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');

    p {
        font-family: 'Open Sans', serif;
        font-size: 18px;
        position: absolute;
        text-align: center;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
    }

    div.success {
        background-color: #4BCA03;
    }
</style>

</body>
</html>
