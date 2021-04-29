<?php
function rechnung($rechnungsnr)
{
    ob_start();
    session_start();
    include_once "Rechnung.php";
    include_once("../../../api/sql/sql_account.php");

    $rechnung = new Rechnung();

    $rechnung->AddPage();

    $rechnung->SetFont('Times', '', 8);
    $rechnung->Cell(80, 10, 'Ihre Rechnung');
    $rechnung->Ln(5);

    $kundenstmt = $pdo->prepare("SELECT * FROM Kunde, Bestellung WHERE Bestellung.Kaeufer = Kunde.Kundennummer AND Bestellung.RechnungID = " . $rechnungsnr . ";");

    $rechnung->SetFont('Times', '', 12);

    if ($kundenstmt->execute()) {
        $row = $kundenstmt->fetch();

        $rechnung->Cell(80, 10, iconv('UTF-8', 'windows-1252', $row['Vorname'] . " " . $row['Nachname']));
        $rechnung->Ln(5);
    }

    $rechnung->ln(20);

    $rechnung->Cell(80, 10, utf8_decode('Bestellübersicht') . " - Rechnungsnummer: " . $rechnungsnr);
    $rechnung->ln(10);

    $artikelstmt = $pdo->prepare("SELECT Artikel.Titel, Posten.Menge, Artikel.Preis, Artikel.Preis * Posten.Menge as total FROM Artikel, Posten, Bestellung WHERE Bestellung.RechnungID = Posten.Rechnung AND Artikel.Artikelnummer = Posten.Artikel AND Bestellung.RechnungID = " . $rechnungsnr . ";");

    $articles = array();
    $total = 0.00;

    if ($artikelstmt->execute()) {
        while ($row = $artikelstmt->fetch()) {
            $a = array($row['Titel'], $row['Menge'], number_format(((float)$row['Preis']), 2, ',', '.') . " EUR", number_format(((float)$row['total']), 2, ',', '.') . " EUR");
            $total += $row['total'];
            array_push($articles, $a);
        }

        $rechnung->PrintTable(array('Artikel', 'Anzahl', utf8_decode('Stückpreis'), 'Summe'), $articles);
    }

    $rechnung->ln(5);
    $rechnung->Cell(80, 10, "Total: " . number_format(((float)$total), 2, ',', '.') . " EUR");

    $rechnung->Output();
    ob_end_flush();
}

rechnung(6);
?>
