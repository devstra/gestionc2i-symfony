<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader
{
    public function upload($uploadDir, $file, $filename)
    {
        try {
            $file->move($uploadDir, $filename);

            //We are going to insert some data into the users table
            // $sth = $dbh->prepare(
            //     "INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)"
            // );

            // $csv = Reader::createFromPath($uploadDir . '/' . $filename, 'r')->setHeaderOffset(0);
            // $entityManager =  getDoctrine()->getManager();

            // foreach ($csv as $record) {
            //     $copie = new Copie();
            //     $etudiant = new Etudiant();
            //     $salle = new Salle();
            //     $epreuve = new Epreuve();

            //     // Etudiant
            //     $etudiant->setPrenom($record['prenom']);
            //     $etudiant->setNom($record['nom']);
            //     $etudiant->setGroupe($record['groupe']);

            //     // Salle
            //     $salle->setCapacite($record['capacite']);
            //     $salle->setLieu($record['lieu']);
            //     $salle->setBatiment($record['batiment']);
            //     $salle->setEtage($record['etage']);

            //     // Epreuve
            //     $epreuve->setBarre($record['barre']);
            //     $epreuve->setNomUFR($record['nomUFR']);
            //     $epreuve->setAnnee($record['annee']);

            //     // Copie
            //     $copie->setVague($record['vague']);
            //     $copie->setCorrecteur($record['correcteur']);
            //     $copie->setNoteD1($record['noteD1']);
            //     $copie->setNoteD2($record['noteD2']);
            //     $copie->setNoteTableur($record['noteTableur']);
            //     $copie->setNoteTraitementTexte($record['noteTraitementTexte']);
            //     $copie->setNotePresentationAO($record['notePresentationAO']);
            //     $copie->setNoteD4($record['noteD4']);
            //     $copie->setNoteD5($record['noteD5']);
            //     $copie->setEpreuve($epreuve);
            //     $copie->setEtudiant($etudiant);
            //     $copie->setSalle($salle);

            //     //Do not forget to validate your data before inserting it in your database
            //     $sth->bindValue(':firstname', $record['First Name'], PDO::PARAM_STR);
            //     $sth->bindValue(':lastname', $record['Last Name'], PDO::PARAM_STR);
            //     $sth->bindValue(':email', $record['E-mail'], PDO::PARAM_STR);
            //     $sth->execute();
            // }

            // echo $csv->toString();
        } catch (FileException $e) {

            // $this->logger->error('failed to upload image: ' . $e->getMessage());
            throw new FileException('Erreur upload de fichier');
        }
    }
}
