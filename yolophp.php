<?php
if(sizeof($argv)>1) {
    if (sizeof($argv) > 2 AND $argv[1] == '--h') {
        echo 'Créez un fichier grâce à la commande: --create-file=NOMFICHIER' . "\n" . 'Puis ajoutez des utilisateurs grâce à la commande : --add-user=NOMFICHIER --firstname=FIRSTNAME --lastname=LASTNAME --note=NOTE' . "\n" . 'Vous pouvez également lire un fichier grâce à la commande : --get-all-users=NOMFICHIER';
    } else {
        $paraun = explode("=", $argv[1]);
//Creation du fichier :
        if ($paraun[0] == '--create-file' AND !file_exists($paraun[1])) {
            $fichier = fopen($paraun[1], 'x');
            fclose($fichier);
            echo 'Fichier créé';
        } else {
            if (($paraun[0] == '--create-file' AND file_exists($paraun[1]))) {
                echo 'Fichier déjà existant';
            }
        }
//Ajout d'un utilisateur :
        if (sizeof($argv) == 5 AND $paraun[0] == '--add-user' AND file_exists($paraun[1])) {
            $firstname = explode('=', $argv[2]);
            $lastname = explode('=', $argv[3]);
            $note = explode('=', $argv[4]);
            if ($firstname[0] == '--firstname' AND $lastname[0] == '--lastname' AND $note[0] == '--note') {
                while (strlen($firstname[1]) < 20 OR strlen($lastname[1]) < 20 OR strlen($note[1]) < 20) {
                    if (strlen($firstname[1]) < 20) {
                        $firstname[1] = $firstname[1] . ' ';
                    }
                    if (strlen($lastname[1]) < 20) {
                        $lastname[1] = $lastname[1] . ' ';
                    }
                    if (strlen($note[1]) < 20) {
                        $note[1] = $note[1] . ' ';
                    }
                }
                $fichier = fopen($paraun[1], 'r+');
                fseek($fichier, -1, SEEK_END);
                fwrite($fichier, $firstname[1] . ' | ' . $lastname[1] . ' | ' . $note[1] . "\n\n");
                fclose($fichier);
                echo 'Utilisateur ajouté';
            } else {
                echo 'Veuillez respecter la forme de saisie : --add-user=NOMFICHIER --firstname=FIRSTNAME --lastname=LASTNAME --note=NOTE';
            }
        } else {
            if (sizeof($argv) == 5 AND $paraun[0] != '--get-all-users' AND file_exists($paraun[1])) {
                echo 'Fichier déjà existant';
            } else {
//Lire toute la liste
                if ($paraun[0] == '--get-all-users' AND file_exists($paraun[1])) {
                    $fichier = file($paraun[1]);
                    foreach ($fichier as $lineNumber => $lecture) {
                        echo $lecture;
                    }
                } else {
                    if ($paraun[0] != '--create-file') {
                        echo 'Veuillez saisir une commande correcte';
                    }
                }
            }
        }
    }
}else{
    echo 'Aucune commande détectée';
}
