<?php

namespace App\Service;

use App\Entity\Copie;
use App\Entity\Epreuve;
use App\Entity\Etudiant;
use App\Entity\Salle;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function calculerNoteD3(float $noteTableur, float $noteTraitementTexte, float $notePresentationAO): float
    {
        // Calcul du domaine 3 sur /5 en fonction des sous-notes entrées
        return round((($noteTableur / 4) + $noteTraitementTexte + $notePresentationAO) / 3, 2);
    }

    public function upload($uploadDir, $file, $filename)
    {
        try {
            $file->move($uploadDir, $filename);

            $csv = Reader::createFromPath($uploadDir . '/' . $filename, 'r')->setHeaderOffset(0);

            foreach ($csv as $record) {
                $salle = (new Salle())
                    ->setCapacite($record['capacite'])
                    ->setLieu($record['lieu'])
                    ->setBatiment($record['batiment'])
                    ->setEtage($record['etage'])
                ;

                $this->em->persist($salle);

                $etudiant = (new Etudiant())
                    ->setPrenom($record['prenom'])
                    ->setNom($record['nom'])
                    ->setGroupe($record['groupe'])
                ;

                $this->em->persist($etudiant);

                $epreuve = (new Epreuve())
                    ->setBarre($record['barre'])
                    ->setAnnee($record['annee'])
                    ->setNomUFR($record['nomUFR'])
                ;

                $this->em->persist($epreuve);

                // Copie
                $noteD3 = $this->calculerNoteD3($record['noteTableur'], $record['noteTraitementTexte'], $record['notePresentationAO']);

                $noteFin = $this->calculerNoteFinale($record['noteD1'], $record['noteD2'], $noteD3, $record['noteD4'], $record['noteD5']);

                $mention1 = $this->calculerMention($record['barre'], $record['noteD1']);
                $mention2 = $this->calculerMention($record['barre'], $record['noteD2']);
                $mention3 = $this->calculerMention($record['barre'], $noteD3);
                $mention4 = $this->calculerMention($record['barre'], $record['noteD4']);
                $mention5 = $this->calculerMention($record['barre'], $record['noteD5']);

                $mentionFin = $this->calculerMentionFinale($mention1, $mention2, $mention3, $mention4, $mention5);

                $copie = (new Copie())
                    ->setVague($record['vague'])
                    ->setCorrecteur($record['correcteur'])
                    ->setNoteD1($record['noteD1'])
                    ->setNoteD2($record['noteD2'])
                    ->setNoteTableur($record['noteTableur'])
                    ->setNoteTraitementTexte($record['noteTraitementTexte'])
                    ->setNotePresentationAO($record['notePresentationAO'])
                    ->setNoteD4($record['noteD4'])
                    ->setNoteD5($record['noteD5'])
                    ->setNoteD3($noteD3)
                    ->setNoteFinale($noteFin)
                    ->setMentionD1($mention1)
                    ->setMentionD2($mention2)
                    ->setMentionD3($mention3)
                    ->setMentionD4($mention4)
                    ->setMentionD5($mention5)
                    ->setMentionFinale($mentionFin)
                    ->setEpreuve($epreuve)
                    ->setEtudiant($etudiant)
                    ->setSalle($salle)
                ;

                $this->em->persist($copie);

            }

            $this->em->flush();

        } catch (FileException $e) {
            throw new FileException('Erreur upload de fichier');
        }
    }

    private function calculerNoteFinale(float $noteD1, float $noteD2, float $noteD3, float $noteD4, float $noteD5): float
    {
        // Calcul de la note finale sur /20 en fonction des notes entrées
        return round((($noteD1 + $noteD2 + $noteD3 + $noteD4 + $noteD5) / 5) * 4, 2);
    }

    private function calculerMention(float $barre, float $note): string
    {
        if ($note >= $barre) {
            return 'ADM';
        } else {
            if ($note >= 2.5) {
                return 'MOY';
            } else {
                return 'AJ';
            }
        }
    }

    private function calculerMentionFinale(string $mentionD1, string $mentionD2, string $mentionD3, string $mentionD4, string $mentionD5): string
    {
        $mentions = array($mentionD1, $mentionD2, $mentionD3, $mentionD4, $mentionD5);
        $nbMentions = array_count_values($mentions);

        if (array_key_exists('ADM', $nbMentions)) {
            if ($nbMentions['ADM'] == 5) {
                return 'ADM';
            } else if ($nbMentions['ADM'] == 4 && array_key_exists('MOY', $nbMentions)) {
                return 'ADM';
            } else {
                return 'AJ';
            }
        } else {
            return 'AJ';
        }
    }
}
