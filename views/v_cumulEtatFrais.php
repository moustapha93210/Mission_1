<h3>Fiche du cumules des frais du mois: </h3>
    <div class="encadre">

    
  	
        <table class="listeLegere">

                <tr>
                    <th class="idVisiteur">Id : </th>
                    <th class="nom">Nom : </th>
                    <th class="prenom">Prénom : </th>
                    <th class="typeDeFrais">Type de frais : </th>
                    <th class='MontantTotalCumulés'>Montant : </th>           
                </tr>
            
            <?php 

            foreach ($lesCumules as $unCumule ) :
    
            ?>
                    <tr>
                        <td><?= $unCumule['idVisiteur'] ?></td>
                        <td><?= $unCumule['nom'] ?></td>
                        <td><?= $unCumule['prenom'] ?></td>
                        <td><?= $unCumule['idFraisForfait'] ?></td>
                        <td><?= $unCumule['MontantTotalCumulés'] ?></td>
                    </tr>

            <?php endforeach;?>

        </table>
     </div>