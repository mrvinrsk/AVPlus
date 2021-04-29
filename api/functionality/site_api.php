<?php
function isLoggedIn()
{
    return isset($_SESSION['login']);
}

function addToCart($wk, $articleID, $amount, $plus)
{
    $amount = intval($amount);
    $article = array($articleID, $amount);
    $added = false;
    $index = 0;

    foreach ($wk as $art) {
        if ($art[0] == $articleID) {
            if (count($wk) == 1) {
                $wk = array();
            }

            $a = intval($art[1]);

            if ($plus) {
                $article = array($articleID, ($amount + $a));
            } else {
                $newamount = $a - $amount;
                if ($newamount > 0) {
                    $article = array($articleID, $newamount);
                } else {
                    unset($wk['' . $articleID . '']);
                    return $wk;
                }
            }

            if (!is_null($article)) {
                $wk['' . $articleID . ''] = $article;
            } else {
                unset($wk['' . $articleID . '']);
            }

            $added = true;
        }
        $index++;
    }

    if (!$added) {
        array_push($wk, $article);
    }

    return $wk;
}

function getCartTotal($wk, $sql)
{
    $price = 0;

    if (count($wk) > 0) {
        foreach ($wk as $wkItem) {
            $article = $sql->result("SELECT * FROM Artikel WHERE Artikelnummer = " . $wkItem[0] . ";");
            $amount = $wkItem[1];

            $aprice = ($amount * $article['Preis']);
            $price += $aprice;
        }
    }

    return $price;
}
