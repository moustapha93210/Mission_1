<h3>Fiche du cumules des libelles en fonction de l'id : </h3>
    <div class="encadre">

    
  	
        <table class="listeLegere">

                <tr>
                    <th class="libelle">Id : </th>
                    <th class="libelle">Type de Forfait : </th>
                    <th class='MontantTotalCumulés'>Montant : </th>           
                </tr>
            
            <?php 

            foreach ($lesCumules as $unCumule) :
    
            ?>
                    <tr>
                        <td><?= $unCumule['idVisiteur'] ?></td>
                        <td><?= $unCumule['libelle'] ?></td>
                        <td><?= $unCumule['MontantTotalCumulés'] ?></td>
                    </tr>

            <?php endforeach;?>

        </table>
     </div>