<div id="contenu">
      <h2>Ligne Frais Forfait</h2>
      <h3>Id à sélectionner : </h3>
  <form action="index.php?uc=AjouterFrais&action=voirFraisAjouter" method="post">
          <div class="corpsForm">
            
            <p>


                <h4> VISITEUR :</h4>

                <label for="ajtFraisId" accesskey="n">Nom/Prénom : </label>

                <select id="ajtFraisId" name="ajtFraisId">
                    
                    <?php

                        foreach ($desNoms as $unNom)
                        {

                    ?>

                        <option value="<?php echo $unNom['id'] ?>"><?php echo  $unNom['nom'] . " / " . $unNom['prenom']?> </option>
                            
                    <?php 

                        }

                    ?>    
            
                </select>


                <h4> PERIODE :</h4>

                <label for="ajtFraisMois" accesskey="n">Mois (2 chiffres) : </label>
    
                <select id="ajtFraisMois" name="ajtFraisMois">
                    
                    <option selected value="01" >Janvier</option>
                    <option value="02">Février</option>
                    <option value="03">Mars</option>
                    <option value="04">Avril</option>
                    <option value="05">Mai</option>
                    <option value="06">Juin</option>
                    <option value="07">Juillet</option>
                    <option value="08">Août</option>
                    <option value="09">Septembre</option>
                    <option value="10">Octobre</option>
                    <option value="11">Novembre</option>
                    <option value="12">Décembre</option>
            
                </select>


                <label for="ajtFraisAnnee" accesskey="n">Année (4 chiffres) : </label>
    
                <select id="ajtFraisAnnee" name="ajtFraisAnnee">
                    
                    <option selected value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                      
                </select>


                <h4> FRAIS AU FORFAIT :</h4>

                <label for="repasMidi" accesskey="n">Repas Midi : </label>
                <input type="text" id="repasMidi" name= "repasMidi">

                <br>
                <br>

                <label for="nuitee" accesskey="n">Nuitée : </label>
                <input type="text" id="nuitee" name= "nuitee">

                <br>
                <br>

                <label for="etape">Etape : </label>
                <input type="text" id="etape" name= "etape">

                <br>
                <br>

                <label for="kilometre">Kilomètre : </label>
                <input type="text" id="kilometre" name= "kilometre">

                <br>
                <br>  

            </p>

      </div>

      <div class="piedForm">

        <p>
          <input id="ok" type="submit" value="Valider" size="20" />
          <input id="annuler" type="reset" value="Effacer" size="20" />
        </p> 
      </div>
        
  </form>