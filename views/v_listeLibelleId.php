<div id="contenu">
      <h2>Mes fiches de frais</h2>
      <h3>Id à sélectionner : </h3>
  <form action="index.php?uc=LibelleId&action=voirLibelleId" method="post">
          <div class="corpsForm">
            
            <p>
      
                <label for="lstLibelle" accesskey="n">Id : </label>

                <select id="lstLibelle" name="lstLibelle">
                    
                    <?php

                        foreach ($lesLibelles as $unLibelle)
                        {

                    ?>

                        <option value="<?php echo $unLibelle['id'] ?>"><?php echo  $unLibelle['id']?> </option>
                            
                    <?php 

                        }

                    ?>    
            
                </select>

            </p>

      </div>

      <div class="piedForm">

        <p>
          <input id="ok" type="submit" value="Valider" size="20" />
          <input id="annuler" type="reset" value="Effacer" size="20" />
        </p> 
      </div>
        
  </form>