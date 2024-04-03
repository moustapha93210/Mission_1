<?php include_once 'v_ajouterFrais.php';?>

<h3 class="align-center">Donées insérer dans la table lignefraisforfait : </h3>
    <div class="encadre">
    <table class="listeLegere">
             <tr>
                <th class='nom'> IdVisiteur: </th>   
                <th class='prenom'> Mois:</th>   
                <th class='montant'>idFraisForfait: </th> 
                <th class='mois'> Quantite: </th>

           
             </tr>
        <?php    foreach ($lesFrais as $unFrais ): ?>
            <tr>
              <td><?=$unFrais['idVisiteur']?></td>
              <td><?=$unFrais['mois']?></td>
              <td><?=$unFrais['idFraisForfait']?></td>
              <td><?=$unFrais['quantite']?></td>
           </tr>
           <?php endforeach?>
          
    </table>
  </div>