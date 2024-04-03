<h3>Fiche du cumules des types de frais en fonction de l'Id visiteur : </h3>
    <div class="encadre">

    
  	
        <table class="listeLegere">

                <tr>
                    <th class="id">Id : </th>
                    <th class="mois">Mois : </th>
                    <th class="forfait">Forfait : </th>
                    <th class='MontantTotalCumulés'>Montant : </th>           
                </tr>
            
            <?php 

            foreach ($lesCumules as $unCumule) :
    
            ?>
                    <tr>
                        <td><?= $unCumule['idVisiteur'] ?></td>
                        <td><?= $unCumule['mois'] ?></td>
                        <td><?= $unCumule['idFraisForfait'] ?></td>
                        <td><?= $unCumule['MontantTotalCumulés'] ?></td>
                    </tr>

            <?php endforeach;?>

        </table>
     </div>