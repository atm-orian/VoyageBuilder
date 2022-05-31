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
dol_include_once('/voyagebuilder/core/modules/voyagebuilder/modules_voyage.php');


llxHeader();



function read($csv){

    global $db,$user;


    $row = 1;
    if (($handle = fopen($csv, "r")) !== FALSE)
    {
        fgetcsv($handle, 1000, ","); // skip la première ligne du csv

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) //parcourt le csv
        {
            $num = count($data);
            echo "<p> $num champs à la ligne $row: <br /></p>\n";
            $row++;


                $object = new Voyage($db);

                $object->label= $data[0];
                $object->tarif= $data[1];

                $object->pays= $object->getIdCountry($data[2]);


                $date_dConvert= DateTime::createFromFormat('d/m/y',$data[3]);
                $object->date_deb = $date_dConvert->format('Y-m-d');

                $date_fConvert= DateTime::createFromFormat('d/m/y',$data[4]);
                $object->date_fin = $date_fConvert->format('Y-m-d');

                $TLabelTag = explode(", ", $data[5]);

                 foreach ($TLabelTag as $tag)
                 {
                     $idTag = $object->getIdTag($tag);
                     if(!empty($idTag) && $idTag != -1)
                     {
                        $object->array_options['options_tag'] = $tag;
                     }
                     else if(empty($idTag))
                     {
                         $object->createTag($tag);
                        // create tag
                     }
                 }





                // search id product by label
                // $data[10];
                //if not exist create product
                // $object->array_options['options_product']=
                //
                //var_dump($object, $object->array_options['options_tag']);exit;

                echo $data[0] . "<br />\n";
                echo $data[1] . "<br />\n";
                echo $data[2] . "<br />\n";
                echo $data[3] . "<br />\n";
                echo $data[4] . "<br />\n";
                echo $data[5] . "<br />\n";
                echo $data[6] . "<br />\n";
                echo $data[7] . "<br />\n";
                echo $data[8] . "<br />\n";
                echo $data[9] . "<br />\n";
                echo $data[10] . "<br />\n";
                echo "<br />\n";

            exit;

                $object->create($user);


        }
        fclose($handle);
    }
}

print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'" enctype="multipart/form-data">';
print '<input type="hidden" name="token" value="'.newToken().'">';
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

