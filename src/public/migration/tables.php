<?php
/*
 * This script can process tables
 */
$input = input();

$return = processTables($input);

echo json_encode($return);
print_r($return);

function processTables($input)
{
    if (! stristr($input, '<table'))
        return $input;
    
    $layout = array();
    
    $subpattern = array();
    
    // process <table></table>
    $pattern = "~(.*)(?:<table(?:.*)>)(.*)(?:</table(?:.*)>)~isU";
    
    preg_match_all($pattern, $input, $tables, PREG_SET_ORDER);
    
    $i = 0;
    foreach ($tables as $table) {
        
        $tableRows = array();
        
        // remove <table>, </table>, <tbody> </tbody>
        $pattern = "~(<table[^>]*>)|(<tbody[^>]*>)|(</tbody[^>]*>)|(</table[^>]*>)~isU";
        $table[2] = preg_replace($pattern, '', $table[2]);
        
        // text vor tabelle
        if (strlen(trim($table[1])) > 0) {
            $layout[][]['content'] = $table[1];
        }
        
        // <tr></tr> == new row
        $pattern = "~(?:.*)(?:<tr(?:.*)>)(.*)(?:</tr(?:.*)>)~isU";
        preg_match_all($pattern, $table[2], $tableRows, PREG_SET_ORDER);
        
        foreach ($tableRows as $tableRow) {
            $tableColumns = array();
            
            // remove <tr>, </tr>
            $pattern = "~(<tr[^>]*>)|(</tr[^>]*>)~isU";
            $tableRow[0] = preg_replace($pattern, '', $tableRow[0]);
            
            // <td></td> == new column
            $pattern = "~(?:.*)(?:<td(?:.*)>)(.*)(?:</td(?:.*)>)~isU";
            preg_match_all($pattern, $tableRow[0], $tableColumns, PREG_SET_ORDER);
            
            $columns = array();

            $count = count($tableColumns);
            if($count < 4){
                foreach ($tableColumns as $tableColumn) {

                    // remove <td>, </td>
                    $pattern = "~(<td[^>]*>)|(</td[^>]*>)~isU";
                    $tableColumn[0] = preg_replace($pattern, '', $tableColumn[0]);

                    $columns[] = array(
                        'col' => 12 / $count,
                        'content' => $tableColumn[0]
                    );
                }
            } else {
                $columns[] = array(
                    'col' => 12,
                    'content' => '<table><tr>'.$tableRow[0].'</tr></table>'
                );
            }
            
            $layout[] = $columns;
        }
        $lastTable = $table;
    }
    
    // process non-tables behind last </table>
    $pos = strpos($input, $table[0]);
    $garbage = substr($input, $pos);
    $layout[][]['content'] = str_replace($table[0], '', $garbage);
    
    return $layout;
}

