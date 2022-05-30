<?php


// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
    $res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
    $i--; $j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
    $res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
    $res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
    $res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
    $res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
    $res = @include "../../../main.inc.php";
}
if (!$res) {
    die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formprojet.class.php';
dol_include_once('/voyagebuilder/class/voyage.class.php');
dol_include_once('/voyagebuilder/lib/voyagebuilder_voyage.lib.php');

llxHeader();

function read($csv){
    $file = fopen($csv, 'r');
    if($file === false) return false;

    while (!feof($file) ) {
        $line[] = fgetcsv($file, 1024);
    }
    fclose($file);
    return $line;
}

print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'" enctype="multipart/form-data">';
print '<input type="hidden" name="token" value="'.newToken().'">';
print '<label>'.$langs->trans('ChooseFile').'</label> ';
print '<input type="file" name="nomFichier">';
print '<input type="submit" value="envoyer" name="submit" class="button small reposition">';
print '</form>';


if(isset($_FILES['nomFichier'])){
    $csv = $_FILES['nomFichier']['tmp_name'];
    $csv = read($csv);
    echo '<pre>';
    print_r($csv);
    echo '</pre>';
}

