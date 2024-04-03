<h3>Fiche du cumules des libelles en fonction du Mois: </h3>
    <div class="encadre">

    
  	
        <table class="listeLegere">

                <tr>
                    <th class="libelle">Id : </th>
                    <th class="libelle">ETP : </th>
                    <th class='libelle'>KM : </th>
                    <th class='libelle'>NUI : </th>
                    <th class='libelle'>REP : </th>           
                </tr>
            
            <?php 

            foreach ($lesCumules as $unCumule) :
    
            ?>
                    <tr>
                        <td><?= $unCumule['idVisiteur'] ?></td>
                        <td><?= $unCumule['ETP'] ?></td>
                        <td><?= $unCumule['KM'] ?></td>
                        <td><?= $unCumule['NUI'] ?></td>
                        <td><?= $unCumule['REP'] ?></td>
                    </tr>

            <?php endforeach;?>

        </table>
     </div>