function input()
{
    return "Die **Addition**, umgangssprachlich auch **Plus-Rechnen** genannt, ist eine der vier [wiki=262]Grundrechenarten[/wiki]. In der Grundschule und in der Umgangssprache verwendet man meist den Ausdruck **Zusammenzlen** fÃ¼r die Addition von zwei oder mehr Zahlen, da Addition den Vorgang des ZÃ¤hlens beschreibt.

Â 

Die Elemente bzw. Operanden einer Addition werdenÂ **Summanden**Â und das ErgebnisÂ **Summe**Â genannt:Â 

1. Summand + 2. Summand = Summe

Eine Summe muss aber nicht nur aus 2 Summanden bestehen, sie kann auch aus mehreren Summanden bestehen.Â 

Â 

Im Allgemeinen ist die Addition nicht fÃ¼r fÃ¼r Zahlen definiert. Vektoren kann man zum Beispiel auch miteinander addieren. Die Grundrechenart, die eine Addition \"rÃ¼ckgÃ¤ngig\" macht, istÂ **[wiki=12]Subtraktion[/wiki]**.Â 

Anschauung
==========

Die Addition beschreibt der Vorgang des ZusammenzÃ¤hlens. Â Man bringt also zwei Zahlen (oder zwei Sachen) zusammen, und macht daraus eine neue.

Â 

### Beispiel

<table><tr><td>Nimmt man zwei Kreise, und tut 3 Kreise dazu, so bekommt man 5 Kreise.</td>

<td>![7881_M0szn1FMdb.xml](/uploads/7882_Zr8ENblk1o.png)</td>

</tr>

</table>

Â  Â 

Rechenregeln
============

GrundsÃ¤tzlich gelten fÃ¼r die Addition folgende Rechengesetze:

Â 

Summanden vertauschen - KommutativgesetzÂ [wikilink]131[/wikilink]
-----------------------------------------------------------------

Man kann zwei Summanden miteinander vertauschen, ohne das Ergebnis zu verÃ¤ndern.

Â 

<table><tr><td>### Beispiel

 Nimmt man nun 3 Kreise, und zÃ¤hlt 2 dazu, so bekommt man wieder 5 Kreise.</td>

<td>![7883_ves6ZfxdeD.xml](/uploads/7884_Qdvczaa6WD.png)</td>

</tr>

</table>

Â Â 

Klammergesetz - Assoziativgesetz [wikilink]124[/wikilink]
---------------------------------------------------------

Beim Rechnen mit mehreren Zahlen benutzen wir Klammern um zu zeigen, welche Teile man zuerst rechnen will. Beim addieren darf man die Klammern beliebig umplatzieren, ohne das Ergebnis zu verÃ¤ndern.

<table><tr><td>### Beispiel

ZÃ¤hlt man 1 Kreis und 2 Kreise zuerst zusammen, dann 3 dazu, bekommt man 6 Kreise.

ZÃ¤hlt man nun zuerst die zwei Kreise mit den 3 Kreisen zusammen, dann den einen Kreis dazu, bekommt man auch 6 Kreise.

</td>

<td>![7891_JT3ZPEhuGx.xml](/uploads/7892_IuG4ObbrA9.png)

</td>

</tr>

</table>

Â  Â 

Die besondere Zahl - Null
-------------------------

FÃ¼r die Zahl Null gilt:

1. ZÃ¤hlt man zu etwas 0 dazu, so bleibt die Summe gleich.
2. Wenn man zu eine Zahl etwas addiert und die Summe sich nicht Ã¤ndert, dann war es die Null, die man dazu addiert hat. Mit Formeln ausgedrÃ¼tckt: falls fÃ¼r zwei Zahlen a und b gilt a + b = a, dann muss gelten b = 0.

Â  Â 

Addition von kleine Zahlen
==========================

Es gibt verschiedene MÃ¶glichkeiten eine Summe von einstellige Zahlen zu berechnen.Â 

Â  Â 

Addition mit Zahlengerade [wikilink]390[/wikilink]

Zahlengerade zu benutzen ist die anschaulichste MÃ¶glichkeit, eine einfache Summe zu berechnen. Um zum Beispiel Â 2 + 3Â zu berechnen, markiert man zuerst die Zahl 2 auf der Zahlengerade, und geht von dort aus um 3 nach rechts. Die nun markierte Zahl auf dem Zahlengerade ist dann das Ergebnis.Â 

![7997_Gt90w4vq78.xml](/uploads/7998_DmDKGEe0jr.png)

Mit dieser Methode kann man sich zwar die Addition gut vorstellen, sie ist aber nur fÃ¼r kleine Zahlen geeignet, und kostet sehr viel Zeit.

Â Â 

Merktabelle
-----------

Um spÃ¤ter grÃ¶ÃŸere Zahlen addieren zu kÃ¶nnen, ist es schneller die Summe von kleinen Zahlen auswendig zu lernen. (Wegen der KommutativitÃ¤t muss die Reihenfolge nicht beachtet werden.) Diese Tabelle schaut sehr riesig aus, ist aber nicht schwer zu merken, da man im Alltag ohnehin oft Sachen zusammenzÃ¤hlt.

<table><tr><td>**+**</td>

<td>**0**</td>

<td>**1**</td>

<td>**2**</td>

<td>**3**</td>

<td>**4**</td>

<td>**5**</td>

<td>**6**</td>

<td>**7**</td>

<td>**8**</td>

<td>**9**</td>

</tr>

<tr><td>**0**</td>

<td>0</td>

<td>1</td>

<td>2</td>

<td>3</td>

<td>4</td>

<td>5</td>

<td>6</td>

<td>7</td>

<td>8</td>

<td>9</td>

</tr>

<tr><td>**1**</td>

<td>1</td>

<td>2</td>

<td>3</td>

<td>4</td>

<td>5</td>

<td>6</td>

<td>7</td>

<td>8</td>

<td>9</td>

<td>10</td>

</tr>

<tr><td>**2**</td>

<td>2</td>

<td>3</td>

<td>4</td>

<td>5</td>

<td>6</td>

<td>7</td>

<td>8</td>

<td>9</td>

<td>10</td>

<td>11</td>

</tr>

<tr><td>**3**</td>

<td>3</td>

<td>4</td>

<td>5</td>

<td>6</td>

<td>7</td>

<td>8</td>

<td>9</td>

<td>10</td>

<td>11</td>

<td>12</td>

</tr>

<tr><td>**4**</td>

<td>4</td>

<td>5</td>

<td>6</td>

<td>7</td>

<td>8</td>

<td>9</td>

<td>10</td>

<td>11</td>

<td>12</td>

<td>13</td>

</tr>

<tr><td>**5**</td>

<td>5</td>

<td>6</td>

<td>7</td>

<td>8</td>

<td>9</td>

<td>10</td>

<td>11</td>

<td>12</td>

<td>13</td>

<td>14</td>

</tr>

<tr><td>**6**</td>

<td>6</td>

<td>7</td>

<td>8</td>

<td>9</td>

<td>10</td>

<td>11</td>

<td>12</td>

<td>13</td>

<td>14</td>

<td>15</td>

</tr>

<tr><td>**7**</td>

<td>7</td>

<td>8</td>

<td>9</td>

<td>10</td>

<td>11</td>

<td>12</td>

<td>13</td>

<td>14</td>

<td>15</td>

<td>16</td>

</tr>

<tr><td>**8 Â **</td>

<td>8</td>

<td>9</td>

<td>10</td>

<td>11</td>

<td>12</td>

<td>13</td>

<td>14</td>

<td>15</td>

<td>16</td>

<td>17</td>

</tr>

<tr><td>**9**</td>

<td>9</td>

<td>10</td>

<td>11</td>

<td>12</td>

<td>13</td>

<td>14</td>

<td>15</td>

<td>16</td>

<td>17</td>

<td>18</td>

</tr>

</table>

Â Â 

### Wie benutzt man die Merktabelle?

- Suche am roten Randstreifen der erst Summand und liegt der Zeigefinger der linken Hand darauf.
- Suche mit dem rechten Zeigefinger den zweiten Summand unter den blauen Zahlen.Â 
- Bewege jetzt beide HÃ¤nde jeweils in den Reihen und Spalten aufeinander zu, bis sie sich treffen. Die Zahl, die jetzt unter beiden Zeigefinger liegt, ist das Ergebnis.

### Â 

### Beispiel

In der folgenden Animation wird die Vorgehensweise anhand von dem Beispiel 2 + 3 = 5 gezeigt.

Â Â 

### Ãœbungsaufgaben

Finde die folgende Summen in der Additionstabelle:

1. 9 + 4
2. 8 + 2

Â [spoiler=LÃ¶sung]

1. 9 + 4 = 13

![Additionstabelle: 9 + 4](/uploads/8049_aBs4M1wzRD.png \"Additionstabelle: 9 + 4\")

Â 

2. 8 + 2 = 10

![Additionstabelle:8+2](/uploads/8052_9kdm56PwrQ.png \"Additionstabelle:8+2\")

Â Â [/spoiler]

Â Â 

Schriftliche AdditionÂ [wikilink]436[/wikilink]
==============================================

FÃ¼r Addition mit grÃ¶ÃŸeren Zahlen benutzt man die **schriftliche Addition**.

Bei der schriftlichen Addition werden die Summanden untereinander geschrieben und dann von der Einerstelle ausgehend addiert. Bei mehreren Zahlen werden alle Summanden untereinander geschrieben, die Vorgehensweise ist wie bei zwei Zahlen.

Â Â 

Beispiel

<table><tr><td>![Â«math xmlns=Â¨http://www.w3.org/1998/Math/MathMLÂ¨Â»Â«mtable columnalign=Â¨leftÂ¨ rowspacing=Â¨0Â¨Â»Â«mtrÂ»Â«mtdÂ»Â«menclose notation=Â¨bottomÂ¨Â»Â«mtableÂ»Â«mtrÂ»Â«mtdÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mtdÂ»Â«mtdÂ»Â«mnÂ»3Â«/mnÂ»Â«/mtdÂ»Â«mtdÂ»Â«mnÂ»6Â«/mnÂ»Â«/mtdÂ»Â«mtdÂ»Â«mnÂ»5Â«/mnÂ»Â«/mtdÂ»Â«/mtrÂ»Â«mtrÂ»Â«mtdÂ»Â«moÂ»+Â«/moÂ»Â«/mtdÂ»Â«mtdÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mtdÂ»Â«mtdÂ»Â«msubÂ»Â«mnÂ»1Â«/mnÂ»Â«mnÂ»1Â«/mnÂ»Â«/msubÂ»Â«/mtdÂ»Â«mtdÂ»Â«mnÂ»5Â«/mnÂ»Â«/mtdÂ»Â«/mtrÂ»Â«/mtableÂ»Â«/mencloseÂ»Â«/mtdÂ»Â«/mtrÂ»Â«mtrÂ»Â«mtdÂ»Â«mtableÂ»Â«mtrÂ»Â«mtdÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mtdÂ»Â«mtdÂ»Â«mnÂ»3Â«/mnÂ»Â«/mtdÂ»Â«mtdÂ»Â«mnÂ»8Â«/mnÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mtdÂ»Â«mtdÂ»Â«mnÂ»0Â«/mnÂ»Â«/mtdÂ»Â«/mtrÂ»Â«/mtableÂ»Â«/mtdÂ»Â«/mtrÂ»Â«/mtableÂ»Â«/mathÂ»](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=c0e33a2445c2dd88f2a86d3b181fc122.png \"Double click to edit\")Â Â </td>

<td>1. **Einerstelle addieren:**Â ![Â«math xmlns=Â¨http://www.w3.org/1998/Math/MathMLÂ¨Â»Â«mnÂ»5Â«/mnÂ»Â«moÂ»+Â«/moÂ»Â«mnÂ»5Â«/mnÂ»Â«moÂ»=Â«/moÂ»Â«mnÂ»10Â«/mnÂ»Â«/mathÂ»](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=140cc0a93742ec69566ead0f64036421.png \"Double click to edit\")![Â«math xmlns=Â¨http://www.w3.org/1998/Math/MathMLÂ¨Â»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§#8658;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mathÂ»](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=fd14476735098f68773f1085beef42f4.png \"Double click to edit\")Â An der Einerstelle des Ergebnisses (unter dem Strich) steht eine 0 und es muss ein Zehner addiert werden![Â«math xmlns=Â¨http://www.w3.org/1998/Math/MathMLÂ¨Â»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§#8594;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mathÂ»](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=164da5eb93540f443b12b9f4733cd91b.png \"Double click to edit\")also 1 bei den 10ern anmerken.
2. **Zehnerstelle addieren:**Â ![Â«math xmlns=Â¨http://www.w3.org/1998/Math/MathMLÂ¨Â»Â«mnÂ»6Â«/mnÂ»Â«moÂ»+Â«/moÂ»Â«mnÂ»1Â«/mnÂ»Â«moÂ»+Â«/moÂ»Â«mnÂ»1Â«/mnÂ»Â«moÂ»=Â«/moÂ»Â«mnÂ»8Â«/mnÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§#8658;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mathÂ»](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=5b6a9d6e5b2b0286d7d994cc2acb30b9.png \"Double click to edit\")Die Zehnerstelle des Ergebnisses ist 8.
3. **Hunderterstellen addieren:Â **![Â«math xmlns=Â¨http://www.w3.org/1998/Math/MathMLÂ¨Â»Â«mnÂ»3Â«/mnÂ»Â«moÂ»+Â«/moÂ»Â«mnÂ»0Â«/mnÂ»Â«moÂ»=Â«/moÂ»Â«mnÂ»3Â«/mnÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§#8658;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«moÂ»Â§nbsp;Â«/moÂ»Â«/mathÂ»](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=925596a31bffec49a2eb2d590d59da80.png \"Double click to edit\")Die Hunderterstelle des Ergebnisses ist 3.

</td>

</tr>

</table>

Â Â 

Tricks
======

Wegen der KommutativitÃ¤t und AssoziativitÃ¤t der Addition kann man die Reihenfolge der Summanden beliebig vertauschen. Das liefert einige praktische Tricks bei der Addition vor allem von mehreren Zahlen.

Â  Â 

10er sammeln
------------

Bevor man anfÃ¤ngt, mehrere Zahlen von Links nach Rechts zu addieren, kann man versuchen zuerst nach Zahlen zu suchen, die zusammen 10 ergeben. Denn Addition von 10er ist besonders einfach! DafÃ¼r mÃ¼ssen diese Zahlen ist nicht nebeneinander stehen, die Reihenfolge der Addition ist ja egal.

###

### Beispiel

![showimage.php?formula=89cef236b9374be2ec](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=89cef236b9374be2ec2e354e611c0f70.png)

Â  Â 

Zahlen aufspalten
-----------------

Manchmal ist es einfacher, eine Zahl als eine Summe vorzustellen. Man kann damit oft die Addition auf Addition von einstellige Zahlen reduzieren und sich damit die schriftliche Addition ersparen. Ein einfaches Beispiel zeigt die Vorgehensweise:

### Beispiel 1

![showimage.php?formula=91a4b06c4e042866f4](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=91a4b06c4e042866f4fe4c8404facf31.png)

Â  Â 

Dieses Beispiel ist so einfach, dass man gar keine Tricks hÃ¤tte anwenden mÃ¼ssen. Allerdings gibt es auch andere Rechnungen, bei denen sich dieser Trick als nÃ¼tzlich erweist:

### Beispiel 2

![showimage.php?formula=0027f207a944776614](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=0027f207a944776614cf2990f306cd3b.png)

Â  Â 

Man kann diesen Trick auch in Kombination mit Multiplikation benutzen. Vor allem kann man die Einfachheit des Â \"Verdoppelns\" ausnutzen.

### Beispiel 3

![showimage.php?formula=850a72bb948d77d5c9](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=850a72bb948d77d5c94380627e4b4a58.png)

Â  Â 

Zahlen aufrunden
----------------

Ist eine Zahl fast \"rund\", das heiÃŸt nahe an einer 100er oder 10er Zahl, kann man es aunutzen um die Addition zu vereinfachen.

### Beispiel

![showimage.php?formula=6f64f1496fabaac169](/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=6f64f1496fabaac169ea26bceff99536.png)

Â  Â Â 

Â 

Besondere Additionen
====================

Â Addition kann man nicht nur fÃ¼r Zahlen definieren, auch andere Objekte. Siehe dazu

- [wiki=94]BrÃ¼che addieren[/wiki]
- [wiki=60]Vektoren addieren[/wiki]
- Addition mit negativen Zahlen
        ";
}

function input1()
{
    return "        
        <table border=\"0\" style=\"width:100%;\"><tbody><tr><td style=\"width:30%;\">
<h2>Exponentielles Wachstum</h2>
</td>
<td><a href=\"/math/wiki/article/view/exponentielles-wachstum\" class=\"frontbox button\">Artikel zum Thema</a></td>
</tr><tr><td>
<p>allg. Formel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; =<img align=\"middle\" alt=\"showimage.php?formula=ceac0c1f13a5c2cceb\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=ceac0c1f13a5c2cceb643becd0271269.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mi»a«/mi»«mo»§#183;«/mo»«msup»«mi»b«/mi»«mi»t«/mi»«/msup»«mo»=«/mo»«mi»y«/mi»«/math»\"></p>
<p>Wachstumsfaktor b =<img align=\"middle\" alt=\"showimage.php?formula=c83dc017b84f2402a2\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=c83dc017b84f2402a26385b36e8cb2c1.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»1«/mn»«mo»,«/mo»«mn»025«/mn»«/math»\"></p>
<p>Anfangswert a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = <img align=\"middle\" alt=\"showimage.php?formula=cfce097cb39643961f\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=cfce097cb39643961f46fe8ec38ebfce.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»500«/mn»«mo»§#160;«/mo»«/math»\"></p>
<p>Exponent=<img align=\"middle\" alt=\"showimage.php?formula=d7f83c6d9209da3fdd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d7f83c6d9209da3fdd8a0981dda1c114.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»t«/mi»«/mfenced»«/math»\"> in Jahren</p>
<p><img align=\"middle\" alt=\"showimage.php?formula=511a82028aed5d3de9\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=511a82028aed5d3de98ad2b33d3ea902.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»y«/mi»«/mfenced»«/math»\"> in Euro</p>
</td>
<td>Erhält Hans jährlich <img align=\"middle\" alt=\"showimage.php?formula=ca5ab6225079288b9c\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=ca5ab6225079288b9cbd827b62b00db2.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»2«/mn»«mo»,«/mo»«mn»5«/mn»«mo»%«/mo»«/math»\"> Zinsen auf sein Kapital so beträgt sein Kontostand das 1,025-fache des vorherigen Betrags von 500 Euro.</td>
</tr><tr><td>
<h1>&nbsp;&nbsp;&nbsp;</h1>
</td>
<td></td>
</tr><tr><td>
<h1>Teilaufgabe a</h1>
</td>
<td></td>
</tr><tr><td>
<h3>&nbsp;&nbsp;&nbsp;</h3>
</td>
<td></td>
</tr><tr><td>
<h3>Gesucht ist y</h3>
</td>
<td></td>
</tr><tr><td>
<p>Exponent=<img align=\"middle\" alt=\"showimage.php?formula=d7f83c6d9209da3fdd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d7f83c6d9209da3fdd8a0981dda1c114.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»t«/mi»«/mfenced»«/math»\"> in Jahren</p>
<p>=<img align=\"middle\" alt=\"showimage.php?formula=ec248b58f958001abd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=ec248b58f958001abded15bf958b4793.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»1«/mn»«/math»\"></p>
</td>
<td>Nach einem Jahr ist sein Kontostand um das genau <img align=\"middle\" alt=\"showimage.php?formula=c687fa274b5d191064\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=c687fa274b5d1910642d526232a99c90.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»1«/mn»«mo»,«/mo»«msup»«mn»025«/mn»«mn»1«/mn»«/msup»«/math»\">-fache des vorherigen Betrages gestiegen.</td>
</tr><tr><td>
<p><img align=\"middle\" alt=\"showimage.php?formula=23a61b14c6d5612710\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=23a61b14c6d5612710e98d4ffc0ac5e7.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»500«/mn»«mo»§#183;«/mo»«mn»1«/mn»«mo»,«/mo»«msup»«mn»025«/mn»«mn»1«/mn»«/msup»«mo»=«/mo»«mn»512«/mn»«mo»,«/mo»«mn»50«/mn»«/math»\"> Euro</p>
</td>
<td></td>
</tr><tr><td>
<p>Exponent=<img align=\"middle\" alt=\"showimage.php?formula=d7f83c6d9209da3fdd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d7f83c6d9209da3fdd8a0981dda1c114.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»t«/mi»«/mfenced»«/math»\"> in Jahren</p>
<p>=2</p>
</td>
<td>Nach zwei Jahren wird auf den vorherigen bezinsten Betrag erneut das 1,025 fache aufgschlagen.Ein Zuwachs von&nbsp;<img align=\"middle\" alt=\"showimage.php?formula=b6880420fb5cb545c5\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=b6880420fb5cb545c569c5e9b9855521.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»1«/mn»«mo»,«/mo»«mn»025«/mn»«mo»§#183;«/mo»«mn»1«/mn»«mo»,«/mo»«mn»025«/mn»«mo»§#160;«/mo»«/math»\">also&nbsp;<img align=\"middle\" alt=\"showimage.php?formula=a8dd00e605e8ff6456\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=a8dd00e605e8ff64564b34d4610c3382.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»5«/mn»«mo»,«/mo»«mn»1«/mn»«mo»%«/mo»«/math»\">.</td>
</tr><tr><td>
<p><img align=\"middle\" alt=\"showimage.php?formula=2ea7d43213363f8498\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=2ea7d43213363f84983c79378404fc07.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»500«/mn»«mo»§#183;«/mo»«mn»1«/mn»«mo»,«/mo»«msup»«mn»025«/mn»«mn»2«/mn»«/msup»«mo»=«/mo»«mn»525«/mn»«mo»,«/mo»«mn»31«/mn»«/math»\"> Euro</p>
</td>
<td></td>
</tr><tr><td>
<p>Exponent=<img align=\"middle\" alt=\"showimage.php?formula=d7f83c6d9209da3fdd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d7f83c6d9209da3fdd8a0981dda1c114.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»t«/mi»«/mfenced»«/math»\"> in Jahren</p>
<p>=5</p>
</td>
<td></td>
</tr><tr><td>
<p><img align=\"middle\" alt=\"showimage.php?formula=d63e34725a4bd1a207\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d63e34725a4bd1a207581bbef0b40651.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»500«/mn»«mo»§#183;«/mo»«mn»1«/mn»«mo»,«/mo»«msup»«mn»025«/mn»«mn»5«/mn»«/msup»«mo»=«/mo»«mn»565«/mn»«mo»,«/mo»«mn»70«/mn»«/math»\"> Euro</p>
</td>
<td></td>
</tr><tr><td>
<p>Exponent=<img align=\"middle\" alt=\"showimage.php?formula=d7f83c6d9209da3fdd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d7f83c6d9209da3fdd8a0981dda1c114.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»t«/mi»«/mfenced»«/math»\"> in Jahren</p>
<p>=10</p>
</td>
<td></td>
</tr><tr><td>
<p><img align=\"middle\" alt=\"showimage.php?formula=21d646275ace64479d\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=21d646275ace64479d66d71fcda12713.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»500«/mn»«mo»§#183;«/mo»«mn»1«/mn»«mo»,«/mo»«msup»«mn»025«/mn»«mn»10«/mn»«/msup»«mo»=«/mo»«mn»640«/mn»«mo»,«/mo»«mn»04«/mn»«/math»\"> Euro</p>
</td>
<td></td>
</tr><tr><td>
<h1>&nbsp;</h1>
</td>
<td></td>
</tr><tr><td>
<h1>Teilaufgabe b</h1>
</td>
<td></td>
</tr><tr><td>
<p>&nbsp;&nbsp;&nbsp;&nbsp;</p>
</td>
<td></td>
</tr><tr><td>
<p>allg. Formel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; =<img align=\"middle\" alt=\"showimage.php?formula=ceac0c1f13a5c2cceb\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=ceac0c1f13a5c2cceb643becd0271269.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mi»a«/mi»«mo»§#183;«/mo»«msup»«mi»b«/mi»«mi»t«/mi»«/msup»«mo»=«/mo»«mi»y«/mi»«/math»\"></p>
<p>Wachstumsfaktor b =<img align=\"middle\" alt=\"showimage.php?formula=c83dc017b84f2402a2\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=c83dc017b84f2402a26385b36e8cb2c1.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»1«/mn»«mo»,«/mo»«mn»025«/mn»«/math»\"></p>
<p>Anfangswert a&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; = <img align=\"middle\" alt=\"showimage.php?formula=cfce097cb39643961f\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=cfce097cb39643961f46fe8ec38ebfce.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»500«/mn»«mo»§#160;«/mo»«/math»\"></p>
<p>y</p>
<p>Exponent=<img align=\"middle\" alt=\"showimage.php?formula=d7f83c6d9209da3fdd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d7f83c6d9209da3fdd8a0981dda1c114.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»t«/mi»«/mfenced»«/math»\"> in Jahren</p>
<p><img align=\"middle\" alt=\"showimage.php?formula=511a82028aed5d3de9\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=511a82028aed5d3de98ad2b33d3ea902.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»y«/mi»«/mfenced»«/math»\"> in Euro</p>
</td>
<td></td>
</tr><tr><td>
<h3>Gesucht ist t</h3>
</td>
<td>Gesucht ist hierbei die Variable <img align=\"middle\" alt=\"showimage.php?formula=d7f83c6d9209da3fdd\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=d7f83c6d9209da3fdd8a0981dda1c114.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mfenced open=¨[¨ close=¨]¨»«mi»t«/mi»«/mfenced»«/math»\"> in Jahren, also die Anzahl der Jahre die verstreichen müssen, bis Hans 1000 Euro auf seinem Konto hat.</td>
</tr><tr><td>
<h3><img align=\"middle\" alt=\"showimage.php?formula=f4cf340afa2aab626b\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=f4cf340afa2aab626bf3845516371510.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»500«/mn»«mo»§#183;«/mo»«mn»1«/mn»«mo»,«/mo»«msup»«mn»025«/mn»«mi»t«/mi»«/msup»«mo»=«/mo»«mn»1000«/mn»«/math»\"></h3>
</td>
<td><img align=\"middle\" alt=\"showimage.php?formula=4c36f640692b62fbda\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=4c36f640692b62fbdabfc928104b185c.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«menclose notation=¨left¨»«mo»:«/mo»«mo»§#160;«/mo»«mn»500«/mn»«/menclose»«/math»\"></td>
</tr><tr><td>
<h3><img align=\"middle\" alt=\"showimage.php?formula=cdaec7b2a9489fb7a4\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=cdaec7b2a9489fb7a4d93f3c8af8116c.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mn»1«/mn»«mo»,«/mo»«msup»«mn»025«/mn»«mi»t«/mi»«/msup»«mo»=«/mo»«mn»2«/mn»«/math»\"></h3>
</td>
<td><img align=\"middle\" alt=\"showimage.php?formula=c0a891b044b31a5881\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=c0a891b044b31a588168ec5b0c71e3f1.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«menclose notation=¨left¨»«mo»§#183;«/mo»«mi»log«/mi»«mfenced»«mrow/»«/mfenced»«/menclose»«/math»\"> <a href=\"/math/wiki/article/view/logarithmus\" class=\"frontbox\">Logarithmiere.</a></td>
</tr><tr><td>
<h3><img align=\"middle\" alt=\"showimage.php?formula=ae9b29e1dc930bae19\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=ae9b29e1dc930bae1994accc50d98f25.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«msub»«mi»log«/mi»«mrow»«mn»1«/mn»«mo»,«/mo»«mn»025«/mn»«/mrow»«/msub»«mfenced»«mn»2«/mn»«/mfenced»«mo»=«/mo»«mi»t«/mi»«/math»\"></h3>
</td>
<td></td>
</tr><tr><td><img align=\"middle\" alt=\"showimage.php?formula=2e0b668d5b47dc070b\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=2e0b668d5b47dc070b4b09c32596d687.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mi»t«/mi»«mo»§#8776;«/mo»«mn»28«/mn»«mo»,«/mo»«mn»2«/mn»«mo»§#160;«/mo»«/math»\">Jahre</td>
<td></td>
</tr><tr><td colspan=\"2\"><img align=\"middle\" alt=\"showimage.php?formula=f8ff39db72b5abe07f\" class=\"Wirisformula\" src=\"http://www.serlo.org/scripts/libs/tiny_mce/plugins/tiny_mce_wiris/integration/showimage.php?formula=f8ff39db72b5abe07fe58838cd882049.png\" data-mathml=\"«math xmlns=¨http://www.w3.org/1998/Math/MathML¨»«mo»§#8658;«/mo»«/math»\">Im 29 Jahr besitzt Hans 1000 Euro auf seinem Konto.</td>
</tr></tbody></table>";
}